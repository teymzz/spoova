<?php

namespace spoova\mi\core\classes\ErrorHandlers;

use ErrorHandler;
use spoova\mi\core\classes\Debug;
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
    public function __construct(int $errno, string $errstr, string $errfile, int $errline) {

        $this->handleErrors(...func_get_args());

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
    public static function handleErrors(int $errno, string $errstr, string $errfile, int $errline)
    {

        if((self::$err_displayed !== null) && (self::$err_displayed === self::$err_displays)) return;
    
        $traces = Debug::traces(); // all back traces
        $backTrace = Debug::get(2, true) ?: $traces; // backtrace from 2 else backtrace all

        // preFormat($traces);
        $useFile = self::$addfile;
        $cfile = strtolower(to_dirslash(str_replace(scheme('', false), docroot.DS, $useFile)));
       
        if(($ext = pathinfo($cfile, PATHINFO_EXTENSION))){
            if(realpath($cfile.'.php')) $cfile .= '.php';
        }

        if(is_string($useFile)){
            //use $traceIndex(>=[2]) later to remove  
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
          foreach ($backTrace as $backTraceIndex => $traceBack) {
            if(isset($traceBack['file'])){

                $class = $traceBack['class']  ?? '';
                $type = $traceBack['type'] ?? '';
                $function = $traceBack['function'] ?? '';

                if($class === 'ErrorHandler' && ($type === '::') && ($function === 'handleErrors')){
                    if($traceBack['file'] !== __FILE__){
                        $backTrace[$backTraceIndex]['class'] = '';
                        $backTrace[$backTraceIndex]['type'] = '';
                        $backTrace[$backTraceIndex]['function'] = '';
                    }
                }
                #REVISIT THIS FOR Undefined Variable Errors & Others before final removal!!!
            //   $file = strtolower(to_frontslash($traceBack['file'])); 
            //   $core_file = rtrim(strtolower(to_frontslash(domroot('core'))), '/');

            //   $stripos = stripos($file, $core_file);
              
            //   if($stripos === false){
            //         // Trace other directories (may update later)
            //         $errfile = $traceBack['file'];
            //         $errline = $traceBack['line'];
            //         break;
            //   }
            }
          }            
        }
        $err = [
            'error'    => self::errors[$errno],
            'message'  => $errstr,
            'errfile'  => $errfile,
            'errline'  => $errline,
            'backtrace'=> $backTrace, //debug backtrace
            'alltrace' => $traces, //debug backtrace full
            'handler'  => 'Error'
        ];

        $max = 1; 

        for($i = 0; $i <= count($backTrace); $i++){

            $line = $errline;
            $trace = $backTrace[$i] ?? [];

            if(isset($trace['line']) && ($trace['line'] === $errline)){
                $max = $i + 1; //update maximum
                break;
            }elseif($i === count($backTrace)){
                $max = $i;
            }

        }

        $min = $max - 1;

        if(isset($backTrace[$max])){
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
        $btraces = $errors['backtrace']?? [];   // backtraces all 
        $etraces = $errors['errtrace'] ?? [];  // stack traces (Exceptions)
        $message = $errors['message']  ?? '';

        self::webdisplay($errors, $error, $message, $efile, $eline, $btraces, $etraces);
    }

}