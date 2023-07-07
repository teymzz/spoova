<?php

namespace spoova\mi\core\classes;

use ReflectionClass;
use ReflectionMethod;

class Dumper{

    private $init = false;
    private const dumpFile = _core.'custom/views/dump.php';

    /**
     * Dump Variables
     *
     * @param mixed $value argument(s)
     * @return Dumper
     */
    public static function dump($value) {
        self::set_xdebug_ini();     

        print '<style>'.self::style().'</style>';   

        foreach(func_get_args() as $args){

            print '<details class="main">';
            
            self::handleVariableObject(...func_get_args());

            print '</details>';   

        }

        return new self;

    }

    public static function vdump($var){

        if(isCli()){
            var_dump(...func_get_args());
            return new self;
        }

        $args = func_get_args();

        foreach($args as $arg){
            $contents = <<<'CONTENTS'
            <?php 
            
            use spoova\mi\core\classes\Dumper;

            Dumper::dump($arg);

            CONTENTS;

            $Filemanager = new FileManager;

            if($Filemanager->openFile(true, self::dumpFile)){
                
                file_put_contents(self::dumpFile, $contents);
    
                ob_start();
                include(self::dumpFile);
                $template = ob_get_clean(); //new replacement
                $vfile = str_replace(['\\','/'], '\\\\', __FILE__).':[\d]+:';
                $template = preg_replace("~(<small>)?$vfile(</small>)?\n?~", '', $template);
                echo $template;            
                
            }
        }

        return new self;

    }

    public function exit() {
        if(is_file(self::dumpFile)) unlink(self::dumpFile);
        exit();
    }

    private static function set_xdebug_ini()
    {
        ini_set('xdebug.var_display_max_depth', -1);
        ini_set('xdebug.var_display_max_children', -1);
        ini_set('xdebug.var_display_max_data', -1);
    }

    private static function handleVariableObject($args) {


        $args = func_get_args();

        foreach($args as $property => $value){

            $items = !is_numeric($property)? $property : gettype($value);

            $objectType = (is_object($value))? basename(get_class($value)) : ucfirst(gettype($value));
            $traversable = (is_object($property) && ($property instanceof \Traversable))? ' (Traversable)' : '';

            $objectType = (!is_object($value) && ($objectType === 'Double'))? 'Float' : $objectType;

            print '<summary><span>'.$objectType.$traversable.'</span></summary>';
            
            $openHTML = $closeHTML = '';
            $summary = '<details><summary><span>%s</span></summary><div class="padd-16 dump">%s</div></details>';

            if(is_object($value)){
                $traversable = ($value instanceof \Traversable)? ' (Traversable)' : '';
                $openHTML = '<details><summary><span>class'.$traversable.'</span></summary>';
                $closeHTML= '</details>';
            }

            print $openHTML;
            print '<div class="dumper dump">';
            var_dump($value);
            print '</div>';
            print $closeHTML;

            //print methods
            if(is_object($value)){
                //get object methods
                $Reflection = new ReflectionClass($value);
                $publics = $Reflection->getMethods(ReflectionMethod::IS_PUBLIC);
                $protecteds = $Reflection->getMethods(ReflectionMethod::IS_PROTECTED);
                $statics = $Reflection->getMethods(ReflectionMethod::IS_STATIC);
                $build   = '';

                foreach($publics as $public){

                    $public = (in_array($public, $statics)? ":: " : "-> ").$public->name;
                    $build .="<span class=\"methods\"> PUBLIC {$public}() </span>"; 

                }

                foreach($protecteds as $protected){

                    $protected = (in_array($public, $statics)? ":: " : "-> ").$protected->name;
                    $build .="<span class=\"methods\"> PROTECTED {$protected}() </span>"; 

                }

                if($build) printf($summary, 'methods', $build);

            }

        }


    }

    private static function style() {
        return '

            :where(*) {
                margin:0;
                padding:0;
                box-sizing: border-box;
            }

            details.main {  
                font-family: monospace;     
                display: inline-block;
                color: #3b4664;
                background: rgba(238, 238, 238, 0.9); 
                float:left; 
                width:100%; 
                padding: 1em;
                margin-bottom: 10px;
            }

            details[open] > summary {
                background-color: #067abf;
                color: white;
            }

            details[open] > .dump {
                background-color:white;
                overflow-x: auto;
                margin-top: 1em;
                border-radius: 10px;
                padding-top: 10px;
            }

            details[open] > .dump > pre {
                padding-bottom: 12px;
            }

            details.main[open] > summary {
                margin-bottom: 10px;
            }

            details.main details:not(.main){
                padding:10px;
            }

            summary {
                background-color:#aeaeae; 
                padding:10px; 
                border-radius:100vh; 
                background-color: #fff;
                cursor:pointer;
                transition: background-color .2s ease-in-out;
            }

            summary > span {
                user-select: none;
            }

            .dumper {
                display:block; 
                padding:0 12px
            }

            .padd-16 {
                display: block;
                padding: 16px;
                padding-bottom: 0;
            }
            
            .methods {
                display: block;
                font-family: calibri;
                font: menu;
                margin: 10px;
                color: #565656;
            }

        ';
    }

}