<?php

/* App Basic functions - Dependent on defs.php */
use spoova\mi\core\classes\FileManager;

/**
 * Check php console environment
 *
 * @return boolean
 */
function isCli() : bool{ 
    return (php_sapi_name() == 'cli') ; 
}

/**
 * Return app environment value
 *
 * @param string $value
 * @return mixed
 */
function appenv($value = ''){

    return $_ENV[$value] ?? '';
    
}	

if(!function_exists('env')){
    /**
     * Reads the last data obtained from Filemanager::loadEnv() method
     * @param string $key an access key
     * @param bool|string $super defines environment where data should be pulled.
     *  - When $super is not defined or set as false, data returned may be from global scope and if not found, from Filemanager::env_data() 
     *  - When $super is set as true, $key must exist as a global key only or empty value is returned.
     *  - When $super is set as a string, $key must be a subkey of $super or empty value is returned.
     * @return array|string
     */
    function env(string $key, bool|string $super = false) : array|string {
    
        if((func_num_args() === 1) | ($super === false)){
        $data = FileManager::env_data();
        return $_ENV[$key] ?? $data[$key] ?? '';
        }else{
        if($super === true){
            return $_ENV[$key] ?? '';
        }else{
    
            if(isset($_ENV[$super])){
                return $_ENV[$super][$key] ?? '';
                }
    
                return '';
            }
        }
    
    
    }
} 

/**
 * Return app environment constants value
 *
 * @param string $value
 * @return mixed
 */
function appcon($value = ''){

    $env['base-url'] = baseUrl;
    $env['base-uri'] = baseUri;
    $env['pathlink'] = pathlink;
    $env['docdir']   = docdir;
    
    if(!($_ENV['constants'] ?? '')) {
        return $env[$value]?? '';
    }
    
    if(in_array($value, $env)){
        return $_ENV['constants'][$value] ?? $env[$value];
    }
    
    return $_ENV['constants'][$value] ?? '';
    
} 

//define function undefined
function _define($name, $value){ if(!defined($name)) define($name,$value); }

//define environment constants
function _envdefine($name, $onvalue, $offvalue = ''){ 
    if(!defined($name)) 
      ((online)? define($name,$onvalue): define($name,$offvalue)); 
}
  
//set items only when on live server
function setOnline(&$var, $value){
    if(defined('online')){
        if(online) $var = $value;
    }
}

//set items only when on local server
function setOffline(&$var, $value){
    if(defined('online')){
        if(!online) $var = $value;
    }
}


/**
 * Get request values
 *
 * @param string $reqType [post|get]
 * @param array $values
 * @return string
 */
function reqValue($reqType = 'get', array $values = []){

    if($reqType == '$_POST'){
        $method = $_POST;
    }else{
        $method = $_GET;
    }

    foreach($values as $child){
        if(isset($method[$child])){
            $method = $method[$child];
        }else{
            $method = '';
        }
    }

    return $values? $method : '';

}

/**
 * set post in ajax requests using phpInput()
 * @notice: This cannot be validated with INPUT_POST.
 * @return void
 */
function phpInput(){
    if(empty($_POST)){
        if(!empty(file_get_contents('php://input'))){
            $phpInput = @json_decode(file_get_contents('php://input'), true); 
            if(!empty($phpInput))
            $_POST = $phpInput;
        }
    }
}

//define function for light file inclusion
function _includeOnce($path){
    if(is_file($path)) include_once $path;
} 

/**
 * Returns defined constant's value or empty string
 *
 * @param string $core
 * @return string
 */
function getDefined(string $core) :string {
    return defined($core)? constant($core) : '';
}

/**
 * Checks if a class exists in project folder or its subdirectory using regex
 * 
 *  - Note 1: This does not truely check if the class is callable
 *  - Note 2: The project folder root namespace is attached by default
 * @param string $class
 * @return boolean
 */
