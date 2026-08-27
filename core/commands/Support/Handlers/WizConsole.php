<?php

namespace spoova\mi\core\commands\Support\Handlers;

use ParseError;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliArgs;
use spoova\mi\core\commands\Root\Cli\CliCast;
use spoova\mi\core\commands\Root\Cli\CliScreen;
use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use Throwable;

/**
 * Shared base of the interactive code channels.
 *
 * Two channels are built on this: {@see InteractiveConsole} (:wiz) collects a whole
 * block and runs it once a semicolon is entered on a line of its own, while
 * {@see CastConsole} (:wizi) evaluates each line as it is typed. Only the way input
 * is gathered differs — the console commands, the error reporting and the evaluation
 * itself are the same for both and live here rather than being repeated in each.
 *
 *  - This class is under development and may not be entirely suitable for running PHP codes.
 */
abstract class WizConsole {

    protected static Filemanager $Filemanager;

    protected static $exceptions = [
        'Error'   => E_ERROR,
        'ParseError' => E_PARSE,
    ];

    protected static $ipromptCounter = 0;

    protected static $errors = [
        E_ERROR   => 'Fatal Error', //1
        E_WARNING => 'Warning',     //2
        E_PARSE   => 'Parse Error', //4
        E_NOTICE  => 'Notice Error', //8
        E_CORE_ERROR      => "Core Error", //16
        E_CORE_WARNING    => "Core Warning", //32
        E_COMPILE_ERROR   => "Zend Error", //64
        E_COMPILE_WARNING => "Zend Warning", //128
        E_USER_ERROR      => "Trigger Error", //256
        E_USER_WARNING    => "Trigger Warning", //512
        E_USER_NOTICE     => "Trigger Notice", //1024
        // E_STRICT          => "Strict", //2048 (Deprecated)
        E_RECOVERABLE_ERROR => "Notice", //4096
        E_DEPRECATED      => "Deprecated",//8192
        E_USER_DEPRECATED => "User Deprecated", //16384
        E_ALL             => "All Errors", //32767
    ];

    /** Lines making up the block currently being collected. */
    protected static array $buffer = [];

    /** Variables carried from one submitted block to the next. */
    protected static array $scope = [];

    /** Everything submitted during the session. */
    protected static array $history = [];

    /** Seconds the last evaluation took. */
    protected static float $duration = 0.0;

    /**
     * Console commands and what each one does, used both by /help and by the
     * completion handler so that the two can never disagree.
     */
    protected const commands = [
        '/help'    => 'list these commands',
        '/list'    => 'show what has been collected so far',
        '/clear'   => 'discard the collected lines',
        '/del <n>' => 'remove one collected line by its number',
        '/vars'    => 'show the variables the session is holding',
        '/time'    => 'how long the last run took',
        '/history' => 'show what has been submitted this session',
        '/save <file>' => 'write what has been collected to a file',
        '/load <file>' => 'read a file in as collected lines',
        '/exit'    => 'end the session (Ctrl+D does the same)',
    ];

    /**
     * Short names made reachable without an import.
     *
     * A channel is for trying something quickly, and opening every session with a
     * line of `use spoova\mi\core\classes\...` defeats that. Any name already taken
     * is left alone, so nothing the framework defines can be shadowed.
     */
    protected const shortcuts = [
        'Benchmark'          => 'spoova\mi\core\classes\Benchmark',
        'DB'                 => 'spoova\mi\core\classes\DB',
        'Hasher'             => 'spoova\mi\core\classes\Hasher',
        'Record'             => 'spoova\mi\core\classes\Record',
        'Debug'              => 'spoova\mi\core\classes\Debug',
        'Init'               => 'spoova\mi\core\classes\Init',
        'Lqip'               => 'spoova\mi\core\classes\Lqip',
        'ErrorLogger'        => 'spoova\mi\core\classes\ErrorLogger',
        'RequestRateLimiter' => 'spoova\mi\core\classes\RequestRateLimiter',
    ];


