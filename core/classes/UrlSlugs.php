<?php 

namespace spoova\mi\core\classes;

/**
 * This class manages the slugs applied on Windows (or Route) urls.
 */
class UrlSlugs {

    protected static array $parameters = [];
    private static bool $response = false;

    final public function __construct(){}

    /**
     * Save slugs
     *
     * @param array $args
     * @return void
     */
    final static function save(array $args){
        static::$parameters = $args;
        static::$response = false;
    }

    /**
     * Return saves slugs
     *
     * @return array
     */
    final static public function parameters() : array{
        return static::$parameters;
    }

    final static public function response() : bool{
        return self::$response;
    }

    /**
     * Set slugs response and returns new instance or UrlSlugs
     *
     * @param boolean $response
     * @return UrlSlugs
     */
    final static public function responder(bool $response) : UrlSlugs {
        static::$response = $response;
        return new self;
    }

}