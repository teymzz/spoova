<?php

namespace spoova\mi\core\classes\ErrorHandlers;

use Closure;
use spoova\mi\core\classes\Ghost\GhostClass;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostProxy;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliRuntime;
use spoova\mi\core\commands\Root\Cli\GhostCli\GhostCliFinal;
use spoova\mi\core\commands\Root\Cli\GhostCli\Interface\GhostCliMsgInterface;

abstract class GhostCliMsg extends GhostClass implements GhostCliMsgInterface {

    /**
     * Determines if response message is disabled
     *
     * @var boolean
     */
    private bool|string $disabled = false;

    /**
     * Execution flag.
     *
     * @var boolean
     */
    private bool $isExecuted = false;
    protected string|array|null $default_message = null;
    protected string|array|null $fatal_message = null;

    /** @var array default error message */
    private array $onErrorDefault = [
        'title' => 'Info',
        'message' => 'Some error occured.',
        'indent' => 0,
        'color' => 'danger|black',
        'break' => 2
    ];
    /** @var array default error message */
    private array $onFatalDefault = [
        'title' => 'Info',
        'message' => 'Program terminated.',
        'indent' => 0,
        'color' => 'danger|black',
        'break' => 2
    ];

    /** @var array default message when any error occurs  */
    private array $onError = [];

    /** @var array when defined is used for custom messages  */
    private array $onNotice = [];

    /** @var array overrides default fatal error message  */
    private array $onFatal = [];

    /** @var array default message when an argument validation fails  */
    private array $argumentsEvent = [];

    /**
     * optional
     *
     * @param string $type optional [default|fatal]
     * @param string $message
     * @return GhostCliMsg
     */
    function set_message(string $type, string $message) : GhostCliMsg {
        if($type === 'fatal') {
            $this->fatal_message = $message;
        }elseif($type === 'default') {
            $this->default_message = $message;
        }
        return $this;
    }

    /**
     * Returns true if fatal error occurs
     *
     * @return boolean
     */
    public function isFatal() : bool {
        return $this->proxy->fatal;
    }

    /**
     * Returns true if any application-triggered error exists (i.e warning or fatal errors)
     *
     * @return boolean
     */
    public function error_exists() : bool {
        return $this->proxy->error_exists();
    }

    /**
     * Set default error message
     *   - Note: If fatal error message is not defined, this message will be assumed as the default fatal error message.
     * @param string $title
     *   - When set as true, enables default error message display.
     * @param string $message
     * @param integer $indent
     * @param string $color
     * @return void
     */
    function onError(string|bool $title, string $message, int $indent = 0, string $color = 'danger|black') : void {  
        if($title === true){
            $this->onError = $this->onErrorDefault;
        }elseif(is_string($title)){
            if($title) $title = " $title ";
            $data = compact('title','message','indent', 'color');
            $this->onError = $data;
        }
    }

    /**
     * Sets fatal error message which overrides a default message when an error occurs
     *
     * @param string $title
     * @param string $message
     * @param integer $indent
     * @param string $color
     * @return void
     */
    function onFatal(string $title, string $message, int $indent = 0, string $color = 'danger|black') : void {
        if($title) $title = " $title ";
        $data = compact('title','message','indent', 'color');
        $this->onFatal = $data;
    }

    /**
     * Sets custom error message
     *
     * @param string $title
     * @param string $message
     * @param integer $indent
     * @param string $color
     * @return void
     */
    function onNotice(string $title, string $message, int $indent = 0, string $color = 'danger|black') : void {
        if($title) $title = " $title ";
        $data = compact('title','message','indent', 'color');
        $this->onNotice = $data;
    }

    /**
     * Sets custom error message
     *
     * @param string $message
     * @param integer $indent
     * @param string $color
     * @return void
     */
    function onInfo(string $message, int $indent = 0, string $color = 'danger|black') : void {
        $data = compact('message','indent', 'color');
        $data['title'] = ' Info ';
        $this->onNotice = $data;
    }

    /**
     * Sets custom error message
     *
     * @param closure $callback recieves {@see GhostCliFinal} object.
     * @return void
     */
    function onFinal(Closure $callback, string $type = 'before', bool $exit = false) : void {
        if($type === 'before') {
            GhostProxy::new([], fn(GhostDraft $draft) => new class($draft) extends GhostCliFinal{});
            $callback(GhostProxy::object());
            Cli::break();
        }
        if($type === 'after') HandleCliErrors::final($callback);
        if($exit) exit;
    }

    /**
     * Disables response message depending to type
     *
     * @param boolean $mode optional [true|false|'default'|'fatal']
     *  - boolean(true|false) : Enables or disables all error 
     *  - string 'default' : disables last custom error info  display
     *  - string 'fatal' : disables last fatal error info display
     */
    function disabled(bool|string $mode = true) : void {
        if(!in_array($mode, ['default','fatal', true, false], true)) return;
        $this->disabled = $mode;
    }

    /**
     * Checks if message logging is disabled either for fatal, default or both errors.
     *
     * @param boolean|string|null|null $disabled
     *  - Retrieve disabled status by reference which can be boolean or string (fatal|default) depending on the type of error disabled.
     * @return boolean
     */
    public function isDisabled(bool|string|null &$disabled = null) : bool {
        $disabled = $this->disabled;
        return $disabled;
    }

    /**
     * Resolve the display of CLI messages..
     *
     * @return void
     */
    public function execute() {

        $this->isExecuted = true;

        $properties = $this->proxy->ghosts('properties');

        $isFatal = in_array('fatal', $properties) ? $this->proxy->fatal : false;

        $isFatalDisabled = in_array($this->disabled, [true,'fatal'], true);
        $isErrorDisabled = in_array($this->disabled, [true,'default'], true); 
        $isAllDisabled = $this->disabled === true; 

        if(($isAllDisabled) || ($isFatal && $isFatalDisabled) || (!$isFatal && $isErrorDisabled)) {
            Cli::isTerminal('windows')? Cli::moveUp(1) : ''; // move cursor up to hide error message for windows terminal
            return;
        }

        if($isFatal){
            $error = $this->onFatal ?: $this->onError ?: $this->onFatalDefault;
            $error['title'] = ' '.trim($error['title']).' ';
            $error['break'] = Cli::isTerminal(['linux','wt'])? 2 : 1;
            Cli::infoView(...$error);
        }else if($this->error_exists() && $this->onError){
            $error = $this->onError;
            $error['title'] = ' '.trim($error['title']).' ';
            $error['break'] = 2;
            Cli::infoView(...$error);
        }else if($this->argumentsEvent){
            foreach($this->argumentsEvent as $argumentEvent){
                $notice = $argumentEvent;
                $notice['title'] = ' '.trim($notice['title']).' ';
                $notice['break'] = 2;
                $exit = $notice['exit'] ?? false;
                unset($notice['exit']);
                Cli::infoView(...$notice);
                Cli::moveUp();
                exit;
            } 
        }else if($this->onNotice) {
            $notice = $this->onNotice;
            $notice['title'] = ' '.trim($notice['title']).' ';
            $notice['break'] = 2;
            Cli::infoView(...$notice);
        }

    }

    /**
     * Returns TRUE only after the {@see GhostCliMsg::execute()} function has been called at least once.
     *
     * @return boolean
     */
    function isExecuted() : bool {
        return $this->isExecuted;
    }
    /**
     * Executes a callback function which recieves the total amount of time required to execute a command
     *
     * @return void
     */
    function loadTime(string $id, Closure $callback) {
        $time = CliRuntime::duration($id);
        $callback($time);
    }

    public function ghostInit() : void {
         $this->argumentsEvent = [];
    }

}