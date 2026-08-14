<?php

namespace spoova\mi\core\classes;

use Throwable;

/**
 * Writes errors to a file instead of putting them on the page.
 *
 * An error shown to a visitor carries the file path, the line, and often a stack
 * trace with argument values in it — an outline of the application, handed to
 * whoever asked. Logging keeps that where it is useful and off the response.
 *
 * Nothing here is on by default. Two init keys switch it on:
 *
 *   ERROR_LOG     : on   — record errors under logs/
 *   ERROR_DISPLAY : off  — stop showing them in the browser
 *
 * The two are separate on purpose: logging while still displaying is what you
 * want on a staging machine, and either can be set without the other.
 *
 * Logs are kept in the project's own logs/ directory rather than core/storage,
 * because storage is emptied by "mi project sanitize" and a log that a deploy
 * step can delete is not a log.
 *
 * @author Akinola Saheed <akinolasaheed001@gmail.com>
 */
class ErrorLogger {

    /**
     * Directory holding the log files, relative to the project root.
     *
     * @var string
     */
    public static string $logDir = 'logs';

    /**
     * Overrides the ERROR_LOG init key when set.
     *
     * @var bool|null
     */
    public static ?bool $enabled = null;

    /**
     * Overrides the ERROR_DISPLAY init key when set.
     *
     * @var bool|null
     */
    public static ?bool $display = null;

    /**
     * Size at which a log file is rolled aside, in bytes.
     *
     * @var int
     */
    public static int $maxBytes = 5242880; // 5MB

    /**
     * Whether the log directory is added to the project's .gitignore on first use.
     *
     * Logs describe the application and must not be committed, so this is on by
     * default — but a project that manages its own .gitignore can turn it off
     * rather than have a line appended behind its back.
     *
     * @var bool
     */
    public static bool $gitignore = true;

    /**
     * Guards against re-entry.
     *
     * This runs from inside the error handler, so an error raised while logging
     * would be handed straight back to it. The flag makes that a no-op instead of
     * a loop that ends in a stack overflow.
     *
     * @var bool
     */
    private static bool $writing = false;

    /* --------------------------------------------------------------------- *
     *  Switches                                                              *
     * --------------------------------------------------------------------- */

    /**
     * Whether errors are being written to file.
     *
     * @return bool
     */
    public static function enabled() : bool {

        if(self::$enabled !== null) return self::$enabled;

        return self::switched('ERROR_LOG', false);

    }

    /**
     * Whether errors may still be shown on the page.
     *
     * Defaults to TRUE so that switching logging on does not silently blank the
     * error pages a developer is relying on; hiding them is a separate decision.
     *
     * @return bool
     */
    public static function displaying() : bool {

        if(self::$display !== null) return self::$display;

        return self::switched('ERROR_DISPLAY', true);

    }

    /**
     * Read an on/off init key.
     *
     * Init reads the project's icore directory, so it can only be asked once the
     * framework has been bootstrapped — outside that the default stands.
     *
     * @param string $key
     * @param bool $default
     * @return bool
     */
    private static function switched(string $key, bool $default) : bool {

        if(!defined('_icore') || !class_exists(Init::class)) return $default;

        $value = strtolower(trim((string) (Init::key($key) ?: '')));

        if($value === '') return $default;

        return in_array($value, ['on','1','true','yes','enabled'], true);

    }

    /* --------------------------------------------------------------------- *
     *  Logging                                                               *
     * --------------------------------------------------------------------- */

    /**
     * Record an error.
     *
     * Accepts what the error bridge is handed: a Throwable, the array PHP's error
     * handler produces, or the array error_get_last() returns.
     *
     * @param Throwable|array|null $error
     * @param string $type error, exception or shutdown
     * @return bool TRUE when something was written
     */
    public static function log(Throwable|array|null $error, string $type = 'error') : bool {

        if(self::$writing || !self::enabled()) return false;

        $entry = self::describe($error, $type);

        if($entry === null) return false;

        self::$writing = true;

        try{
            return self::write($entry);
        }catch(Throwable){
            // an error handler that throws is worse than one that loses a line
            return false;
        }finally{
            self::$writing = false;
        }

    }

