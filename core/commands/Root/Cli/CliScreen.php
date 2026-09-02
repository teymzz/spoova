<?php 

namespace spoova\mi\core\commands\Root\Cli;

use spoova\mi\core\commands\Root\Cli;

class CliScreen
{
    protected static ?int $width = null;
    protected static ?int $height = null;

    /** TRUE once the terminal has been measured, so it is not measured again */
    protected static bool $probed = false;

    public function __construct()
    {
        self::refresh();
    }

    public static function width(): int
    {
        self::refresh();
        return self::$width ?? 80;
    }

    public static function height(): int
    {
        self::refresh();
        return self::$height ?? 24;
    }

    /**
     * Returns the dimensions of the CLI screen in respect to the current width and height
     *
     * @return array [width, height]
     */
    public static function size(): array
    {
        return [self::width(), self::height()];
    }

    /** Re-detect screen size */
    /**
     * Measures the terminal, reusing the result rather than measuring again.
     *
     * Every probe shells out to tput, stty or mode con, which costs in the region of
     * a sixth of a second. width() and height() are read from inside the input loop,
     * which runs on every keypress, so measuring afresh each time stalled the redraw
     * long enough to be seen as the field blinking off and back on. The terminal is
     * therefore measured once and the result kept for the life of the process.
     *
     * A window is not normally resized in the middle of filling in a form, so the
     * saving is worth far more than the staleness. Where a long-running command does
     * need to notice a resize, pass TRUE to measure again.
     *
     * @param boolean $force measure the terminal again rather than reuse the last result
     * @return void
     */
    public static function refresh(bool $force = false): void
    {
        if (self::$probed && !$force) return;

        self::$probed = true;

        if (self::fromTput()) return;
        if (self::fromStty()) return;
        if (self::fromModeCon()) return;

        // fallback defaults
        self::$width  = 80;
        self::$height = 24;
    }

    protected static function fromTput(): bool
    {
        if(!Cli::isTerminal(['wsl','linux','termux-bash'])) return false;
        $cols = @trim((string)shell_exec('tput cols 2>/dev/null'));
        $rows = @trim((string)shell_exec('tput lines 2>/dev/null'));

        if ($cols !== '' && $rows !== '') {
            self::$width  = (int)$cols;
            self::$height = (int)$rows;
            return true;
        }
        return false;
    }

    protected static function fromStty(): bool
    {
        if(!Cli::isTerminal(['wsl','linux','termux-bash'])) return false;
        $out = @shell_exec('stty size 2>/dev/null');
        if (!$out) return false;

        $parts = preg_split('/\s+/', trim($out));
        if (count($parts) === 2) {
            self::$height = (int)$parts[0];
            self::$width  = (int)$parts[1];
            return true;
        }
        return false;
    }

    protected static function fromModeCon(): bool
    {
        $out = @shell_exec('mode con');
        if (!$out) return false;

        if (preg_match('/Columns:\s*(\d+)/i', $out, $m1)) {
            self::$width = (int)$m1[1];
        }
        if (preg_match('/Lines:\s*(\d+)/i', $out, $m2)) {
            self::$height = (int)$m2[1];
        }

        return (self::$width !== null && self::$height !== null);
    }
}