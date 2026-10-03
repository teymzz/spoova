<?php

namespace spoova\mi\core\commands\Root\Cli;

use Closure;
use spoova\mi\core\commands\Root\Cli\CliForms\CliAlpha;
use spoova\mi\core\commands\Root\Cli\CliForms\CliChoice;
use spoova\mi\core\commands\Root\Cli\CliForms\CliDate;
use spoova\mi\core\commands\Root\Cli\CliForms\CliNumber;
use spoova\mi\core\commands\Root\Cli\CliForms\CliPassword;
use spoova\mi\core\commands\Root\Cli\CliForms\CliPattern;
use spoova\mi\core\commands\Root\Cli\CliForms\CliRadio;
use spoova\mi\core\commands\Root\Cli\CliForms\CliRange;
use spoova\mi\core\commands\Root\Cli\CliForms\CliSelect;
use spoova\mi\core\commands\Root\Cli\CliForms\CliText;
use spoova\mi\core\commands\Root\Cli\CliForms\CliTextBox;
use stdClass;

/**
 * This class contains all the currently available and supported features of 
 * spoova's Cli input form fields.
 */
class CliForms {

    use CliDate, CliRadio, CliChoice, CliNumber, CliText, CliPassword, CliPattern, CliSelect, CliRange, CliAlpha, CliTextBox;

    private static $cleaner = 3;

    public function __construct()
    {
        if(!self::$using_requirements){
            self::use_requirements();
        }
    }

    /**
     * This method determines how the CLI wipes form fields. It points the CLI form cleaner to the number of lines used for 
     * drawing out form field. 
     *
     * @param integer $value
     * @return void
     */
    public static function setLines(int $value){
        self::$cleaner = $value;
    }

    /**
     * This method returns the number of line defined by the  {@see CLIForm::setLines()} method.
     *   - Default lines is 3 if setLines() have not been initially applied.
     * @return integer
     */
    public static function lines() : int {
        return self::$cleaner;
    }
    
    private static function readLine(Closure $callback){
        
        function setRawMode() {
            if (stripos(PHP_OS, 'WIN') === false) {
                // For Unix-based systems
                system('stty -echo -icanon min 1 time 0');
            } else {
                // Windows does not support stty, so this will not work.
            }
        }

        // Function to read a character from the terminal
        function readChar() {
            return stream_get_contents(STDIN, 1);
        }

        // Function to read arrow keys
        function readArrowKey() {
            $char = readChar();
            if ($char === "\033") {
                $char .= readChar();
                if ($char === "\033[") {
                    $char .= readChar();
                }
            }
            return $char;
        }

        // Function to process arrow keys
        function input(Closure $callback) {
            $control = new stdClass;
        
            $control->exit = function() {
                if (stripos(PHP_OS, 'WIN') !== false) {
                    // On Windows, nothing to reset as no stty was applied.
                } else {
                    // Reset terminal to its default settings
                    system('stty sane');
                }
            };
            setRawMode();

            //echo "Press arrow keys (up, down, left, right) or 'q' to quit.\n";
            $read = true;
            while ($read) {
                $char = readArrowKey();
                switch ($char) {
                    case "\033[A":
                        $callback('up', $control);
                        break;
                    case "\033[B":
                        $callback('down', $control);
                        break;
                    case "\033[C":
                        $callback('right', $control);
                        break;
                    case "\033[D":
                        $callback('left', $control);
                        break;
                    default:
                        $callback($char, $control);
                        break;
                }
            }
        }

        // Call the function to process arrow keys
        input($callback);
        
    }

}