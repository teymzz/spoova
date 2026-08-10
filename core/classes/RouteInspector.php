<?php

namespace spoova\mi\core\classes;

use Window;
use Throwable;
use ReflectionClass;
use ReflectionParameter;
use ReflectionNamedType;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use spoova\mi\core\classes\Container\Container;

/**
 * Route introspection helper.
 *
 * Spoova registers routes imperatively (each controller calls call()/smartcall()/
 * pathcall() inside its __construct), so the route graph cannot be read statically.
 * This inspector puts the shutters into a "capture" mode via the SETTER flag
 * {@see RouteInspector::FLAG}: instead of authorising and dispatching, they record
 * their route map and return, and each controller is instantiated only to harvest
 * that map — nothing is rendered and no response is sent.
 *
 * The routing core needs one tiny hook at the top of
 * Window::call()/smartcall()/pathcall():
 *
 *     if (RouteInspector::capturing()) {
 *         RouteInspector::capture(get_class($instance), __FUNCTION__, $windows);
 *         return;                       // skip authorise / dispatch / render / exit
 *     }
 *
 * Because capturing() is false on every real request, live routing is unchanged.
 * Other subsystems (e.g. Sensor) can guard constructor side effects during a scan
 * with the same RouteInspector::capturing() check.
 */
final class RouteInspector
{
    /** SETTER key that marks an inspection pass in progress. */
    public const FLAG = 'ROUTE_INSPECT';

    /** @var array<int,array> raw captured shutter calls */
    private static array $captured = [];

    /** shutter option keys that are NOT routes (mirrors Window::SHUTTER_KEYS) */
    private const OPTION_KEYS = Window::SHUTTER_KEYS;

    // ---------------------------------------------------------------- flag API

    /** TRUE only while an inspection pass is running (SETTER-backed, re-run safe). */
    public static function capturing(): bool
    {
        return SETTER::EXISTS(self::FLAG) && SETTER::GET(self::FLAG) === true;
    }

    /** Toggle the inspection flag. SET on first use, MOD thereafter (SET can't redefine). */
    private static function flag(bool $on): void
    {
        if (SETTER::EXISTS(self::FLAG)) {
            SETTER::MOD(self::FLAG, $on);   // key is unlocked, so modifiable
        } else {
            SETTER::SET(self::FLAG, $on);   // first declaration (no lock)
        }
    }

    // ---------------------------------------------------------------- hook API

    /**
     * Called by the shutter hook. Splits the shutter array into route entries and
     * options (:ORIGIN, :ARG, :TRUNK, ...) and records them against the controller.
     */
    public static function capture(string $controller, string $shutter, array $windows): void
    {
        $options = [];
        $routes  = [];

        foreach ($windows as $key => $value) {
            if (in_array($key, self::OPTION_KEYS, true)) {
                $options[$key] = $value;
            } else {
                $routes[$key] = $value;
            }
        }

        self::$captured[] = [
            'controller' => $controller,
            'shutter'    => $shutter,          // call | smartcall | pathcall
            'origin'     => rtrim((string) ($options[Window::ORIGIN] ?? ''), '/'),
            'trunk'      => $options[Window::TRUNK] ?? null,
            'options'    => array_keys($options),
            'routes'     => $routes,
        ];
    }

    // ------------------------------------------------------------- entry point

    /**
     * Discovers every route controller, dry-runs it, and returns a flat route map.
     *
     * @return array<int,array{path:string,handler:string,kind:string,controller:string,shutter:string,options:array}>
     */
    public static function inspect(?string $routesDir = null): array
    {
        self::$captured = [];
        $routesDir      = $routesDir ?: docroot . '/windows/Routes';

        self::flag(true);

        // Some controllers emit output while constructing; swallow it so the
        // scan stays clean. We also record the buffer depth to unwind safely.
        $obLevel = ob_get_level();
        ob_start();

        try {
            foreach (self::discover($routesDir) as $class) {
                self::dryRun($class);
            }
        } finally {
            while (ob_get_level() > $obLevel) ob_end_clean();
            self::flag(false);              // never leave capture mode dangling
        }

        return self::flatten();
    }

    // --------------------------------------------------------------- discovery