    /**
     * @param array $args tokens supplied after the command, so that a one-liner can
     *                    be run with -e without opening the channel at all
     */
    final function __construct(array $args = [])
    {

        set_error_handler([static::class,'handleCliErrors']);
        set_exception_handler([static::class,'handleCliExceptions']);
        static::$Filemanager = new Filemanager;

        static::shortcuts();

        $input = (new CliArgs($args))
            ->option('eval', ['-e', '--eval'])
            ->max(0)
            ->parse();

        if(!$input->ok()){
            foreach($input->errors() as $error){
                Cli::textView(Cli::error($error), "3|1", "1|1");
            }
            Cli::break();
            return;
        }

        /* -e runs a single block and leaves, so the channel can be used from a
           script or a makefile rather than only by hand */
        if(($code = $input->getOption('eval')) !== null){
            static::evaluate((string) $code);
            return;
        }

        static::completion();

        $this->interact();

    }

    /**
     * First method called during initialization. Prints whatever heading the channel
     * shows, then hands over to the reader it is built on.
     *
     * @return void
     */
    abstract protected function interact() : void;

    /**
     * Display name used in the exit message, so each channel identifies itself.
     * Subclasses may override; the default suits the :wiz block console.
     *
     * @return string
     */
    protected static function label() : string {
        return 'WizConsole';
    }

    /* ----------------------------------------------------------------- *
     *  Block channel (:wiz)                                              *
     * ----------------------------------------------------------------- */

    /**
     * Collects a block of code, running it once a semicolon is entered on a line of
     * its own, and stays open for the next block afterwards.
     *
     * @return void
     */
    public static function process(){

        static::$buffer = [];

        while(true){

            $line = readline('   '.(count(static::$buffer) + 1).'. ');

            // FALSE is end of stream: Ctrl+D at a terminal, or a spent pipe
            if($line === false){
                Cli::textView(Cli::valid(static::label() . ' exited successfully.'), "3|1", "1|1");
                break;
            }

            $line = rtrim($line, "\r\n");

            if(trim($line) === '') continue;

            if(static::command(trim($line), $ended, true)){
                if($ended) break;
                continue;
            }

            if(trim($line) === ';'){
                static::submit();
                continue;
            }

            static::$buffer[] = $line;
            static::remember($line);

        }

    }

    /**
     * Runs whatever has been collected and starts a fresh block.
     *
     * @return void
     */
    protected static function submit() : void {

        if(!static::$buffer) return;

        $code = implode(PHP_EOL, static::$buffer);

        static::$history[] = $code;
        static::$ipromptCounter = count(static::$buffer);
        static::$buffer = [];

        static::evaluate($code);

    }

    /* ----------------------------------------------------------------- *
     *  Line channel (:wizi)                                              *
     * ----------------------------------------------------------------- */

    /**
     * The callback handed to {@see Cli::cast()}, so that the line channel answers
     * the same console commands as the block channel and everything else is left to
     * be evaluated as ordinary PHP.
     *
     * @return \Closure
     */
    protected static function caster() : \Closure {

        return function(CliCast $cast){

            $line = trim((string) $cast->input());

            /* the line channel keeps its variables inside cast(), so .vars has to
               read them from there rather than from the block channel's scope */
            static::$scope = $cast->scope();
            static::$duration = Cli::castDuration();

            if(static::command($line, $ended)){
                if($ended) return $cast->stop();
                return $cast->handled();
            }

            static::remember($line);
            static::$history[] = $line;

        };

    }

    /* ----------------------------------------------------------------- *
     *  Console commands                                                  *
     * ----------------------------------------------------------------- */

