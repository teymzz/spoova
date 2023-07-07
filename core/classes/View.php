<?php

use spoova\mi\core\classes\Compiler;
use spoova\mi\core\classes\EInfo;
use spoova\mi\core\classes\Rex;
use spoova\mi\core\classes\Slicer;

    /**
     * View is a function used render template files for routed files.
     * 
     * @param string $file_path file path
     * @param array $arg2 variable arguments
     * @return string|void void is returned if file path does not exist
     */
    function view(string $file_path = '', array $params = []){

        //get path extension            
        $file_path = ($file_path == '/')? "index" : $file_path;
        $file_ext = pathinfo($file_path, PATHINFO_EXTENSION);

        if($file_path){
            $ext = ($file_ext == '')? ".rex.php" : ($file_ext == 'rex' ? ".php" : '');        

            $path = docroot.DS.WIN_REX.$file_path.$ext;
            return Slicer::loadSlice($path, $params)->data();
        }

    }

    /**
     * Compile is a function used to compile a rex template files.
     * 
     * {@See Rex::compile()}
     *
     * @param string|array $arg1 url or arguments
     * @param array|string $arg2 arguments or url
     * @return Compiler|String
     */
    function compile(array|string $arg1 = [], array|string $arg2 = ''): Compiler|String {
        $compiler = new Compiler();
        return $compiler->compile(...func_get_args());
    }   

    /**
     * This function compiles and directly displays rex template files with no extended functionalities.
     * 
     * {@See Rex::compile()}
     *
     * @param string|array $arg1 url or arguments
     * @param array|string $arg2 arguments or url
     * @return void
     */
    function rexcompile(array|string $arg1 = [], array|string $arg2 = '') {
        $compiler = new Compiler();
        echo $compiler->compile(...func_get_args());
    }   

    /**
     * Pulls out the raw content of a rex file
     *
     * @param string $file rex file path within WIN_REX directory.
     *  - Note: supports dot convention with default extension as ".rex.php"
     * 
     * @return string|false
     */
    function raw(string $file) : string|false {

        $file = to_frontslash(WIN_REX.$file, true);
        $file .= ".rex.php";

        if(is_file($file)){

            $contents = file_get_contents($file);

            return $contents;


        } else {    

            return EInfo::view('invalid rex file path supplied!');

        }

    }

    /**
     * Returns the markup of a rendered component
     */
    function rex(string $url = '', bool|Closure $callback = false) {
  
      $rex = new Rex;
      return (string) $rex::markup(...func_get_args());
    
    }


?>