    /**
     * Finds classes under windows/Routes that extend Window (i.e. route controllers).
     *
     * @return string[] fully-qualified class names
     */
    private static function discover(string $dir): array
    {
        if (!is_dir($dir)) return [];

        $base    = scheme('windows\\Routes\\', false);   // spoova\mi\windows\Routes
        $classes = [];

        $it = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($it as $file) {
            if ($file->getExtension() !== 'php') continue;

            // build FQCN from the path relative to windows/Routes
            $rel   = trim(str_replace([$dir, '/', '\\'], ['', '\\', '\\'], $file->getPathname()), '\\');
            $rel   = preg_replace('/\.php$/', '', $rel);
            $class = $base . '\\' . $rel;

            if (class_exists($class) && is_subclass_of($class, Window::class)) {
                $classes[] = $class;
            }
        }

        sort($classes);
        return $classes;
    }

    /**
     * Instantiate a controller in capture mode so its shutter calls are recorded.
     * Uses the framework's DI container (the same path callRoute() uses) so any
     * constructor dependencies resolve correctly. Every failure is isolated so one
     * bad constructor can't abort the whole scan.
     */
    private static function dryRun(string $class): void
    {
        // Preferred path: the framework's DI container (resolves typed deps).
        try {
            Container::instance()->with('dependencies')->dispatch($class);
            return;
        } catch (Throwable $e) {
            // fall through — often just a route param the container can't autowire
        }

        // Fallback: reflect and supply benign stub args for required params.
        try {
            $ref  = new ReflectionClass($class);
            $ctor = $ref->getConstructor();
            $args = [];
            if ($ctor) {
                foreach ($ctor->getParameters() as $p) $args[] = self::stubArg($p);
            }
            $ref->newInstanceArgs($args);
        } catch (Throwable $e) {
            self::$captured[] = [
                'controller' => $class,
                'shutter'    => '(error)',
                'origin'     => '',
                'trunk'      => null,
                'options'    => [],
                'routes'     => ['(uninspectable)' => $e->getMessage()],
            ];
        }
    }

    /** A harmless value for a required constructor parameter during a scan. */
    private static function stubArg(ReflectionParameter $p): mixed
    {
        if ($p->isDefaultValueAvailable()) return $p->getDefaultValue();

        $type = $p->getType();
        if ($type instanceof ReflectionNamedType) {
            if ($type->allowsNull()) return null;
            return match ($type->getName()) {
                'array'  => [],
                'string' => '',
                'int'    => 0,
                'float'  => 0.0,
                'bool'   => false,
                default  => self::stubObject($type->getName()),
            };
        }
        return null;   // untyped / union / intersection
    }

    /** Instantiate a class param only if it needs no required args; else null. */
    private static function stubObject(string $class): mixed
    {
        try {
            if (class_exists($class)) {
                $rc = new ReflectionClass($class);
                if ($rc->isInstantiable()) {
                    $ctor = $rc->getConstructor();
                    if (!$ctor || $ctor->getNumberOfRequiredParameters() === 0) {
                        return $rc->newInstance();
                    }
                }
            }
        } catch (Throwable $e) {
            // ignore — best effort
        }
        return null;
    }

    // ---------------------------------------------------------------- shaping

    /** Collapse captured shutters into one row per route, resolving :ORIGIN prefixes. */
    private static function flatten(): array
    {
        $rows = [];

        foreach (self::$captured as $group) {

            // an explicit :ORIGIN wins; otherwise a top-level controller's URL base
            // is its file path (Docs\Mailer -> docs/mailer)
            $origin = $group['origin'] !== '' ? $group['origin'] : self::controllerBase($group['controller']);

            foreach ($group['routes'] as $path => $handler) {

                $effPath = self::joinPath($origin, (string) $path);
                $handler = is_string($handler) ? $handler : gettype($handler);

                // handler is either "win:Class" (nested channel) or a method name
                $kind = str_starts_with($handler, 'win:') ? 'channel' : 'method';

                $rows[] = [
                    'path'       => $effPath === '' ? '/' : $effPath,
                    'handler'    => $handler,
                    'kind'       => $kind,
                    'controller' => $group['controller'],
                    'shutter'    => $group['shutter'],
                    'options'    => $group['options'],
                ];
            }
        }

        usort($rows, fn($a, $b) => strcmp($a['path'], $b['path']));
        return $rows;
    }

