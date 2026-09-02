<?php 

namespace spoova\mi\core\commands\Root\Cli\CliError;

use spoova\mi\core\classes\ErrorHandlers\HandleCliErrors;

class CliError {

    /**
     * Returns true if any error exists on the CLI environment
     * 
     * @return boolean
     */
    public static function exists()  : bool{
        return self::detects('any');
    }

    /**
     * Returns true if an error exists on the CLI environment
     *
     * @param string $type optional [any|fatal|non-fatal]
     *   - any : refers to any kinds of error (i.e fatal or non-fatal) 
     *   - fatal: refers to only fatal errors
     *   - non-fatal, nfatal, nonFatal: any of these options (case-insensitive) refers to non-fatal errors. 
     * @return boolean
     */
    public static function detects(string $type)  : bool{
        $type = strtolower($type);

        if(!HandleCliErrors::error_exists()) return false;
        if($type === 'any') return true;
        if(in_array($type, ['nfatal','non-fatal','nonfatal'])) return !HandleCliErrors::isFatal();
        if($type === 'fatal') return HandleCliErrors::isFatal();
        return false;
    }

}