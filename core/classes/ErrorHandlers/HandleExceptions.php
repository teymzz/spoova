<?php

namespace spoova\mi\core\classes\ErrorHandlers;

use ArgumentCountError;
use ErrorHandler;
use spoova\mi\core\classes\Init;

class HandleExceptions extends ErrorHandler{

    public function __construct(object $e = null)
    {
        if(php_sapi_name() !== 'cli'){
            $this->handleExceptions(...func_get_args());
        }else{
            $this->handleCliExceptions(...func_get_args());
        }
    }

    /**
     * Resolve exceptions for web environment
     *
     * @param object $e
     * @return void
     */
    public static function handleExceptions(object $e = null) {

        if(self::$err_displayed == self::$err_displays) return;

        // Detect type of error
        $constant = ucfirst(get_class($e)); 
        $constant = ($constant == 'ParseError')? $constant : 'Error';
        $exception = self::$exceptions[$constant];

        // Set error type
        $error = self::$errors[$exception];

        $err = [
            'error'    => $error,
            'message'  => $e->getMessage(),
            'errfile'  => $e->getFile(),
            'errline'  => $e->getLine(),
            'errtrace' => $e->getTrace(), //debug backtrace
            'handler'  => 'Exception'
        ];

        // Get the first backtrace item
        $backTrace = (debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1));
        $backTraceArgs = $backTrace[0]['args'] ?? false;
        
        // Reset file,line and error traces using backtrace argument
        if(is_array($backTraceArgs) && isset($backTraceArgs[0])){
            $backTraceFirstArg = $backTraceArgs[0];

            if($backTraceFirstArg instanceof ArgumentCountError){
                $errorTraces = $backTraceFirstArg->getTrace();

                $traceBuild['file'] = $errorTraces[0]['file'] ?? '';
                $traceBuild['line'] = $errorTraces[0]['line'] ?? '';

                if($traceBuild['file'] && $traceBuild['line']){
                    $err['errfile'] = $traceBuild['file']; 
                    $err['errline'] = $traceBuild['line'];
                    $err['errtrace'] = $errorTraces;
                }
            }

        }
        self::$ErrorExceptions = $err;
        self::displayExceptions($err);
    }

    /**
     * Format and display exceptions for web environment
     *
     * @param array $exceptions
     * @return void
     */
    private static function displayExceptions(array $exceptions){

        $error   = $exceptions['error']    ?? '';
        $efile   = $exceptions['errfile']  ?? '';
        $eline   = $exceptions['errline']  ?? '';
        $etraces = $exceptions['errtrace'] ?? [];
        $message = $exceptions['message']  ?? '';

        $traces = [];

        //filter out composer autoloader 
        array_map(function($value, $key) use(&$traces) {
            $loader = 'Composer\Autoload';

            $function = $value['function'] ?? '';
            $class    = $value['class'] ?? '';
            
            if((strpos($class, $loader) === false) && (strpos($function, $loader) === false)){
                $traces[$key] = $value;
            }else if($traces) {
                $traces[$key] = $value;
            }

        }, $etraces, array_keys($etraces));

        self::webdisplay($error, $message, $efile, $eline, $traces);

    }
    
    /**
     * Resolve exceptions for cli environment
     *
     * @return void
     */
    static function handleCliExceptions($e = null){
        $constant = ucfirst(get_class($e)); 
        $constant = $constant == 'ParseError'? $constant : 'Error';
        $exception = self::$exceptions[$constant];
        $error = self::$errors[$exception];

        $err = self::buildErrors(
            $error, $e->getMessage(), $e->getFile(), $e->getLine(),
            $e->getTrace(), 'Exception'
        );
        self::clidisplay($err);
    }

}