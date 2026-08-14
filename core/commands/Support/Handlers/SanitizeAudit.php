<?php

namespace spoova\mi\core\commands\Support\Handlers;

/**
 * class SanitizeAudit
 *
 * The reading half of "project sanitize" — it inspects the project and reports
 * what a deployment would trip over. It writes nothing and prints nothing, so
 * the rules below can be exercised without a console.
 *
 * The autoloader is the only place where a class name meets a case-sensitive
 * filesystem. PHP class names are themselves case-insensitive, so `new Filemanager`
 * against `class FileManager` is harmless once the class is loaded — what has to
 * match exactly is the *path* PSR-4 builds from the fully qualified name.
 *
 * NOTE for anyone extending this: on Windows, is_file() and file_exists() are
 * case-insensitive, so they will happily confirm a file that Linux would never
 * find. Every path comparison here is a strict string comparison against the real
 * name read back from the directory, never a file_exists() probe.
 *
 * @author Akinola Saheed <akinolasaheed001@gmail.com>
 */
class SanitizeAudit
{
    /** PSR-4 prefix that maps to the project root (see composer.json autoload). */
    public const prefix = 'spoova\\mi\\';

    /** Directories walked for class declarations. */
    public const scanned = ['core', 'windows', 'index', 'icore', 'mi'];

    /** Never walked — third party code and the sanitize backups themselves. */
    public const skipped = ['vendor', 'backup', '.git', 'node_modules'];

    /** Offline credential keys that must be empty before a deployment. */
    public const credentials = ['NAME', 'USER', 'PASS', 'SERVER', 'PORT', 'SOCKET'];

    private string $root;

    /** @var list<string>|null memoised file list */
    private ?array $files = null;

    public function __construct(?string $root = null)
    {
        $this->root = rtrim(to_frontslash($root ?? docroot), '/');
    }

    public function root(): string
    {
        return $this->root;
    }

    /* --------------------------------------------------------------------- *
     *  Class declarations                                                    *
     * --------------------------------------------------------------------- */

    /**
     * Every .php file under the scanned directories, as paths relative to the root.
     *
     * @return list<string>
     */
    public function files(): array
    {
        if ($this->files !== null) {
            return $this->files;
        }

        $files = [];

        foreach (self::scanned as $directory) {
            $path = $this->root.'/'.$directory;

            if (is_file($path)) {          // "mi" is a file, not a directory
                if (str_ends_with($path, '.php')) $files[] = $directory;
                continue;
            }

            if (!is_dir($path)) continue;

            $walker = new \RecursiveIteratorIterator(
                new \RecursiveCallbackFilterIterator(
                    new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS),
                    fn($current) => !in_array($current->getFilename(), self::skipped, true)
                )
            );

            foreach ($walker as $file) {
                if ($file->isFile() && strtolower($file->getExtension()) === 'php') {
                    $files[] = ltrim(substr(to_frontslash($file->getPathname()), strlen($this->root)), '/');
                }
            }
        }

        sort($files);

