<?php 

namespace spoova\mi\core\classes\Forms\Traits;

use Closure;
use Form;
use spoova\mi\core\classes\ContainerFunction;
use spoova\mi\core\classes\Request;

trait FormTrait {

    /**
     * This method is used to run a callback function 
     * if the forwarded form request method is post
     * 
     * @param String|Closure $open 
     *  - When set as string, it is assumed to be a key which must 
     *    exist in csrf validated request data before the callback $call is triggered. 
     *  - When set as array, values are assumed to be all keys that must 
     *    exist in csrf validated request data before the callback $call is triggered.
     *  - When set as Closure, it is assumed to be the callback called when a post request is sent.
     * 
     * @param Closure $call A callback to be called if $open is string
     * 
     * @return false|mixed
     *  - This will always return the data type returned by the callback or a false value.
     */
    public static function onpost(string|array|Closure $open, ?Closure $call = null) {

        $Request = new Request;

        if($Request->isPost()){

            if(func_num_args() == 1 && ($open instanceof Closure)) {
                return ContainerFunction::resolve($open);
            }elseif(func_num_args() == 2 && ($call instanceof Closure)){

                if(is_string($open)) {
                    
                    $postkeys = explode('|', $open);
                    foreach($postkeys as $postkey){
                        if($Request->has($postkey)){
                            return ContainerFunction::resolve($call, [$postkey]);
                        }                
                    }
                    
                }elseif(is_array($open)){

                    $matches = false;

                    foreach($open as $datakey){

                        $matches = $Request->has($datakey);

                        if(!$matches) break;

                    }

                    if($matches){
                        $call($open);
                    }

                }

            }

        }

        return false;
        
    }

    /**
     * Returns a value from unmapped form data key if the supplied key exists. 
     *
     * @param string $key form's mapped request data key.
     * 
     * @return array|string|false
     *  - Array is returned if the value of $key is array or no argument is supplied, thereby returning all form request data 
     *  - String is returned if the value of $key is string
     *  - FALSE is returned if the data key does not exist
     */
    public static function request(?string $key = null) : array|string|false {
        $requestData = (new Request())->data();
        if(func_num_args() === 0) return $requestData;
        return $requestData[$key] ?? false;
    }

    /**
     * Returns user data to be used for initializing a 
     * user session usually defined through the {@see Form::authBind()} method.
     * 
     * @param bool $bindData TRUE includes {@see Form::authBind()} data keys along with user id
     *
     * @return array
     */
    public static function account(bool $bindData = false) : array {
        if(!$bindData) return ['userid' => Form::dataid()];
        $authData = Form::authData();
        $authData['userid'] = Form::dataid(); 
        return $authData;
    }

    /**
     * Syntactic sugar for {@see Form::isAuthenticated()} method
     *
     * @return boolean
     */
    public static function isCertified(): bool {
        return Form::isAuthenticated();
    }
    
}