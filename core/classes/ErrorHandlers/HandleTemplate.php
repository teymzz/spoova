<?php

namespace spoova\mi\core\classes\ErrorHandlers;

use Error;
use ErrorHandler;
use ParseError;
use spoova\mi\core\classes\Debug;
use spoova\mi\core\classes\Init;
use spoova\mi\core\commands\Root\Cli;

/**
 * This class is designed to handle errors that are triggered from Template compiler files.
 */
class HandleTemplate extends ErrorHandler{

    /**
     * Handle template errors
     *
     * @param Error|null $e
     */
    public function __construct(?Error $e) {

        $type = $e instanceof ParseError? 'Parse Error' : 'Fatal Error';
        $format = self::formatThrowable($e, $type);

        if(php_sapi_name() !== 'cli'){
            $this->handleTemplateError($format);
        }else{
            $this->handleCliTemplateError($format);
        }

    }

    private static function handleTemplateError(array $info){
        $error   = $info['error'];
        $message = $info['message'];
        $efile   = $info['errfile'];
        $eline   = $info['errline'];
        $backtrace = $info['backtrace'];

        ob_end_clean();

        response(510, $error.' (Rex)');
        print "<!doctype html><html lang='en'><body>";
        echo self::resource('design', 'res/main/css/local/debug/res.css');
        echo self::resource('script', 'res/main/js/local/debug/debug.js');
        self::webdisplay($info, $error, $message, $efile, $eline, $backtrace);
        print "</html></body>";
    }

    private static function handleCliTemplateError(array $info){
        self::cliDisplay($info);
        Cli::break(2);
    }

}