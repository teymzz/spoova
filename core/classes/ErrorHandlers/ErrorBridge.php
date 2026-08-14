<?php 

namespace spoova\mi\core\classes\ErrorHandlers;

use spoova\mi\core\classes\ErrorHandlers\HandleCliErrors;
use spoova\mi\core\classes\ErrorHandlers\HandleExceptions;
use spoova\mi\core\classes\ErrorHandlers\HandleShutdown;
use spoova\mi\core\classes\ErrorLogger;
use spoova\mi\core\commands\Root\Cli;
use Throwable;

class ErrorBridge{

    public static function connect(Throwable|array|null $errors, string $type) {

        /* Recorded before anything is rendered, so an error still reaches the log
           even when the handler that would have displayed it fails. Does nothing
           unless ERROR_LOG is switched on, and never throws. */
        ErrorLogger::log($errors, $type);

        if(php_sapi_name() === 'cli'){
            // the console is not public, so a developer always sees the error there
            new HandleCliErrors($errors, $type);
        }else{

            /* With display switched off the log is the whole response. Returning
               here keeps the trace, the file paths and the argument values out of
               the page; the framework's own error page still answers the request. */
            if(!ErrorLogger::displaying()) return null;

            if($type === 'shutdown'){
               // error must occur before the class is initialized.
               if($errors) new HandleShutdown($errors);
            }elseif($type === 'exception'){
                new HandleExceptions($errors);
            }else if($type === 'error'){
                if(!(error_reporting() & !empty($errors))){
                    return false; // respect supression
                }else{
                    $errors = array_values($errors);
                    new HandleErrors(...$errors);
                }
            }
        }
    }

}