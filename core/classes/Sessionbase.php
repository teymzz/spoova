<?php 

namespace spoova\mi\core\classes;

use Session;
use stdClass;

class Sessionbase {
    
    const KEY = ':base:';

    function remove(string|bool $key, string $subkey = '') : bool{
        
        if($key === true){
            Session::remove(SELF::KEY);
            return Session::has(SELF::KEY);
        }

        if(Session::has(SELF::KEY)){

            $base = Session::value(SELF::KEY);

            if(func_num_args() === 1){
                
               if(isset($base[$key])) unset($base[$key]);

               if(!empty($base)){
                Session::save(SELF::KEY, $base);
               }else{
                Session::remove(SELF::KEY);
               }
               return true;

            }else{

               if(array_key_exists($key, $base) && is_array($base[$key])) {

                    if(array_key_exists($subkey, $base[$key])){
                        unset($base[$key][$subkey]);
                        Session::save(SELF::KEY, $base); 
                        return true;
                    }

               } 

            }

        }

        return false;

    }

    function save($key, $value) {

        $session = Session::value(SELF::KEY);
        
        $session = is_array($session)? $session : [];

        $session[$key] = $value;

        Session::save(SELF::KEY, $session);

    }

    
    public static function overwrite(array $value){
        if(Session::has(SELF::KEY)){
         Session::save(SELF::KEY, $value);
        }
    }


  /**
   * Return true if the session storage base contains a particular root key or a root key's direct subkey
   *
   * @param string $key a session key to be checked. 
   * @param string $subkey a subkey of session key (i.e $key) to be checked. 
   * @return boolean
   */
  public static function has(string $key, string $value = '') : bool{

    $storage = Session::value(SELF::KEY) ?: [];

    if(func_num_args() === 1) return array_key_exists($key, $storage);
    
    return array_key_exists($key, $storage) && is_array($storage[$key]) && array_key_exists($value, $storage[$key]);
    
  }


    /**
     * Returns the value in which a session contains in the application environment
     *
     * @param string $key defines a specific key in session whose value is to be returned 
     *  - If not supplied, this will return the entire value in the session environment.
     * @return mixed
     */
    public static function value(string $key = '', string $subkey = ''){

        if(func_num_args() === 0) return Session::value(SELF::KEY);

        if(func_num_args() === 1) return Session::value(SELF::KEY, $key);

        $base = Session::value(SELF::KEY, $key);

        if(is_array($base) && array_key_exists($subkey, $base)){
            return $base[$subkey];
        }

        return '';

    }

    /**
     * Returns the value of the current session base value as a stdClass object
     *
     * @return stdClass
     */
    public static function fetch() : stdClass {

        $base = Session::base()->value(); 
        $base = is_array($base)? $base : [];
        return toStdClass($base);

    }

}