    /**
     * Answers a console command, returning FALSE for anything that should be run as
     * PHP instead.
     *
     * A line is only treated as a command when it is a bare dot-word, so that a line
     * continuing a concatenation — ." and the rest"; — is still read as code.
     *
     * @param string $line
     * @param bool|null $ended set when the command ends the session
     * @return bool TRUE when the line was a command and needs no evaluation
     */
    protected static function command(string $line, ?bool &$ended = null, bool $modalHelp = false) : bool {

        $ended = false;

        if($line === '' || $line[0] !== '/') return false;

        $parts    = preg_split('~\s+~', $line, 2);
        $command  = strtolower($parts[0]);
        $argument = trim($parts[1] ?? '');

        switch($command){

            case '/exit':
            case '/quit':
                $ended = true;
                Cli::textView(Cli::valid(static::label() . ' exited successfully.'), "3|1", "1|1");
                return true;

            case '/help':    $modalHelp ? static::helpModal() : static::showCommands(); return true;
            case '/list':    static::showBuffer();        return true;
            case '/clear':   static::clearBuffer();       return true;
            case '/del':     static::removeLine($argument); return true;
            case '/vars':    static::showVars();          return true;
            case '/time':    static::showTime();          return true;
            case '/history': static::showHistory();       return true;
            case '/save':    static::saveBuffer($argument); return true;
            case '/load':    static::loadBuffer($argument); return true;

        }

        /* a bare slash-word that matches nothing is a mistyped command, not code —
           "//comment", "/regex/" and division ("$a / $b", which has a space or
           does not start the line) all fail this test and are left to evaluate */
        if(preg_match('~^/[a-z]+$~i', $line)){
            Cli::textView(Cli::warn('unknown command "'.$command.'". Type ').Cli::alert('/help'), "3|1", "1|1");
            return true;
        }

        return false;

    }

    /** @return void */
    protected static function showCommands() : void {

        Cli::break();

        foreach(static::commands as $command => $description){
            Cli::textView(Cli::alert(str_pad($command, 16)).Cli::dots(4, '', ' ').$description, "3|1", "1");
        }

        Cli::break();

    }

    /**
     * Show the commands full-screen and dismiss them on a keypress, then restore
     * the block so the prompt is back where it was. Used by the block channel
     * (:wiz) so the help does not pile up in the scrollback while a block is being
     * written; the line channel keeps the plain, inline listing.
     *
     * @return void
     */
    protected static function helpModal() : void {

        print "\e[2J\e[3J\e[H";           // clear the screen
        static::showCommands();
        Cli::textView(Cli::warn('  — press a key to return —'), "3|1", "1|1");

        // dismiss: any key when the terminal reports stty, otherwise Enter
        if(Cli::sttyEnabled()){
            Cli::input(function($key){ $key->exit(); });
        } else {
            fgets(STDIN);
        }

        print "\e[2J\e[3J\e[H";           // clear and put the collected block back
        static::replayBuffer();

    }

    /**
     * Reprint the lines collected so far, matching the readline prompt format, so
     * that after the help modal the block reads continuously into the next prompt.
     *
     * @return void
     */
    protected static function replayBuffer() : void {

        foreach(static::$buffer as $i => $line){
            Cli::textView('   '.($i + 1).'. '.$line, 0, '|1');
        }

    }

    /** @return void */
    protected static function showBuffer() : void {

        if(!static::$buffer){
            Cli::textView(Cli::warn('nothing collected yet.'), "3|1", "1|1");
            return;
        }

        Cli::break();

        foreach(static::$buffer as $index => $line){
            Cli::textView(Cli::alert(str_pad(($index + 1).'.', 4)).static::highlight($line), "3|1", "1");
        }

        Cli::break();

    }

    /** @return void */
    protected static function clearBuffer() : void {

        if(!static::$buffer){
            Cli::textView(Cli::warn('nothing collected yet.'), "3|1", "1|1");
            return;
        }

        $count = count(static::$buffer);

        static::wipe(static::$buffer);
        static::$buffer = [];

        Cli::textView(Cli::warn($count.' line(s) discarded.'), "3|1", "1|1");

    }

    /**
     * Removes one collected line and redraws the rest, so the numbering on screen
     * still matches the numbering the next .del would use.
     *
     * @param string $argument
     * @return void
     */
    protected static function removeLine(string $argument) : void {

        if(!ctype_digit($argument) || (int) $argument < 1){
            Cli::textView(Cli::warn('/del needs a line number, e.g. ').Cli::alert('/del 2'), "3|1", "1|1");
            return;
        }

        $number = (int) $argument;

        if(!isset(static::$buffer[$number - 1])){
            Cli::textView(Cli::warn('there is no line '.$number.'.'), "3|1", "1|1");
            return;
        }

        static::wipe(static::$buffer);

        unset(static::$buffer[$number - 1]);
        static::$buffer = array_values(static::$buffer);

        foreach(static::$buffer as $index => $line){
            Cli::textView(Cli::alert(str_pad(($index + 1).'.', 4)).static::highlight($line), "3|1", "1");
        }

    }

