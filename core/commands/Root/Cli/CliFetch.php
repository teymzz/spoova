<?php 

namespace spoova\mi\core\commands\Root\Cli;

use Closure;
use Exception;
use spoova\mi\core\classes\Ghost\GhostClass;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostProxy;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\commands\Root\Cli\CliKey;
use spoova\mi\core\commands\Root\Cli\CliProcess;

/**
 * This abstract class contains method callable from 
 * the {@see CliInput::fetch()} closure argument.
 */
abstract class CliFetch extends GhostClass {

    /**
     * This executes the callback function when the CLI input reading process is terminated 
     * through any of the {@see CliKey::EXIT_SIGNALS} signals
     *
     * @param Closure $callback a callback closure(CliProcess $process) argument.
     * @return mixed from callback
     */
    public function onCancel(Closure $callback) {
        $key = $this->proxy->ghostData('key');
        if($key instanceof CliKey){
            $this->setProcess($key);
            return $key->inSignals(CliKey::EXIT_SIGNALS)? $callback(GhostProxy::object()) : '';
        }
    }

    /**
     * This executes the callback function when the CLI input reading process is terminated 
     * through CTRL+C (or SIGINT) signal
     *
     * @param Closure $callback a callback closure(CliProcess $process) argument.
     * @return mixed from callback
     */
    public function onInterrupt(Closure $callback) {
        $key = $this->proxy->ghostData('key');
        if($key instanceof CliKey){
            $this->setProcess($key);
            return $key->isSignal(SIGINT)? $callback(GhostProxy::object()) : '';
        }
    }

    /**
     * This executes the callback function when the CLI input reading process is terminated 
     * only through CTRL+\ (or SIGQUIT/SIGTERM) signals
     *
     * @param Closure $callback a callback closure(CliProcess $process) argument.
     * @return mixed from callback
     */
    public function onQuit(Closure $callback) {
        $key = $this->proxy->ghostData('key');

        if($key instanceof CliKey){
            $this->setProcess($key);
            return $key->inSignals([SIGQUIT,SIGTERM])? $callback(GhostProxy::object()) : '';
        }
    }

    /**
     * This executes the callback function when the CLI input reading process is terminated 
     * only through CTRL+Z (or SIGTSTP) signals
     *
     * @param Closure $callback a callback closure(CliProcess $process) argument.
     * @return mixed from callback
     */
    public function onEnded(Closure $callback) {
        $key = $this->proxy->ghostData('key');

        if($key instanceof CliKey){
            $this->setProcess($key);
            return $key->inSignals([SIGTSTP])? $callback(GhostProxy::object()) : '';
        }
    }

    /**
     * This executes the callback function when the CLI input reading process is terminated 
     * when terminal closed or hanged up (SIGHUP) signal
     *
     * @param Closure $callback a callback closure(CliProcess $process) argument.
     * @return mixed from callback
     */
    public function onHangUp(Closure $callback) {
        $key = $this->proxy->ghostData('key');

        if($key instanceof CliKey){
            $this->setProcess($key);
            return $key->isSignal(SIGHUP)? $callback(GhostProxy::object()) : '';
        }
    }

    /**
     * This executes the callback function when program is aborted with (SIGABRT) signal
     *
     * @param Closure $callback a callback closure(CliProcess $process) argument.
     * @return mixed from callback
     */
    public function onAbort(Closure $callback) {
        $key = $this->proxy->ghostData('key');

        if($key instanceof CliKey){
            $this->setProcess($key);
            return $key->isSignal(SIGABRT)? $callback(GhostProxy::object()) : '';
        }
    }

    /**
     * This executes the callback function when program is aborted with CTRL+Z or (SIGTSTP) signal
     *
     * @param Closure $callback a callback closure(CliProcess $process) argument. 
     * @return mixed from callback
     */
    public function onSuspend(Closure $callback) {

        $key = $this->proxy->ghostData('key');

        if($key instanceof CliKey){
            
            $this->setProcess($key);

            //Note: restore terminal first here....
            if($key->isSignal(SIGTSTP)){
               return $callback(GhostProxy::object());
                //Note: restore terminal after here....
            }
        }
    }

