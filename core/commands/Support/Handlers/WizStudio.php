<?php

namespace spoova\mi\core\commands\Support\Handlers;

use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliKey;
use spoova\mi\core\commands\Root\Cli\CliScreen;

/**
 * WizStudio — the "full reworked UX": the multi-line editor of {@see WizEditor}
 * (Enter = newline, Backspace-join, slash-command board with TAB select, titled
 * result boxes) on top of a PERSISTENT session — variables carry over between
 * runs, and the command set is richer:
 *
 *   /run /clear /list /vars /save <file> /load <file> /help /exit
 *
 * The whole frame (header, board, editor) is redrawn from the top of the screen
 * on every keystroke, so a terminal scroll can never leave a stale copy behind.
 * Every command box is shown just below the editor and wiped by the next render.
 * /run keeps the code (tweak & re-run); /clear starts a new block. Requires
 * `stty` + `pcntl`.
 */
class WizStudio {

    public const BOARD_CMDS = ['run', 'clear', 'list', 'vars', 'help', 'exit'];
    public const COMMANDS   = ['run', 'clear', 'list', 'vars', 'save', 'load', 'help', 'exit', 'quit'];

    private const BOARD_TEXT = '#312f38';
    private const BOARD_BOX  = '#312f38';
    private const BOARD_SEL  = '#1a56db';

    /** Fixed layout rows: header=1, board=2..4, editor starts at 5. */
    private const EDITOR_ROW = 5;

    function __construct(array $args = []) {
        self::run();
    }

    /* ---- pure editor logic ---- */

    public static function newState() : array { return ['lines' => [''], 'row' => 0, 'col' => 0]; }
    public static function text(array $s) : string { return implode("\n", $s['lines']); }

    public static function applyKey(array $s, string $k, string $ch = '') : array {
        $lines = $s['lines']; $row = $s['row']; $col = $s['col']; $line = $lines[$row] ?? '';
        switch ($k) {
            case 'char':
                $lines[$row] = mb_substr($line, 0, $col) . $ch . mb_substr($line, $col); $col += mb_strlen($ch); break;
            case 'enter':
                $left = mb_substr($line, 0, $col); $right = mb_substr($line, $col);
                $lines[$row] = $left; array_splice($lines, $row + 1, 0, [$right]); $row++; $col = 0; break;
            case 'backspace':
                if ($col > 0) { $lines[$row] = mb_substr($line, 0, $col - 1) . mb_substr($line, $col); $col--; }
                elseif ($row > 0) { $prev = mb_strlen($lines[$row - 1]); $lines[$row - 1] .= $line; array_splice($lines, $row, 1); $row--; $col = $prev; }
                break;
            case 'left':  if ($col > 0) { $col--; } elseif ($row > 0) { $row--; $col = mb_strlen($lines[$row]); } break;
            case 'right': if ($col < mb_strlen($line)) { $col++; } elseif ($row < count($lines) - 1) { $row++; $col = 0; } break;
            case 'up':    if ($row > 0) { $row--; $col = min($col, mb_strlen($lines[$row])); } break;
            case 'down':  if ($row < count($lines) - 1) { $row++; $col = min($col, mb_strlen($lines[$row])); } break;
        }
        return ['lines' => array_values($lines), 'row' => $row, 'col' => $col];
    }

    public static function parseCommand(string $line) : ?array {
        $t = trim($line);
        if (!preg_match('~^/([a-zA-Z]+)(?:\s+(.*))?$~', $t, $m)) return null;
        $name = strtolower($m[1]);
        if (!in_array($name, self::COMMANDS, true)) return null;
        return ['name' => $name, 'arg' => trim($m[2] ?? '')];
    }

    public static function nextSelected(?int $sel, int $count) : int {
        return ($sel === null) ? 0 : ($sel + 1) % max(1, $count);
    }

    /* ---- rendering helpers ---- */

    private static function boardPlain() : string {
        $toks = array_map(fn($n) => '/' . $n, self::BOARD_CMDS);
        return ' commands:   ' . implode('   ', $toks) . ' ';
    }

