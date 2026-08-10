<?php 

namespace spoova\mi\core\classes\ErrorHandlers;

use spoova\mi\core\classes\ErrorHandlers\HandleCliErrors;
use spoova\mi\core\classes\ErrorHandlers\HandleExceptions;
use spoova\mi\core\classes\ErrorHandlers\HandleShutdown;
use spoova\mi\core\commands\Root\Cli;
use Throwable;

class ErrorBridge{

    public static function connect(Throwable|array|null $errors, string $type) {

        if(php_sapi_name() === 'cli'){
            new HandleCliErrors($errors, $type);
        }else{
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