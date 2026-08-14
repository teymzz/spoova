<?php

namespace spoova\mi\core\classes;

use Redis;
use SessionHandlerInterface;
use SessionUpdateTimestampHandlerInterface;
use Throwable;

/**
 * Keeps sessions in Redis.
 *
 * Registered through {@see \Session::attachHandler()} before the session is opened,
 * so everything above it is unchanged: $_SESSION behaves exactly as it always did,
 * and Session::save(), User::login(), User::logout() and the rest keep working
 * without knowing where the data went. Storage is a deployment decision, not
 * something application code should have to be written against.
 *
 * Redis is the one store that is genuinely faster than the filesystem — it is in
 * memory, and its native key expiry matches session lifetime exactly, so expired
 * sessions cost nothing to collect.
 *
 * The redis extension is not a dependency of the framework. Without it this class
 * is never constructed and the session falls back to file storage.
 *
 * Connection details are read from the init file:
 *
 *   REDIS_HOST     : 127.0.0.1;
 *   REDIS_PORT     : 6379;
 *   REDIS_PASSWORD : secret;
 *   REDIS_DATABASE : 0;
 *   REDIS_PREFIX   : spoova:session:;
 *
 * @author Akinola Saheed <akinolasaheed001@gmail.com>
 */
class RedisSessionHandler implements SessionHandlerInterface, SessionUpdateTimestampHandlerInterface {

    /**
     * Key prefix, so session keys never collide with anything else in the database.
     *
     * @var string
     */
    public static string $prefix = 'spoova:session:';

    private ?Redis $redis = null;

    /**
     * Whether the redis extension is present and a connection was established.
     *
     * @return bool
     */
    public static function available() : bool {

        return extension_loaded('redis') && class_exists(Redis::class);

    }

    public function __construct()
    {
        if(!self::available()) return;

        try{

            $redis = new Redis();

            $connected = $redis->connect(
                self::config('REDIS_HOST', '127.0.0.1'),
                (int) self::config('REDIS_PORT', '6379'),
                2.0 // seconds; a session store that cannot be reached quickly is no use
            );

            if(!$connected) return;

            if(($password = self::config('REDIS_PASSWORD', '')) !== ''){
                $redis->auth($password);
            }

            if(($database = self::config('REDIS_DATABASE', '')) !== ''){
                $redis->select((int) $database);
            }

            if(($prefix = self::config('REDIS_PREFIX', '')) !== ''){
                self::$prefix = $prefix;
            }

            $this->redis = $redis;

        }catch(Throwable){
            // unreachable or refused — left null so every call falls through harmlessly
            $this->redis = null;
        }

    }

    /* ----------------------------------------------------------------- *
     *  Lifecycle                                                         *
     * ----------------------------------------------------------------- */

    public function open(string $path, string $name): bool
    {
        return $this->redis !== null;
    }

    public function close(): bool
    {
        try{
            if($this->redis !== null) $this->redis->close();
        }catch(Throwable){
            // closing a connection that has already gone is not a failure
        }

        return true;
    }

    /**
     * @param string $id
     * @return string|false
     */
    public function read(string $id): string|false
    {
        if($this->redis === null) return '';

        try{
            $data = $this->redis->get($this->key($id));
        }catch(Throwable){
            return '';
        }

        // an absent session is an empty one, never a failure — PHP starts a fresh session
        return is_string($data)? $data : '';
    }

    /**
     * Write a session, letting Redis expire it rather than tracking expiry by hand.
     *
     * @param string $id
     * @param string $data
     * @return bool
     */
    public function write(string $id, string $data): bool
    {
        if($this->redis === null) return false;

        try{
            return (bool) $this->redis->setex($this->key($id), $this->lifetime(), $data);
        }catch(Throwable){
            return false;
        }
    }

    /**
     * Push the expiry forward without rewriting the payload.
     *
     * PHP calls this instead of write() when a request read the session but changed
     * nothing, which is most of them.
     *
     * @param string $id
     * @param string $data
     * @return bool
     */
    public function updateTimestamp(string $id, string $data): bool
    {
        if($this->redis === null) return false;

        try{
            return (bool) $this->redis->expire($this->key($id), $this->lifetime());
        }catch(Throwable){
            return false;
        }
    }

    /**
     * Whether a session id exists.
     *
     * With session.use_strict_mode on, PHP asks this before adopting an id. Answering
     * it honestly is what stops an id the server never issued from being accepted, so
     * it must never return a blind TRUE.
     *
     * @param string $id
     * @return bool
     */
    public function validateId(string $id): bool
    {
        if($this->redis === null) return false;

        try{
            return (bool) $this->redis->exists($this->key($id));
        }catch(Throwable){
            return false;
        }
    }

    public function destroy(string $id): bool
    {
        if($this->redis === null) return true;

        try{
            $this->redis->del($this->key($id));
        }catch(Throwable){
            return false;
        }

        return true;
    }

    /**
     * Redis expires keys itself, so there is nothing to collect.
     *
     * @param int $max_lifetime
     * @return int|false
     */
    public function gc(int $max_lifetime): int|false
    {
        return 0;
    }

    /* ----------------------------------------------------------------- *
     *  Internals                                                         *
     * ----------------------------------------------------------------- */

    /**
     * Namespaced key for a session id.
     *
     * @param string $id
     * @return string
     */
    private function key(string $id) : string {

        return self::$prefix.$id;

    }

    /**
     * Session lifetime in seconds, taken from PHP's own setting so the store and the
     * cookie agree on when a session has ended.
     *
     * @return int
     */
    private function lifetime() : int {

        return (int) (ini_get('session.gc_maxlifetime') ?: 1440);

    }

    /**
     * Read a connection setting, preferring the init file and falling back to the
     * environment for projects that keep such values in a .env instead.
     *
     * @param string $key
     * @param string $default
     * @return string
     */
    private static function config(string $key, string $default) : string {

        if(defined('_icore') && class_exists(Init::class)){
            $value = (string) (Init::key($key) ?: '');
            if(trim($value) !== '') return trim($value);
        }

        $value = (string) (getenv($key) ?: ($_ENV[$key] ?? $_SERVER[$key] ?? ''));

        return trim($value) !== ''? trim($value) : $default;

    }

}
