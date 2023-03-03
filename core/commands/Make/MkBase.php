<?php

namespace teymzz\spoova\core\commands\Make;

use teymzz\spoova\core\commands\Cli;

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

    /**
     * Returns the class format structure
     *
     * @return string
     */
    final static function classFormat($placements) {

        $map = [
            'namespace' => '', 
            'class'     => '', 
            'use'       => [], 
            'extends'   => '',
            'implements'=> '',
            'methods'   => '',
        ];

        $placements['use'] = (array) ($placements['use']?? []);
        $placements['implements'] = implode(', ', (array) ($placements['implements']?? []));

        $placements = array_merge($map, $placements);

        $classStructure = <<<Structure
        namespace{{namespace}}use{{use}}class{{class}}extends{{extends}}implements{{implements}}{
            methods{{methods}}
        }
        Structure;

        $nospaces = ['use','methods'];

        foreach($placements as $key => $value) {

            //string replace placeholder
            if(is_string($value) && $value && !in_array($key, $nospaces)) {
                $placeholder = $key.'{{'.$key.'}}';
                $value = $key.' '.$value.' ';
                if($key === 'namespace') $value = rtrim($value,' ').";\n\n";
            }
            if(is_array($value) && $key == 'use'){
                $val = '';
                foreach($value as $uses => $use){
                    if(trim($use)) $val .= 'use '.$use.";\n"; 
                }
                $value = $val? "$val\n" : $val."\n";
            }
            $classStructure = str_replace($key.'{{'.$key.'}}', $value, $classStructure);

        }

        return <<<Format
        <?php

        $classStructure

        Format;

    }

    static function addTitle($title, $desc = '') {
        Cli::textView(Cli::danger(Cli::emo('point-list').' '.$title.' ').$desc);
        Cli::break(2);
    }

}