    private static function boardContent(?int $sel) : string {
        $parts = [];
        foreach (self::BOARD_CMDS as $i => $n) {
            $tok = '/' . $n;
            $parts[] = ($i === $sel)
                ? "\e[4m" . Cli::color($tok, self::BOARD_SEL) . "\e[24m"
                : Cli::color($tok, self::BOARD_TEXT);
        }
        return ' ' . Cli::color('commands:', self::BOARD_TEXT) . '   ' . implode('   ', $parts) . ' ';
    }

    private static function panel(string $title, string $body, string $titleColor) {
        $strip = fn($s) => preg_replace('/\e\[[0-9;?]*[a-zA-Z]/', '', (string) $s);
        $vis   = fn($s) => mb_strlen($strip($s));
        $lines = explode("\n", rtrim((string) $body, "\r\n"));
        if ($lines === ['']) $lines = ['(no output)'];
        $MAXW = 76; $tlen = $vis($title);
        $w = 0; foreach ($lines as $l) $w = max($w, $vis($l));
        $w = min($MAXW, max($w, $tlen + 2)); $span = $w + 2; $box = self::BOARD_BOX;
        $fill = max(0, $span - 3 - $tlen);
        Cli::textView(Cli::color('┌─ ', $box) . Cli::color($title, $titleColor) . Cli::color(' ' . str_repeat('─', $fill) . '┐', $box), 0, '|1');
        foreach ($lines as $l) {
            $len = $vis($l);
            if ($len > $w) { $l = mb_substr($strip($l), 0, $w - 1) . '…'; $len = $w; }
            Cli::textView(Cli::color('│', $box) . ' ' . $l . str_repeat(' ', max(0, $w - $len)) . ' ' . Cli::color('│', $box), 0, '|1');
        }
        Cli::textView(Cli::color('└' . str_repeat('─', $span) . '┘', $box), 0, '|1');
    }

    /* ---- session ---- */

    /** Friendly guard message when a required capability is missing. */
    private static function needError(string $need) {
        Cli::clearUp();
        Cli::break();
        Cli::headerView(':wiz error', break: 2);
        Cli::textView('WizStudio requires ' . Cli::warn($need) . ' support.', break: 2);
    }