    /** Top-level controller's URL base, derived from its class path (Docs\Mailer -> docs/mailer). */
    private static function controllerBase(string $fqcn): string
    {
        return strtolower(str_replace('\\', '/', self::short($fqcn)));
    }

    private static function joinPath(string $origin, string $path): string
    {
        $path = str_replace('.', '/', $path);          // dot-convention -> slashes
        $joined = $origin === '' ? $path : $origin . '/' . $path;
        return trim(preg_replace('#/+#', '/', $joined), '/');   // collapse // and trim
    }

    // ------------------------------------------------------------- static mode

    /**
     * Static route map: parses each controller's source for call()/smartcall()/
     * pathcall() and extracts their literal route arrays WITHOUT executing any
     * code (no constructors, no compilation, no I/O). Dynamic keys/values (e.g.
     * lastCall(), variables) are shown as their source text since they can't be
     * evaluated statically. The route-definition convention is unchanged — this
     * only reads the same self::call() format you already write.
     */
    public static function inspectStatic(?string $routesDir = null): array
    {
        $routesDir = $routesDir ?: docroot . '/windows/Routes';

        $rows = [];
        foreach (self::discoverFiles($routesDir) as $file) {
            foreach (self::parseFile($file, $routesDir) as $row) $rows[] = $row;
        }
        usort($rows, fn($a, $b) => strcmp($a['path'], $b['path']));
        return $rows;
    }

