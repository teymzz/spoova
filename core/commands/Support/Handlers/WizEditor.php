<?php

namespace spoova\mi\core\commands\Support\Handlers;

use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliKey;
use spoova\mi\core\commands\Root\Cli\CliScreen;

/**
 * WizEditor — the "beautiful" :wiz console (one of the flavours offered by WizLauncher).
 *
 * A raw-mode, multi-line editor for running PHP snippets from the CLI:
 *   - Enter starts a new line; Backspace at the START of a line joins it back
 *     onto the previous line (a natural editor, so there is no separate delete
 *     command);
 *   - a "commands" board is shown above the editor. Its slash-commands can be
 *     typed on a line (e.g. `/run`) or picked with TAB (which cycles/highlights
 *     them) and then ENTER to execute; any other key drops the highlight and is
 *     received as normal input;
 *   - `/run` evaluates the collected code and shows the output in a titled box.
 *
 * Requires `stty` and the `pcntl` extension (same as {@see Cli::input()}).
 *
 * The editing behaviour lives in pure functions ({@see applyKey},
 * {@see parseCommand}, {@see nextSelected}) so it is deterministic and testable.
 */
class WizEditor {

    /** Slash-commands shown (and TAB-selectable) on the board, in order. */
    public const BOARD_CMDS = ['run', 'clear', 'list', 'help', 'exit'];

    /** All slash-commands recognised when typed on a line. */
    public const COMMANDS = ['run', 'clear', 'list', 'help', 'exit', 'quit'];

    private const BOARD_TEXT = '#312f38';
    private const BOARD_BOX  = '#312f38';
    private const BOARD_SEL  = '#1a56db'; // colour of the TAB-selected command

    function __construct() {
        self::run();
    }

    /* =====================================================================
       PURE EDITOR LOGIC (no I/O)
       state = ['lines' => string[], 'row' => int, 'col' => int]
       ===================================================================== */

    /** Fresh empty buffer. */
    public static function newState() : array {
        return ['lines' => [''], 'row' => 0, 'col' => 0];
    }

    /** Full text of the buffer. */
    public static function text(array $s) : string {
        return implode("\n", $s['lines']);
    }

    /**
     * Apply one key event to the buffer and return the new state.
     *
     * @param array  $s  current state
     * @param string $k  one of: char, enter, backspace, left, right, up, down
     * @param string $ch the character to insert when $k === 'char'
     */
    public static function applyKey(array $s, string $k, string $ch = '') : array {
        $lines = $s['lines'];
        $row   = $s['row'];
        $col   = $s['col'];
        $line  = $lines[$row] ?? '';

        switch ($k) {

            case 'char':
                $lines[$row] = mb_substr($line, 0, $col) . $ch . mb_substr($line, $col);
                $col += mb_strlen($ch);
                break;

            case 'enter': // newline: split the current line at the caret
                $left  = mb_substr($line, 0, $col);
                $right = mb_substr($line, $col);
                $lines[$row] = $left;
                array_splice($lines, $row + 1, 0, [$right]);
                $row++;
                $col = 0;
                break;

            case 'backspace':
                if ($col > 0) {
                    // delete the character before the caret
                    $lines[$row] = mb_substr($line, 0, $col - 1) . mb_substr($line, $col);
                    $col--;
                } elseif ($row > 0) {
                    // caret at column 0 -> join this line onto the previous one
                    $prevLen = mb_strlen($lines[$row - 1]);
                    $lines[$row - 1] .= $line;
                    array_splice($lines, $row, 1);
                    $row--;
                    $col = $prevLen;
                }
                break;

            case 'left':
                if ($col > 0)     { $col--; }
                elseif ($row > 0) { $row--; $col = mb_strlen($lines[$row]); }
                break;

            case 'right':
                if ($col < mb_strlen($line))      { $col++; }
                elseif ($row < count($lines) - 1) { $row++; $col = 0; }
                break;

            case 'up':
                if ($row > 0) { $row--; $col = min($col, mb_strlen($lines[$row])); }
                break;

            case 'down':
                if ($row < count($lines) - 1) { $row++; $col = min($col, mb_strlen($lines[$row])); }
                break;
        }

        return ['lines' => array_values($lines), 'row' => $row, 'col' => $col];
    }

    /**
     * Parse a line as a slash command. Returns ['name'=>, 'arg'=>] or null when
     * the line is ordinary code (so `//comment`, `/regex/`, unknown `/foo` etc.
     * stay as code because they do not match a known command name exactly).
     */
    public static function parseCommand(string $line) : ?array {
        $t = trim($line);
        if (!preg_match('~^/([a-zA-Z]+)(?:\s+(.*))?$~', $t, $m)) return null;
        $name = strtolower($m[1]);
        if (!in_array($name, self::COMMANDS, true)) return null;
        return ['name' => $name, 'arg' => trim($m[2] ?? '')];
    }

    /** Next board selection index when TAB is pressed (null -> 0, then wraps). */
    public static function nextSelected(?int $sel, int $count) : int {
        return ($sel === null) ? 0 : ($sel + 1) % max(1, $count);
    }

