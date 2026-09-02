<?php

namespace spoova\mi\core\commands\Root\Cli;

use spoova\mi\core\classes\Ghost\GhostClass;

abstract class CliPrompt extends GhostClass {

    /**
     * Checks if the number of trials is within the range of specified maximum number of trials. 
     * 
     * @uses CliPrompt::active()
     */
    public bool $active = false;

    /**
     * Checks if the number of trials is NOT within the range of specified maximum number of trials. 
     * 
     * @uses CliPrompt::inactive()
     */
    public bool $inactive = false;

    public function query(string $text, bool $looped = true){
        if($this->active()) {
          if(($looped === false) && !$this->trials()) $looped = true;
          if($looped && !$this->maximum())  print $text;
        }
    }

    /**
     * Returns the current value typed into CLI prompt
     *
     * @return string|null
     */
    public function value(): string|null {
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
     * This method always returns the boolean value supplied. It is designed to be used 
     * only when {@see Cli::prompt()} has no maximum number of trials defined.
     * 
     * @param boolean $bool TRUE continues the prompt while FALSE terminates the prompt.
     * 
     * @return bool TRUE
     */
    public function continue(bool $bool= true) : bool {
        return $bool;
    }

    /**
     * Checks if the number of trials is within the range of specified maximum number of trials. 
     * 
     * @uses {@see CliPrompt::trials()}
     */
    public function active() : bool {
        return $this->proxy->trials('active');
    }

    /**
     * Checks if the number of trials is NOT within the range of specified maximum number of trials. 
     * 
     * @uses {@see CliPrompt::trials()}
     */
    public function inactive() : bool {
        return !$this->active();
    }

    /**
     * Checks if the entered input matches the specified options. 
     * 
     */
    public function matches(array|string|null $options = null) : bool {
        if($options === null) return false;
        $input = $this->proxy->value();
        $options = $options ?? $this->options();

        //convert options to array if it is a string
        if($options != null && is_string($options)) $options = [$options];

        if($this->proxy->is_case_sensitive()) {
            return in_array($input, $options);
        } else {
            return in_array(strtolower($input), array_map('strtolower', $options));
        }
    }

    /**
     * Checks if the entered input matches the specified options. 
     * 
     */
    public function imatches(array|string|null $options = null) : bool {

        if($options === null) return false;
        $input = $this->proxy->value();
        $options = $options ?? $this->options();

        //convert options to array if it is a string
        if(is_string($options)) $options = [$options];
        
        return in_array(strtolower($input), array_map('strtolower', $options));
    }

    /**
     * Returns the total count state of the cli prompt
     * @param string $option optional [in-range]
     *  - in-range returns TRUE or FALSE if the number of trials made is within the range of accepted numbers of input attempts.
     * @return int
     */
    public function state(string $option = '') : int|bool {
        return $this->proxy->state($option);
    }

    /**
     * Detects the termination mode of the prompt
     *
     * @return int|boolean $input
     *  - Integer is returned corresponding to the number of trials accepted
     *  - Boolean of TRUE is returned if automatic termination is defined.
     */
    public function terminate(): int|bool{
        return $this->proxy->terminate();
    }

    /**
     * Detects when the input supplied is invalid
     *
     * @return boolean TRUE only if input supplied is not within the range of options supplied to the prompt
     */
    public function invalid(): bool {
        return $this->proxy->invalid();
    }

    /**
     * Alias of the {@see CliPrompt::invalid()} method. This method is designed to provide a more intuitive syntax when validating user input.
     * Detects when the input supplied is invalid
     *
     * @return boolean TRUE only if input supplied is not within the range of options supplied to the prompt
     * @uses CliPrompt::invalid()
     */
    public function illegal(): bool {
        return $this->proxy->invalid();
    }

    /**
     * Detects when the input supplied is valid
     *
     * @return boolean TRUE only if input supplied is legal and within the range of options supplied to the prompt
     * @uses CliPrompt::invalid()
     */
    public function valid(): bool {
        return !$this->proxy->invalid();
    }

    /**
     * Alias of the {@see CliPrompt::valid()} method. This method is designed to provide a more intuitive syntax when validating user input.
     * Detects when the input supplied is valid
     *
     * @return boolean TRUE only if input supplied is legal and within the range of options supplied to the prompt
     * @uses CliPrompt::valid()
     */
    public function legal(): bool {
        return $this->proxy->valid();
    }

    /**
     * Detects if the maximum number of failed input attempts have been reached.
     *
     * @return int|false $input
     */
    public function maximum(): int|false {
        return $this->proxy->maximum();
    }

    /**
     * Detects if the maximum number of failed input attempts have been currently reached.
     *
     * @return boolean
     */
    public function exceeded(){
        return $this->proxy->exceeded();
    }

    public function ghostInit() : void {
        $this->active = $this->active();
        $this->inactive = $this->inactive();
    }

    public function __toString()
    {
        return $this->value();
    }
};