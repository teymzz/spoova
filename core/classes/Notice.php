<?php

namespace spoova\mi\core\classes;

/**
 * This class is used to handle flash messages
 */
class Notice 
{
    protected const FLASH_KEY = 'FLASH_KEY';

    public function __construct()
    {

        $flashNotices = $_SESSION[self::FLASH_KEY]?? [];

        foreach ($flashNotices as $key => &$flashNotice) {
            
            //set to be deleted
            $flashNotice['remove'] = true;

        }
        $_SESSION[self::FLASH_KEY] = $flashNotices;

        if(empty($_SESSION[self::FLASH_KEY])) unset($_SESSION[self::FLASH_KEY]);

    }

    public function setFlash(string $key, $message = '')
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message
        ];
    }


    /**
     * returns the value of the default key set
     *
     * @param string $key
     * @return string|false
     */
    public function getFlash(string $key) : string|false {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }
    
    /**
     * Returns true if a flash key exists
     *
     * @param string $key
     * @return bool
     */
    public function hasFlash(string $key) : bool{
        return isset($_SESSION[self::FLASH_KEY][$key]);
    }

    /**
     * if $key exists, returns $inline_message or default message set 
     *
     * @param string $key flash key
     * @return string
     */    
    public function flash($key, $inline_message = '') : string {
        
        if(isset($_SESSION[self::FLASH_KEY])){
            if(isset($_SESSION[self::FLASH_KEY][$key])){
                if(func_num_args() < 2) return $_SESSION[self::FLASH_KEY][$key]['value']?? '' ;      
                return $inline_message;
            }
        }
        return '';
    }

    public function __destruct()
    { 
        $flashNotices = $_SESSION[self::FLASH_KEY]?? [];

        foreach ($flashNotices as $key => &$flashNotice) {
            
            if($flashNotice['remove']){
                unset($flashNotices[$key]);
            }            
        }
       
        $_SESSION[self::FLASH_KEY] = $flashNotices;

    }

}