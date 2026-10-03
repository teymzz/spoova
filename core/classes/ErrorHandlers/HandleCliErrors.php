<?php 

namespace spoova\mi\core\classes\ErrorHandlers;

use Closure;
use ErrorHandler;
use Exception;
use Throwable;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliState;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\classes\Ghost\GhostProxy;
use spoova\mi\core\classes\ErrorHandlers\GhostCliMsg;
use spoova\mi\core\commands\Root\Cli\GhostCli\GhostCliFinal;

class HandleCliErrors extends ErrorHandler{

    /** Determines if a command has been lauched */
    public static bool $lauched = false;


    /** Determinines if an error has been  initialized */
    public static bool $initialized = false;

    /** True when error output has been displayed on the CLI screen*/
    public static bool $started = false;

    /** True when silent mode is activated */
    public static bool $silent = false;
    public static bool $header_mode = false;
    public static ?array $args = null;
    public static ?Closure $final = null;
    private static bool $forceBreak = true;

    /**
     * This variable is used to detect that the silent mode property (i.e $silent) had been enabled before error occured. 
     *
     * @var boolean
     */
    public static bool $exitMode = false;

    /**
     * When defined as TRUE, the custom response message defined will be assumed 
     * if a fatal error occurs instead of the default internal termination message.
     *
     * @var boolean
     */
    public static bool $strict_mode = false;

    /**
     * This becomes TRUE if a fatal error has occured.
     *
     * @var boolean
     */
    public static bool $fatal = false;
    public static bool $consoled = false; 
    public static array $hashLogs = [];
    public static array|Closure|false $shutdown_info = [];

    /**
     * Contains only errors logged which has not been saved.
     *
     * @var array
     */
    private static array $errorLogs = [];

    /**
     * Contains all errors triggered.
     *
     * @var array
     */
    private static array $errors = [];

    /**
     * Flagged as TRUE if at least one application error (fatal or non-fatal) is triggered.
     *
     * @var boolean
     */
    private static bool $error_exists = false;

    /**
     * Cli Error Entry Point
     *  - Arguments are received from the {@see ErrorBridge::connect()} method.
     * @param Throwable|array|null $errors
     *  - Throwable : exceptions from {@see \set_exception_handler()} in ErrorHandler.
     *  - array : errors from {@see \set_error_handler()} or {@see \register_shutdown_function()} in ErrorHandler.
     *  - null : no errors only from {@see \register_shutdown_function()} in ErrorHandler.
     * @param string $type
     */
    public function __construct(Throwable|array|null $errors, string $type) {
         static $counter = 0;
         $counter++;

         if($type === 'shutdown'){
             self::handle_shutdown($errors, $type);
         }else{

            self::$error_exists = true;
            if($type === 'error'){
                self::handle_triggers(self::cli_errors(...array_values($errors)), $type, $counter);
            }else{
                self::handle_triggers(self::cli_exceptions($errors), $type, $counter);
            }

         }

         if(isset(self::$final)) {
            // resolve after ...........
            Cli::break(Cli::isTerminal('windows') ? 1 : 0);
            GhostProxy::new([], fn(GhostDraft $draft) => new class($draft) extends GhostCliFinal{});
            (self::$final)(GhostProxy::object());
            Cli::break(Cli::isTerminal('windows') ? 0 : 1);
         }
    }

    /**
     * This is used for tracking the  initialization of a command's
     *
     * @return void
     */
    public static function launch() {
        self::$lauched = true;
    }

