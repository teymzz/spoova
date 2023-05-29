<?php 

namespace spoova\mi\core\classes;

use ReflectionMethod;

class ContainerClass {

    private static $class;
    private static $order = 'dependencies';
    private array $args = [];

    function __construct($method, mixed $arguments)
    {

        $args = [];

        if(method_exists(self::$class, $method)){
            $Reflection = new ReflectionMethod(self::$class, $method);
            $parameters = ($Reflection->getParameters());

            $count = 0;

            if(self::$order === 'dependencies'){

                $args1 = [];

                foreach($parameters as $key => $parameter) {

                        $dependenceClass = (string) $parameter->getType();

                        if($dependenceClass && !in_array($dependenceClass, ['bool','float','int','string', 'mixed'])){ 
                            //add class
                            $args1[] = new $dependenceClass();
                        }

                }

                $args = array_merge($args1, $arguments);

            } else {

                foreach($parameters as $key => $parameter) {

                        $dependenceClass = (string) $parameter->getType();

                        if($dependenceClass){ 
                            //add class
                            $args[] = new $dependenceClass();
                        }else{
                            if(isset($arguments[$count])) {
                                //add other arguments based on position
                                $args[] = $arguments[$count];
                                $count++; 
                            }    
                        }

                }
                
                //overwrite parameter with arguments
                foreach($arguments as $key => $argument) {
                    $args[$key] = $argument;
                }

            }

        }

        $this->args = $args; // array_merge($args, $arguments);
        
    }

    /**
     * Set argument priority order
     *
     * @param string $order optional [dpendencies|arguments]
     * @return void
     */
    static function setOrder(string $order = 'dependencies'){
        $orders = ['dependencies', 'arguments'];

        if(in_array($order, $orders)) {
            self::$order = $order;
        }
    }

    static function setClass($class) {
        self::$class = $class;
    }

    static function getClass() : object {
        return self::$class;
    }

    /**
     * Returns true if a class name which is not an empty string has been set
     *
     * @return boolean
     */
    static function defined() : bool {
        $class = isset(self::$class)? self::$class : '';

        if(is_object($class)){ return true; }
        return (!empty(trim($class)));
    }

    function args() : array {
        return $this->args;
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


}