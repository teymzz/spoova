<?php

namespace spoova\mi\core\commands\Root\Cli;

use ErrorException;
use spoova\mi\core\commands\Root\Cli;

/**
 * This class gets or sets stty state.
 */
class CliState{

    private static array $states = [];

    /**
     * Get the current stty state
     *  @param boolean|string|null $hash 
     *   - NULL : returns the direct state without saving in memory.
     *   - TRUE : saves the current state and returns the direct string of the saved state. 
     *   - FALSE : saves the current state and returns the hash string of the saved state. 
     *   - String : hash value supplied fetches the saved state or returns false if the hash is not found.
     * @return string|False
     *  FALSE if the hash string supplied does not exist or stty command fails to get saved state.
     */
    public static function get(bool|string|null $hash = null) : string|false{
        if($hash===null) return trim(shell_exec('stty -g'));
        $randice = randice(10); // get an hash string
        if(is_string($hash)) return self::$states[$hash] ?? false;
        self::$states[$randice] = trim(shell_exec('stty -g'));
        return $hash;
    }

    /**
     * Get the current stty state using the default ``get(null)`` mode.
     * 
     * @return string|False
     *  FALSE if stty command fails to get saved state.
     */
    public static function current() : string|false{
        return self::get();
    }

    /**
     * Detects if an hash string state exists.
     *
     * @param string $hash hash of previously saved state.
     * @return boolean
     */
    public static function exists(string $hash) : bool {
        return self::$states[$hash] ?? false;
    }

    /**
     * Set a new stty command
     *  - Hash string returned should be used to restore the previous state using {@see CliState::restore()} 
     * @param string $command stty command to be executed. 
     *   - Note that stty command is prefixed by default 
     * @param boolean $save TRUE saves the mode while FALSE does not save mode. 
     * @return string hash string
     */
    public static function set(string $command, bool $save = true) : string{
        if($save){
            $hashString = randice(10);
            self::$states[$hashString] = trim(shell_exec('stty -g'));
        }
        $response = system('stty ' . $command);
        if($response){
            return $hashString ?? true;
        }else{
            if(!empty($hashString)) unset(self::$states[$hashString]);
            return $response;
        }
    }
    /**
     * Runs a new stty command. Alias to {@see Cli::set()}
     *  - Hash string returned should be used to restore the previous state using {@see CliState::restore()} 
     * @param string $command stty command to be executed. 
     *   - Note that stty command is prefixed by default
     * @return string hash string
     */
    public static function stty($command, bool $save = true) : string{
       return self::set(...func_get_args());
    }

    /**
     * Restore a previous stty state
     *
     * @param string|null $state previous hash string of state.
     *   - NULL will restore stty state using the 'stty sane' command.
     * @param bool $flush TRUE unsets hash string from storage after restore. The state will no longer exist in storage after this is used.
     * @return void
     */
    public static function restore(?string $state = null, $flush = false){
        if(!in_array($state, self::$states)){
            Cli::showCursor();
            throw new ErrorException('unknown stty state cannot be restored');
        }
        $state = self::$states[$state];
        if($flush) unset(self::$states[$state]);
        system('stty ' . escapeshellarg($state));
    }

}