function appExists($class) : bool{

    $class = '\\'.ltrim($class,'\\ ');
    $classDir = str_replace('\\', '/', $class);
   
    $appSpace = rtrim(ltrim(scheme, '\\ '),'\\ ');

    // class path in windows folder
    $classSpace = str_replace('/', '\\', dirname($classDir));
    $classSpace = $classSpace == '.'? '' : $classSpace;
    $classSpace = $classSpace;

    // set a namespace structure
    $Namespace = str_replace(['\\', '/'], '\\', 'namespace '. $appSpace . $classSpace );
   

    //Get the class real name
    $className = ucfirst(basename($classDir));

    //class path
    $classPath = $classSpace.'/'.$className;

    //class file
    $classFile = str_replace('\\', '/', docroot.$classPath.'.php');

    if( is_file($classFile) ) {

        $fcontents = file_get_contents($classFile);

        $map = array();
        $tokens = token_get_all($fcontents);
        $namespace = '';

        foreach($tokens as $token) {

            if(!is_string($token)) {

                list($id, $text) = $token;

                if( $id == T_NAMESPACE ) {

                    $namespace = $text;

                }

                if( $id == T_CLASS ) {
                
                    if($namespace) {

                        $map[$namespace] = $text;
                        
                        if( stristr($fcontents, $Namespace) ) { 
                            preg_match("~\n\s*?class\s*?$className\s?[\w\\\s,]*?~", $fcontents, $matches);

                            if($matches[0]??false) return true;
                        }
                    
                    }


                }

            }

        }

    }

    return false;

}

/**
 * Checks if a class exists in window folder using regex
 * 
 *  - Note 1: This does not truely check if the class is callable
 *  - Note 2: $class must be a file directly within the windows folder or its subdirectory.
 * 
 * @param string $class class name or path within the windows folder
 * @return boolean
 */
function windowExists($class) : bool{

    $winRoute = "\windows\\".ltrim($class, '\\');

    return appExists($winRoute);

}

/**
 * Checks if a route class exists in 'windows\Routes' folder using regex
 * 
 *  - Note 1: This does not truely check if the class is callable
 *  - Note 2: $class must be a file or subdirectory of "windows\Routes" folder.
 * 
 * @param string $class
 * @return boolean
 */
function routeExists($class) : bool{


    $winRoute = WIN_ROUTES.ltrim($class, '\\');
    return appExists($winRoute);

}

/**
 * Strip the last slashes of a specific string
 *
 * @param string $var
 * @return string
 */
function striplastSlash(string $var){
    if(substr($var, -1)=='\\' || substr($var, -1)=='/'){
      $var = substr($var, 0,-1);
      if(substr($var, -1)=='\\' || substr($var, -1)=='/'){
        $var = striplastSlash($var);
      }
     return $var;
    }  
    return $var;
} 

/**
 * Returns a path to a namspace struture (i.e using forward slash)
 *
 * @param string $text
 * @return string bool $dots true allows all dots to be converted to backslash 
 */
function to_backslash(string $text, $dots = false) : string {

    return str_replace(($dots? ['/','.'] : ['/']),'\\', $text);

}


/**
 * Converts all slashes to DIRECTORY_SEPARTOR
 *
 * @param string $text
 * @param bool $dots true allows all dots to be converted to frontslash 
 * @return string
 */
function to_dirslash(string $text, $dots = false) : string {

    return str_replace(($dots? ['\\','.','/'] : ['\\','/']), DIRECTORY_SEPARATOR, $text);

}


/**
 * Returns backslash to frontslash (i.e using back slash)
 *
 * @param string $text
 * @param bool $dots true allows all dots to be converted to frontslash 
 * @return string
 */
function to_frontslash(string $text, $dots = false) : string {

    return str_replace(($dots? ['\\','.'] : ['\\']),'/', $text);

}

/**
 * Returns a path to a namspace struture (i.e using forward slash)
 * - backslash prefix is automatically set if $text contains at least a non-space character and $prefix is true 
 * - backslash will be removed only of $prefix is set as false
 * - strips all last slashes
 *
 * @param string $text
 * @return string bool $dots true allows all dots to be converted to backslash 
 *  
 */
function to_namespace(string $text, $prefix = false) : string {

    $text = to_backslash($text);
    $text = trim($text)? '\\'.$text : $text; 
    if(!$prefix) $text = ltrim($text, ' \\');
    return striplastSlash($text, '\\');

}

/**
 * Returns a path to a namspace struture (i.e using forward slash)
 *
 * @param string $text
 * @return string bool $dots true allows all dots to be converted to backslash 
 * 
 * @notice: 
 * - backslash prefix is automatically set if $text contains at least a non-space character and $prefix is true 
 * - backslash will be removed only of $prefix is set as false
 */
function to_dotspace(string $text, $prefix = false) : string {

    $text = to_backslash($text, true);
    return to_namespace($text, $prefix);

}