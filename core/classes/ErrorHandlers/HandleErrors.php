<?php

namespace spoova\mi\core\classes\ErrorHandlers;

use ErrorHandler;
use spoova\mi\core\classes\Init;

class HandleErrors extends ErrorHandler{

    /**
     * Handle all simple non-fatal errors (Warning / Notice)
     *
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     * @return void
     */
    public function __construct($errno, $errstr, $errfile, $errline) {

        if(php_sapi_name() !== 'cli'){
            $this->handleErrors(...func_get_args());
        }else{
            $this->handleCliErrors(...func_get_args());
        }

    }

    /**
     * Resolve soft errors for web environments
     *
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     * @return void
     */
    public static function handleErrors($errno, $errstr, $errfile, $errline)
    {
        
        if(self::$err_displayed == self::$err_displays) return;

        $backTrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

        $useFile = self::$addfile;
        $cfile = strtolower(to_dirslash(str_replace(scheme('', false), docroot.DS, $useFile)));
       
        if(($ext = pathinfo($cfile, PATHINFO_EXTENSION))){
            if(realpath($cfile.'.php')) $cfile .= '.php';
        }
  
        if(is_string($useFile)){
          foreach ($backTrace as $traceBack) {
            if(isset($traceBack['file'])){
              $file = strtolower(to_dirslash($traceBack['file']));   
              if($file === $cfile) {
                $errfile = $traceBack['file'];
                $errline = $traceBack['line'];
                break;
              }else{
                if(strpos($file, domroot('core'))){
                    $errfile = $traceBack['file'];
                    $errline = $traceBack['line'];
                    break;
                }
              }
            }
          }
        }else{
          foreach ($backTrace as $traceBack) {
            if(isset($traceBack['file'])){
              $file = strtolower(to_frontslash($traceBack['file'])); 
              $core_file = rtrim(strtolower(to_frontslash(domroot('core'))), '/');

              $stripos = stripos($file, $core_file);
              
              if($stripos === false){
                    // Trace other directories (may update later)
                    $errfile = $traceBack['file'];
                    $errline = $traceBack['line'];
                    break;
                }
            }
          }            
        }

        $err = [
            'error'    => self::$errors[$errno],
            'message'  => $errstr,
            'errfile'  => $errfile,
            'errline'  => $errline,
            'errtrace' => $backTrace, //debug backtrace
            'handler'  => 'Exception'
        ];

        $max = 1;

        for($i = 0; $i <= count($backTrace); $i++){

            $line = $errline;
            $trace = $backTrace[$i] ?? [];

            if(isset($trace['line']) && ($trace['line'] === $errline)){
                $max = $i + 1; //update maximum
                break;
            }

        }

        $min = $max - 1;

        if(isset($backTrace[$max])){

            // max length of backtrace with equal error lines.
            $file = $backTrace[$min]['file'] ?? $backTrace[$max]['file'] ?? '';
            $line = $backTrace[$min]['line'] ?? $backTrace[$max]['line'] ?? '';
            
            $class = $backTrace[$max]['class'] ?? '';
            $type = $backTrace[$max]['type'] ?? '';
            $func = $backTrace[$max]['function'] ?? '';
           
            // var_dump($min, $max, $backTrace); 
            if(!$func && !$class){
                $class = $backTrace[$min]['class'] ?? '';     
                $type = $backTrace[$max]['type'] ?? '';
                $func = $backTrace[$min]['function'] ?? '';
            }
            // if($file) $backTrace[$min]['file'] = $file;          
            // if($line) $backTrace[$min]['line'] = $line;           
            // if($func) $backTrace[$min]['function'] = $func;          
            // if($class) $backTrace[$min]['class'] = $class;          
            // if($type) $backTrace[$min]['type'] = $type;  

            $previous = [];
            for($i = 0; $i < $max; $i++){
                $previous[$i] = $backTrace[$i];
                unset($backTrace[$i]);
            }
        
            $err['errfile'] = $file;
            $err['errline'] = $line;
            $err['errtrace'] = array_values($previous);
            $err['errtracx'] = array_values($backTrace);
        }
        
        self::displayErrors($err);
    }

    /**
     * Display errors as text string (webview)
     *
     * @param array $errors
     * @return void
     */
    private static function displayErrors(array $errors) {

        $error   = $errors['error']    ?? '';
        $efile   = $errors['errfile']  ?? '';
        $eline   = $errors['errline']  ?? '';
        $etraces = $errors['errtrace'] ?? [];
        $etracex = $errors['errtracx'] ?? [];
        $message = $errors['message']  ?? '';
        $err = $error;

        self::webdisplay($error, $message, $efile, $eline, $etraces, $etracex);
        
    }

    /**
     * Handle all simple errors (Warning / Notice)
     *
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     * @return void
     */
    public static function handleCliErrors($errno, $errstr, $errfile, $errline) {
        $err = self::buildErrors(self::$errors[$errno], $errstr, $errfile, $errline);

        //* Display with default cli text format
        self::clidisplay($err);
    }

}