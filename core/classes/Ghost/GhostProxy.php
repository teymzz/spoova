<?php 

namespace spoova\mi\core\classes\Ghost;

use Closure;
use Exception;

/**
 * This is the main container class for GhostFunction class.
 */
class GhostProxy {

    private static ?object $object = null;

    /** @var int|float|string|bool|null channel id */
    private static int|float|string|bool|null $id = null;

    private static ?GhostProxy $proxy = null;

    /** @var int|float|string|null proxy id */
    private static ?string $proxy_id = null;
    
    /**
     * Set handler channels for GhostProxies
     *
     * @var GhostFunction[]
     */
    private static ?array $handler = [];
    private static ?array $channel = [];

    private function __construct()
    {
        self::$proxy  = $this;
    }
    private static function proxy(bool $new = false)
    {
        if(!isset(self::$proxy) || $new) self::$proxy = new self();
        return self::$proxy;
    }

    /**
     * Generates a dynamic proxy object with a GhostFunction object as its ghost property. 
     * The GhostFunction object is generated from the supplied arguments and is accessible 
     * via the ghost property of the returned proxy object.
     *   - Every generated proxy object must be immediately retrieved using {@see GhostProxy::object()} method to be useful.
     *   - The $map callback is used to map the generated proxy object to a user defined class or object and is supplied with the generated 
     *     proxy object and its unique id as arguments.
     * @param array|GhostFunction $arguments
     * @param Closure $map
     * @return object|false
     */
    static function new(array|GhostFunction $arguments, Closure $map) : object|false {
        $proxy = self::proxy(true);
        $id = spl_object_id($proxy);
        
        if(is_array($arguments)){
            $props = [];
            $props[] = 'ghost';
            foreach($arguments as $key => $val){
                $props[] = [$key => $val];
            }
            $Ghost = new GhostFunction($props, 'GhostProxy');
            
            $Ghost2 = new GhostFunction(['ghost','id']);
            $Ghost2->ghost(fn() => $Ghost);
            $Ghost = $Ghost2;
            
        }else{
            $Ghost = new GhostFunction(['ghost','id']);
            $Ghost->ghost(fn() => $arguments);
        }

        $Ghost->id(fn() => $id); // return ghost id

        // create a light anonymous proxy closure 
        $proxy = function(GhostFunction $Ghost) : GhostDraft {
            return new class($Ghost) extends GhostDraft {
                public function __construct(private GhostFunction $Ghost){}
                function id() : int {
                    return $this->Ghost->id();
                }
                function ghost() : GhostFunction {
                    return $this->Ghost->ghost();
                }
            };
        };

        self::$channel[$id] = self::$handler;
        self::$object = $map($proxy($Ghost), $id);
        self::$handler = [];
        return self::$object ?? false;
    }

    /**
     * Returns previously mapped GhostFibre object
     *
     * @return object|false 
     *   - FALSE if last mapping fails else returns mapped Object
     */
    static function object() : object|false {
        return self::$object ?? false;
    }
    
    /**
     * Sets a callback function for processing
     * 
     * @param string $id unique id for callback function
     * @param Closure $callback a callback function
     * @return void
     */
    static function channel(string|int $id, Closure $callback) : void {
        if(array_key_exists($id, self::$handler)){
            throw new Exception('cannot override an existing push id before GhostProxy::new()');
        }
        self::$handler[$id] = $callback;
    }

    /**
     * Retrieves and executes a previously defined callback function
     *
     * @param string $id unique storage id by which a previously stored callback is retrieved.
     * @param array $arguments array list of arguments if supplied
     * @return mixed value returned depends on the returned value of the callback executed.
     */
    static function route(string|int $id, array $arguments = []) {
        return self::$handler[$id](...$arguments);
    }

    /**
     * pulls a value from a property
     *
     * @param string $id unique storage id by which a previously stored callback is retrieved and executed to return a value.
     * @param Closure|null $callback a callback function that returns the value to be pulled
     * @return GhostFunction|false 
     *  - FALSE if no callback is supplied, else callback must return GhostFunction object
     */
    static function map(string $id, ?Closure $callback = null) : GhostFunction|False {
        self::$proxy_id = $id;
        self::$handler = self::$channel[self::$proxy_id];
        if($callback){
            return $callback();
        }
        return false;
    }

    /**
     * Return current GhostProxy id
     *
     * @return int|null
     */
    static function proxy_id() : int|null {
        return self::$proxy_id;
    }

    /**
     * Sets an id for proxy channel activity
     *  - This is required for {@see GhostProxy::push()} and {@see GhostProxy::pull()}
     * @param integer|float|string|boolean $name
     * @return GhostProxy
     */
    static function id(int|float|string|bool|null $name = null) : GhostProxy {
        self::$id = $name;
        return self::proxy();
    }
 
}