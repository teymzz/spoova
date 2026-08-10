<?php 

namespace spoova\mi\core\classes\Fabricator;


abstract class FabricatorAbstract implements FabricatorInterface {

    protected static array $fabrics = [];

    protected static int $count = 0;
    
    abstract public static function reset();

    public static function plus(){
        static::$count++;
    }

    public static function count(int $i){
        static::$count = $i;
    }

    /**
     * Save Fabricator class
     *
     * @return void
     */
    protected static function save(string $class){
        
        if(!in_array($class, self::$fabrics)){
            self::$fabrics[] = $class;
        }
  
    }

}