    /**
     * Reduce whatever the handler was given to the fields worth recording.
     *
     * @param Throwable|array|null $error
     * @param string $type
     * @return array|null NULL when there is nothing to record
     */
    public static function describe(Throwable|array|null $error, string $type = 'error') : ?array {

        if($error instanceof Throwable){
            return [
                'severity' => self::severity($error->getCode(), get_class($error)),
                'message'  => $error->getMessage(),
                'file'     => $error->getFile(),
                'line'     => $error->getLine(),
                'trace'    => $error->getTraceAsString(),
                'type'     => $type,
            ];
        }

        if(!is_array($error) || $error === []) return null;

        $message = (string) ($error['message'] ?? '');

        if(trim($message) === '') return null;

        return [
            'severity' => self::severity($error['type'] ?? null),
            'message'  => $message,
            'file'     => (string) ($error['file'] ?? ''),
            'line'     => (int) ($error['line'] ?? 0),
            'trace'    => '',
            'type'     => $type,
        ];

    }

    /**
     * Name a PHP error constant, so a log reads as words rather than numbers.
     *
     * @param mixed $code
     * @param string $fallback
     * @return string
     */
    private static function severity(mixed $code, string $fallback = 'ERROR') : string {

        $levels = [
            E_ERROR             => 'E_ERROR',
            E_WARNING           => 'E_WARNING',
            E_PARSE             => 'E_PARSE',
            E_NOTICE            => 'E_NOTICE',
            E_CORE_ERROR        => 'E_CORE_ERROR',
            E_CORE_WARNING      => 'E_CORE_WARNING',
            E_COMPILE_ERROR     => 'E_COMPILE_ERROR',
            E_COMPILE_WARNING   => 'E_COMPILE_WARNING',
            E_USER_ERROR        => 'E_USER_ERROR',
            E_USER_WARNING      => 'E_USER_WARNING',
            E_USER_NOTICE       => 'E_USER_NOTICE',
            E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
            E_DEPRECATED        => 'E_DEPRECATED',
            E_USER_DEPRECATED   => 'E_USER_DEPRECATED',
        ];

        if(is_int($code) && isset($levels[$code])) return $levels[$code];

        return $fallback;

    }

    /**
     * Append an entry to today's log file.
     *
     * @param array $entry
     * @return bool
     */
    private static function write(array $entry) : bool {

        if(!self::prepare()) return false;

        $file = self::path();

        self::rotate($file);

        $line = implode(' | ', array_filter([
            '['.date('Y-m-d H:i:s').']',
            $entry['severity'],
            strtoupper($entry['type']),
            self::context(),
        ]));

        $body = $line.PHP_EOL
              .'  '.trim($entry['message']).PHP_EOL
              .'  at '.$entry['file'].':'.$entry['line'].PHP_EOL;

        if(trim((string) $entry['trace']) !== ''){
            $body .= '  '.str_replace(PHP_EOL, PHP_EOL.'  ', trim($entry['trace'])).PHP_EOL;
        }

        return @file_put_contents($file, $body.PHP_EOL, FILE_APPEND | LOCK_EX) !== false;

    }

    /**
     * Where the error came from, so one line in a log can be traced to one request.
     *
     * @return string
     */
    private static function context() : string {

        if(php_sapi_name() === 'cli'){
            $argv = $_SERVER['argv'] ?? [];
            return 'cli '.implode(' ', array_slice(is_array($argv)? $argv : [], 0, 4));
        }

        $method = (string) ($_SERVER['REQUEST_METHOD'] ?? '');
        $uri    = (string) ($_SERVER['REQUEST_URI'] ?? '');
        $ip     = (string) ($_SERVER['REMOTE_ADDR'] ?? '');

        return trim($method.' '.$uri.($ip !== ''? ' from '.$ip : ''));

    }

