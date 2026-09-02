<?php

namespace spoova\mi\core\commands\Root\Cli;

use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\classes\Ghost\GhostProxy;
use spoova\mi\core\commands\Root\Cli;

abstract class CliAutoSignals {
  
    private static array $signals = [];
  
    public function __construct(protected GhostDraft $get, protected ?GhostFunction $proxy = null)
    {
        $this->proxy = GhostProxy::map($this->get->id(), fn() => $this->get->ghost());
    }


    /**
     * This method is used to apply the default auto interruption signals for {@see Cli::input()} method.
     *  - This method is automatically called within {@see Cli::input()} method. 
     *  - If you wish to customize the interruption signals, you can call this method
     *    within your callback function passed to {@see Cli::input()} method.
     *  - By default, the following signals are applied: SIGINT, SIGTERM, SIGTSTP.
     * @param array|boolean $signals interruption signals to apply
     * @return void
     */
    public function applyInterruption(array|bool $signals = [SIGINT, SIGTERM, SIGTSTP]) {

        $input = $this->proxy->ghostData('input');
        $callback = $this->proxy->ghostData('callback');

        if($signals === [] || $signals === false) return;
        if($signals === true) {
          if($callback) $callback(new CliKey(false, $input, true));
          ($input->close)();
        }else{
            Cli::useSignals($signals, function($signal) use($input, $callback) {
                  if($callback) $callback(new CliKey($signal, $input, true));
                  ($input->close)();
            });
        }


    }
    
    // /**
    //  * Handle registered signals
    //  */
    // public static function handleSignal($signal) {
    //   switch($signal) {
    //     case SIGINT:
    //     case SIGTERM:
    //     case SIGTSTP:
    //       Cli::textPlain("\nSignal received: " . self::signalName($signal) . ". Exiting...\n");
    //       exit(0);
    //       break;
    //   }
    // }
    
    // /**
    //  * Get signal name from signal number
    //  */
    // private static function signalName($signal) {
    //   return match($signal) {
    //     SIGINT => 'SIGINT',
    //     SIGTERM => 'SIGTERM',
    //     SIGTSTP => 'SIGTSTP',
    //     default => 'UNKNOWN',
    //   };
    // }
}   