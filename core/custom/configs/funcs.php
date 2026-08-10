<?php

/* App Basic functions - Dependent on defs.php */

use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use spoova\mi\core\commands\Root\Cli;

/**
 * Check php console environment
 *
 * @return boolean
 */
function isCli() : bool{ 
    return (php_sapi_name() == 'cli') ; 
}

/**
 * Check php terminal type
 * 
 * @param string[] $type optional [wsl|bash|termux|termux-bash|linux]
 *
 * @return boolean
 */
function isTerminal(string|array $type) : bool { 

    return Cli::isTerminal($type);
    
}

/**
 * Test if online connection is available using google domain.
 *
 * @return boolean
 */
function isOnline() : bool {

    // Quick DNS check (fast)
    if (!checkdnsrr("google.com", "A")) return false;

    // Real HTTP test (confirm actual internet)
    $ch = curl_init("https://www.google.com/generate_204");
    curl_setopt_array($ch, [
        CURLOPT_CONNECTTIMEOUT => 3,
        CURLOPT_TIMEOUT => 3,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_NOBODY => true,
        CURLOPT_SSL_VERIFYPEER => false, // optional for testing
    ]);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    return $code === 204;
}

/**
 * Get the device operating system
 *  - Note that all strings are returned in lower case
 * 
 * @param bool $strict ``TRUE`` returns macos for macOs devices instead of the default darwin.
 * @return string|false
 */
function getOs(bool $strict = false) : string|false { 
    
    if(PHP_OS_FAMILY === 'Unknown') return false;

    if(PHP_OS_FAMILY === 'Darwin') {
        return strtolower($strict? 'macos' : 'darwin');
    }

    return strtolower(PHP_OS_FAMILY); //return the os of other devices in smaller cases.
}
/**
 * Smartly tests the current operating system name. Use this as an alternative to {@see getOS()}
 *  - Note for macOS, any of mac, darwin, macOS string is supported
 * 
 * @param string|array $name a list of os that the current device O.S must exist within
 *  - Note 'unix' will refer to darwin and linux O.S only 
 * @return boolean
 */
function isOS(string|array $name) : bool { 
    $name = is_array($name)? $name : [$name];
    $name = array_map(fn($val) => in_array(strtolower($val), ['macos','mac'])? 'darwin' : strtolower($val), $name);
    
    if($name === 'unix') return in_array(strtolower(PHP_OS_FAMILY), ['darwin','linux']);
    return in_array(strtolower(PHP_OS_FAMILY),$name); //return the os of other devices in smaller cases.
}

/**
 * Check if device operating system is windows
 *
 * @return boolean
 */
function isWindows() : bool{ 
    return getOs() === 'windows';
}


if(!function_exists('is_closure')){
    /**
     * Check if a value is Closure format
     *
     * @return boolean
     */
    function is_closure(mixed $value) : bool{ 
        return $value instanceof Closure;
    }
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
     * @return mixed
     */
    function env(string $key, bool|string $super = false) : mixed {
    
        if((func_num_args() === 1) | ($super === false)){
        $data = Filemanager::env_data();
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
 * Dumps the content of PHPInput into $_POST variable only 
 * when $_POST is empty. This is useful for custom ajax request methods.
 *  - Note: Data dumped into $_POST cannot be validated with INPUT_POST.
 * @return void
 */
function POSTInput() : void {
    if(empty($_POST)){
        if(!empty(file_get_contents('php://input'))){
            $POSTInput = @json_decode(file_get_contents('php://input'), true); 
            if(!empty($POSTInput))
            $_POST = $POSTInput;
        }
    }
}

/**
 * Retrieves the content of 'php://input' as string or array using data type hinting.
 *  - Note that the default data hinting type is array if callback function is not defined.
 * @param $callback a callback that manages the type of data returned
 * @return mixed
 *   - If Closure data hinting is string and php input is empty, empty string is returned
 *   - If Closure data hinting is array and php input is empty, empty array is returned
 *   - Any data type is allowed to be returned through the $callback Closure function
 */
function PHPInput(?Closure $callback = null) {

    $type = 'array';
    if($callback){
        $reflection = new ReflectionFunction($callback);
        $parameters = $reflection->getParameters();
        if(count($parameters)>0){
            $type = (string) $parameters[0]->getType();
        }
        if(!in_array($type, ['array', 'string', ''])){
            throw new InvalidArgumentException('data type hint must be an array or string if defined');
        }
    }
    if(!empty(file_get_contents('php://input'))){
        $data = file_get_contents('php://input');
        $data = ($type === 'string')? $data :  @json_decode($data, true);
        return $callback($data);
    }
    return ($type === 'string')? '' : [];
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
 *  - Note 2: The project folder root namespace (e.g \spoova\mi) is attached by default
 * @param string $class
 * @param boolean $strict FALSE includes abstract classes
 * @return boolean
 */
function appExists($class, bool $strict = true) : bool{

    $class = str_replace('.', '\\', $class);
    $class = '\\'.ltrim($class,'\\ ');
    $classDir = str_replace('\\', '/', $class);
   
    $appSpace = rtrim(ltrim(scheme, '\\ '),'\\ ');

    // class path in windows folder
    $classSpace = str_replace('/', '\\', dirname($classDir));
    $classSpace = $classSpace == '.'? '' : $classSpace;
    $classSpace = $classSpace;

    $test_token = $strict? [T_CLASS] :  [T_CLASS, T_ABSTRACT];

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

                if(in_array($id, $test_token)) {
                    
                    if($namespace) {

                        $map[$namespace] = $text;
                        
                        if( stristr($fcontents, $Namespace) ) { 

                            if($strict){ 
                                preg_match("~\n\s*?class\s*?$className\s?[\w\\\s,]*?~i", $fcontents, $matches);
                            }else{
                                preg_match("~\n\s*?((abstract)?\s*?)?class\s*?$className\s?[\w\\\s,]*?~i", $fcontents, $matches);
                            }

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
 * @return boolean $dots TRUE allows all dots to be converted to backslash 
 */
function to_backslash(string $text, $dots = false) : string {

    return str_replace(($dots? ['/','.'] : ['/']),'\\', $text);

}


/**
 * Converts forward or backward slashes to the current device's DIRECTORY_SEPARTOR slash
 *
 * @param string $text
 * @param boolean $dots true allows all dots to be converted to frontslash 
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
 * Returns a path (dots excluded) to a namespace struture using backslash
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
 * Returns a path (dots included) to a namespace structure using backslash slash
 *
 * @param string $text string to be converted to namespace format
 * @param bool $prefix TRUE adds a backslash prefix to the returned string while FALSE will strip off the preceding backslash.
 * 
 * @return string  
 * - retured value is preceded by backslash if $text contains at least a non-space character and $prefix is true 
 */
function to_dotspace(string $text, bool $prefix = false) : string {

    $text = to_backslash($text, true);
    return to_namespace($text, $prefix);

}