<?php 

namespace spoova\mi\core\commands\Root\Cli\CliForms;

use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliForms;
use spoova\mi\core\commands\Root\Cli\CliKey;

/**
 * This class is used for handling form termination or submission
 */
class CliTransmit {
    
    /** @var CliKey */
    private ?CliKey $key = null;
    private string|array $message = '';

    /**
     * @param CliKey $key
     * @param string $message
     */
    function __construct(CliKey $key, $message)
    {
        $this->key = $key;
        $this->message = $message;
    }

    /**
     * Returns true if CLI is exited with any of the signals (SIGINT,SIGTERM,SIGHUP,SIGQUIT)
     *
     * @param CliKey $key
     * @return boolean
     */
    function isTerminated(){

        return $this->key->isExit();

    }

    /**
     * Returns true if ENTER key is pressed.
     *  - Alternative method is {@see CliTransmit::isSubmitted()}
     * @param CliKey $key
     * @return boolean
     */
    function isTransmitted() : bool {

        return $this->key->isEnter();

    }

    /**
     * Alias of {@see CliTransmit::isTransmitted()}. 
     *  - Returns true if ENTER key is pressed.
     *
     * @param CliKey $key
     * @return boolean
     */
    function isSubmitted() : bool {

        return $this->key->isEnter();

    }

    /**
     * Terminates the current input streaming and returns the response message
     *
     * @param boolean $clearForm determines if form is cleared after exit or submission
     * @return array|string message received.
     */
    function message(bool $clearForm = false) : array|string {
        if($clearForm){
            Cli::clearUp(CliForms::lines());
            echo CliForms::lines();
        }
        $this->key->exit();
        return $this->message;
    }

}