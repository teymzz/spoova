<?php

namespace spoova\mi\core\commands\Root\Cli;

use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\classes\Ghost\GhostProxy;
use spoova\mi\core\classes\TClass;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliForms\CliAlpha;
use stdClass;
use spoova\mi\core\commands\Root\Cli\CliForms\CliDate;
use spoova\mi\core\commands\Root\Cli\CliForms\CliText;
use spoova\mi\core\commands\Root\Cli\CliForms\CliRadio;
use spoova\mi\core\commands\Root\Cli\CliForms\CliChoice;
use spoova\mi\core\commands\Root\Cli\CliForms\CliFlow;
use spoova\mi\core\commands\Root\Cli\CliForms\CliNumber;
use spoova\mi\core\commands\Root\Cli\CliForms\CliPassword;
use spoova\mi\core\commands\Root\Cli\CliForms\CliPattern;
use spoova\mi\core\commands\Root\Cli\CliForms\CliRange;
use spoova\mi\core\commands\Root\Cli\CliForms\CliSelect;
use spoova\mi\core\commands\Root\Cli\CliForms\CliTextBox;

/**
 * This class contains all the currently available and supported features of 
 * spoova's Cli input form fields.
 */
class CliForms {

    use CliDate, CliRadio, CliChoice, CliNumber, CliText, CliPassword, CliPattern, CliSelect, CliRange, CliAlpha, CliTextBox;

    private static $cleaner = 3;
    protected static $using_requirements = false;
    
    /** Specified by a white color */
    public const text_field_color = 'ash';

    public function __construct()
    {
        if(!self::$using_requirements){
            self::use_requirements();
        }
    }

    public static function setLines(int $value){
        self::$cleaner = $value;
    }

    public static function lines(){
        return self::$cleaner;
    }

    protected static function use_requirements() {
        if(self::$using_requirements) return ;
        Cli::requires('stty', fn() => Cli::errorView('Cli text input requires stty', break: 2) );
        Cli::requires('pcntl', fn() => Cli::textPlain('Cli input requires pcntl extension') );
        self::$using_requirements = true;
    }
    
    private static function readLine($callback){
        
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
        function input($callback) {
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

  
    private static function modified($modifier, array $chars, string $argType = 'array'){
      $md = array_values(TClass::funcParams($modifier));

      $data = ['ghostData'];

      if(count($md)>0 && is_array($md[0]) && $md[0][0] === CliFlow::class){
        
        $Ghost = new GhostFunction($data);
        $data = [
          'chars' => $chars,
          'count' => count($chars), 
          'value' => implode('',$chars),
          'textColor' => self::text_field_color, 
          'borderColor' => self::text_field_color
        ];
        
        $Ghost->ghostData(fn($key) => $data[$key] ?? null);

        GhostProxy::new($Ghost, fn(GhostDraft $draft) => new class($draft) extends CliFlow{});

        $flow = GhostProxy::object();
        $modifier($flow, $flow->value);
        $mod = $flow;
      }else{
        $mod = $modifier(($argType === 'string')? $data['value'] : $chars);
        $mod = is_array($mod) ? $mod : [];
        if(is_array($mod)) {
          $Ghost = new GhostFunction(['ghostData']);
          $Ghost->ghostData(fn($key) => $mod[$key] ?? null);
          GhostProxy::new($Ghost, fn(GhostDraft $draft) => new class($draft) extends CliFlow{});
          $mod = GhostProxy::object();
        }
      }

      return $mod;
    }

}