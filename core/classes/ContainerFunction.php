<?php 

namespace spoova\mi\core\classes;

use Closure;
use ReflectionFunction;
use ReflectionNamedType;

class ContainerFunction { 

 public static function resolve($function, array $arguments = []){
    if($function instanceof Closure){
        $reflection = new ReflectionFunction($function);
        $parameters = $reflection->getParameters();
        $dependencies = [];
  
        foreach($parameters as $parameter){

          $type = $parameter->getType();

          // avoid built-in argument types (e.g bool, float ...) 
          if($type instanceof ReflectionNamedType){
            
            if(!$type->isBuiltin()){
              // use order: defaultValue, dependency
              $dependenceClass =  $type->getName();
              $dependencies[] = $parameter->isDefaultValueAvailable()? $parameter->getDefaultValue() : new $dependenceClass();
            }elseif($parameter->isDefaultValueAvailable()){
              $dependencies[] = $parameter->getDefaultValue(); //apply default if available
            }
          }
  
        }
        
        // apply parsed arguments after dependencies.
        $args = array_merge($dependencies, $arguments ?? []);
  
        //execute callback and return value
        return $reflection->invokeArgs($args);
      }
  
      return false;
 }

 /**
   * Supply arguments to function in serialized format 
   *
   * @param Closure $function
   * @param array $arguments argument to be supplied in series
   * @return mixed 
   */
  public static function serialized($function, array $arguments = []){
    if($function instanceof Closure){
        $reflection = new ReflectionFunction($function);
        $parameters = $reflection->getParameters();
        $dependencies = [];
        foreach($parameters as $i => $parameter){

          $type = $parameter->getType();

          if($type instanceof ReflectionNamedType){
            if(!$type->isBuiltin()){
              // avoid built-in argument types (e.g bool, float ...) 
              $dependenceClass =  $type->getName();
              // use order: argument, defaultValue, dependency 
              $dependencies[] = $arguments[$i] ?? ($parameter->isDefaultValueAvailable()? $parameter->getDefaultValue() : new $dependenceClass()) ;
              unset($arguments[$i]);
            }else{
              // use order: argument, defaultValue
              if(isset($arguments[$i])){
                $dependencies[] = $arguments[$i]; //use argument supplied
                unset($arguments[$i]);
              }elseif($parameter->isDefaultValueAvailable()){
                $dependencies[] = $parameter->getDefaultValue(); // use default value
              }
            }
          } else {
              // use order (unhinted types): argument, defaultValue
              if(isset($arguments[$i])){
                $dependencies[] = $arguments[$i]; //use argument supplied
                unset($arguments[$i]);
              }elseif($parameter->isDefaultValueAvailable()){
                $dependencies[] = $parameter->getDefaultValue(); // use default value
              }
          }

        }

        $arguments = array_values($arguments);

        $args = array_merge($dependencies, $arguments ?? []);

        //execute callback and return value
        return $reflection->invokeArgs($args);
    }

    return false;
  }

}