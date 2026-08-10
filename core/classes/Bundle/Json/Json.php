<?php

namespace spoova\mi\core\classes\Json;

use Closure;
use JsonException;

final class Json {

    /**
     * Stores the callback to run when an encode/decode error occurs
     */
    protected static ?Closure $onError = null;

    /**
     * Run this callback when error (encode or decode) occurs.
     * The callback receives the JsonException instance and its
     * return value is passed back to the caller of build()/parse().
     *
     * @param Closure $callback
     * @return void
     */
    static function onError(Closure $callback): void
    {
        static::$onError = $callback;
    }

    /**
     * Convert text to JSON format using {@see \json_encode()}
     * and returns data immediately
     *
     * @return string|false
     */
    static function build(mixed $value, int $flags = 0, int $depth = 512): string|false
    {
        try {
            return \json_encode($value, $flags | JSON_THROW_ON_ERROR, $depth);
        } catch (JsonException $e) {
            return static::$onError ? (static::$onError)($e) : false;
        }
    }

    /**
     * Convert a JSON string back to array/object data using {@see \json_decode()}
     *
     * @return mixed
     */
    static function parse(string $json, bool $associative = true, int $depth = 512, int $flags = 0): mixed
    {
        try {
            return \json_decode($json, $associative, $depth, $flags | JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return static::$onError ? (static::$onError)($e) : false;
        }
    }

    /**
     * Converts array or data supplied to JSON and print out immediately
     *
     * @return void
     */
    static function view(mixed $data, int $flags = 0, int $depth = 512): void
    {
        echo static::build($data, $flags, $depth) ?: '';
    }

    /**
     * Converts JSON string supplied to array and prints out immediately
     *
     * @return void
     */
    static function viewArray(string $json, int $depth = 512, int $flags = 0): void
    {
        print_r(static::parse($json, true, $depth, $flags));
    }

}