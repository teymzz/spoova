<?php 

namespace spoova\mi\core\classes\Bundle\IOText;

use Closure;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\classes\Ghost\GhostProxy;

/**
 * Holds per-context counters for a single IOTextStream::init()...close() block.
 * Kept as a separate state object (instead of static properties on IOTextStream)
 * so that nested or sequential streaming contexts don't clobber each other's
 * counters, while IOTextStream itself stays fully static for direct calls.
 */
final class IOTextStreamState {

    public int $steps = 0;
    public int $views = 0;
    public int $streams = 0;
    public int $timeout = 0;

    /**
     * Define the number of steps
     *
     * @param integer $steps
     */
    public function __construct(int $steps = 0) {
        $this->steps = $steps;
    }
}

/**
 * Class is designed to buffer text from API requests or existing text file.
 */
class IOTextStream {

    /**
     * Stack of active streaming contexts. The last entry is always the
     * "current" context that static calls operate against. Pushed by
     * init(), popped by close().
     *
     * @var IOTextStreamState[]
     */
    private static array $stack = [];

    /**
     * Returns the currently active state, auto-initializing a default
     * context if none has been started yet.
     *
     * @return IOTextStreamState
     */
    private static function current() : IOTextStreamState {
        if (empty(self::$stack)) {
            self::init();
        }
        return end(self::$stack);
    }

    /**
     * Initializes a new streaming context.
     *  - Sets header content-type as 'text/plain'
     *  - Sets header X-Accel-Buffering to 'no'
     *  - Applies the {@see \ob_start()} function
     *  - Pushes a fresh, independent counters state onto the context stack
     *
     * @return void
     */
    static function init(int $steps = 0) : void {
        \header('Content-Type: text/plain');
        \header('X-Accel-Buffering: no');
        while(ob_get_level()) ob_end_flush();
        ob_start();  // start a fresh controlled one

        self::$stack[] = new IOTextStreamState($steps);
    }

    /**
     * Ends the current streaming context and restores the previous one
     * (if any), so counters from an earlier init() aren't affected by
     * a nested or sequential one.
     *
     * @return void
     */
    static function close() : void {
        array_pop(self::$stack);
    }

    /**
     * Sets a default global timeout for the current context.
     *
     * @param integer $milliseconds timeout in miliseconds.
     */
    static function interval(int $milliseconds) : void {
        self::current()->timeout = $milliseconds;
    }

    /**
     * Sets the total number of steps for the current context.
     *
     * @param integer $steps
     * @return void
     */
    static function steps(int $steps) : void {
        self::current()->steps = $steps;
    }

    /**
     * Prints a simple untracked text message.
     * @param string $message
     * @param integer $timeout delay (in milliseconds) after message is displayed.
     * @return void
     */
    static function view(string $message, int $timeout = 0) : void {
        self::emit(...\func_get_args());
    }

    /**
     * Prints a simple untracked JSON message built from an array value.
     * @param array $message
     * @param integer $timeout delay (in milliseconds) after message is displayed.
     * @return void
     */
    static function json(array $message, int $timeout = 0) : void {
        $message = \json_encode($message);
        $args = \func_get_args();
        $args[0] = $message;
        self::emit(...$args);
    }

    /**
     * Ends the streaming process with a json response text
     *
     * @param array $message
     * @return never
     */
    static function issue_json(array $message) : never {
        self::json($message); exit;
    }

    /**
     * Ends the streaming process with a response text
     *
     * @param string $message
     * @return never
     */
    static function issue_text(string $message) : never {
        self::view($message); exit;
    }

    /**
     * Writes a message to the response stream and flushes it immediately.
     * All output-producing methods (view, json, stream_view, stream_json)
     * funnel through here.
     *
     * @param string $message
     * @param integer $timeout delay (in milliseconds) after message is displayed.
     * @return void
     */
    private static function emit(string $message, int $timeout = 0) : void {
        $state = self::current();

        echo $message . PHP_EOL;
        \ob_flush(); \flush();

        $timeout = \func_num_args() > 1 ? $timeout : $state->timeout;
        usleep(1000 * $timeout);

        $state->views++;
    }

