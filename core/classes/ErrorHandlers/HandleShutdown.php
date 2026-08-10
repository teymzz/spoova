<?php 

namespace spoova\mi\core\classes\ErrorHandlers;

use ErrorHandler;
use spoova\mi\core\classes\Debug;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliState;

/**
 * Reconsider Fixing this class arguments.
 */
class HandleShutdown extends ErrorHandler{

    /**
     * Shutdown Errors Handler for web pages
     *
     * @param array $error array containing the following keys 
     *  - errno: error number 
     *  - errstr: error message 
     *  - errfile: error file 
     *  - errline: error line number
     */
    public function __construct(array $error)
    {
        if($error){
            if(ob_get_level() > 0) ob_end_clean();
            $this->handleShutdown($error['type'], $error['message'], $error['file'], $error['line']);  
        }

    }

    private static function normalize_cli(){
        if(isCli()){
            Cli::showCursor();
            if(Cli::hasCommand('stty') && Cli::sttyEnabled()) {CliState::stty('sane', false); Cli::break();}
        }
    }

    public static function handleShutdown(int $errno, string $errstr, string $errfile, int $errline){
        $errors['error'] = self::errors[$errno]; // type of shutdown error
        $errors['message'] = $errstr;
        $errors['errfile'] = $errfile;
        $errors['errline'] = $errline;
        $errors['backtrace'] = Debug::get(2) ?: Debug::traces();
        $errors['handler'] = 'Shutdown';
        self::displayShutdownError($errors);
    }

    private static function displayShutdownError(array $info){
        $error   = $info['error'];
        $message = $info['message'];
        $efile   = $info['errfile'];
        $eline   = $info['errline'];
        $backtrace = $info['backtrace'];
        if(ob_get_level() > 0) ob_end_clean();
        response(510, 'Server Error');
        print "<!doctype html><html lang='en'><body>";
        echo self::resource('design', 'res/main/css/local/debug/res.css');
        echo self::resource('script', 'res/main/js/local/debug/debug.js');
        self::webdisplay($info, $error, $message, $efile, $eline, $backtrace);
        print "</html></body>";
    }

}