    /* =====================================================================
       RENDERING HELPERS
       ===================================================================== */

    /** Visible (uncoloured) inner content — used only to size the borders. */
    private static function boardPlain() : string {
        $toks = array_map(fn($n) => '/' . $n, self::BOARD_CMDS);
        return ' commands:   ' . implode('   ', $toks) . ' ';
    }

    /**
     * Coloured inner content. When $sel is an index, that command is shown with
     * an accent colour + underline for the TAB selector. ANSI codes add no
     * visible width, so the borders still line up.
     */
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

    /** Draw the "commands" board (optionally with one command highlighted). */
    private static function board(?int $sel = null) {
        $inner = mb_strlen(self::boardPlain());
        $bar   = Cli::color('│', self::BOARD_BOX);
        Cli::textView(Cli::color('┌' . str_repeat('─', $inner) . '┐', self::BOARD_BOX), 0, '|1');
        Cli::textView($bar . self::boardContent($sel) . $bar, 0, '|1');
        Cli::textView(Cli::color('└' . str_repeat('─', $inner) . '┘', self::BOARD_BOX), 0, '|1');
    }

    /**
     * Draw a titled box (used for the /run result and /list output). Sizes
     * itself to the widest line (capped at 76 cols; longer lines truncated) and
     * embeds the title in the top border.
     */
    private static function panel(string $title, string $body, string $titleColor) {
        $strip = fn($s) => preg_replace('/\e\[[0-9;?]*[a-zA-Z]/', '', (string) $s);
        $vis   = fn($s) => mb_strlen($strip($s));

        $lines = explode("\n", rtrim((string) $body, "\r\n"));
        if ($lines === ['']) $lines = ['(no output)'];

        $MAXW = 76;
        $tlen = $vis($title);
        $w = 0; foreach ($lines as $l) $w = max($w, $vis($l));
        $w    = min($MAXW, max($w, $tlen + 2));
        $span = $w + 2;
        $box  = self::BOARD_BOX;

        $fill = max(0, $span - 3 - $tlen);
        Cli::textView(
            Cli::color('┌─ ', $box) . Cli::color($title, $titleColor)
            . Cli::color(' ' . str_repeat('─', $fill) . '┐', $box), 0, '|1'
        );
        foreach ($lines as $l) {
            $len = $vis($l);
            if ($len > $w) { $l = mb_substr($strip($l), 0, $w - 1) . '…'; $len = $w; }
            Cli::textView(Cli::color('│', $box) . ' ' . $l . str_repeat(' ', max(0, $w - $len)) . ' ' . Cli::color('│', $box), 0, '|1');
        }
        Cli::textView(Cli::color('└' . str_repeat('─', $span) . '┘', $box), 0, '|1');
    }

    /* =====================================================================
       INTERACTIVE LOOP (raw mode via Cli::input)
       ===================================================================== */

    /** Friendly guard message when a required capability is missing. */
    private static function needError(string $need) {
        Cli::clearUp();
        Cli::break();
        Cli::headerView(':wiz error', break: 2);
        Cli::textView('WizCode Runner requires ' . Cli::warn($need) . ' support.', break: 2);
    }

