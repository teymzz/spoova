<?php

namespace spoova\mi\core\commands\Consoler;

use Closure;
use spoova\mi\core\commands\Root\Cli;

/**
 * Consoler is a toolkit that manages CLI custom commands using predefined  
 * template formats. 
 */
class Consoler {

    /**
     * Cat command used
     *
     * @var string optional [cat|catd|catx|cati]
     */
    protected static string $cat = '';
    protected static array $cats = [
        'cat'  => 'arguments',
        'catd' => 'arguments',
        'catx' => 'arguments',
        'cati' => 'arguments',
    ];

    protected static int $args_min = 0;

    protected static int $args_max = 3;

    protected static bool $auto = true;

    protected static bool $auto_respond = true;

    protected static array $options = [];

    final public function __construct(mixed $args = []){}

    final public static function validate_console(array $args) : bool|string|array {

        static::$options = static::setOps(); // defines a list of accepted options.

        $response = step_run([
            fn() => static::validate_arguments($args),
            fn() => static::validate_options($args),
        ]);

        return $response;
    }

    final public static function validate_arguments(array $args) : bool|string {

        //validate arguments
        if(static::$auto_respond){
            Cli::cls();
            Cli::textView(Cli::danger(Cli::emo('point-list').' '.static::$cat.strtolower(basename(to_dirslash(get_called_class()))).' '.Cli::warn(implode(' ', $args))));
            Cli::break(1);
        }    
        
        if(count($args) > static::$args_max) {
            if(static::$auto_respond){
                Cli::break(1);
                Cli::textView(Cli::error('number of arguments('.count($args).') exceed maximum of: '.static::$args_max));
                Cli::break(1);
            }

            Cli::break(1);
            
            return false;
        }

        if(count($args) < static::$args_min) {
            if(static::$auto_respond){
                Cli::break(1);
                Cli::textView(Cli::error('number of arguments('.count($args).') less than minimum of: '.static::$args_min));
                Cli::break(1);
            }

            Cli::break(1);
            
            return false;
        }
        Cli::break(1);

        return true;
    }

