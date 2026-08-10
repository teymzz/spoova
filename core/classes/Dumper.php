<?php

namespace spoova\mi\core\classes;

use ReflectionClass;
use ReflectionMethod;
use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;

class Dumper{

    private $init = false;
    private static $vlist = false;
    private static array $cdump = [];
    private static int $cdumpCounter = 0;
    private static bool $headers = true;
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

        //get init key for dumper theme
        $theme = Init::key('VDUMP-THEME', '');
        $theme = $theme ? " ".$theme :  '';

        /* ################################################################################### */

        if(self::$vlist === false){
            foreach(func_get_args() as $key => $args){
    
                print '<details class="main'.$theme.'" :dump="dump">';
                // add key here ... 
                self::handleVariableObject(...func_get_args());
    
                print '</details>';   
                
            }
        } else {
            self::$cdumpCounter = 0;
            foreach($value as $key => $args){
                
                $subject = self::$vlist ?: [];
                $padd = self::$headers && ($subject[self::$cdumpCounter]??'' !== '')? 'padd-16' : '';
                if(!$padd && !self::$vlist && self::$headers) $padd = 'padd-16';

                print '<details class="main'.$theme.' padd-15" :dump="dump">';
                print '<summary>['.$key.']</summary>';
                print '<div class="'.$padd.'">'; 
                self::handleVariableObject($args);
                print '</div>';

                print '</details>';
                self::$cdumpCounter++;   
            }
            self::$vlist = false;
            self::$headers = true;
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

            $Filemanager = new Filemanager;

            if($Filemanager->openFile(true, self::dumpFile)){
                
                file_put_contents(self::dumpFile, $contents);
    
                ob_start();
                include(self::dumpFile);
                $template = ob_get_clean(); //new replacement
                $vfile = str_replace(['\\','/'], '\\\\', __FILE__).':[\d]+:';
                $template = preg_replace("~(<small>)?$vfile(</small>)?\n?~", '', $template);

                // redesign template 
                $template = preg_replace_callback('~<font color=\'(#[a-z0-9]{6})\'>(.*?)</font>~', function($matches){
                    $repls = [
                        '#4e9a06' => 'int', //green
                        '#cc0000' => 'string', //orange, red
                        '#75507b' => 'bool', // #d379el
                    ];

                    $name = $repls[$matches[1]] ?? 'x';

                    return "<font color='$matches[1]' vdump='$name' >$matches[2]</font>";

                }, $template);

                echo $template;            
                
            }
        }

