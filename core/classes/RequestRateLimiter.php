<?php

namespace spoova\mi\core\classes;

use Closure;

/**
 * Limits how often a caller may reach a route.
 *
 * Each caller gets a bucket holding the timestamps of its recent hits. A hit is
 * allowed while fewer than the permitted number of timestamps fall inside the
 * window, and the window slides with the clock rather than resetting on a fixed
 * boundary — so a caller cannot spend a whole allowance at the end of one window
 * and the whole of the next one a moment later, which is what a fixed window
 * lets through.
 *
 * Buckets live on disk so the count survives between requests, and are keyed by
 * the caller's identity and the scope being limited:
 *
 *   $limiter = new RequestRateLimiter(60, 60);       // 60 hits a minute
 *
 *   if(!$limiter->scope('login')->attempt()){
 *      Response::code(429);
 *      exit;
 *   }
 *
 * Nothing here writes a response or ends the request. What to do with a refusal
 * belongs to the caller — a middleware, typically — so that the same limiter can
 * answer with a 429, a redirect or a queued job as the route requires.
 *
 * @author Akinola Saheed <akinolasaheed001@gmail.com>
 */
class RequestRateLimiter {

    /**
     * Directory holding the buckets, relative to the project root.
     *
     * It sits under core/storage because the contents are disposable: losing them
     * forgives outstanding limits, which is the safe direction to fail in.
     *
     * @var string
     */
    public static string $storeDir = 'core/storage/ratelimit';

    /**
     * Hits permitted inside one window.
     *
     * @var int
     */
    private int $limit;

    /**
     * Length of the window, in seconds.
     *
     * @var int
     */
    private int $window;

    /**
     * Name of what is being limited, so one caller can hold separate allowances
     * for separate routes.
     *
     * @var string
     */
    private string $scope = 'global';

    /**
     * Identity of the caller. Resolved from the client IP unless it is set.
     *
     * @var string|null
     */
    private ?string $identity = null;

    /**
     * Timestamps left in the bucket after the last read.
     *
     * @var array<int,float>
     */
    private array $hits = [];

    /**
     * Whether the last call to {@see RequestRateLimiter::attempt()} was allowed.
     *
     * @var bool
     */
    private bool $allowed = true;

    /**
     * Whether the bucket has been read off disk yet for this instance.
     *
     * @var bool
     */
    private bool $loaded = false;

    /**
     * @param int $limit hits permitted inside one window. Values below 1 are read as 1.
     * @param int $window length of the window in seconds. Values below 1 are read as 1.
     */
    public function __construct(int $limit = 60, int $window = 60)
    {
        $this->limit  = max(1, $limit);
        $this->window = max(1, $window);
    }

    /* --------------------------------------------------------------------- *
     *  Configuration                                                         *
     * --------------------------------------------------------------------- */

    /**
     * Name what is being limited.
     *
     * Two scopes never share an allowance, so a caller throttled out of one route
     * can still reach another.
     *
     * @param string $scope
     * @return static
     */
    public function scope(string $scope) : static {

        $scope = trim($scope);

        $this->scope = ($scope === '')? 'global' : $scope;

        return $this;

    }

    /**
     * Limit somebody other than the current client — a user id or an API key,
     * where a signed-in caller should be counted rather than their address.
     *
     * @param string $identity
     * @return static
     */
    public function identify(string $identity) : static {

        $identity = trim($identity);

        $this->identity = ($identity === '')? null : $identity;

        return $this;

    }

    /* --------------------------------------------------------------------- *
     *  Asking                                                                *
     * --------------------------------------------------------------------- */

    /**
     * Record a hit and report whether it is permitted.
     *
     * A refused hit is not recorded, so hammering a limit that has already been
     * reached cannot push its expiry further away.
     *
     * @return bool TRUE when the caller may proceed
     */
    public function attempt() : bool {

        $now = microtime(true);

        $directory = $this->directory();

        if(!is_dir($directory) && !@mkdir($directory, 0755, true) && !is_dir($directory)){
            // nowhere to count — let the caller through rather than refuse everybody
            return $this->allowed = true;
        }

        /* Counting has to be one atomic step. Reading, deciding and writing as three
           separate operations lets two simultaneous requests both read the same count
           and both write a hit over it, so a limit of one admits two. The bucket is
           therefore held under an exclusive lock across the whole read-modify-write. */
        $handle = @fopen($this->bucketPath(), 'c+');

        if($handle === false) return $this->allowed = true;

        try{

            if(!flock($handle, LOCK_EX)) return $this->allowed = true;

            $hits = json_decode((string) stream_get_contents($handle), true);

            // an unreadable bucket forgives the caller rather than locking them out
            $hits = is_array($hits)? $hits : [];

            $hits = $this->fresh($hits, $now);

            $this->loaded = true;

            if(count($hits) >= $this->limit){
                $this->hits = $hits;
                return $this->allowed = false;
            }

            $hits[] = $now;

            ftruncate($handle, 0);
            rewind($handle);
            fwrite($handle, (string) json_encode($hits));
            fflush($handle);

            $this->hits = $hits;

            return $this->allowed = true;

        }finally{
            flock($handle, LOCK_UN);
            fclose($handle);
        }

    }