    public static function run() {

        Cli::requires('stty',  fn() => self::needError('stty'));
        Cli::requires('pcntl', fn() => self::needError('pcntl'));
        Cli::silentErrors();

        Cli::textView(Cli::alert(' █ wiz · code runner'), 0, '|1');
        self::board();

        $state  = self::newState();
        $origin = Cli::cursorPosition('col'); // anchor for the numbered lines (below the board)
        if (!$origin) return false; // stty is guaranteed above; a rare cursor-report failure just bails

        // visible window height (anchor -> just above the screen bottom) so a block
        // taller than the screen scrolls in place instead of merging on the last row
        $viewH = max(3, (CliScreen::height() ?: 24) - $origin[1] - 1);
        $scroll = 0;
        $render = function () use (&$state, &$scroll, $origin, $viewH) {
            Cli::hideCursor();
            $lines = $state['lines'];
            $total = count($lines);
            // keep the caret inside the visible window
            if ($state['row'] < $scroll)                  $scroll = $state['row'];
            elseif ($state['row'] > $scroll + $viewH - 1) $scroll = $state['row'] - $viewH + 1;
            $scroll = max(0, min($scroll, max(0, $total - $viewH)));
            $shown  = min($total - $scroll, $viewH);
            for ($v = 0; $v < $shown; $v++) {
                $idx  = $scroll + $v;
                $num  = sprintf('%2d.', $idx + 1);
                $text = $lines[$idx];
                $pad  = str_repeat(' ', max(0, 60 - mb_strlen($text)));
                Cli::moveTo($origin[0], $origin[1] + $v)->textPlain(Cli::warn($num) . ' ' . $text . $pad);
            }
            // clear everything below the editor (stale rows after a join/clear/scroll,
            // and any /help or /list panel) so leftover output goes as editing resumes
            Cli::moveTo(1, $origin[1] + $shown);
            print "\e[0J";
            Cli::moveTo($origin[0] + 4 + $state['col'], $origin[1] + ($state['row'] - $scroll)); // caret
            Cli::showCursor();
        };

        // board-command selector: null = not selecting; 0..n-1 = highlighted command
        $selected = null;
        $boardMid = $origin[1] - 2; // the board's middle row sits just above the anchor

        $renderBoard = function (?int $sel) use ($boardMid, $origin, &$state) {
            Cli::hideCursor();
            $bar = Cli::color('│', self::BOARD_BOX);
            Cli::moveTo(1, $boardMid)->textPlain($bar . self::boardContent($sel) . $bar);
            Cli::moveTo($origin[0] + 4 + $state['col'], $origin[1] + $state['row']);
            Cli::showCursor();
        };

        $render();

        return Cli::input(function (CliKey $key) use (&$state, &$selected, $render, $renderBoard, $origin, $viewH) {

            // Ctrl+C / signals -> leave
            if ($key->isExit()) {
                Cli::showCursor();
                $shownRows = min(count($state['lines']), $viewH);
                Cli::moveTo(1, $origin[1] + $shownRows);
                print "\e[0J"; // wipe any /help or /list panel still open
                Cli::break(1);
                Cli::textView(Cli::warn('WizCode Runner terminated.'), 0, '|1');
                $key->exit();
                return;
            }

            // TAB enters / cycles the board command selector
            if ($key->isTab()) {
                $selected = self::nextSelected($selected, count(self::BOARD_CMDS));
                $renderBoard($selected);
                return;
            }

            // While a board command is highlighted:
            if ($selected !== null) {
                if ($key->isEnter()) {
                    $name = self::BOARD_CMDS[$selected];
                    $selected = null;
                    $renderBoard(null);
                    return self::command(['name' => $name, 'arg' => ''], $state, $render, $origin, $key);
                }
                // any other key drops the highlight; the key is handled below as
                // normal input (ESC simply cancels, since it is not writable)
                $selected = null;
                $renderBoard(null);
                // fall through
            }

            if ($key->isEnter()) {
                // a slash command on the current line runs instead of a newline
                $cur = $state['lines'][$state['row']] ?? '';
                if ($cmd = self::parseCommand($cur)) {
                    return self::command($cmd, $state, $render, $origin, $key);
                }
                $state = self::applyKey($state, 'enter');
                $render();
                return;
            }

            if ($key->isBackspace()) { $state = self::applyKey($state, 'backspace'); $render(); return; }
            if ($key->isArrow('left'))  { $state = self::applyKey($state, 'left');  $render(); return; }
            if ($key->isArrow('right')) { $state = self::applyKey($state, 'right'); $render(); return; }
            if ($key->isArrow('up'))    { $state = self::applyKey($state, 'up');    $render(); return; }
            if ($key->isArrow('down'))  { $state = self::applyKey($state, 'down');  $render(); return; }

            if ($key->isWritable()) {
                $ch = $key->fetch();
                if ($ch === false) return;
                $state = self::applyKey($state, 'char', $ch);
                $render();
                return;
            }
        });
    }

    /** Handle a slash command inside the interactive loop. */
    private static function command(array $cmd, array &$state, \Closure $render, array $origin, CliKey $key) {

        // position output flush below the VISIBLE editor window (no gap row)
        $viewH = max(3, (CliScreen::height() ?: 24) - $origin[1] - 1);
        $below = fn() => Cli::moveTo(1, $origin[1] + min(count($state['lines']), $viewH));

        switch ($cmd['name']) {

            case 'exit':
            case 'quit':
                Cli::showCursor(); $below();
                Cli::textView(Cli::valid('WizCode Runner exited successfully.'), 0, '|1');
                $key->exit();
                return;

            case 'clear':
                $state = self::newState();
                $render();
                return;

            case 'list':
                $below();
                self::panel('collected', self::text($state), self::BOARD_SEL);
                Cli::break(1);
                return;

            case 'help':
                $below();
                self::panel('commands', "/run     evaluate the collected code\n/clear   discard everything\n/list    show the collected code\n/help    show this help\n/exit    leave the session", self::BOARD_SEL);
                Cli::break(1);
                return;

            case 'run':
                // drop the current line ONLY when it is the typed "/run" line;
                // when /run is picked from the board (TAB) the current line is
                // code and must be kept — otherwise the block is emptied.
                $lines = $state['lines'];
                $curCmd = self::parseCommand($lines[$state['row']] ?? '');
                if ($curCmd && $curCmd['name'] === 'run') {
                    array_splice($lines, $state['row'], 1);
                }
                $code = trim(implode("\n", $lines));
                $below();
                try {
                    ob_start();
                    eval($code);
                    $out = ob_get_clean();
                    self::panel('result', $out === '' ? '(no output)' : $out, '#1a7f37');
                } catch (\Throwable $e) {
                    if (ob_get_level() > 0) ob_end_clean();
                    self::panel('error', get_class($e) . ': ' . $e->getMessage(), '#c0392b');
                }
                Cli::break(1);
                $key->exit();
                return;
        }
    }

}