    private static function handle_shutdown(?array $errors, string $type) {
        self::normalize_cli(); 

        if(self::$fatal){

            $message = 'Program terminated!';
            $title = ' Info ';
            $indent = 0;

            if(is_closure(self::$shutdown_info)){

                Cli::break(Cli::isTerminal('windows')? 1 : 0); // break for window terminals

                $GhostFunction = new GhostFunction(['error_exists',  'args',  ['fatal'=>self::$fatal]]);

                $GhostFunction->args(function(){
                    return self::$args;
                });

                $GhostFunction->error_exists(function(){
                    return self::error_exists();
                });

                GhostProxy::new($GhostFunction, fn(GhostDraft $draft) =>
                    new class($draft) extends GhostCliMsg {}
                );

                /** @var GhostCliMsg */
                $proxy = GhostProxy::object();
                (self::$shutdown_info)($proxy); // define messages here...
                $proxy->execute();
            }elseif(!self::$strict_mode){
                Cli::break(Cli::isTerminal('windows')? 1 : 0);
                Cli::infoView($title, $message, indent: $indent);
                Cli::break(Cli::isTerminal(['linux','wt'])? 2 : 1);
            }else{
                $message = self::$shutdown_info['message'] ?? 'Program terminated!';
                $title = self::$shutdown_info['title'] ?? ' Info ';
                $indent = self::$shutdown_info['indent'] ?? 0;
                Cli::break(Cli::isTerminal('windows')? 1 : 0);
                Cli::infoView($title, $message, indent: $indent);
                Cli::break(Cli::isTerminal(['linux','wt'])? 2 : 1);
            }

        } else {

            if(!Cli::animeResolved()){
                
                // may be in (non-resolved) animation or normal mode

                if(is_closure(self::$shutdown_info)){
                    Cli::break(Cli::isTerminal('windows')? 1 : 0); // break for window terminals
                        
                    $GhostFunction = new GhostFunction(['error_exists', 'args', ['fatal'=>self::$fatal]]);

                    $GhostFunction->args(function(){
                        return self::$args;
                    });
                    
                    $GhostFunction->error_exists(function(){
                        return self::error_exists();
                    });

                    GhostProxy::new($GhostFunction, fn(GhostDraft $draft) =>
                        new class($draft) extends GhostCliMsg {}
                    );

                    /** @var GhostCliMsg */
                    $proxy = GhostProxy::object();
                    (self::$shutdown_info)($proxy); // use callback function to modify GhostCliMsg

                    if($proxy->isExecuted()) throw new Exception('calling the execute method directly is disallowed');
                    
                    $proxy->execute();
                    $proxy->isDisabled($disabled);

                    if(!in_array($disabled, [true, 'fatal'], true)) {
                        Cli::isTerminal('windows')? Cli::moveUp(1) : '';
                    }
                }else{

                    // shutdown when latent mode is not enabled
                    $logged = false; $silent = self::$silent;
                    foreach(self::$errorLogs as $errorkey => $errorLogs){

                        unset(self::$errorLogs[$errorkey]);

                        if(!self::$started && self::$silent && $type==='fatal') Cli::moveUp(1);

                        foreach($errorLogs as $errorLog){
                            if(self::$silent) self::$exitMode = true; //enable clean exit
                            self::$silent = false;
                            self::$started = true;
                            $logged = true;
                            self::cli_display($errorLog);
                        }
            
                    }

                    if($logged && self::$exitMode) Cli::break(1);

                    if(isset(self::$shutdown_info['message']) && self::$shutdown_info['message']){
                        $message = self::$shutdown_info['message'] ?? 'Program terminated!';
                        $title = self::$shutdown_info['title'] ?? ' Info ';
                        $indent = self::$shutdown_info['indent'] ?? 0;
                        Cli::break(Cli::isTerminal('windows')? 1 : 0);
                        Cli::infoView($title, $message, indent: $indent);
                        Cli::break(Cli::isTerminal(['linux','wt'])? 2 : 1);
                    }

                }

            }else{
                // in animation mode and successful.
                 if(isset(self::$shutdown_info)){
                    $shutdown_info = self::$shutdown_info;

                    if(is_closure($shutdown_info)){
                           
                        Cli::break(Cli::isTerminal('windows')? 1 : 0); // break for window terminals

                        $GhostFunction = new GhostFunction(['error_exists', 'args', ['fatal'=>self::$fatal]]);
                        
                        $GhostFunction->args(function(){
                            return self::$args;
                        });

                        $GhostFunction->error_exists(function(){
                            return self::error_exists();
                        });
                        GhostProxy::new($GhostFunction, fn(GhostDraft $draft) =>
                            new class($draft) extends GhostCliMsg {}
                        );

                        /** @var GhostCliMsg */
                        $proxy = GhostProxy::object();
                    
                        (self::$shutdown_info)($proxy);

                        if($proxy->isExecuted()) throw new Exception('calling the execute method directly is disallowed');
                    
                        $proxy->execute();
                        $proxy->isDisabled($disabled);

                        if(!in_array($disabled, [true, 'fatal'], true)) {
                            Cli::isTerminal('windows')? Cli::moveUp(1) : '';
                        }

                    }else if(is_array(self::$shutdown_info) && isset(self::$shutdown_info['message']) && self::$shutdown_info['message']){
                        $message = self::$shutdown_info['message'] ?? 'Program successful!';
                        $title = self::$shutdown_info['title'] ?? ' Info ';
                        $indent = self::$shutdown_info['indent'] ?? 0;
                        Cli::break(Cli::isTerminal('windows')? 1 : 0);
                        Cli::infoView($title, $message, color: 'valid|white', indent: $indent);
                        Cli::break(Cli::isTerminal(['linux','wt'])? 2 : 1);
                    }
                }
            }
        }

    }