        return $this->files = $files;
    }

    /**
     * Fully qualified names declared in a source string.
     *
     * The tokenizer is used rather than a regular expression so that the word
     * "class" inside a comment, a docblock, a string, a `::class` constant or an
     * anonymous class cannot be mistaken for a declaration.
     *
     * @return list<string>
     */
    public static function declarations(string $source): array
    {
        $tokens = @token_get_all($source);
        $namespace = '';
        $found = [];
        $count = count($tokens);

        for ($i = 0; $i < $count; $i++) {
            $token = $tokens[$i];

            if (!is_array($token)) continue;

            if ($token[0] === T_NAMESPACE) {
                $namespace = '';
                for ($j = $i + 1; $j < $count; $j++) {
                    if (is_string($tokens[$j]) && ($tokens[$j] === ';' || $tokens[$j] === '{')) break;
                    if (is_array($tokens[$j]) && in_array($tokens[$j][0], [T_STRING, T_NS_SEPARATOR], true)) {
                        $namespace .= $tokens[$j][1];
                    } elseif (is_array($tokens[$j]) && defined('T_NAME_QUALIFIED') && $tokens[$j][0] === T_NAME_QUALIFIED) {
                        $namespace .= $tokens[$j][1];
                    }
                }
                $namespace = trim($namespace, '\\');
                continue;
            }

            $kinds = [T_CLASS, T_INTERFACE, T_TRAIT];
            if (defined('T_ENUM')) $kinds[] = T_ENUM;

            if (!in_array($token[0], $kinds, true)) continue;

            // "Foo::class" is a constant, not a declaration
            $previous = self::significantBefore($tokens, $i);
            if (is_array($previous) && $previous[0] === T_DOUBLE_COLON) continue;
            if (is_array($previous) && $previous[0] === T_NEW) continue;   // anonymous class

            // the name is the next T_STRING; anything else means an anonymous class
            $name = null;
            for ($j = $i + 1; $j < $count; $j++) {
                if (is_array($tokens[$j]) && $tokens[$j][0] === T_WHITESPACE) continue;
                if (is_array($tokens[$j]) && $tokens[$j][0] === T_STRING) $name = $tokens[$j][1];
                break;
            }

            if ($name === null) continue;

            $found[] = $namespace === '' ? $name : $namespace.'\\'.$name;
        }

        return $found;
    }

    /** The last token before $index that is not whitespace or a comment. */
    private static function significantBefore(array $tokens, int $index): mixed
    {
        for ($i = $index - 1; $i >= 0; $i--) {
            if (is_array($tokens[$i]) && in_array($tokens[$i][0], [T_WHITESPACE, T_COMMENT, T_DOC_COMMENT], true)) {
                continue;
            }
            return $tokens[$i];
        }
        return null;
    }

    /**
     * The path PSR-4 will build for a fully qualified name, relative to the root.
     *
     * @return string|null NULL when the name lies outside the project's prefix
     */
    public static function expectedPath(string $fqcn): ?string
    {
        if (strncasecmp($fqcn, self::prefix, strlen(self::prefix)) !== 0) {
            return null;
        }

        return str_replace('\\', '/', substr($fqcn, strlen(self::prefix))).'.php';
    }

    /**
     * Class declarations whose file the autoloader would fail to find on a
     * case-sensitive filesystem.
     *
     * A declaration is only judged against its own file. Several classes sharing
     * one file — traits written alongside the class they belong to, for instance —
     * are co-located on purpose and are never individually autoloadable, so they
     * are not findings. The test is therefore: does a file exist bearing this
     * class's own name, and if so, is it spelled and placed exactly as PSR-4 expects?
     *
     * @return list<array{fqcn:string,actual:string,expected:string,kind:string}>
     */
    public function classFindings(): array
    {
        $findings = [];

        foreach ($this->files() as $relative) {
            $source = @file_get_contents($this->root.'/'.$relative);

            if ($source === false) continue;

            foreach (self::declarations($source) as $fqcn) {
                $expected = self::expectedPath($fqcn);

                if ($expected === null || $expected === $relative) continue;

                // co-located declaration (a trait beside its class) — intended, not a fault
                if (strcasecmp(basename($expected), basename($relative)) !== 0) continue;

                $findings[] = [
                    'fqcn'     => $fqcn,
                    'actual'   => $relative,
                    'expected' => $expected,
                    'kind'     => strcasecmp($expected, $relative) === 0 ? 'case' : 'path',
                ];
            }
        }

        return $findings;
    }

    /* --------------------------------------------------------------------- *
     *  Credentials                                                           *
     * --------------------------------------------------------------------- */

    public function dbconfigPath(): string
    {
        return $this->root.'/icore/dbconfig.php';
    }

    /**
     * Offline credential keys that still carry a value.
     *
     * Only the key names are reported — a sanitize report is often pasted into a
     * chat or an issue, so the values themselves never leave this class.
     *
     * @param array $offline the offline half of a loaded dbconfig
     * @return list<string>
     */
    public static function filledCredentials(array $offline): array
    {
        $filled = [];

        foreach (self::credentials as $key) {
            if (trim((string) ($offline[$key] ?? '')) !== '') {
                $filled[] = $key;
            }
        }

        return $filled;
    }

    /* --------------------------------------------------------------------- *
     *  Storage                                                               *
     * --------------------------------------------------------------------- */

    public function storagePath(): string
    {
        return $this->root.'/core/storage';
    }

    /**
     * What is sitting in core/storage, which is regenerated online and so is only
     * upload weight.
     *
     * @return array{count:int,bytes:int}
     */
    public function storageUsage(): array
    {
        $path = $this->storagePath();

        if (!is_dir($path)) {
            return ['count' => 0, 'bytes' => 0];
        }

        $count = 0;
        $bytes = 0;

        $walker = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS)
        );

        foreach ($walker as $file) {
            if ($file->isFile()) {
                $count++;
                $bytes += $file->getSize();
            }
        }

        return ['count' => $count, 'bytes' => $bytes];
    }

    /**
     * Render a byte count in the largest unit that keeps it short.
     */
    public static function readableSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $unit = 0;
        $size = (float) $bytes;

        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }

        return ($unit === 0 ? (string) (int) $size : number_format($size, 1)).$units[$unit];
    }
}