    final public static function validate_options(array $args) : bool|string|array {

        $cat = static::$cat;
        $isCat = ($cat === 'cat::');

        $options = static::$options; //accepted options

        $testOps = $options; 
        $nextOps = []; 
        $keys = []; 
        $description = '';
        $arguments = []; 
        $allArgs = $args; 
        $counter = 0;

        foreach($args as $arg) {

            unset($allArgs[$counter]);

            $nextOps = $testOps;
            
            if(isset($testOps[$arg])) { 

                $keys[] = $arg;
                if(!($testOps[$arg] instanceof Closure)){
                    $testArg = $testOps[$arg];
                    $testMin = $testMax = false;

                    // Only string handlers carry :max/:min/:N constraints and "..." variadics.
                    // A nested option group is an array and must fall through to the descend
                    // branch below (guarding here prevents an explode() TypeError on arrays).
                    if(is_string($testArg)){

                        if(count($exp = explode(':max',$testArg)) === 2 && is_numeric($max = str_replace(':max','',$exp[1]))){
                            $testArg = $exp[0]; // redefined the handler method
                            $testMax = (int) $max; // defined number of arguments supported
                        }

                        if(count($exp = explode(':min',$testArg)) === 2 && is_numeric($min = str_replace(':min','',$exp[1]))){
                            $testArg = $exp[0]; // redefined the handler method
                            $testMin = (int) $min; // defined number of arguments supported
                        }

                        if(($testMin === $testMax) && ($testMax === false)){
                            if(count($exp = explode(':',$testArg)) === 2 && is_numeric($minmax = str_replace(':','',$exp[1]))){
                                $testArg = $exp[0]; // redefined the handler method
                                $testMin = $testMax = $minmax;
                            }
                        }

                    }

                    if($testArg === '...' && $isCat){
                        //Return arguments as options
                        array_unshift($allArgs, $arg);
                        if(($testMax !== false) &&  ((count($allArgs)-1) > $testMax)){
                            Cli::textView(Cli::error('maximum arguments exceeded for "'.Cli::warn($arg).'"'), break: '|2');
                            return false;
                        }elseif(($testMin !== false) &&  ((count($allArgs)-1) < $testMin)){
                            Cli::textView(Cli::error('minimum arguments required for "'.Cli::warn($arg).'"'), break: '|2');
                            return false;
                        }
                        return array_values($allArgs);
                    }elseif(is_string($testArg) && (($a = (str_starts_with($testArg, '...'))) || ($b = (str_ends_with($testArg, '...')))) && $isCat) {
                        if(strlen($testArg) < 4) {
                            return false; // fails because argument only contains ellipses
                        }elseif($a){
                            //Parse argument to method after ellipsis
                            $method = substr($testArg, 3, strlen($testArg));
                            array_unshift($allArgs, $method);
                            if(($testMax !== false) &&  ((count($allArgs)-1) > $testMax)){
                                Cli::textView(Cli::error('maximum arguments exceeded for "'.Cli::warn($arg).'"'), break: '|2');
                                return false;
                            }elseif(($testMin !== false) &&  ((count($allArgs)-1) < $testMin)){
                                Cli::textView(Cli::error('minimum arguments required for "'.Cli::warn($arg).'"'), break: '|2');
                                return false;
                            }
                            return array_values($allArgs);
                        }elseif($b){
                            //Parse subsequent arguments to the argument before ellipsis
                            $method = substr($testArg, 0, strlen($testArg) - 3);
                            array_unshift($allArgs, $method);
                            if(($testMax !== false) &&  ((count($allArgs)-1) > $testMax)){
                                Cli::textView(Cli::error('maximum arguments exceeded for "'.Cli::warn($arg).'"'), break: '|2');
                                return false;
                            }elseif(($testMin !== false) &&  ((count($allArgs)-1) < $testMin)){
                                Cli::textView(Cli::error('minimum arguments required for "'.Cli::warn($arg).'"'), break: '|2');
                                return false;
                            }
                            return array_values($allArgs);
                        }
                    } else{
                        $testOps = $testOps[$arg];
                    }
                }
            }else{
                $testOps = false;
                break;
            }

            $counter++;

        }

        $linebreak = 1;

        if($testOps === false){
            if(static::$auto_respond){
                $ops = []; $options = [];

                if(is_array($nextOps)){
                    foreach($nextOps as $key => $nextOp){
                        if(!($nextOp instanceof Closure)){
                            $ops[$key] = $nextOp;
                        }
                    }
                    $nextOps = $ops;
                    $options = array_keys($nextOps);
                }
                
                if($isCat){
                    // Display for when an invalid option is attempted for execution
                    Cli::textView(Cli::error('invalid option "'.Cli::warn($arg).'" supplied'));
                    Cli::response(false);
                    Cli::break($linebreak);
                } else {
                    Cli::textView(Cli::danger('Desc:').(' no available description for command "'.Cli::warn($arg).'"'));
                    Cli::response(false);
                    Cli::break($linebreak);
                }
                if(!empty($options)){
                    // Display for available options
                    Cli::textView(Cli::danger(Cli::emo('ribbon-arrow').' valid options: '.Cli::warn('['.implode('|', $options)."]")), '3');
                    Cli::break($linebreak);
                }elseif($isCat){
                    // Notice for executing cat:: without any handler
                    Cli::cls()->pause(2);
                    Cli::textView(Cli::danger(Cli::emo('bullet').' no arguments detected for this command'), '1');
                    Cli::response(false);
                    Cli::break($linebreak);
                }
            }
            
            return false;

        } else if(!$isCat) {

            $descs = false;
                    
            foreach($nextOps as $nextOp){
                if($nextOp instanceof Closure){
                    $descs = $nextOp();
                    if(is_array($descs)){
                        $descs = $descs[$arg] ?? false;
                        if((!is_array($descs) && !trim($descs)) || empty($descs)) $descs = false;
                    }
                }
            }
            
            if(!$nextOps && empty($arg)){
                $root = false; //closure in root
                foreach($options as $ops){
                    if($ops instanceof Closure){
                        $root = $ops;
                    }
                }
                if($root) $descs = $root();
                $descs = $descs[''] ?? false;
            }


            //get options .............
            
            $ops = []; $description = ''; $options = [];
            if(is_array($testOps)){
                foreach($testOps as $key => $testOp){
                    if(!($testOp instanceof Closure)){
                        $ops[$key] = $testOp;
                    }else{
                        $description = $testOp();
                    }
                }
                $testOps = $ops;
                $options = array_keys($testOps);
            }


            if($descs === false) {
                if(!empty($arg)){
                    Cli::textView(Cli::danger('Desc:').(' no available description for command "'.Cli::warn($arg).'".'));
                    Cli::break($linebreak);
                }else{
                    if(empty($root)){
                        Cli::textView(Cli::danger('Desc:').(' no available description for this command.'));
                        Cli::break($linebreak);
                    }
                }
            }else{

                if(is_array($descs)){
                    $desc = $descs['i'] ?? false;
                    $synx = $descs['x'] ?? null;
                }else{
                    $desc = $descs;
                    $synx = null;
                }

                if($cat === 'cati::' || $cat === 'catd::'){
                    Cli::textView(Cli::danger('Info: ').$desc, 2);
                    Cli::break($linebreak);
                    if(!empty($options)){
                        Cli::textView(Cli::danger(Cli::emo('ribbon-arrow').' options: '.Cli::warn('['.implode('|', $options)."]")), '3');
                        Cli::break($linebreak);
                    }
                }

                if($cat === 'catx::' || $cat === 'catd::'){
 
                    $synx = Cli::warn($synx ?: 'No available syntax for this command.');
                    //syntax ...
                    Cli::textView(Cli::danger(Cli::emo('ribbon-arrow')).' '. $synx, 3);
                    Cli::break($linebreak);

                }

            }
            
            return false;
        } else if(is_array($testOps)) {
            
            $ops = []; $description = '';
            foreach($testOps as $key => $testOp){
                if(!($testOp instanceof Closure)){
                    $ops[$key] = $testOp;
                }else{
                    $description = $testOp();
                }
            }
            $testOps = $ops;
            $options = array_keys($testOps);
            $options = array_filter($options, fn($value) => $value !== '');

            if($isCat){
                // Handle cat:: commands
                if(!empty($options)){
                    Cli::textView(Cli::danger(Cli::emo('ribbon-arrow').' options: '.Cli::warn('['.implode('|', $options)."]")), '3');
                    Cli::break($linebreak);
                    return false;
                }
                Cli::clearUp(1);
            }else{
                // Handle other cat command variants.
                Cli::break($linebreak);
                Cli::textView(Cli::danger('Desc: ').$description, '3');

                if($options){
                    Cli::textView(Cli::danger(Cli::emo('ribbon-arrow').' options: '.Cli::warn('['.implode('|', $options)."]")), '3');
                    Cli::break($linebreak);
                    return false;
                }

                //print description

            }
            return false;

        }

        return $testOps;
    }

    /**
     * Set options for command
     *
     * @return array
     */
    public static function setOps() : array{
        return []; //set static options ... 
    }

    /**
     * Sets the cat command used. This method is used internally and should 
     * NOT be called directly
     *     
     * @var string optional [cat|catd|catx|cati]
     * @return void
     */
    final public static function setCat(string $cat){
       static::$cat = $cat;
    }

    /**
     * Return argument control type. When this returns false, 
     * the entire arguments of an interfaced controller are controlled 
     * from the Consoler::arguments() ghost method.
     *
     * @return bool
     */
    final public static function isAuto() : bool{
      return static::$auto;
    }

    /**
     * Return controller methods for cat commands (i.e cat, catd, cati, catx)
     *
     * @return array
     */
    final public static function getCats() : array{
      return static::$cats;
    }

    /**
     * Return the current cat command used
     *
     * @return string
     */
    final protected static function getCat() : string {
      return static::$cat;
    }

    /**
     * Display an item on the cli
     *
     * @return bool
     */
    public static function log() {
      vdump(...func_get_args());
    }

}