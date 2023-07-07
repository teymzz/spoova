<?php

namespace spoova\mi\core\classes;

use Session;

/**
 * This class is used to handle flash messages
 */
class Notice 
{
    public const FLASH_KEY = 'FLASH'; 

    public function __construct()
    {

        if(is_array(Session::base()->value(SELF::FLASH_KEY))){
            $flashNotices = Session::base()->value(SELF::FLASH_KEY);
        }else{
            $flashNotices = [];
        }

        foreach ($flashNotices as $key => &$flashNotice) {
            
            //set to be deleted
            $flashNotice['remove'] = true;

        }

        Session::base()->save(SELF::FLASH_KEY, $flashNotices);

        if(!Session::base()->value(SELF::FLASH_KEY)) {
            Session::base()->remove(SELF::FLASH_KEY);
        }

    }

    public function setFlash(string $key, $message = '')
    {
        //get previous flash key...
        $flashes = Session::base()->value(SELF::FLASH_KEY);
        
        if(!is_array($flashes)) $flashes = [];
        
        $flashes[$key] = [
            'remove' => false,
            'value' => $message
        ];
        Session::base()->save(SELF::FLASH_KEY, $flashes);
    }


    /**
     * returns the value of the default key set
     *
     * @param string $key
     * @return string|false
     */
    public function getFlash(string $key) : string|false {
        $flash = Session::base()->value(self::FLASH_KEY, $key);
        $flash = is_array($flash)? $flash : [];
        return $flash['value'] ?? false;
    }
    
    /**
     * Returns true if a flash key exists
     *
     * @param string $key
     * @return bool
     */
    public function hasFlash(string $key) : bool{
        return Session::base()->has(self::FLASH_KEY, $key);
    }

    /**
     * if $key exists, returns $inline_message or default message set 
     *
     * @param string $key flash key
     * @return string
     */    
    public function flash($key, $inline_message = '') : string {

        if(Session::base()->has(self::FLASH_KEY, $key)){
            if(func_num_args() < 2) {
                $value = Session::base()->value(self::FLASH_KEY, $key);
                $value = (array) $value;
                return $value['value'] ?? '' ; 
            }
            return $inline_message;
        }
        
        return '';
    }

    public static function flashes() : array{
        if(Session::base()->has(self::FLASH_KEY)){
            $flashes = Session::base()->value(self::FLASH_KEY);
            $notices = [];
            foreach($flashes as $flashkey => $message){
                $notices[$flashkey] = $message['value'] ?? '';
            }
            return $notices;
        }   
        return [];     
    }

    public function __destruct()
    { 
        $flashNotices = Session::base()->value(self::FLASH_KEY);
        
        $flashNotices = is_array($flashNotices)? $flashNotices : [];

        foreach ($flashNotices as $key => &$flashNotice) {
            
            if($flashNotice['remove']){
                unset($flashNotices[$key]);
            }            
        }

        Session::base()->save(self::FLASH_KEY, $flashNotices);
       
        if(!$flashNotices) {
            Session::base()->remove(self::FLASH_KEY);            
        }
    }

}