    /**
     * Return all triggered errors saved into memory.
     *
     * @return array
     */
    public static function errors() : array {
        return self::$errors;
    }

    /**
     * Checks if CLI errors is in silent mode
     *
     * @param boolean $strict 
     *  - FALSE : returns TRUE if the current mode is silent 
     *  - TRUE : returns TRUE if the silent was enabled once before being disabled. 
     * @return boolean
     */
    public static function isSilent(bool $strict = false) : bool {
        return $strict? self::$exitMode : self::$silent;
    }

    private static function handle_triggers(array $errors, string $type, int $counter){

        $isSilent = self::$silent;
        if((!self::$header_mode || self::$forceBreak) && $counter < 2 && !$isSilent && $type !== 'error') {
            Cli::break(1);
        }
        
        if($type === 'error'){
            self::$errors[] = [
                'type' => 'error',
                'data' => 'error',
            ];
            self::$errorLogs['errors'][] = $errors;
            if($isSilent) return; // log only on silent mode
        }else if($type === 'exception'){
            self::$errors[] = [
                'type' => 'exception',
                'data' => $errors,
            ];
            self::$fatal = true;
            self::$errorLogs['exception'][] = $errors;
        }
        
        // When not in silent mode or fatal error occurs, log the errors immediately

        if(!$isSilent && ($counter == 0)){ Cli::break(1);  $appliedBreak = true; }
        
        foreach(self::$errorLogs as $errorkey => $errorLogs){

            unset(self::$errorLogs[$errorkey]);

            foreach($errorLogs as $errorLog){
                if(self::$silent) self::$exitMode = true; //enable clean exit
                self::$silent = false;
                self::$started = true;
                self::cli_display($errorLog);
            }

        }

    }

    /**
     * Controls the last response message shown when the terminal shutsdown
     *
     * @param string|Closure|false|null $message
     * @param string $title
     * @param int $indent
     * @return void
     */
    public static function set_info(string|Closure|false|null $message, string $title = 'Info', int $indent = 0){
        $title = trim($title);
        if($title) $title = ' '.$title.' ';

        if($message === false){
            self::$shutdown_info = false;
        }elseif(is_closure($message)){
            self::$shutdown_info = $message;
        }else{
            self::$shutdown_info = [];
            self::$shutdown_info['title'] = $title ?: ' Info ';
            self::$shutdown_info['message'] = $message;
            self::$shutdown_info['indent'] = $indent;
        }

    }

    /**
     * Use arguments with GhostCliMsg  
     *  - Setting arguments allow {@see GhostCliMsg} to validate arguments with methods.
     *
     * @param string|array|null $args
     * @return void
     */
    public static function use_arguments(string|array|null $args = null){
        $args = is_string($args)? [$args] : $args;
        self::$args = $args;
    }

    /**
     * This method allows the default fatal error message to be overriden with the response message defined.
     *
     * @param boolean $mode
     * @return void
     */
    public static function strict_mode(bool $mode = true){
        self::$strict_mode = $mode;
    }

    /**
     * This method helps to declare a start mode applicable only to 
     * {@see Cli::headerView()} method.
     *
     * @param boolean $mode
     * @return void
     */
    public static function header_mode(bool $mode = true){
        self::$header_mode = $mode;
    }

    /**
     *  This method is used to delay warning errors' logging till after expected processes have been completed. This will not prevent fatal errors from displaying
     *   - Notice: if silent error mode is enabled and fatal error occurs, all previously hidden warning errors will be displayed before the fatal error.
     * @param boolean $mode TRUE enables silent error mode while FALSE disables it.
     * @param boolean $forceBreak forces application of a single line break before warning error is displayed.
     *   -  If an expected output is being cleared due to warning error, this mode should be enabled to apply a single linebreak before the error is displayed to avoid clearing expected output.  
     * @return void
     */
    public static function silentErrors(bool $mode = true, bool $forceBreak = false){
        self::$silent = $mode;
        self::$forceBreak = $forceBreak;
    }

    /**
     * Forces a line break when the first error is displayed.
     *
     * @param boolean $force
     * @return void
     */
    public static function forceBreak(bool $force = true){
        self::$forceBreak = $force;
    }