    public static function run() {

        Cli::requires('stty',  fn() => self::needError('stty'));
        Cli::requires('pcntl', fn() => self::needError('pcntl'));
        Cli::silentErrors();
        $scope   = [];
        $state   = self::newState();
        $viewH   = max(3, (CliScreen::height() ?: 24) - self::EDITOR_ROW - 1);
        $scroll  = 0;
        $selected = null; // board-command selector: null = none; 0..n-1 = highlighted

        // Redraw the ENTIRE frame from the top each time, so a terminal scroll can
        // never leave a duplicate behind (\e[0K clears each line's tail, \e[0J
        // clears everything below the editor: stale rows, command boxes, leftovers).
        $render = function () use (&$state, &$scroll, &$selected, $viewH) {
            Cli::hideCursor();
            $box = self::BOARD_BOX;
            Cli::moveTo(1, 1)->textPlain(Cli::alert(' █ wiz · studio · variables carry over') . "\e[0K");
            $inner = mb_strlen(self::boardPlain());
            Cli::moveTo(1, 2)->textPlain(Cli::color('┌' . str_repeat('─', $inner) . '┐', $box) . "\e[0K");
            Cli::moveTo(1, 3)->textPlain(Cli::color('│', $box) . self::boardContent($selected) . Cli::color('│', $box) . "\e[0K");
            Cli::moveTo(1, 4)->textPlain(Cli::color('└' . str_repeat('─', $inner) . '┘', $box) . "\e[0K");

            $lines = $state['lines'];
            $total = count($lines);
            if ($state['row'] < $scroll)                  $scroll = $state['row'];
            elseif ($state['row'] > $scroll + $viewH - 1) $scroll = $state['row'] - $viewH + 1;
            $scroll = max(0, min($scroll, max(0, $total - $viewH)));
            $shown  = min($total - $scroll, $viewH);
            for ($v = 0; $v < $shown; $v++) {
                $idx = $scroll + $v;
                $num = sprintf('%2d.', $idx + 1);
                Cli::moveTo(1, self::EDITOR_ROW + $v)->textPlain(Cli::warn($num) . ' ' . $lines[$idx] . "\e[0K");
            }
            Cli::moveTo(1, self::EDITOR_ROW + $shown);
            print "\e[0J";
            Cli::moveTo(1 + 4 + $state['col'], self::EDITOR_ROW + ($state['row'] - $scroll)); // caret
            Cli::showCursor();
        };

        print "\e[2J\e[3J\e[H"; // clear once; the render owns the frame thereafter
        $render();

        Cli::input(function (CliKey $key) use (&$state, &$scope, &$selected, $render, $viewH) {

            // Ctrl+C / signals -> leave
            if ($key->isExit()) {
                Cli::showCursor();
                Cli::moveTo(1, self::EDITOR_ROW + min(count($state['lines']), $viewH));
                print "\e[0J";
                Cli::break(1);
                Cli::textView(Cli::warn('WizStudio terminated.'), 0, '|1');
                $key->exit();
                return;
            }

            // TAB enters / cycles the board command selector (render redraws the board)
            if ($key->isTab()) {
                $selected = self::nextSelected($selected, count(self::BOARD_CMDS));
                $render();
                return;
            }

            // while a board command is highlighted
            if ($selected !== null) {
                if ($key->isEnter()) {
                    $name = self::BOARD_CMDS[$selected]; $selected = null;
                    return self::command(['name' => $name, 'arg' => ''], $state, $scope, $render, $viewH, $key);
                }
                $selected = null; $render();
            }

            if ($key->isEnter()) {
                $cur = $state['lines'][$state['row']] ?? '';
                if ($cmd = self::parseCommand($cur)) {
                    return self::command($cmd, $state, $scope, $render, $viewH, $key);
                }
                $state = self::applyKey($state, 'enter'); $render(); return;
            }

            if ($key->isBackspace()) { $state = self::applyKey($state, 'backspace'); $render(); return; }
            if ($key->isArrow('left'))  { $state = self::applyKey($state, 'left');  $render(); return; }
            if ($key->isArrow('right')) { $state = self::applyKey($state, 'right'); $render(); return; }
            if ($key->isArrow('up'))    { $state = self::applyKey($state, 'up');    $render(); return; }
            if ($key->isArrow('down'))  { $state = self::applyKey($state, 'down');  $render(); return; }

            if ($key->isWritable()) {
                $ch = $key->fetch();
                if ($ch === false) return;
                $state = self::applyKey($state, 'char', $ch); $render(); return;
            }
        });
    }