    /**
     * Prints a simple tracked text message
     *
     * @param string $message message to be printed.
     * @param integer $timeout delay (in milliseconds) after message is displayed.
     * @return void
     */
    static function stream_view(string $message, int $timeout = 0) : void {
        self::stream_emit(...\func_get_args());
    }

    /**
     * Alias to {@see IOTextStream::stream_view()}
     *
     * @param string $message
     * @param integer $timeout
     * @return void
     */
    static function stream_out(string $message, int $timeout = 0){
        self::stream_view(...\func_get_args());
    }

    /**
     * Prints a simple tracked JSON message built from an array value.
     *
     * @param array $message message to be printed in JSON format.
     * @param integer $timeout delay (in milliseconds) after message is displayed.
     * @return void
     */
    static function stream_json(array $message, int $timeout = 0) : void {
        $args = \func_get_args();
        $args[0] = \json_encode($args[0]);
        self::stream_emit(...$args);
    }

    private static function stream_emit(string $message, int $timeout = 0) : void {
        self::emit(...\func_get_args());
        self::current()->streams++;
    }

    /**
     * Returns the total number of text views made through either stream_view() or stream_json() methods only,
     * for the current context.
     *
     * @return integer
     */
    public static function streams() : int {
        $streams = self::current()->streams;
        return $streams < 0 ? 0 : $streams;
    }

    /**
     * Returns the total number of text views made through any of the view(), json(), stream_view() or stream_json() methods,
     * for the current context.
     *
     * @return integer
     */
    public static function views() : int {
        $views = self::current()->views;
        return $views < 0 ? 0 : $views;
    }

    /**
     * Gets the progress in percentage for the current context.
     *  - Progress is calculated by the total number of logged streams relative to the total number of steps defined is greater than 0.
     *  - If percentage is greater than 100, then the calculation made is wrong.
     * @param boolean $int TRUE returns integer values only
     * @return integer|float
     */
    public static function progress(bool $int = false) : int|float {
        $state = self::current();
        $streams = self::streams();
        if ($state->steps > 0) {
            $progress = (($streams / $state->steps) * 100);
            return $int ? round($progress) : $progress;
        }
        return 0;
    }

    /**
     * Sets delay in seconds
     *
     * @param integer $seconds
     * @return void
     */
    public static function pause(int $seconds) : void {
        \sleep($seconds);
    }

    /**
     * Sets delay in milliseconds
     *
     * @param integer $milliseconds
     * @return void
     */
    public static function wait(int $milliseconds) : void {
        \usleep($milliseconds * 1000);
    }

    /**
     * streams the contents of a file
     *
     * @param string $path file path
     * @param Closure $callback fn(IOTextFile $file)
     * @param float $interval
     * @return void
     */
    public static function stream_file(string $path, Closure $callback, float $interval = 1.0) : void {

        $info = (object) [
            'path' => $path, 'contents' => '', 'lines' => [], 'modified' => false,
            'mtime' => 0, 'tick' => 0, 'exists' => false, 'stopped' => false,
        ];

        $GhostFunction = new GhostFunction(['::file', 'ghostData']);
        $GhostFunction->file(fn() => $info->path);
        $GhostFunction->ghostData(fn() => $info);

        $proxy = GhostProxy::new($GhostFunction, fn(GhostDraft $draft) => new class($draft) extends IOTextFile{});

        $lastMtime = null;

        while(!$info->stopped){
            
            clearstatcache(true, $path); // force PHP to re-check the real filesystem, not its cache
            $exists = file_exists($path);
            $mtime = $exists ? filemtime($path) : 0;

            // fire on first tick (initial read) and whenever the file's mtime changes
            $changed = ($lastMtime === null) || ($exists && $mtime !== $lastMtime);

            if($changed){
                $info->tick++;
                $info->exists = $exists;
                $info->modified = ($lastMtime !== null) && $exists; // false on the very first read
                $info->mtime = $mtime;
                $info->contents = $exists ? (file_get_contents($path) ?: '') : '';
                $info->lines = $exists ? preg_split('/\r\n|\r|\n/', $info->contents) : [];

                $callback($proxy);

                $lastMtime = $mtime;
            }

            if($info->stopped) break;

            usleep((int) ($interval * 1_000_000));
        }
    }
}