    /**
     * This executes the callback function when program is resumed (SIGCONT) signal
     *
     * @param Closure $callback a callback closure(CliProcess $process) argument.
     * @return mixed from callback
     */
    public function onResume(Closure $callback) {

        $key = $this->proxy->ghostData('key');

        if($key instanceof CliKey){
            
            $this->setProcess($key);

            //Note: restore terminal first here....
            if($key->isSignal(SIGCONT)){
               return $callback(GhostProxy::object());
                //Note: restore terminal after here....
            }
        }
    }

    /**
     * This executes the callback function when any of the signals SIGSEGV or SIGBUS is received. 
     *   - SIGSEGV : Segmentation fault
     *   - SIGSBUS : Bad memory access
     *
     * @param Closure $callback a callback closure(CliProcess $process) argument.
     * @param int|int $type optional [SIGBUS,SIGSEGV] or both.
     * @return mixed from callback
     */
    public function onCrash(Closure $callback, int|array $type) {

        $key = $this->proxy->ghostData('key');

        if($key instanceof CliKey){

            $this->setProcess($key);

            $types = is_array($type)? $type : [$type];
            foreach($types as $type){
                if(!in_array($type, [SIGBUS, SIGSEGV])) throw new Exception('invalid type specified');
            }
            //Note: restore terminal first here....
            if($key->isSignal($type)){
               return $callback(GhostProxy::object());
                //Note: restore terminal after here....
            }
        }
    }

    /**
     * This executes the callback function when an illgal instruction (or SIGKILL) signal is received.
     *
     * @param Closure $callback a callback closure(CliProcess $process) argument.
     * @return mixed from callback
     */
    public function onIllegal(Closure $callback) {
        //Create a new Ghost process 
        $key = $this->proxy->ghostData('key');

        if($key instanceof CliKey){
            $this->setProcess($key);
            if($key->isSignal(SIGKILL)){
               return $callback(GhostProxy::object());
            }
        }
    }

    /**
     * This executes the callback function when the CLI terminal is redrawn
     *
     * @param Closure $callback a callback closure(CliProcess $process) argument.
     * @return mixed from callback
     */
    public function onResize(Closure $callback) {
        //Create a new Ghost process 
        $key = $this->proxy->ghostData('key');

        $this->setProcess($key);

        return $key->isSignal(SIGWINCH)? $callback(GhostProxy::object()) : '';
    }

    /**
     * This executes the callback function when a divide by zero (or SIGFPE) signal is received.
     *
     * @param Closure $callback a callback closure(CliProcess $process) argument.
     * @return mixed from callback
     */
    public function onMathError(Closure $callback) {
        $key = $this->proxy->ghostData('key');
        $buffer = $this->proxy->ghostData('buffer');
        if($key instanceof CliKey){
            if($key->isSignal(SIGFPE)){
               return $callback(GhostProxy::object());
            }
        }
    }

    /**
     * This executes the callback function when a Sheduled task signal (or SIGALRM) signal is received.
     *
     * @param Closure $callback a callback closure(CliProcess $process) argument.
     * @return mixed from callback
     */
    public function onTimer(Closure $callback) {
        $key = $this->proxy->ghostData('key');
        $buffer = $this->proxy->ghostData('buffer');
        if($key instanceof CliKey){
            if($key->isSignal(SIGALRM)){
               return $callback(GhostProxy::object());
            }
        }
    }

    /**
     * This executes the callback function when a Sheduled task signal (or SIGVTALRM) signal is received.
     *
     * @param Closure $callback a callback closure(CliProcess $process) argument.
     * @return mixed from callback
     */
    public function onVTimer(Closure $callback) {
        $key = $this->proxy->ghostData('key');
        $buffer = $this->proxy->ghostData('buffer');
        if($key instanceof CliKey){
            if($key->isSignal(SIGVTALRM)){
                return $callback(GhostProxy::object());
            }
        }
    }

