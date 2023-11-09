<?php

namespace spoova\mi\core\classes;

use ErrorHandler;

/**
 * Error warning display
 */
class EInfo {

    /**
     * trigger error message with file options
     *
     * @param string $message error message
     * @param boolean $addfile
     * @return boolean false
     */
    public static function trigger(string $message = '', string|object|bool $addfile = true) : bool{
        if(is_object($addfile)) $addfile = get_class($addfile);
        ErrorHandler::addFile($addfile);
        trigger_error($message);
        return false;
    }

    /**
     * trigger error message without file options
     *
     * @param string $message error message
     * @return boolean false
     */
    public static function view(string $message = '') : bool{
        ErrorHandler::addFile(false);   
        trigger_error($message);
        return false;
    }

    public static function errors(){
        return ErrorHandler::getErrors();
    }

}