    /** Recursively list *.php files under the routes dir (no autoload, no execution). */
    private static function discoverFiles(string $dir): array
    {
        if (!is_dir($dir)) return [];
        $files = [];
        $it = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
        );
        foreach ($it as $f) {
            if ($f->getExtension() === 'php') $files[] = $f->getPathname();
        }
        sort($files);
        return $files;
    }

    /** Controller class name derived purely from the file path (no loading). */
    private static function fileToClass(string $file, string $dir): string
    {
        $file = str_replace('\\', '/', $file);
        $dir  = rtrim(str_replace('\\', '/', $dir), '/');
        $rel  = ltrim(substr($file, strlen($dir)), '/');
        $rel  = preg_replace('/\.php$/i', '', $rel);
        return scheme('windows\\Routes\\', false) . '\\' . str_replace('/', '\\', $rel);
    }

    /** Tokenise one controller and pull route entries from its shutter calls. */
    private static function parseFile(string $file, string $dir): array
    {
        $code = @file_get_contents($file);
        if ($code === false || !preg_match('/(?:call|smartcall|pathcall)\s*\(/', $code)) return [];

        $tokens = token_get_all($code);
        $n      = count($tokens);
        $class  = self::fileToClass($file, $dir);
        $rows   = [];

        for ($i = 0; $i < $n; $i++) {
            $t = $tokens[$i];
            if (!(is_array($t) && $t[0] === T_STRING && in_array($t[1], ['call', 'smartcall', 'pathcall'], true))) continue;

            // must be a static call: preceding significant token is '::'
            $p = $i - 1;
            while ($p >= 0 && is_array($tokens[$p]) && $tokens[$p][0] === T_WHITESPACE) $p--;
            if (!($p >= 0 && is_array($tokens[$p]) && $tokens[$p][0] === T_DOUBLE_COLON)) continue;

            $shutter = $t[1];

            $q = $i + 1;
            while ($q < $n && $tokens[$q] !== '(') $q++;
            if ($q >= $n) continue;

            [$argTokens, $end] = self::sliceBalanced($tokens, $q, '(', ')');
            $args = self::splitTop($argTokens, ',');

            // the route map is the first array-literal argument
            $arrayArg = null;
            foreach ($args as $arg) {
                if (self::firstSig($arg) === '[') { $arrayArg = $arg; break; }
            }

            if ($arrayArg === null) {
                $rows[] = self::staticRow($class, $shutter, self::controllerBase($class),
                                          '(dynamic array — use dynamic mode)', 'dynamic');
                $i = $end;
                continue;
            }

            $origin = '';
            $routes = [];
            foreach (self::arrayPairs($arrayArg) as [$kText, $vText]) {
                $keyResolved = self::resolveShutterKey($kText);
                if (is_string($keyResolved) && str_starts_with($keyResolved, ':')) {
                    if ($keyResolved === WindowBase::ORIGIN) $origin = trim(self::unquote($vText), '/');
                    continue;   // shutter option, not a route
                }
                $routes[] = [$kText, $vText];   // keep raw source text
            }

            $base = $origin !== '' ? $origin : self::controllerBase($class);
            foreach ($routes as [$kText, $vText]) {

                // literal handler is unquoted; a dynamic one is shown as-is
                $handler = self::isStringLiteral($vText) ? self::unquote($vText) : $vText;
                if ($handler === '') $handler = '(index)';
                $kind = str_starts_with($handler, 'win:') ? 'channel' : 'method';

                // literal keys join normally; dynamic keys are wrapped {expr} un-mangled
                $path = self::isStringLiteral($kText)
                    ? self::joinPath($base, self::unquote($kText))
                    : trim($base . '/{' . $kText . '}', '/');

                $rows[] = self::staticRow($class, $shutter, $path, $handler, $kind);
            }

            $i = $end;
        }

        return $rows;
    }

    private static function staticRow(string $class, string $shutter, string $path, string $handler, string $kind): array
    {
        return [
            'path'       => $path === '' ? '/' : $path,
            'handler'    => $handler,
            'kind'       => $kind,
            'controller' => $class,
            'shutter'    => $shutter,
            'options'    => [],
        ];
    }

    /** Return [innerTokens, closeIndex] for a balanced $open/$close starting at $openIdx. */
    private static function sliceBalanced(array $tokens, int $openIdx, string $open, string $close): array
    {
        $depth = 0; $inner = []; $n = count($tokens);
        for ($i = $openIdx; $i < $n; $i++) {
            $tk = $tokens[$i];
            if ($tk === $open) { $depth++; if ($depth === 1) continue; }
            elseif ($tk === $close) { $depth--; if ($depth === 0) return [$inner, $i]; }
            $inner[] = $tk;
        }
        return [$inner, $n - 1];
    }

    /** Split a token stream at a top-level single-char delimiter (respects () [] {}). */
    private static function splitTop(array $tokens, string $delim): array
    {
        $parts = []; $cur = []; $depth = 0;
        foreach ($tokens as $tk) {
            if (in_array($tk, ['(', '[', '{'], true)) $depth++;
            elseif (in_array($tk, [')', ']', '}'], true)) $depth--;
            if ($tk === $delim && $depth === 0) { $parts[] = $cur; $cur = []; continue; }
            $cur[] = $tk;
        }
        if ($cur !== []) $parts[] = $cur;
        return $parts;
    }

    private static function firstSig(array $tokens): mixed
    {
        foreach ($tokens as $tk) {
            if (is_array($tk) && $tk[0] === T_WHITESPACE) continue;
            return $tk;
        }
        return null;
    }

    /** Parse an array-literal argument into [ [keyText, valueText], ... ]. */
    private static function arrayPairs(array $argTokens): array
    {
        $openIdx = null;
        foreach ($argTokens as $idx => $tk) { if ($tk === '[') { $openIdx = $idx; break; } }
        if ($openIdx === null) return [];

        [$inner] = self::sliceBalanced($argTokens, $openIdx, '[', ']');
        $pairs = [];
        foreach (self::splitTop($inner, ',') as $el) {
            [$k, $v] = self::splitPair($el);
            if ($k === null) continue;                 // no '=>' -> not a route entry
            $pairs[] = [self::tokenText($k), self::tokenText($v)];
        }
        return $pairs;
    }

    /** Split one array element at its top-level '=>'. Returns [keyTokens|null, valueTokens]. */
    private static function splitPair(array $tokens): array
    {
        $depth = 0;
        foreach ($tokens as $idx => $tk) {
            if (in_array($tk, ['(', '[', '{'], true)) $depth++;
            elseif (in_array($tk, [')', ']', '}'], true)) $depth--;
            elseif ($depth === 0 && is_array($tk) && $tk[0] === T_DOUBLE_ARROW) {
                return [array_slice($tokens, 0, $idx), array_slice($tokens, $idx + 1)];
            }
        }
        return [null, $tokens];
    }

    private static function tokenText(array $tokens): string
    {
        $s = '';
        foreach ($tokens as $tk) {
            if (is_array($tk)) {
                if ($tk[0] === T_COMMENT || $tk[0] === T_DOC_COMMENT) continue;  // drop comments
                $s .= $tk[1];
            } else {
                $s .= $tk;
            }
        }
        return trim($s);
    }

    /** Resolve a shutter option key written as a constant (Window::ORIGIN) or literal (':ORIGIN'). */
    private static function resolveShutterKey(string $text): string
    {
        $name = trim($text);
        if (str_contains($name, '::')) {                 // e.g. self::ARG -> ARG
            $parts = explode('::', $name);
            $name  = trim(end($parts));
        }
        return self::shutterConsts()[$name] ?? self::unquote($text);
    }

    private static function isStringLiteral(string $s): bool
    {
        $s = trim($s);
        return strlen($s) >= 2 && ($s[0] === "'" || $s[0] === '"') && substr($s, -1) === $s[0];
    }

    /** Map of WindowBase shutter option constant NAME => ':VALUE' (read-only reflection). */
    private static function shutterConsts(): array
    {
        static $map = null;
        if ($map !== null) return $map;
        $map = [];
        try {
            foreach ((new ReflectionClass(WindowBase::class))->getConstants() as $name => $val) {
                if (is_string($val) && str_starts_with($val, ':')) $map[$name] = $val;
            }
        } catch (Throwable $e) {
            // ignore
        }
        return $map;
    }

    /** Strip surrounding quotes from a string literal; leave any other expression as-is. */
    private static function unquote(string $s): string
    {
        $s = trim($s);
        if (strlen($s) >= 2 && ($s[0] === "'" || $s[0] === '"') && substr($s, -1) === $s[0]) {
            $q     = $s[0];
            $inner = substr($s, 1, -1);
            return $q === "'"
                ? str_replace(["\\'", '\\\\'], ["'", '\\'], $inner)
                : str_replace(['\\"', '\\\\'], ['"', '\\'], $inner);
        }
        return $s;
    }

    // ---------------------------------------------------------------- output

    /** Pretty CLI table (for a `routes` command). $static uses the no-execution parser. */
    public static function render(?string $routesDir = null, bool $static = false): string
    {
        $rows = $static ? self::inspectStatic($routesDir) : self::inspect($routesDir);
        if (!$rows) return "No routes discovered.\n";

        // hard caps so one long value (e.g. an error message) can't blow out a column
        $cap = ['path' => 40, 'handler' => 34, 'kind' => 7, 'controller' => 40];

        $cells = [];
        foreach ($rows as $r) {
            $cells[] = [
                'path'       => self::trunc($r['path'], $cap['path']),
                'handler'    => self::trunc($r['handler'], $cap['handler']),
                'kind'       => self::trunc($r['kind'], $cap['kind']),
                'controller' => self::trunc(self::short($r['controller']), $cap['controller']),
            ];
        }

        $w = ['path' => 4, 'handler' => 7, 'kind' => 4, 'controller' => 10];
        foreach ($cells as $c) {
            foreach ($w as $k => $_) $w[$k] = max($w[$k], strlen($c[$k]));
        }

        $line = fn($p, $h, $k, $c) => sprintf(
            "  %-{$w['path']}s  %-{$w['handler']}s  %-{$w['kind']}s  %-{$w['controller']}s\n",
            $p, $h, $k, $c
        );

        $out  = $line('PATH', 'HANDLER', 'KIND', 'CONTROLLER');
        $out .= '  ' . str_repeat('-', array_sum($w) + 6) . "\n";
        foreach ($cells as $c) {
            $out .= $line($c['path'], $c['handler'], $c['kind'], $c['controller']);
        }
        $out .= "\n  " . count($rows) . " route(s)\n";
        return $out;
    }

    /** Truncate with an ellipsis so a single long value can't distort the table. */
    private static function trunc(string $s, int $max): string
    {
        $s = trim(preg_replace('/\s+/', ' ', $s));
        return strlen($s) <= $max ? $s : substr($s, 0, $max - 1) . '…';
    }

    public static function toJson(?string $routesDir = null, bool $static = false, int $flags = JSON_PRETTY_PRINT): string
    {
        return json_encode($static ? self::inspectStatic($routesDir) : self::inspect($routesDir), $flags);
    }

    private static function short(string $fqcn): string
    {
        return str_replace(scheme('windows\\Routes\\', false) . '\\', '', $fqcn);
    }
}