    /** @return void */
    protected static function showVars() : void {

        if(!static::$scope){
            Cli::textView(Cli::warn('no variables held yet.'), "3|1", "1|1");
            return;
        }

        Cli::break();

        foreach(static::$scope as $name => $value){
            Cli::textView(Cli::alert('$'.str_pad($name, 14)).Cli::dump($value), "3|1", "1");
        }

        Cli::break();

    }

    /** @return void */
    protected static function showTime() : void {

        if(static::$duration <= 0){
            Cli::textView(Cli::warn('nothing has been run yet.'), "3|1", "1|1");
            return;
        }

        $seconds = static::$duration;

        $reading = ($seconds < 0.001)
            ? round($seconds * 1000000).'µs'
            : (($seconds < 1)? round($seconds * 1000, 2).'ms' : round($seconds, 3).'s');

        Cli::textView(Cli::valid('last run took ').Cli::alert($reading), "3|1", "1|1");

    }

    /** @return void */
    protected static function showHistory() : void {

        if(!static::$history){
            Cli::textView(Cli::warn('nothing submitted yet.'), "3|1", "1|1");
            return;
        }

        Cli::break();

        foreach(static::$history as $index => $entry){
            // a submitted block can span lines; only its first is worth listing
            $first = strtok($entry, PHP_EOL);
            $extra = substr_count($entry, PHP_EOL);
            Cli::textView(
                Cli::alert(str_pad(($index + 1).'.', 4)).static::highlight($first).
                ($extra? Cli::warn('  (+'.$extra.' more line(s))') : ''),
                "3|1", "1"
            );
        }

        Cli::break();

    }

    /**
     * Writes what has been collected — or, when nothing is collected, what has been
     * submitted — to a file, so that an experiment can become a seeder or a script.
     *
     * @param string $argument
     * @return void
     */
    protected static function saveBuffer(string $argument) : void {

        if($argument === ''){
            Cli::textView(Cli::warn('/save needs a file name, e.g. ').Cli::alert('/save draft.php'), "3|1", "1|1");
            return;
        }

        $lines = static::$buffer?: static::$history;

        if(!$lines){
            Cli::textView(Cli::warn('nothing to save yet.'), "3|1", "1|1");
            return;
        }

        $path = static::resolve($argument);

        /* refused rather than overwritten: a channel is a scratch space, and losing
           a file to a name typed in a hurry is not a fair trade */
        if(is_file($path)){
            Cli::textView(Cli::warn('"'.$argument.'" already exists — choose another name.'), "3|1", "1|1");
            return;
        }

        $content = "<?php".PHP_EOL.PHP_EOL.implode(PHP_EOL, $lines).PHP_EOL;

        if(@file_put_contents($path, $content) === false){
            Cli::textView(Cli::error('could not write to "'.$argument.'".'), "3|1", "1|1");
            return;
        }

        Cli::textView(Cli::valid('saved to ').Cli::alert($path), "3|1", "1|1");

    }

    /**
     * Reads a file in as collected lines.
     *
     * @param string $argument
     * @return void
     */
    protected static function loadBuffer(string $argument) : void {

        if($argument === ''){
            Cli::textView(Cli::warn('/load needs a file name, e.g. ').Cli::alert('/load draft.php'), "3|1", "1|1");
            return;
        }

        $path = static::resolve($argument);

        if(!is_file($path)){
            Cli::textView(Cli::warn('"'.$argument.'" was not found.'), "3|1", "1|1");
            return;
        }

        $content = (string) @file_get_contents($path);

        // the opening tag belongs to the file, not to the block being built
        $content = preg_replace('~^\s*<\?php\s*~', '', $content);
        $content = preg_replace('~\?>\s*$~', '', (string) $content);

        $lines = preg_split('~\R~', trim((string) $content));

        foreach($lines as $line){
            if(trim($line) !== '') static::$buffer[] = $line;
        }

        Cli::textView(Cli::valid('loaded ').Cli::alert(count($lines).' line(s)').Cli::valid(' from '.$argument), "3|1", "1|1");

        static::showBuffer();

    }

