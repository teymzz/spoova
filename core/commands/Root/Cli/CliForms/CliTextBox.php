<?php

namespace spoova\mi\core\commands\Root\Cli\CliForms;

use Closure;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliKey;
use spoova\mi\core\commands\Root\Cli\CliDraw;
use spoova\mi\core\commands\Root\Cli\CliForms;
use spoova\mi\core\commands\Root\Cli\CliScreen;

/**
 * Multi-line text input (textarea) field for the CLI.
 *
 * Behaviour model
 * ----------------
 * Instead of tracking the cursor with fragile incremental terminal moves, this
 * field keeps an internal character buffer (`$chars`) plus a single caret index
 * (`$pos`) as the source of truth, and fully re-renders the box interior on every
 * keystroke from a fixed absolute anchor (captured once, right after the box is
 * drawn — the same technique used by {@see CliDate}).
 *
 * Because the visible text is always redrawn from the buffer and only the *real*
 * terminal cursor is repositioned over the caret, spaces and characters are never
 * clobbered when the arrows move back and forth — it behaves like a real textbox.
 *
 * Keys
 * ----
 *  - printable (32-126) : insert at caret
 *  - ← / →              : move caret left / right (wraps across rows)
 *  - ↑ / ↓              : move caret up / down a visual row (keeps column)
 *  - Backspace          : delete the character before the caret
 *  - Enter              : submit (consistent with the other CliForms fields)
 *  - Ctrl+C / signals   : cancel {@see CliKey::EXIT_SIGNALS}
 *
 * Text wraps automatically at the box width and scrolls vertically once it
 * grows beyond the visible height, keeping the caret in view. The entered value
 * is delivered through the `$onEnd` callback via {@see CliTransmit}, like the
 * sibling fields.
 *
 * @param string       $hint    title shown on the box border
 * @param string|null  $value   initial value
 * @param array        $design  design keys: width, height, indent, color, shape
 * @param int|null     $maxlength maximum characters (default: unlimited — content scrolls)
 * @param Closure|null $onEnd   callback(CliTransmit $form) fired on submit/cancel
 * @return mixed
 */
trait CliTextBox {

    public static function textbox(string $hint = '', ?string $value = null, array $design = [], ?int $maxlength = null, ?Closure $onEnd = null){

        self::use_requirements();

        // ---- resolve design ------------------------------------------------
        $width  = (int) ($design['width']  ?? 40);
        $height = (int) ($design['height'] ?? 4);
        $margin = (int) ($design['indent'] ?? 0);
        $color  = $design['color'] ?? CliForms::text_field_color;
        $shape  = $design['shape'] ?? 'square';

        if($width  < 4) $width  = 4;
        if($height < 1) $height = 1;
        if($margin < 0) $margin = 0;

        // keep the box within the visible screen width (guard indent, cap width)
        $margin = CliDraw::fitIndent($margin);
        $width  = max(4, CliDraw::fitWidth($width, $margin));

        // ---- internal buffer (source of truth) -----------------------------
        // Content may grow past the visible height; the box scrolls vertically.
        $chars = ($value !== null && $value !== '') ? mb_str_split($value) : [];
        if($maxlength !== null && count($chars) > $maxlength) $chars = array_slice($chars, 0, $maxlength);
        $pos = count($chars); // caret sits after the last character
        $scroll = 0;          // first visible content row (vertical scroll offset)

        // ---- draw the box and capture the interior anchor ------------------
        CliForms::setLines($height + 2);
        Cli::break(1);
        CliDraw::textBox($width, $height, $margin, $color, $hint, $shape);

        // After textBox() the cursor rests on the top-left interior cell.
        $origin = Cli::cursorPosition('col'); // [col, row] (absolute)
        if(!$origin){
            Cli::break();
            return null; // cursor position could not be read (needs stty)
        }

        // ---- renderer: redraw the visible window + place the real caret ----
        $render = function() use (&$chars, &$pos, &$scroll, $origin, $width, $height) {

            // caret (row, col) from the flat index
            $caretRow = intdiv($pos, $width);
            $caretCol = $pos - ($caretRow * $width);

            // scroll so the caret stays inside the visible window
            if($caretRow < $scroll){
                $scroll = $caretRow;
            }elseif($caretRow > $scroll + $height - 1){
                $scroll = $caretRow - $height + 1;
            }
            if($scroll < 0) $scroll = 0;

            Cli::hideCursor();

            for($r = 0; $r < $height; $r++){
                $contentRow = $scroll + $r;                 // which buffer row is shown here
                $rowChars = array_slice($chars, $contentRow * $width, $width);
                $line = implode('', $rowChars);
                $len  = mb_strlen($line);
                if($len < $width) $line .= str_repeat(' ', $width - $len); // clear stale chars
                Cli::moveTo($origin[0], $origin[1] + $r)->textPlain($line);
            }

            // caret position on screen (relative to the scrolled window)
            $screenRow = $caretRow - $scroll;
            if($screenRow > $height - 1){ $screenRow = $height - 1; $caretCol = $width; }

            Cli::moveTo($origin[0] + $caretCol, $origin[1] + $screenRow);
            Cli::showCursor();
        };

        $render();

        // ---- input loop ----------------------------------------------------
        return Cli::input(function(CliKey $key) use (&$chars, &$pos, $render, $origin, $width, $height, $margin, $maxlength, $onEnd) {

            // Submit (Enter) or cancel (interrupt signal)
            if($key->isEnter() || $key->isExit()){
                $value = implode('', $chars);
                Cli::showCursor();
                Cli::moveTo(1, $origin[1] + $height + 1); // drop below the box
                if($onEnd){
                    Cli::break(1);
                    $message = $onEnd(new CliTransmit($key, $value));
                    $key->exit();
                    return $message;
                }
                if($key->isExit()){
                    Cli::textView(Cli::warn('message:').' form terminated', $margin);
                }
                Cli::break(1);
                $key->exit();
                return $value;
            }

            // Backspace : delete character before the caret
            if($key->isBackspace()){
                if($pos > 0){
                    array_splice($chars, $pos - 1, 1);
                    $pos--;
                    $render();
                }
                return;
            }

            // Arrow navigation
            if($key->isArrow('left')){
                if($pos > 0){ $pos--; $render(); }
                return;
            }
            if($key->isArrow('right')){
                if($pos < count($chars)){ $pos++; $render(); }
                return;
            }
            if($key->isArrow('up')){
                if($pos - $width >= 0){ $pos -= $width; $render(); }
                return;
            }
            if($key->isArrow('down')){
                $total   = count($chars);
                $lastRow = intdiv($total, $width);
                if(intdiv($pos, $width) < $lastRow){
                    $pos = min($pos + $width, $total); // keep column, clamp to end of text
                    $render();
                }
                return;
            }

            // Printable character : insert at the caret
            if($key->isWritable()){
                if($maxlength !== null && count($chars) >= $maxlength) return false;
                $char = $key->fetch();
                if($char === false) return;
                array_splice($chars, $pos, 0, [$char]);
                $pos++;
                $render();
                return;
            }
        });

    }

}
