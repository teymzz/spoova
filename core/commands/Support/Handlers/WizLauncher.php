<?php

namespace spoova\mi\core\commands\Support\Handlers;

use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliKey;

/**
 * Entry point for `php mi :wiz`.
 *
 * Presents a menu of the available console "flavours" and runs the one chosen.
 * Each flavour is a separate class, so they can evolve independently:
 *
 *   - {@see WizEditor}     "WizCode Runner" — the beautiful multi-line editor
 *                          (Backspace-join, slash-command board, result boxes);
 *   - InteractiveConsole   "WizConsole"     — the rich console (dot-commands,
 *                          save/load, history, completion) when merged in;
 *   - WizStudio            "WizStudio"      — the full reworked UX (rich
 *                          features on the new editor).
 *
 * The map below is the single place to wire flavours to classes. A class that is
 * not installed in the current build is listed but marked, so the menu degrades
 * gracefully and documents what can be added.
 */
class WizLauncher {

    /** label => fully-qualified class name */
    private const CONSOLES = [
        'WizCode Runner' => WizEditor::class,          // the beautiful multi-line editor
        'WizConsole'     => InteractiveConsole::class, // the rich console (merged in)
        'WizStudio'      => WizStudio::class,           // full reworked UX (rich on the new editor)
    ];

    function __construct(array $args = []) {
        Cli::requires('stty', function(){
            Cli::clearUp();
            Cli::break();
            Cli::headerView(':wiz error', break: 2);
            Cli::textView('This command requires '.Cli::warn('stty').' supported environments.', break: 2);
        });
        Cli::requires('pcntl', function(){
            Cli::clearUp();
            Cli::break();
            Cli::headerView(':wiz error', break: 2);
            Cli::textView('This command requires the '.Cli::warn('pcntl').' extension.', break: 2);
        });
        self::launch();
    }

    private const BOX = '#312f38';

    private static function clearScreen() { print "\e[2J\e[3J\e[H"; }

    public static function launch() {

        self::clearScreen();
        Cli::hideCursor();
        Cli::textView(Cli::alert(' █ wiz · choose a console'), 0, '|1');

        // resolve each flavour to a class and its availability
        $items = [];
        foreach (self::CONSOLES as $label => $class) {
            $items[] = ['label' => $label, 'class' => $class, 'available' => class_exists($class)];
        }
        $count = count($items);

        // inner width from the widest plain row: "   " (marker) + label (+ note)
        $inner = 0;
        foreach ($items as $it) {
            $w = 3 + mb_strlen($it['label']) + (!$it['available'] ? mb_strlen('  (not installed)') : 0);
            $inner = max($inner, $w);
        }
        $span = $inner + 2; // one space of padding each side, between the corners

        $origin = Cli::cursorPosition('col');
        if (!$origin) {
            Cli::showCursor();
            Cli::textView(Cli::error('This terminal cannot report the cursor position (needs stty).'), 0, '|2');
            return false;
        }

        // static top / bottom borders
        Cli::moveTo(1, $origin[1])->textPlain(Cli::color('┌' . str_repeat('─', $span) . '┐', self::BOX));
        Cli::moveTo(1, $origin[1] + $count + 1)->textPlain(Cli::color('└' . str_repeat('─', $span) . '┘', self::BOX));

        // cursor stays hidden for the whole menu (it is a selection, not typing)
        $draw = function () use (&$sel, $items, $inner, $origin) {
            $bar = Cli::color('│', self::BOX);
            foreach ($items as $i => $it) {
                $marker = ($i === $sel) ? ' ❯ ' : '   ';
                $label  = $it['label'] . (!$it['available'] ? '  (not installed)' : '');
                $plain  = $marker . $label;
                $padded = $plain . str_repeat(' ', max(0, $inner - mb_strlen($plain)));
                if ($i === $sel)           $padded = Cli::valid($padded);
                elseif (!$it['available']) $padded = Cli::warn($padded);
                Cli::moveTo(1, $origin[1] + 1 + $i)->textPlain($bar . ' ' . $padded . ' ' . $bar);
            }
        };

        $sel = 0;
        $draw();

        // the selection is kept in this closure variable so the loop exits cleanly
        $chosen = null;
        Cli::input(function (CliKey $key) use (&$sel, &$chosen, $count, $draw) {
            if ($key->isExit())  { $chosen = -1;   $key->exit(); return; }
            if ($key->isEnter()) { $chosen = $sel; $key->exit(); return; }
            if ($key->isArrow('up'))   { $sel = ($sel - 1 + $count) % $count; $draw(); return; }
            if ($key->isArrow('down') || $key->isTab()) { $sel = ($sel + 1) % $count; $draw(); return; }
        });

        if ($chosen === null || $chosen < 0) {
            self::clearScreen();
            Cli::showCursor();
            Cli::textView(Cli::warn('message:') . ' cancelled', 0, '|1');
            return;
        }

        $picked = $items[$chosen];

        if (!$picked['available']) {
            self::clearScreen();
            Cli::showCursor();
            Cli::textView(Cli::warn('That console is not installed in this build yet:'), 0, '|1');
            Cli::textView('  ' . $picked['class'], 0, '|2');
            return;
        }

        // menu (box + header) is cleared; the chosen console prints its own
        // flavour header, which becomes the title.
        self::clearScreen();
        Cli::showCursor();
        $class = $picked['class'];
        return new $class;
    }

}