    public static function isConsoled() : bool {
        return self::$consoled;
    }

    /**
     * Returns TRUE if at least one error has been displayed on the CLI screen
     *
     * @return boolean
     */
    public static function isDisplayed() : bool {
        return self::$started;
    }

    /**
     * This method is used to display logged errors on the CLI screen if the silent mode is enabled. 
     *  - This method will not display pre-existing errors when silent mode is previously enabled. 
     *  - If errors are displayed by this method once, this will prevent them from being displayed again unless $reset is set to TRUE. 
     *  - If the reset parameter is set to TRUE, the silent mode will be enabled again after displaying the errors. 
     *  - This method returns NULL if the errors are already consoled or if the silent mode is enabled, otherwise it returns the value of $return parameter.
     *
     * @param boolean $return value to be returned when silent mode is disabled and error console flag is not enabled 
     * @param boolean $reset TRUE disables (i.e resets) the error console flag 
     * @return boolean|null
     *  - boolean : returns the value of $return parameter if the errors are not consoled and silent mode is disabled.
     *  - null : returns NULL if the errors are already consoled by this method or if in silent mode.
     */
    public static function consoleErrors(bool $return, bool $reset = false) : bool|null {
        if(self::$consoled) {
            if($reset) self::$consoled = false;
            return null;
        }
        if(self::$silent) return null; // do not console if in silent mode
        foreach(self::$errorLogs as $errorLogs){
            self::$consoled = true;
            foreach($errorLogs as $errorLog){
               self::cli_display($errorLog);
            }
        }
        self::$silent = false;
        return $return;
    }

    /**
     * Returns TRUE if at least one triggered error has not displayed.
     *
     * @return boolean
     */
    public static function hasErrors() : bool {
        return self::$errorLogs ? true : false;
    }

    /**
     * Returns TRUE if an application error is triggered.
     *
     * @return boolean
     */
    public static function error_exists() : bool {
        return self::$error_exists;
    }
    
    /**
     * Returns TRUE when fatal error occurs
     *
     * @return boolean
     */
    public static function isFatal() : bool {
        return self::$fatal;
    }
    
    /**
     * Sets a final 
     *
     * @return void
     */
    public static function final(Closure $final) : void {
        self::$final = $final;
    }

    private static function normalize_cli(){
        if(isCli()){
            Cli::showCursor();
            if(Cli::hasCommand('stty') && Cli::sttyEnabled()) {CliState::stty('sane', false); Cli::break();}
        }
    }

    /**
     * Format CLI error notices
     *
     * @param integer $errno
     * @param string $errstr
     * @param string $errfile
     * @param string $errline
     * @return array
     */
    private function cli_errors(int $errno, string $errstr, string $errfile, string $errline) : array {
        return self::buildErrors(self::errors[$errno], $errstr, $errfile, $errline);
    }

    /**
     * Format CLI error exceptions
     *
     * @param Throwable|null $e
     * @return array
     */
    private function cli_exceptions(?Throwable $e = null) : array {
        $constant = ucfirst(get_class($e)); 
        $constant = $constant == 'ParseError'? $constant : 'Error';
        $exception = self::$exceptions[$constant];
        $error = self::errors[$exception];

        return self::buildErrors(
            $error, $e->getMessage(), $e->getFile(), $e->getLine(),
            $e->getTrace(), 'Exception'
        );
    }

    public static function hashLogs() : array {
        return self::$hashLogs;
    }

    /**
     * Format for displaying cli errors
     *
     * @param array $err
     * @return void
     */
    final static function cli_display(array $err){

        if(self::$forceBreak && !self::$started){ 
           Cli::break(); self::$forceBreak = false;
        }
        $error   = $err['error'];
        $errfile = $err['errfile'];
        $errline = $err['errline'].br();
        $errMessage = $err['message'];
        
        $fileString = (self::$addfile)? "in $errfile on line $errline" : '';

        $errorText = "$error $errMessage $fileString";

        $fileStringHash = base_encode($errorText);

        if($fileString && !in_array($fileStringHash, self::$hashLogs)){
            self::$hashLogs[] = $fileStringHash;
        }else{
            return;
        }

        $error = Cli::warn($error.':');

        $body = <<<Body

        $error $errMessage $fileString
        Body;

        if(self::$silent) self::$exitMode = true;
        self::$started = true;
        print $body;
        Cli::showCursor();
    }

}