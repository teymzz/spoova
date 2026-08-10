<?php

namespace spoova\mi\core\commands\Root\Cli;

use spoova\mi\core\classes\Ghost\GhostClass;

abstract class CliPrompter extends GhostClass {

    /**
     * Checks if the number of trials is within the range of specified maximum number of trials. 
     * 
     * @uses CliPrompter::active()
     */
    public bool $active = false;

    /**
     * Checks if the number of trials is NOT within the range of specified maximum number of trials. 
     * 
     * @uses CliPrompter::inactive()
     */
    public bool $inactive = false;

    /**
     * Returns the current value typed into CLI prompt
     *
     * @return string|null
     */
    public function value(): string|null {
        return $this->proxy->value();
    }

    /**
     * Returns the current value typed into CLI prompt.
     *  - Alias to {@see CLIPrompter::value()}
     * @return string|null
     * @uses CliPrompter::value()
     */
    public function i(): string|null {
        return $this->proxy->value();
    }

    /**
     * Returns the current value typed into CLI prompt.
     *  - Alias to {@see CLIPrompter::value()}
     * @return string|null
     * @uses CliPrompter::value()
     */
    public function input(): string|null {
        return $this->proxy->value();
    }

    /**
     * Returns the options defined for prompt
     *
     * @return array
     */
    public function options(){
        return $this->proxy->options();
    }

    /**
     * Returns the total number of attempts made or detects when input attempts are within range.
     * @param string $option optional [in-range]
     *  - in-range returns TRUE or FALSE if the number of trials made is within the range of accepted numbers of input attempts.
     * @return int
     */
    public function trials(string $option = '') : int|bool {
        return $this->proxy->trials($option);
    }

    /**
     * Always returns a false value
     * 
     * @uses {@see CliPrompter::trials()}
     */
    public function active() : false {
        return false;
    }

    /**
     * Always returns a true value 
     * 
     * @uses {@see CliPrompter::trials()}
     */
    public function inactive() : bool {
        return true;
    }

    /**
     * Checks if the entered input matches the specified options. 
     * 
     */
    public function matches(array|string|null $options = null) : bool {
        
        return $this->proxy->matches($options);

    }

    /**
     * Checks if the entered input matches the specified options using case-insensitive format
     */
    public function imatches(array|string|null $options = null) : bool {
        
        return $this->proxy->imatches($options);

    }

    /**
     * Detects when the input supplied is invalid
     *
     * @return boolean TRUE only if input supplied is not within the range of options supplied to the prompt
     */
    public function invalid(): bool {
        return !$this->proxy->valid();
    }

    /**
     * Alias of the {@see CliPrompter::invalid()} method. This method is designed to provide a more intuitive syntax when validating user input.
     * Detects when the input supplied is invalid
     *
     * @return boolean TRUE only if input supplied is not within the range of options supplied to the prompt
     * @uses CliPrompter::invalid()
     */
    public function illegal(): bool {
        return $this->invalid();
    }

    /**
     * Detects when the input supplied is valid
     *
     * @return boolean TRUE only if input supplied is legal and within the range of options supplied to the prompt
     */
    public function valid(): bool {
        return $this->proxy->valid();
    }

    /**
     * Alias of the {@see CliPrompter::valid()} method. This method is designed to provide a more intuitive syntax when validating user input.
     * Detects when the input supplied is valid
     *
     * @return boolean TRUE only if input supplied is legal and within the range of options supplied to the prompt
     * @uses CliPrompter::valid()
     */
    public function legal(): bool {
        return $this->valid();
    }

    /**
     * Detects when the maximum number of trials was reached
     *
     * @return int|false $input
     */
    public function maximum(): int|false {
        return $this->proxy->maximum();
    }

    public function ghostInit() : void {
        $this->active = $this->active();
    }

    public function __toString()
    {
        return $this->value();
    }
};