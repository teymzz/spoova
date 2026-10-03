<?php

namespace spoova\mi\core\commands\Root\Cli\GhostCli;

use Closure;
use Exception;
use Override;
use spoova\mi\core\classes\ErrorHandlers\GhostCliMsg;
use spoova\mi\core\classes\Ghost\GhostClass;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\classes\Ghost\GhostProxy;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\GhostCli\GhostCliLocker;
use spoova\mi\core\commands\Root\Cli\GhostCli\Interface\GhostCliLockerInterface;
use spoova\mi\core\commands\Root\Cli\GhostCli\Interface\GhostCliMsgInterface;

abstract class GhostCliPolicy extends GhostClass implements GhostCliLockerInterface, GhostCliMsgInterface {

    private $arguments_policy = [];
    private $response_policy = [];

    private static array $args;

    /**
     * Runs a callback triggered for 
     *
     * @param Closure $callback Receives {@see GhostCliLocker}
     * @return void
     */
    static function entry(Closure $callback){

            $Ghost = new GhostFunction(['args']);
            $Ghost->args(fn()=>self::$args);
            $callback(GhostProxy::new($Ghost, fn(GhostDraft $draft) => new class($draft) extends GhostCliLocker{}));

    }

    static function exit(Closure $callback){
            return Cli::response(false, $callback); 
    }

    public function onEmptyArguments(string $message, string $title='Error'){
        $this->arguments_policy['onEmptyArguments'] =  func_get_args();
    }

    public function onMissingArguments(array|string $args, string $message, string $title='Error'){
        $this->arguments_policy['onMissingArguments'] = func_get_args();
    }

    public function onBreakArguments(array|string $args, string|Closure $message, string $title='Error'){
        $this->arguments_policy['onBreakArguments'] = func_get_args();
    }

    public function onBelowArguments(int $limit, string $message, string $title='Error'){
        $this->arguments_policy['onBelowArguments'] = func_get_args();
    }

    public function onAboveArguments(int $limit, string $message, string $title='Error'){
        $this->arguments_policy['onAboveArguments'] = func_get_args();
    }

    public function onTotalArguments(int $limit, string $message, string $title='Error'){
        $this->arguments_policy['onTotalArguments'] = func_get_args();
    }

    public function onFlagArguments(array $options, string $message, string $title='Error'){
        $this->arguments_policy['onFlagArguments'] = func_get_args();
    }

    /* response policies : handles messages displayed before a terminal command's process exits */
    public function onError(string|bool $title, string $message, int $indent = 0, string $color = 'danger|black') : void {
        $this->response_policy['onError'] = func_get_args();
    }

    function onFatal(string $title, string $message, int $indent = 0, string $color = 'danger|black') : void {
        $this->response_policy['onFatal'] = func_get_args();
    }

    function onNotice(string $title, string $message, int $indent = 0, string $color = 'danger|black') : void {
        $this->response_policy['onNotice'] = func_get_args();
    }

    function onInfo(string $message, int $indent = 0, string $color = 'danger|black') : void {
        $this->response_policy['onInfo'] = func_get_args();
    }

    /**
     * Returns the name of initialization time created by {@see Cli::policy()}.
     *
     * @return string
     */
    function iniTime() : string {
       return $this->proxy->iniTime();
    }
    /**
     * Set a final response message applied through {@see Cli::response()} method.
     *
     * @param Closure $callback callback that takes GhostCliFinal object
     * @param string $type
     * @param boolean $exit
     * @return void
     */
    function onFinal(Closure $callback, string $type = 'before', bool $exit = false) : void {
        $this->response_policy['onFinal'] = func_get_args();
    }

    public function execute(){
        $approved = $this->proxy->policyGuard();
        if($approved){

            // apply entry arguments policy 
            if($policies = $this->arguments_policy){
                $Ghost = new GhostFunction(['args']);
                $Ghost->args(fn()=>self::$args);
                $apply = GhostProxy::new($Ghost, fn(GhostDraft $draft) => new class($draft) extends GhostCliLocker{});
                
                foreach ($policies as $policy => $value) {
                    $apply->$policy(...$value);
                }
            }

            // apply entry response policy 
            if($policies = $this->response_policy){
                Cli::response(false, function(GhostCliMsg $msg) use($policies){
                    foreach ($policies as $policy => $value) {
                        $msg->$policy(...$value); // uses GhostCliMsg
                    }
                });
            }


        }else{
            throw new Exception('trying to execute cli policy anonymously');
        }
    }

    #[Override]
    public function ghostInit(): void
    {
        parent::ghostInit();
        self::$args = $this->proxy->args();
    }

}