<?php

namespace spoova\core\classes;

use Reflection;
use ReflectionClass;
use ReflectionMethod;
use Traversable;

class Dumper{

    private $init = false;

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

        $args = func_get_args();

        foreach($args as $arg){
            $contents = <<<'CONTENTS'
            <?php 
            
            use spoova\core\classes\Dumper;

            Dumper::dump($arg);

            CONTENTS;

            $file = _core.'custom/views/dump.php';
            
            file_put_contents($file, $contents);

            ob_start();
            include($file);
            $template = ob_get_clean(); //new replacement
            $vfile = str_replace(['\\','/'], '\\\\', __FILE__).':[\d]+:';
            $template = preg_replace("~(<small>)?$vfile(</small>)?\n?~", '', $template);
            echo $template;            
        }

        return new self;

    }

    public function exit() {
        exit();
    }

    private static function set_xdebug_ini()
    {
        ini_set('xdebug.var_display_max_depth', -1);
        ini_set('xdebug.var_display_max_children', -1);
        ini_set('xdebug.var_display_max_data', -1);
    }


    private static function handleDataObject(DataObject $args) {

        print '<summary><span>Data Object</span></summary>';

        foreach($args as $property => $value){
            $traversable = (is_object($value) && ($value instanceof \Traversable))? ' (Traversable)' : '';
            print '<details>';
            print '<summary><span>'.$property.$traversable.'</span></summary>';
            print '<div class="dumper">';
            var_dump($value);
            print '</div>';
            print '</summary>';
            print '</details>';
        }


    }

    private static function handleVariableObject($args) {


        $args = func_get_args();

        foreach($args as $property => $value){

            $items = !is_numeric($property)? $property : gettype($value);

            $objectType = (is_object($value))? basename(get_class($value)) : 'Element';
            $traversable = (is_object($property) && ($property instanceof \Traversable))? ' (Traversable)' : '';

            print '<summary><span>'.$objectType.$traversable.'</span></summary>';
            
            $openHTML = $closeHTML = '';
            $summary = '<details><summary><span>%s</span></summary><div class="padd-16">%s</div></details>';

            if(!is_object($value)){
                $openHTML = '<details>
                <summary><span>'.$items.$traversable.'</span></summary>';
                $closeHTML= '</details>';
            }else{
                $traversable = ($value instanceof \Traversable)? ' (Traversable)' : '';
                $openHTML = '<details>
                                <summary><span>class'.$traversable.'</span></summary>';
                $closeHTML= '</details>';
            }

            print $openHTML;
            print '<div class="dumper">';
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

                printf($summary, 'methods', $build);

            }

        }


    }

    private static function style() {
        return '

            details.main {        
                display: inline-block;
                word-break: break-word;
                color: #3b4664;
                background: rgba(238, 238, 238, 0.9); 
                float:left; width:100%; 
                padding: 1em;
                overflow-x: auto;
                max-height: 94vh;
                margin-bottom: 10px;
            }

            details[open] > summary {
                background-color: #067abf;
                color: white;
            }

            details.main[open] > summary {
                margin-bottom: 10px;
            }

            details:not(.main){
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