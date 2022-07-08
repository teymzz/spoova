<?php

namespace spoova\core\commands\Make;

abstract class MkBase{

    protected static $message;
    protected static $args;

    function __construct($args){
        self::$args = $args;
        return $this;
    }


    function message($message) {
        if(func_num_args() > 0){
            self::$message = $message;
        }

        return self::$message;
    }

    function display($message, $spaces = 0){
        
        static $count = 0;
        $count++;
        $br = isCli()? PHP_EOL : '<br>';
        $spaces = str_repeat(' ', $spaces);
    
        if($count == 1){
          print $br.$spaces.$message.$br.$br; 
        }else{
          print $spaces.$message.$br.$br; 
        }
    
    }

    abstract public function build() : bool; 


}