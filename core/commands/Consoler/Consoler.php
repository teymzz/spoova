<?php

namespace spoova\mi\core\commands\Consoler;

use Closure;
use spoova\mi\core\commands\Root\Cli;

class Consoler {

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

    protected static $options = [];

    final public function __construct(){}

    final public static function validate_console($args) : bool|string|array {
        static::$options = static::setOps();
        $response = step_run([
            fn() => static::validate_arguments($args),
            fn() => static::validate_options($args),
        ]);

        return $response;
    }

    final public static function validate_arguments($args) : bool|string {

        //validate arguments
        if(static::$auto_respond){
            Cli::clearUp();
            Cli::break(2);
            Cli::textView(Cli::danger(Cli::emo('point-list').' '.static::$cat.strtolower(basename(get_called_class())).' '.Cli::warn(implode(' ', $args))));
        }    

        if(count($args) > static::$args_max) {
            if(static::$auto_respond){
                Cli::break(2);
                Cli::textView(Cli::error('number of arguments('.count($args).') exceed maximum of: '.static::$args_max));
            }

            Cli::break(2);
            
            return false;
        }

        if(count($args) < static::$args_min) {
            if(static::$auto_respond){
                Cli::break(2);
                Cli::textView(Cli::error('number of arguments('.count($args).') less than minimum of: '.static::$args_min));
            }

            Cli::break(2);
            
            return false;
        }
        Cli::break(2);

        return true;
    }

    final public static function validate_options($args) : bool|string|array {

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

                    if($testArg === '...' && $isCat){
                        array_unshift($allArgs, $arg);
                        return array_values($allArgs);
                    }elseif(is_string($testArg) && (($a = (substr($testArg, 0, 3) === '...')) || ($b = (substr($testArg, -1, 3) === '...'))) && $isCat) {
                        if(strlen($testArg) < 4) {
                            return false;
                        }elseif($a){
                            $method = substr($testArg, 3, strlen($testArg));
                            array_unshift($allArgs, $method);
                            return array_values($allArgs);
                        }elseif($b){
                            $method = substr($testArg, 0, strlen($testArg) - 3);
                            array_unshift($allArgs, $method);
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
                    Cli::textView(Cli::error('invalid option "'.Cli::warn($arg).'" supplied'));
                    Cli::break(2);
                } else {
                    Cli::textView(Cli::danger('Desc:').(' no available description for command "'.Cli::warn($arg).'"'));
                    Cli::break(2);
                }
                if(!empty($options)){
                    Cli::textView(Cli::danger(Cli::emo('ribbon-arrow').' valid options: '.Cli::warn('['.implode('|', $options)."]")), '3');
                    Cli::break(2);
                }elseif($isCat){
                    Cli::textView(Cli::danger(Cli::emo('ribbon-arrow').' no arguments detected for this command'), '3');
                    Cli::break(2);
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
                    Cli::break(2);
                }else{
                    Cli::textView(Cli::danger('Desc:').(' no available description for this command.'));
                    Cli::break(2);
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
                    Cli::break(2);
                    if(!empty($options)){
                        Cli::textView(Cli::danger(Cli::emo('ribbon-arrow').' options: '.Cli::warn('['.implode('|', $options)."]")), '3');
                        Cli::break(2);
                    }
                }

                if($cat === 'catx::' || $cat === 'catd::'){
 
                    $synx = Cli::warn($synx ?: 'No available syntax for this command.');
                    //syntax ...
                    Cli::textView(Cli::danger(Cli::emo('ribbon-arrow')).' '. $synx, 3);
                    Cli::break(2);

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

            if($isCat){
                if(!empty($options)){
                    Cli::textView(Cli::danger(Cli::emo('ribbon-arrow').' options: '.Cli::warn('['.implode('|', $options)."]")), '3');
                    Cli::break(2);
                    return false;
                }
            }else{
                
                Cli::break(2);
                Cli::textView(Cli::danger('Desc: ').$description, '3');

                if($options){
                    Cli::textView(Cli::danger(Cli::emo('ribbon-arrow').' options: '.Cli::warn('['.implode('|', $options)."]")), '3');
                    Cli::break(2);
                    return false;
                }

                //print description

            }
            return false;

        }else {

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
     * Set options for command
     *
     * @return void
     */
    public static function setCat($cat){
       static::$cat = $cat;
    }

    /**
     * Return argument control type. When this returns false, 
     * the entire arguments are controlled from the Consoler::arguments() method.
     *
     * @return bool
     */
    public static function isAuto() : bool{
      return static::$auto;
    }

    /**
     * Return controller methods for cat commands (i.e cat, catd, cati, catx)
     *
     * @return bool
     */
    public static function getCats() : array{
      return static::$cats;
    }

}