    /**
     * This executes the callback function when a profiler (or SIGPROF) signal is received.
     *
     * @param Closure $callback a callback closure(CliProcess $process) argument.
     * @return mixed from callback
     */
    public function onProfilerTick(Closure $callback) {
        $key = $this->proxy->ghostData('key');
        $buffer = $this->proxy->ghostData('buffer');
        if($key instanceof CliKey){
            if($key->isSignal(SIGPROF)){
               return $callback(GhostProxy::object());
            }
        }
    }

    
    /**
     * This executes the callback function when any of the event signals SIGUSR1 or SIGUSR2 is received.
     *
     * @param Closure $callback a callback closure(CliProcess $process) argument.
     * @param int|int $type optional [SIGUSR1,SIGUSR2] or both.
     * @return mixed from callback
     */
    public function onUserEvent(Closure $callback, int|array $event) {
        $key = $this->proxy->ghostData('key');
        $buffer = $this->proxy->ghostData('buffer');
        if($key instanceof CliKey){
            $events = is_array($event)? $event : [$event];
            foreach($events as $event){
                if(!in_array($events, [SIGUSR1, SIGUSR2])) throw new Exception('invalid type specified');
            }
            if($key->inSignals($events)){
               return $callback(GhostProxy::object());
            }
        }
    }
    
    /**
     * This executes the callback function when any of the supported signals is received.
     *
     * @param int|int $signal supported signals [SIGUSR1,SIGUSR2] or both.
     * @param Closure $callback a callback closure(CliProcess $process) argument.
     * @return mixed from callback
     */
    public function onSignal(int|array $signal, Closure $callback) {
        $key = $this->proxy->ghostData('key');
        $buffer = $this->proxy->ghostData('buffer');
        if($key instanceof CliKey){
            $signals = is_array($signal)? $signal : [$signal];
            if($key->inSignals($signals)){
               return $callback(GhostProxy::object());
            }
        }
    }

    /**
     * This is used to test for signals
     *
     * @param int|int $signal supported signals [SIGUSR1,SIGUSR2] or both.
     */
    public function isSignal(int|array $signal) : bool {
        $key = $this->proxy->ghostData('key');
        if($key instanceof CliKey){
            $signal = is_array($signal)? $signal : [$signal];
            return $key->inSignals($signal);
        }
        return false;
    }

    /**
     * This returns the received signal
     *
     * @param Closure $callback callback a callback closure(CliProcess $process) argument triggered when writing
     */
    public function onWrite(Closure $callback) : bool {
        $key = $this->proxy->ghostData('key');
        $buffer = $this->proxy->ghostData('buffer');
        if($key instanceof CliKey){
            if($key->isWritable()){
                $callback(GhostProxy::object());
            }
        }
        return false;
    }

    // /**
    //  * This returns the received signal
    //  *
    //  * @param int|int $signal supported signals [SIGUSR1,SIGUSR2] or both.
    //  */
    // public function signal() : int|false {
    //     $key = $this->proxy->ghostData('key');
    //     if($key instanceof CliKey){
    //         return $key->signal;
    //     }
    //     return false;
    // }

    private function setProcess(CliKey $key){
        $buffer = $this->proxy->ghostData('buffer');
        
        //Create a new Ghost process 
        $key; $buffer;
        $Ghost = new GhostFunction(['ghostData']);
        GhostProxy::new($Ghost, fn(GhostDraft $draft) => new class($draft) extends CliProcess{});
        $Ghost->ghostData(function($val) use($key, $buffer) {
            if(in_array($val, ['key','buffer'])){
                return $$val;
            }
            throw new Exception("invalid value $".$val." is not available");
        });
    }

}