    /**
     * Absolute path of the log file currently being written.
     *
     * One file a day, so a log can be read without being enormous and an old one
     * can be dropped without touching today's.
     *
     * @return string
     */
    public static function path() : string {

        return self::directory().DIRECTORY_SEPARATOR.'error-'.date('Y-m-d').'.log';

    }

    /**
     * Absolute path of the log directory.
     *
     * @return string
     */
    public static function directory() : string {

        $root = defined('docroot')? rtrim(docroot, '\\/') : rtrim(getcwd(), '\\/');

        return $root.DIRECTORY_SEPARATOR.trim(self::$logDir, '\\/');

    }

    /**
     * Roll a log aside once it grows past the limit, so one runaway loop cannot
     * fill the disk with a single file.
     *
     * @param string $file
     * @return void
     */
    private static function rotate(string $file) : void {

        if(!is_file($file) || @filesize($file) < self::$maxBytes) return;

        @rename($file, substr($file, 0, -4).'-'.date('His').'.log');

    }

    /**
     * Create the log directory and keep it out of the web server's reach and out
     * of version control, the first time anything is written.
     *
     * @return bool
     */
    private static function prepare() : bool {

        $directory = self::directory();

        if(!is_dir($directory) && !@mkdir($directory, 0755, true) && !is_dir($directory)) return false;

        $htaccess = $directory.DIRECTORY_SEPARATOR.'.htaccess';

        if(!is_file($htaccess)){
            @file_put_contents($htaccess, implode(PHP_EOL, [
                '# Error logs describe the application. They must never be served.',
                '<IfModule mod_authz_core.c>',
                '    Require all denied',
                '</IfModule>',
                '<IfModule !mod_authz_core.c>',
                '    Order allow,deny',
                '    Deny from all',
                '</IfModule>',
            ]).PHP_EOL);
        }

        self::ignore();

        return true;

    }

    /**
     * Add the log directory to the project's .gitignore on first use.
     *
     * @return void
     */
    private static function ignore() : void {

        if(!self::$gitignore) return;

        $root = defined('docroot')? rtrim(docroot, '\\/') : rtrim(getcwd(), '\\/');
        $gitignore = $root.DIRECTORY_SEPARATOR.'.gitignore';
        $entry = trim(self::$logDir, '\\/');

        if(is_file($gitignore)){

            foreach(@file($gitignore, FILE_IGNORE_NEW_LINES) ?: [] as $line){
                $line = trim($line);
                if($line === '' || $line[0] === '#') continue;
                if(rtrim(ltrim($line, '/'), '/') === $entry) return; // already ignored
            }

            $content = (string) @file_get_contents($gitignore);
            $lead = (($content !== '') && !str_ends_with($content, PHP_EOL))? PHP_EOL : '';

            @file_put_contents($gitignore, $lead.PHP_EOL.'# spoova error logs (local only)'.PHP_EOL.$entry.'/'.PHP_EOL, FILE_APPEND);

            return;
        }

        @file_put_contents($gitignore, '# spoova error logs (local only)'.PHP_EOL.$entry.'/'.PHP_EOL);

    }

    /* --------------------------------------------------------------------- *
     *  Reading back                                                          *
     * --------------------------------------------------------------------- */

    /**
     * Log files currently held, newest first.
     *
     * @return array<int,string> absolute paths
     */
    public static function files() : array {

        $files = glob(self::directory().DIRECTORY_SEPARATOR.'error-*.log') ?: [];

        usort($files, static fn($a, $b) => filemtime($b) <=> filemtime($a));

        return $files;

    }

    /**
     * Delete log files older than a number of days.
     *
     * @param int $days keep files touched within this many days
     * @return int number of files removed
     */
    public static function prune(int $days = 30) : int {

        $cutoff  = time() - (max(1, $days) * 86400);
        $removed = 0;

        foreach(self::files() as $file){
            if(@filemtime($file) < $cutoff && @unlink($file)) $removed++;
        }

        return $removed;

    }

}