    /**
     * Report whether the caller is within the limit without recording a hit.
     *
     * @return bool
     */
    public function permitted() : bool {

        return count($this->read(microtime(true))) < $this->limit;

    }

    /**
     * Hits still available inside the current window.
     *
     * @return int
     */
    public function remaining() : int {

        return max(0, $this->limit - count($this->read(microtime(true))));

    }

    /**
     * Whole seconds until the caller may try again.
     *
     * Measured from the oldest hit still inside the window, since that is the one
     * whose expiry frees a slot. Zero when there is room already.
     *
     * @return int
     */
    public function retryAfter() : int {

        $hits = $this->read($now = microtime(true));

        if(count($hits) < $this->limit) return 0;

        return max(1, (int) ceil(($hits[0] + $this->window) - $now));

    }

    /**
     * Headers describing the caller's standing, for a response to carry.
     *
     * Retry-After is only present on a refusal, which is where it has meaning.
     *
     * @return array<string,string>
     */
    public function headers() : array {

        $headers = [
            'X-RateLimit-Limit'     => (string) $this->limit,
            'X-RateLimit-Remaining' => (string) $this->remaining(),
        ];

        if(($retry = $this->retryAfter()) > 0){
            $headers['Retry-After'] = (string) $retry;
        }

        return $headers;

    }

    /**
     * Forget the caller's hits for the current scope, restoring a full allowance.
     *
     * Intended for the successful end of an attempt-limited action — a login that
     * finally succeeds should not leave its failures counting against the caller.
     *
     * @return bool
     */
    public function forget() : bool {

        $this->hits    = [];
        $this->loaded  = true;
        $this->allowed = true;

        $file = $this->bucketPath();

        return is_file($file)? @unlink($file) : true;

    }

    /* --------------------------------------------------------------------- *
     *  Reading a bucket                                                      *
     * --------------------------------------------------------------------- */

    /**
     * The caller's timestamps, with those that have aged out dropped.
     *
     * The bucket is read from disk once per instance. Only this instance can change
     * it afterwards, so later calls prune what is already in hand rather than going
     * back to the filesystem — remaining(), retryAfter() and headers() are commonly
     * called together right after an attempt.
     *
     * @param float $now
     * @return array<int,float> remaining timestamps, oldest first
     */
    private function read(float $now) : array {

        if(!$this->loaded){
            $this->hits   = $this->load();
            $this->loaded = true;
        }

        return $this->hits = $this->fresh($this->hits, $now);

    }

    /**
     * Drop the timestamps that have fallen out of the window, oldest first.
     *
     * @param array $hits
     * @param float $now
     * @return array<int,float>
     */
    private function fresh(array $hits, float $now) : array {

        $cutoff = $now - $this->window;

        $hits = array_values(array_filter($hits, static fn($time) => is_numeric($time) && $time > $cutoff));

        sort($hits);

        return $hits;

    }

    /**
     * Read the caller's bucket off disk.
     *
     * @return array<int,float>
     */
    private function load() : array {

        $file = $this->bucketPath();

        if(!is_file($file)) return [];

        $raw = @file_get_contents($file);

        if($raw === false || $raw === '') return [];

        $hits = json_decode($raw, true);

        // an unreadable bucket forgives the caller rather than locking them out
        return is_array($hits)? $hits : [];

    }

    /* --------------------------------------------------------------------- *
     *  Paths and identity                                                    *
     * --------------------------------------------------------------------- */

    /**
     * Absolute path of the directory holding the buckets.
     *
     * @return string
     */
    public function directory() : string {

        return rtrim(docroot, '\\/').DIRECTORY_SEPARATOR.to_dirslash(trim(self::$storeDir, '\\/'));

    }

    /**
     * Absolute path of the bucket belonging to the current caller and scope.
     *
     * The name is a hash so that an address, a user id or an API key never reaches
     * the filesystem as itself.
     *
     * @return string
     */
    private function bucketPath() : string {

        $key = sha1($this->identity().'|'.$this->scope);

        return $this->directory().DIRECTORY_SEPARATOR.$key.'.json';

    }

    /**
     * Identity being limited — whatever {@see RequestRateLimiter::identify()} was
     * given, or the client address.
     *
     * An address that cannot be resolved falls back to a fixed string, which counts
     * every such caller together. That is deliberate: sharing one allowance is
     * safer than handing out an unlimited one.
     *
     * @return string
     */
    public function identity() : string {

        if($this->identity !== null) return $this->identity;

        $ip = (new IPHandler)->clientIP();

        return (is_string($ip) && $ip !== '')? $ip : 'unknown';

    }

