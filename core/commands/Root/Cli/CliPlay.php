<?php

namespace spoova\mi\core\commands\Root\Cli;

use spoova\mi\core\classes\Ghost\GhostClass;
use spoova\mi\core\commands\Root\Cli;

abstract class CliPlay extends GhostClass {

    /**
     * Returns the currently unpolluted text typed into {@see Cli::play()}
     *
     * @return string
     */
    public function text(): string {
        return $this->proxy->text;
    }

    /**
     * Stop a currently played animation
     *
     * @param boolean|string|null $message
     *  - TRUE clears line and prints existing message 
     *  - FALSE clears line and prints no message 
     *  - NULL does not clear line and prints no message 
     *  - String clears line and prints specified message
     * @param int $pause pause in seconds
     * @return CliPlay
     */
    public function stop(bool|string|null $message = true, int $pause = 0) : CliPlay {
        if($message !== null) { Cli::clearLine(); }
        if($message === true){ print Cli::playedText();}
        elseif(is_string($message)) print $message;
        if($pause) Cli::pause($pause);
        return $this;
    }

    /**
     * Switch animation type
     * 
     * @param string $anime [normal|percent|dotted|dotbar|roller|arrows|timer|circle|angles|steps|braill]
     * @param string $char default character for percentages
     * @return void
     */
    public function switchTo(string $anime, string $char = ''){
        Cli::animeType($anime?? 'normal', $char);
    }

    /**
     * Delay in seconds
     * alias for wait()
     *
     * @param integer $seconds
     * @return CliPlay
     */
    public function pause(int $seconds) : CliPlay {
        Cli::pause($seconds);
        return $this;
    }
 
    /**
     * Delay in milliseconds
     *
     * @param integer $milliseconds
     * @return CliPlay
     */
    public function wait(int $milliseconds) : CliPlay {
        Cli::wait($milliseconds);
        return $this;
    }
 
    /**
     * Apply backspace character
     *
     * @param integer $times number of times to apply backspaces
     * @return CliPlay
     */
    public function backspace(int $times = 0) : CliPlay {
        if($times) Cli::backspace($times);
        return $this;
    }



    public function __toString()
    {
        return $this->text();
    }
};