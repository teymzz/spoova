<?php

namespace spoova\mi\core\commands\Root\Cli;

use Closure;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\classes\Ghost\GhostProxy;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\classes\Ghost\GhostClass;

abstract class CliQuery extends GhostClass {

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
     * Alias for {@see CliQuery::trials()}
     * @return int
     */
    public function count() : int {
        return $this->proxy->trials();
    }

    /**
     * Returns the total number of attempts made
     * @return int
     */
    public function trials() : int {
        return $this->proxy->trials();
    }

    /**
     * Case insensitive comparision between options acceptable and input supplied
     * 
     * @param string|array|null $options 
     *  - If $input is NULL (i.e not defined), the options will be automatically assumed default option.
     * @param bool $case_sensitive FALSE disables case-sensitivity. 
     * @return bool
     *  - TRUE : if the input value exists in the options supplied
     *  - FALSE : if the input value does not exist in the options supplied
     */
    public function matches(string|array|null $options = null, bool $case_sensitive = true) : bool {
        $input = $this->value(); 
        $options = $options ?? $this->options();
        if(!is_array($options)) $options = [$options];
        if(!$case_sensitive){
            $input = strtolower($input);
            $options = array_map(fn($val) => strtolower($val), $options);
        }
        return in_array($input, $options);
    }

    public function __toString()
    {
        return $this->value();
    }
}