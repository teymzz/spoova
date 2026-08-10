<?php

namespace spoova\mi\core\classes;

use Closure;

/**
 * This class is used for creating anonymous functions
 */
class Anonymous {

    private static array $functions = [];
    private static string $lastID = '';

    /**
     * Creates the instance of anonymous function class.
     *
     * @param Closure $function anonymous function
     * @param string|null &$id id of generated function
     * @param Anonymous|null &$instance id of generated function
     * @return string resource id
     */
    static function fn(Closure $function, string|null &$id = '', Anonymous|null &$instance = null) : string|Anonymous {
        $instance = new Anonymous;
        $id = self::setFunction($function);
        self::$lastID = $id;
        return new Anonymous;
    }

    /**
     * Invokes and initializes the closure function defined
     *
     * @param string $id id of the function to invoke
     * @param array|string $args arguments to pass to the closure function
     * @return mixed 
     *   - returns the result of the closure function if found
     *   - returns null if the function is not found or if the id is null
     */
    static function invoke(string|null $id, array|string $args = []) : mixed {
        if($id === null) return null;
        $function = self::$functions[$id] ?? null;
        if(is_string($args)) $args = [$args];
        if($function) return $function(...$args);
        return null;
    }

    private static function setFunction(Closure $function) : string {
        self::$functions[$id = uniqid()] = $function;
        return $id;
    }

    /**
     * Load an anonymous function
     *
     * @param string|null $id id of the function to load
     * @return Closure|null
     */
    function __invoke(string $id)
    {
        return self::$functions[$id] ?? null;
    }

    function __toString()
    {
        return self::$lastID;
    }

}

/**
 * Resolves the {@see Anonymous::class}
 *
 * @param string $id oreviously auto generated anonymous id
 * @return Closure|null
 */
function Anonymous(string|null $id) : Closure|null {
    return (new Anonymous())($id);
}