    /**
     * Turns a name typed at the channel into a path, relative to where the command
     * was run from unless it is already absolute.
     *
     * @param string $name
     * @return string
     */
    protected static function resolve(string $name) : string {

        $name = trim($name, "\"' ");

        if(preg_match('~^(/|\\\\|[A-Za-z]:)~', $name)) return $name;

        return rtrim((string) getcwd(), '/\\').DIRECTORY_SEPARATOR.$name;

    }

    /* ----------------------------------------------------------------- *
     *  Evaluation                                                        *
     * ----------------------------------------------------------------- */

    /**
     * Runs a submitted block and prints whatever it produced.
     *
     * The block is evaluated rather than written to a file and included. A scratch
     * file had to live at one fixed path, so two channels open at once wrote to,
     * ran and deleted the same file and each could end up running the other's code;
     * it also survived a session that was killed mid-block. Evaluating removes the
     * file altogether, and the line a failure reports is now the line that was
     * typed rather than a line in a rewritten copy of it.
     *
     * @param string $code
     * @return void
     */
    protected static function evaluate(string $code) : void {

        $code = trim($code);

        if($code === '') return;

        $level   = ob_get_level();
        $started = microtime(true);

        // variables from the blocks already run are put back before this one runs
        extract(static::$scope, EXTR_SKIP);

        try {

            ob_start();
            eval($code);
            $response = ob_get_clean();

            static::$duration = microtime(true) - $started;

            Cli::break();

            Cli::textView(Cli::valid(">> response: "), "3|1");
            Cli::textView(Cli::alert($response), "|1", "|2");

        } catch (Throwable $error) {

            /* the buffer is still open when the failure happened inside it, and
               leaving it open would swallow everything printed afterwards */
            while(ob_get_level() > $level) ob_end_clean();

            static::$duration = microtime(true) - $started;

            static::report($error);

        }

        // carry the variables into the next block
        static::$scope = array_diff_key(get_defined_vars(), array_flip(
            ['code', 'level', 'started', 'response', 'error']
        ));

    }

    /**
     * Prints a failure raised by a submitted block.
     *
     * @param Throwable $e
     * @return void
     */
    protected static function report(Throwable $e) : void {

        $error = static::$errors[($e instanceof ParseError)? E_PARSE : E_ERROR];

        Cli::break();
        Cli::textView(Cli::danger(Cli::emos('point-right')));
        Cli::textView(Cli::danger($error)." : ". $e->getMessage() ." in line ".$e->getLine(), 0, '|2');

    }

    /* ----------------------------------------------------------------- *
     *  Screen                                                            *
     * ----------------------------------------------------------------- */

    /**
     * Clears the rows a set of collected lines occupies on screen.
     *
     * A line longer than the terminal wraps onto more than one row, and the escape
     * that moves the cursor up moves it one *row* rather than one line — so the rows
     * each line actually took have to be counted, or the redraw eats whatever was
     * printed above the block.
     *
     * @param array $lines
     * @param int $prefix width of the numbering printed before each line
     * @return void
     */
    protected static function wipe(array $lines, int $prefix = 7) : void {

        $width = max(1, CliScreen::width());
        $rows  = 0;

        foreach($lines as $line){
            $printed = $prefix + mb_strwidth((string) $line);
            $rows += max(1, (int) ceil($printed / $width));
        }

        for($row = 0; $row < $rows; $row++){
            echo "\033[A\033[2K\r";
        }

    }