        return new self;

    }

    public static function cdump(array $args, array $titles = [], false $headers = false){

            if(isCli()){
                var_dump(...$args);
                return new self;
            }
            self::$cdump = $titles;
            if(func_num_args() > 2) self::$headers = $headers;
            $contents = <<<'CONTENTS'
            <?php 
            
            use spoova\mi\core\classes\Dumper;

            Dumper::dump($args);

            CONTENTS;

            $Filemanager = new Filemanager;

            if($Filemanager->openFile(true, self::dumpFile)){
                
                file_put_contents(self::dumpFile, $contents);
    
                ob_start();
                include(self::dumpFile);
                $template = ob_get_clean(); //new replacement
                $vfile = str_replace(['\\','/'], '\\\\', __FILE__).':[\d]+:';
                $template = preg_replace("~(<small>)?$vfile(</small>)?\n?~", '', $template);
                echo $template;     
            }

            return new self;
        

    }

    /**
     * Dumps an array list sequentially
     *
     * @param array $args associative array list of values to be dumped
     * @param array $titles defines a sequential list of custom subheaders for each array list
     * @param false $headers hide subheaders
     *  - By default subheaders are hidden when this method is applied 
     *  - In cases when $title is defined and $header is not specified as false, subheaders are automatically enabled 
     * @return Dumper
     */
    public static function vlist(array $args, array $titles = [], false $headers = false){

        if(isCli()){
            var_dump(...$args);
            return new self;
        }
        self::$vlist = $titles;
        if(func_num_args() > 2) {
            self::$headers = $headers;
        }else if(!$titles){
            self::$headers = false;
        }else if(func_num_args() === 2 && $titles){
            self::$headers = true;
        }
        $contents = <<<'CONTENTS'
        <?php 
        
        use spoova\mi\core\classes\Dumper;

        Dumper::dump($args);

        CONTENTS;

        $Filemanager = new Filemanager;

        if($Filemanager->openFile(true, self::dumpFile)){
            
            file_put_contents(self::dumpFile, $contents);

            ob_start();
            include(self::dumpFile);
            $template = ob_get_clean(); //new replacement
            $vfile = str_replace(['\\','/'], '\\\\', __FILE__).':[\d]+:';
            $template = preg_replace("~(<small>)?$vfile(</small>)?\n?~", '', $template);
            echo '<div :dump="vlist">'.$template.'</div>';     
        }

        return new self;
        

    }

    /**
     * Dumps an array list sequentially
     *
     * @param array $args associative array list of values to be dumped
     * @return Dumper
     */
    public static function vdiv(array $args){

        $contents = <<<'CONTENTS'
        <?php 
        
        use spoova\mi\core\classes\Dumper;

        Dumper::div($args);

        CONTENTS;

        $Filemanager = new Filemanager;

        if($Filemanager->openFile(true, self::dumpFile)){
            
            file_put_contents(self::dumpFile, $contents);

            ob_start();
            include(self::dumpFile);
            $template = ob_get_clean(); //new replacement
            $vfile = str_replace(['\\','/'], '\\\\', __FILE__).':[\d]+:';
            $template = preg_replace("~(<small>)?$vfile(</small>)?\n?~", '', $template);
            
            // redesign template 
            $template = preg_replace_callback('~<font color=\'(#[a-z0-9]{6})\'>(.*?)</font>~', function($matches){
                $repls = [
                    '#4e9a06' => 'int', //green
                    '#cc0000' => 'string', //orange, red
                    '#75507b' => 'bool', // #d379el
                ];

                $name = $repls[$matches[1]] ?? 'x';

                return "<font color='$matches[1]' vdump='$name' >$matches[2]</font>";

            }, $template);
            
            echo $template;     
        }

        return new self;
        

    }

    public static function div($args){
        self::set_xdebug_ini();     
        print '<style>pre[\:vdiv] > div > pre { margin: 0;}</style>
        <pre :vdiv style="padding:10px">';
        foreach($args as $arg => $value){
            print('<div style="display:flex; background-color:#efefef; padding:10px; border-radius:5px; flex-wrap:wrap"><span>'.$arg.' => </span>');
            var_dump($value);
            print("</div>\r\n");
        }
        print '</pre>';
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


        $args = func_get_args(); $count = -1;

        foreach($args as $property => $value){

            $count++;

            $items = !is_numeric($property)? $property : gettype($value);

            $objectType = (is_object($value))? basename(get_class($value)) : ucfirst(gettype($value));
            $traversable = (is_object($property) && ($property instanceof \Traversable))? ' (Traversable)' : '';

            $objectType = (!is_object($value) && ($objectType === 'Double'))? 'Float' : $objectType;

            $subject = self::$vlist ?: $objectType.$traversable;
            
            if(is_array($subject) && isset($subject[$count])) {
                if(self::$vlist){
                    $subject = $subject[self::$cdumpCounter] ?? '';
                }else{
                    $subject = $subject[$count];
                }
            }

            $padd = '';
            if(self::$headers && ($subject)) {
                $padd = 'padd-16';
                print '<summary><span>'.$subject.'</span></summary>';
            }
            
            $openHTML = $closeHTML = '';
            $summary = '<details><summary><span>%s</span></summary><div class="'.$padd.' dump">%s</div></details>';

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
        static $count = 0;
        $count++;
        if($count > 1) return '';
        return '

            :where(*) {
                margin:0;
                padding:0;
                box-sizing: border-box;
            }

            details[\:dump].main {  
                font-family: monospace;     
                display: inline-block;
                color: #3b4664;
                background: rgba(238, 238, 238, 0.9); 
                background-color: #f2f2f2;
                float:left; 
                width:100%; 
                padding: 1em;
                margin-bottom: 5px;
                list-style: none;
            }

            details[\:dump][open] > summary {
                background-color: #067abf;
                color: white;
            }

            details[\:dump][open] > .dump {
                /* background-color:white; */
                overflow-x: auto;
                padding-top: 10px;
            }

            details[\:dump][open] > .dump > pre {
                padding-bottom: 12px;
            }

             details[\:dump][open] pre.xdebug-var-dump {
                margin-top: 10px;
                margin-bottom: 10px;
                padding: 10px;
                background-color: #ececec;
            }

            details[\:dump].main[open] > summary {
                /* margin-bottom: 10px; */
            }

            details[\:dump].main details:not(.main){
                padding:10px;
            }

            [\:dump] summary {
                background-color:#aeaeae; 
                padding:10px; 
                border-radius:100vh; 
                background-color: #fff;
                cursor:pointer;
                transition: background-color .2s ease-in-out;
            }

            [\:dump] summary > span {
                user-select: none;
            }

            [\:dump] .dumper {
                display:block; 
                padding:0 12px
            }

            [\:dump] .padd-16 {
                display: block;
                padding: 16px;
                padding-bottom: 0;
            }
            
            [\:dump] .methods {
                display: block;
                font-family: calibri;
                font: menu;
                margin: 10px;
                color: #565656;
            }

            /* applied themes - dark */
            details[\:dump].dark.main {
                background-color: rgba(24,15,55,0.9);
                color: #3b4664;
            }

            details[\:dump].dark summary{
                background-color: #2e255b;
                color: white;
            }

            details[\:dump].dark .dump{
                color: #d2d2d2;
            }

            /* applied themes - cool */
            [\:dump] details.cool.main {
                background-color: rgba(45,53,75,0.9);
                color: #3b4664;
            }

            [\:dump] details.cool summary{
                background-color: #333d4b;
                color: white;
            }

            [\:dump] details.cool .dump{
                color: #d2d2d2;
            }

            /* applied value themes - cool, dark */
            [\:dump] details:where(.dark, .cool) font[vdump="string"]{
                color: orange;
            }

            [\:dump] details:where(.dark, .cool) font[vdump="int"]{
                color: lime;
            }

            [\:dump] details:where(.dark, .cool) font[vdump="bool"]{
                color: #d379e1;
            }

            [\:dump] details:where(.dark, .cool) .methods{
                color: #8d868b;
            }
        ';
    }

}