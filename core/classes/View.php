<?php

    use spoova\core\classes\Slicer;

    
    /**
     * View is a function used render a page for routed files.
     * The can be used with the Res::post() or Res::get() method. 
     *
     * @param string|array $arg1 body or arguments
     * @param array|string $arg2 arguments or body
     * @return string|void
     */
    function view(string $file_path = '', $params = []){

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
     * Compile is a function used to compile a page for unrouted files.
     * Because it accepts arguments (variables). It should only be used once
     * within the Res::load() method. 
     * 
     * {@See Res::compile()}
     *
     * @param string|array $arg1 body or arguments
     * @param array|string $arg2 arguments or body
     * @return void
     */
    function compile($arg1 = '', $arg2 = ''){
        return Res::compile(...func_get_args());
    }   

?>