    /**
     * Colours a line of code for display.
     *
     * @param string $code
     * @return string
     */
    protected static function highlight(string $code) : string {

        if(!function_exists('token_get_all')) return $code;

        $keywords = [
            T_ECHO, T_PRINT, T_IF, T_ELSE, T_ELSEIF, T_FOREACH, T_FOR, T_WHILE, T_DO,
            T_FUNCTION, T_FN, T_RETURN, T_NEW, T_CLASS, T_USE, T_NAMESPACE, T_STATIC,
            T_PUBLIC, T_PROTECTED, T_PRIVATE, T_CONST, T_TRY, T_CATCH, T_THROW,
            T_SWITCH, T_CASE, T_BREAK, T_CONTINUE, T_ARRAY, T_ISSET, T_UNSET, T_EMPTY,
        ];

        try {
            // the tag is only there to make the fragment tokenizable
            $tokens = @token_get_all('<?php '.$code);
        } catch (Throwable) {
            return $code;
        }

        $out = '';

        foreach($tokens as $token){

            if(is_string($token)){ $out .= $token; continue; }

            [$id, $text] = $token;

            if($id === T_OPEN_TAG) continue;

            $out .= match(true){
                in_array($id, $keywords, true)                          => Cli::danger($text),
                $id === T_VARIABLE                                      => Cli::alert($text),
                in_array($id, [T_CONSTANT_ENCAPSED_STRING,
                               T_ENCAPSED_AND_WHITESPACE], true)        => Cli::valid($text),
                in_array($id, [T_LNUMBER, T_DNUMBER], true)             => Cli::warn($text),
                in_array($id, [T_COMMENT, T_DOC_COMMENT], true)         => Cli::warn($text),
                default                                                 => $text,
            };

        }

        return $out;

    }

    /* ----------------------------------------------------------------- *
     *  Session setup                                                     *
     * ----------------------------------------------------------------- */

    /**
     * Makes the short names in {@see WizConsole::shortcuts} usable without an import.
     *
     * @return void
     */
    protected static function shortcuts() : void {

        foreach(static::shortcuts as $alias => $class){

            // never shadow a name the framework already defines
            if(class_exists($alias, false)) continue;

            if(class_exists($class)) @class_alias($class, $alias);

        }

    }

    /**
     * Offers class, function and console-command names on tab.
     *
     * @return void
     */
    protected static function completion() : void {

        if(!function_exists('readline_completion_function')) return;

        @readline_completion_function(fn($input) => static::completions((string) $input));

    }

    /**
     * Names offered for a partly typed word.
     *
     * Kept apart from the handler that registers it so that it can be exercised
     * without a terminal attached.
     *
     * @param string $input
     * @return array
     */
    protected static function completions(string $input) : array {

        if($input === '') return [];

        $names = array_merge(
            array_map(fn($command) => strtok($command, ' '), array_keys(static::commands)),
            array_keys(static::shortcuts),
            get_declared_classes(),
            get_defined_functions()['internal'] ?? [],
            get_defined_functions()['user'] ?? []
        );

        /* a class and its alias differ only in case, and offering both twice is
           noise rather than a choice */
        $seen = $matches = [];

        foreach($names as $name){

            $name = (string) $name;

            if(stripos($name, $input) !== 0) continue;

            if(isset($seen[$key = strtolower($name)])) continue;

            $seen[$key] = true;
            $matches[]  = $name;

        }

        return $matches;

    }

    /**
     * Adds a line to the recall history readline offers on the arrow keys.
     *
     * @param string $line
     * @return void
     */
    protected static function remember(string $line) : void {

        if(function_exists('readline_add_history') && trim($line) !== ''){
            @readline_add_history($line);
        }

    }

    /* ----------------------------------------------------------------- *
     *  Console handlers                                                  *
     * ----------------------------------------------------------------- */

    public static function handleCliErrors($errno, $errstr, $errfile, $errline){

        $errline = (($errline -1) > static::$ipromptCounter)? static::$ipromptCounter : $errline -1;
        Cli::clearLine();
        Cli::textView(Cli::warn(static::$errors[$errno] ?? 'Error')." : ". $errstr . " in line ".$errline, 0, "|1");

    }

    /* Throwable, not Exception: a ParseError or an Error is neither, so hinting
       Exception here made the handler raise a TypeError on exactly the failures
       it exists to report. */
    public static function handleCliExceptions(?Throwable $e = null) {

        if($e === null) return;

        $errline = (($e->getLine()-1) > static::$ipromptCounter)? static::$ipromptCounter : $e->getLine() - 1;

        $error = static::$errors[($e instanceof ParseError)? E_PARSE : E_ERROR];

        Cli::clearLine()->break();
        Cli::textView(Cli::danger(Cli::emos('point-right')));
        Cli::textView(Cli::danger($error)." : ". $e->getMessage() ." in line ".$errline, 0, '|2');

    }

}
