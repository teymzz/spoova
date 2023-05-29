<?php 

namespace spoova\mi\core\classes;

use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;

class Container { 

    private static $class;


    /**
     * Initialize a class with container class object
     *
     * @param object|string $class
     * @param array $arguments defined class constructor arguments
     */
    function __construct(object|string &$class, $arguments = [])
    {

        //set class first ...
        ContainerClass::setClass($class);

        if(is_string($class))  {

            
            if(ContainerClass::defined()) {
                $Class = new ContainerClass(__FUNCTION__, $arguments);
                $args = $Class->args();

                $class = new $class(...$args);
                ContainerClass::setClass($class);  
                return $class;
            } else {
                //trigger error ...
            }
        }
        
    }

    function __call($method, $arguments) {

        //prevent fake calls ...
        if(ContainerClass::defined()){
            $class = ContainerClass::getClass();
            $Class = new ContainerClass($method, $arguments);
            $args = $Class->args();
            return $class->$method(...$args);
        }

    }

    static function __callStatic($method, $arguments) {
        
        if(ContainerClass::defined()){
            $class = ContainerClass::getClass();
            $Class = new ContainerClass($method, $arguments);
            $args = $Class->args();
            return $class->$method(...$args);
        }

    }

    // private static function getArgs($method, $arguments) : array {

        
    //     $args = [];
    //     print "<pre>";

    //     if(method_exists(self::$class, $method)){
    //         $Reflection = new ReflectionMethod(self::$class, $method);
    //         $parameters = ($Reflection->getParameters());

    //         $count = 0;
            
    //         foreach($parameters as $key => $parameter) {

    //             // if(isset($arguments[$key])){
    //             //     $args[$key] = $arguments[$key];
    //             // }else {
    //                 $dependenceClass = (string) $parameter->getType();
    //                 //$args[$count] = $arguments[$count] ?? '';
                    
    //                 if($dependenceClass){ 
    //                     $args[] = new $dependenceClass();
    //                 }else{          
    //                     $args[] = $arguments[$count] ?? '';
    //                     $count++; 
    //                 }
    //                 // if(isset($arguments[$count])) unset($arguments[$count]);
    //             // }

    //         }

    //     }

    //     return $args; // array_merge($args, $arguments);
    // }

    public function getClass(){
        $class = self::$class;
        return $class;
    }

}