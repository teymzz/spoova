<?php

namespace spoova\mi\core\commands\Support;

use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Entry;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use spoova\mi\core\classes\Enums\inflect;

/**
 * Portability lint — a read-only scan for hardcoded absolute URLs that would
 * break Spoova's cross-environment promise (localhost/project == domain.com).
 *
 *   mi lint                 scan defaults (windows/ + res local css & js)
 *   mi lint <path>          scan a specific file or directory (relative to docroot)
 *   mi lint --host=site.com also flag a hardcoded production host
 *   mi lint json            machine-readable output
 *
 * It flags:
 *   - href/src/action/... = "/..."     (root-absolute; breaks under a subfolder)
 *   - url(/...) in CSS                  (same)
 *   - fetch/open/axios/ajax('/...')     (absolute JS endpoints)
 *   - http(s)://localhost...            (environment-specific host)
 *   - http(s)://<--host>...             (optional production host)
 *
 * It NEVER edits or executes anything — it only reads files and reports.
 * Correct, portable URLs go through @domurl(...) / @res(...) / scheme().
 */
class Lint extends Entry {

    /** @var array<int,array{file:string,line:int,snippet:string,reason:string}> */
    private array $findings = [];
    private int $scanned = 0;

    private const EXTS = ['php', 'css', 'js', 'html', 'htm'];

    /** path fragments that mark third-party / generated code we should not lint */
    private const SKIP = ['/vendor/', '/.git/', '/node_modules/', '/jquery/', '/bootstrap/', '/mdb5/', '/mdb/', '/fontawesome/', '/bi/'];

    public function __construct($args = [])
    {
        $args = array_values($args);

        $json  = in_array('json', $args, true);
        $host  = '';
        $paths = [];

        foreach ($args as $a) {
            if ($a === 'json' || $a === 'portability') continue;
            if (str_starts_with($a, '--host=')) { $host = trim(substr($a, 7)); continue; }
            if (str_starts_with($a, '--')) continue;   // unknown flag: ignore
            $paths[] = $a;                              // scan-path override
        }

        $roots = $paths ?: ['windows', 'res/main/css/local', 'res/main/js/local'];

        Cli::textView(Cli::danger(Cli::emo('point-list').' lint portability'));
        Cli::break(2);

        foreach ($roots as $root) {
            $this->scanPath(rtrim(docroot, '/\\') . '/' . trim($root, '/\\'), $host);
        }

        if ($json) {
            echo json_encode($this->findings, JSON_PRETTY_PRINT) . PHP_EOL;
            Cli::break(1)->bashBreak(1);
            return;
        }

        echo $this->report();
        Cli::break(1)->bashBreak(1);
    }

    // ---------------------------------------------------------------- scanning

    private function scanPath(string $path, string $host): void
    {
        if (is_file($path)) { $this->scanFile($path, $host); return; }
        if (!is_dir($path)) return;

        $it = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS)
        );
        foreach ($it as $f) {
            if ($f->isFile()) $this->scanFile($f->getPathname(), $host);
        }
    }

    private function skip(string $path): bool
    {
        $p = str_replace('\\', '/', $path);
        foreach (self::SKIP as $frag) {
            if (str_contains($p, $frag)) return true;
        }
        return (bool) preg_match('/\.min\.(css|js)$/i', $p);
    }

    private function scanFile(string $file, string $host): void
    {
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (!in_array($ext, self::EXTS, true) || $this->skip($file)) return;

        $code = @file_get_contents($file);
        if ($code === false) return;

        $this->scanned++;

        $markup = in_array($ext, ['php', 'html', 'htm'], true);
        $css    = $ext === 'css' || $markup;   // .rex.php may hold inline <style>
        $js     = $ext === 'js' || $markup;    // .rex.php may hold inline <script>

        $lines = explode("\n", str_replace("\r\n", "\n", $code));

        foreach ($lines as $i => $line) {
            $ln = $i + 1;

            // 1) root-absolute attribute values in markup
            if ($markup && preg_match_all('~\b(?:href|src|action|poster|data-src|data-href|formaction)\s*=\s*(["\'])(/(?!/)[^"\']*)\1~i', $line, $m, PREG_SET_ORDER)) {
                foreach ($m as $hit) $this->add($file, $ln, $hit[0], 'root-absolute path — use @domurl()/@res()');
            }

            // 2) absolute url() in CSS (or inline styles)
            if ($css && preg_match_all('~url\(\s*(["\']?)(/(?!/)[^)"\']*)\1\s*\)~i', $line, $m, PREG_SET_ORDER)) {
                foreach ($m as $hit) $this->add($file, $ln, $hit[0], 'absolute url() — make relative or use @res()');
            }

            // 3) absolute JS endpoints
            if ($js && preg_match_all('~\b(?:fetch|axios(?:\.\w+)?|\.open|\.load|\.ajax|\.get|\.post)\s*\(\s*(["\'])(/(?!/)[^"\']*)\1~i', $line, $m, PREG_SET_ORDER)) {
                foreach ($m as $hit) $this->add($file, $ln, $hit[0], 'absolute endpoint — resolve against the base');
            }

            // 4) hardcoded localhost host (any file type)
            if (preg_match_all('~https?://localhost[^\s"\'<>)]*~i', $line, $m)) {
                foreach ($m[0] as $hit) $this->add($file, $ln, $hit, 'hardcoded localhost host — drop the host');
            }

            // 5) optional hardcoded production host
            if ($host !== '' && preg_match_all('~https?://' . preg_quote($host, '~') . '[^\s"\'<>)]*~i', $line, $m)) {
                foreach ($m[0] as $hit) $this->add($file, $ln, $hit, 'hardcoded production host — drop the host');
            }
        }
    }

    private function add(string $file, int $line, string $snippet, string $reason): void
    {
        $rel  = str_replace('\\', '/', $file);
        $root = str_replace('\\', '/', rtrim(docroot, '/\\')) . '/';
        if (str_starts_with($rel, $root)) $rel = substr($rel, strlen($root));

        $this->findings[] = [
            'file'    => $rel,
            'line'    => $line,
            'snippet' => trim($snippet),
            'reason'  => $reason,
        ];
    }

    // ---------------------------------------------------------------- output

    private function report(): string
    {
        if (!$this->findings) {
            return "  " . Cli::success('No hardcoded absolute URLs found.') . " ({$this->scanned} files scanned)\n";
        }

        $byFile = [];
        foreach ($this->findings as $f) $byFile[$f['file']][] = $f;

        $out = '';
        foreach ($byFile as $file => $items) {
            $out .= "\n  " . Cli::warn($file) . "\n";
            foreach ($items as $it) {
                $snip = strlen($it['snippet']) > 58 ? substr($it['snippet'], 0, 57) . '…' : $it['snippet'];
                $out .= sprintf("    %-5s  %-58s  %s\n", $it['line'], $snip, $it['reason']);
            }
        }

        $n = count($this->findings);
        $out .= "\n  ".Cli::alert("Scanned: ").Cli::warn("{$this->scanned} ").inflect(['file','files'], $n, inflect::smart)." · ";
        $out .= Cli::danger("{$n} ".inflect(['flag','flags'], $n, inflect::smart))."\n";
        $out .= "\n  ".Cli::alert('Tip').": consider using ".Cli::warn('[@domurl, @res]')." URL directives.\n";
        return $out;
    }

}