    /**
     * Handle a slash command. Output boxes are drawn just below the editor; the
     * next keystroke's full redraw wipes them. The typed command line is dropped
     * first (but a TAB-selected command leaves the code line intact, so it runs).
     */
    private static function command(array $cmd, array &$state, array &$scope, \Closure $render, int $viewH, CliKey $key) {

        $below = fn() => Cli::moveTo(1, self::EDITOR_ROW + min(count($state['lines']), $viewH));

        $dropLine = function () use (&$state, $cmd) {
            $cur = self::parseCommand($state['lines'][$state['row']] ?? '');
            if ($cur && $cur['name'] === $cmd['name']) {
                array_splice($state['lines'], $state['row'], 1);
                if (!$state['lines']) $state['lines'] = [''];
                $state['row'] = max(0, min($state['row'], count($state['lines']) - 1));
                $state['col'] = 0;
            }
        };

        switch ($cmd['name']) {

            case 'exit':
            case 'quit':
                Cli::showCursor();
                $below();
                print "\e[0J";
                Cli::break(1);
                Cli::textView(Cli::valid('WizStudio exited successfully.'), 0, '|1');
                $key->exit();
                return;

            case 'clear':
                $state = self::newState();
                $render();
                return;

            case 'list':
                $dropLine(); $render(); $below();
                self::panel('collected', ($t = self::text($state)) === '' ? '(empty)' : $t, self::BOARD_SEL);
                return;

            case 'vars':
                $dropLine(); $render(); $below();
                self::panel('variables', self::varsText($scope), self::BOARD_SEL);
                return;

            case 'help':
                $dropLine(); $render(); $below();
                self::panel('commands',
                    "/run     run the block · variables + code kept\n" .
                    "/clear   empty the editor (start a new block)\n" .
                    "/list    show the current block\n" .
                    "/vars    show variables in scope\n" .
                    "/save f  write the block to file f\n" .
                    "/load f  read file f into the editor\n" .
                    "/exit    leave", self::BOARD_SEL);
                return;

            case 'save':
                $dropLine(); $render(); $below();
                self::saveBuffer($cmd['arg'], trim(self::text($state)));
                return;

            case 'load':
                $loaded = self::loadBuffer($cmd['arg']);
                if ($loaded !== null) {
                    $state = ['lines' => $loaded === [] ? [''] : $loaded, 'row' => 0, 'col' => 0];
                    $render();
                } else {
                    $dropLine(); $render(); $below();
                    self::panel('error', 'cannot read: ' . ($cmd['arg'] === '' ? '(no file given)' : $cmd['arg']), '#c0392b');
                }
                return;

            case 'run':
                $dropLine();
                $code = trim(self::text($state));
                $r = self::evaluate($code, $scope); // persists $scope
                $render();                           // redraw the editor (the code stays)
                $below();
                if ($r['ok']) self::panel('result', $r['text'] === '' ? '(no output)' : $r['text'], '#1a7f37');
                else          self::panel('error', $r['text'], '#c0392b');
                Cli::textView(Cli::warn('  variables kept · edit & /run again · /clear for a new block'), 0, '|1');
                // The code stays for continuity (tweak & re-run); /clear starts a
                // fresh block. The result/note is wiped by the next keystroke's
                // full redraw, so nothing lingers and nothing duplicates.
                return;
        }
    }

    /* ---- evaluation + rich helpers ---- */

    private static function evaluate(string $code, array &$scope) : array {
        if ($code === '') return ['ok' => true, 'text' => '(nothing to run)'];
        extract($scope, EXTR_SKIP);
        try {
            ob_start();
            eval($code);
            $out = ob_get_clean();
            $scope = array_diff_key(get_defined_vars(), array_flip(['code', 'scope', 'out']));
            return ['ok' => true, 'text' => $out];
        } catch (\Throwable $e) {
            if (ob_get_level() > 0) ob_end_clean();
            return ['ok' => false, 'text' => get_class($e) . ': ' . $e->getMessage()];
        }
    }

    private static function varsText(array $scope) : string {
        if (!$scope) return '(no variables yet)';
        $out = [];
        foreach ($scope as $k => $v) $out[] = '$' . $k . ' = ' . self::shortValue($v);
        return implode("\n", $out);
    }

    private static function shortValue($v) : string {
        if (is_scalar($v) || $v === null) $s = var_export($v, true);
        elseif (is_array($v))             $s = 'array(' . count($v) . ')';
        else                              $s = is_object($v) ? get_class($v) : gettype($v);
        $s = str_replace("\n", ' ', $s);
        return mb_strlen($s) > 60 ? mb_substr($s, 0, 59) . '…' : $s;
    }

    private static function saveBuffer(string $file, string $code) {
        if ($file === '')   { self::panel('error', 'usage: /save <file>', '#c0392b'); return; }
        if (is_file($file)) { self::panel('error', 'file already exists: ' . $file, '#c0392b'); return; }
        $ok = @file_put_contents($file, "<?php\n\n" . $code . "\n");
        if ($ok === false)  self::panel('error', 'could not write: ' . $file, '#c0392b');
        else                self::panel('saved', $file, '#1a7f37');
    }

    /** @return string[]|null lines on success, null when the file cannot be read */
    private static function loadBuffer(string $file) : ?array {
        if ($file === '' || !is_file($file)) return null;
        $raw = @file_get_contents($file);
        if ($raw === false) return null;
        $raw = preg_replace('/^<\?php\s*/', '', $raw);
        $raw = rtrim($raw, "\r\n");
        return explode("\n", $raw);
    }

}
