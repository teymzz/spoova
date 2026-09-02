<?php

namespace spoova\mi\core\commands\Root\Cli;

use Closure;
use Error;
use spoova\mi\core\classes\Bundle\Arr\Arr;
use spoova\mi\core\classes\Ghost\GhostClass;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\classes\Ghost\GhostProxy;
use spoova\mi\core\commands\Root\Cli;

abstract class CliList extends GhostClass {

    /**
     * Returns the {@see Cli::List()} current array key
     *
     * @return string
     */
    public function key() : string {
        return $this->proxy->key;
    }

    /**
     * Returns a numerical key {@see Cli::List()} for items in an array
     *
     * @return string
     */
    public function sn() : string {
        $key = $this->proxy->index;
        return is_numeric($key)? $key + 1 : $key;
    }

    /**
     * Returns the {@see Cli::List()} current array value
     *
     * @return string
     */
    public function val() : string {
        return $this->proxy->value;
    }
    /**
     * Alias to {@see CliList::val()}
     *
     * @return string
     */
    public function value(): string{
        return $this->proxy->value;
    }

    /**
     * View a list
     *
     * @param string $key
     * @param string $value
     * @param string|null $indent 
     *  If NULL, assumes the default value from parent method {@see Cli::List()}
     * @param string|null $break 
     *  If NULL, assumes the default value from parent method {@see Cli::List()}
     * @param string|null $pause 
     *  If NULL, assumes the default value from parent method {@see Cli::List()}
     * @return void
     */
    public function view(string $key, string $value, ?string $indent = null, ?string $break = null, ?string $pause = null){
        if($indent === null) $indent = $this->proxy->indent;
        if($break === null) $break = $this->proxy->break;
        if($pause === null) $pause = $this->proxy->pause;
        return Cli::textView(($key+1).' '.$value, $indent, $break, $pause);
    }

}