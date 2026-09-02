<?php

namespace spoova\mi\core\classes\ErrorHandlers;

use ArgumentCountError;
use ErrorHandler;
use spoova\mi\core\classes\Debug;
use Throwable;

class HandleExceptions extends ErrorHandler{

    public function __construct(?Throwable $e = null)
    {
        //response(510, 'some error occured', coded:false);
        SET('spoova-exception', true);
        self::handleExceptions(...func_get_args());
        exit;
        
    }

    /**
     * Resolve exceptions for web environment
     *
     * @param object $e
     * @return void
     */
    public static function handleExceptions(?Throwable $e = null) {

        if(ob_get_level() > 0) ob_end_clean();

        if(self::$err_displayed === self::$err_displays) return;

        // Detect type of error
        $constant = ucfirst(get_class($e)); 

        $constant = ($constant == 'ParseError')? $constant : 'Error'; // Set Throwable name as ParseError or Error

        $exception = self::$exceptions[$constant]; 

        $backTrace = Debug::get(2, true) ?: Debug::traces(); // backtrace from 2 else backtrace all
        // Set error type
        $error = self::errors[$exception];
        $err = self::formatThrowable($e, ucfirst($error), $backTrace);

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
                    $err['errtrace'] = $errorTraces; // modified stack trace
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
        $btraces = $exceptions['backtrace'] ?? [];
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
        $info = array_values(Debug::get(2, true));
        if(count($info) < 2 && count($traces) > 1){
            $btraces = $traces;
        }
        
        self::webdisplay($exceptions, $error, $message, $efile, $eline, $btraces, $traces);
    }

}