    /* --------------------------------------------------------------------- *
     *  Middleware                                                            *
     * --------------------------------------------------------------------- */

    /**
     * Build a limiter as a shutter middleware, for a route to hand to ONCALL:
     *
     *   self::call($this, [
     *       window('login') => 'login',
     *       'ONCALL' => RequestRateLimiter::guard(5, 60),
     *   ]);
     *
     * A permitted caller passes straight through with the rate headers attached.
     * A refused one is answered with 429 and the request ends there, because ONCALL
     * discards whatever it returns — returning FALSE would not stop the route method
     * from running, so the middleware has to close the request itself.
     *
     * Supplying $onRefusal takes that decision back: the callback is handed the
     * limiter, nothing is sent, and the request continues unless the callback ends it.
     * That is the seam for answering with a redirect, a queued job or a custom body.
     *
     *   'ONCALL' => RequestRateLimiter::guard(5, 60, 'login', function($limiter){
     *        redirect('too-busy');
     *   }),
     *
     * @param int $limit hits permitted inside one window
     * @param int $window length of the window in seconds
     * @param string $scope what is being limited. Defaults to the request path, so
     *   each route carries its own allowance without being named.
     * @param Closure|null $onRefusal called instead of the default 429 response
     * @return Closure
     */
    public static function guard(int $limit = 60, int $window = 60, string $scope = '', ?Closure $onRefusal = null) : Closure {

        return static function() use($limit, $window, $scope, $onRefusal) {

            /* Route scanning walks every shutter to build the route map. Counting a
               hit there would spend a real caller's allowance against a CLI command,
               and refusing one would end the scan — so the guard stands aside. */
            if(RouteInspector::capturing()) return true;

            $limiter = new static($limit, $window);
            $limiter->scope($scope !== ''? $scope : self::requestPath());

            if($limiter->attempt()){
                $limiter->sendHeaders();
                return true;
            }

            if($onRefusal instanceof Closure){
                $onRefusal($limiter);
                return false;
            }

            $limiter->refuse();

        };

    }

    /**
     * Send the rate headers, when there is still a chance to.
     *
     * @return void
     */
    public function sendHeaders() : void {

        if(headers_sent()) return;

        foreach($this->headers() as $name => $value){
            header($name.': '.$value, true);
        }

    }

    /**
     * Answer a refused caller with 429 and end the request.
     *
     * The body follows what the caller asked for: a request that wants JSON is
     * answered with JSON so a fetch() sees a parseable error rather than prose.
     *
     * @return never
     */
    public function refuse() : never {

        $retry = $this->retryAfter();

        $this->sendHeaders();

        if(!headers_sent()) http_response_code(429);

        if(self::wantsJson()){
            if(!headers_sent()) header('Content-Type: application/json', true);
            echo json_encode([
                'status'  => 429,
                'message' => 'Too many requests',
                'retry'   => $retry,
            ]);
        }else{
            if(!headers_sent()) header('Content-Type: text/plain; charset=utf-8', true);
            echo 'Too many requests. Try again in '.$retry.' second'.($retry === 1? '' : 's').'.';
        }

        exit;

    }

    /**
     * Path of the current request, used as the default scope so that each route
     * carries its own allowance. The query string is left out, or every distinct
     * set of parameters would be limited separately.
     *
     * @return string
     */
    private static function requestPath() : string {

        $uri = (string) ($_SERVER['REQUEST_URI'] ?? '');

        $path = trim((string) parse_url($uri, PHP_URL_PATH), '/');

        return ($path === '')? 'global' : $path;

    }

    /**
     * Whether the caller is expecting JSON back.
     *
     * @return bool
     */
    private static function wantsJson() : bool {

        $accept = strtolower((string) ($_SERVER['HTTP_ACCEPT'] ?? ''));
        $with   = strtolower((string) ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? ''));

        return str_contains($accept, 'application/json')
            || str_contains($accept, '+json')
            || $with === 'xmlhttprequest';

    }

    /* --------------------------------------------------------------------- *
     *  Housekeeping                                                          *
     * --------------------------------------------------------------------- */

    /**
     * Delete buckets whose every timestamp has aged out.
     *
     * Nothing calls this during a request — a bucket costs a few bytes and is
     * rewritten on its owner's next hit. It exists for a scheduled sweep of a
     * project whose callers do not come back.
     *
     * @param int $window seconds a bucket may sit untouched before it is dropped
     * @return int number of buckets removed
     */
    public static function prune(int $window = 3600) : int {

        $limiter   = new static();
        $directory = $limiter->directory();

        if(!is_dir($directory)) return 0;

        $cutoff  = time() - max(1, $window);
        $removed = 0;

        foreach(glob($directory.DIRECTORY_SEPARATOR.'*.json') ?: [] as $bucket){
            if(@filemtime($bucket) < $cutoff && @unlink($bucket)) $removed++;
        }

        return $removed;

    }

}
