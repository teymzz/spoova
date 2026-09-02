<?php

namespace spoova\mi\core\commands\Root\Cli;

use Closure;
use Error;
use spoova\mi\core\classes\Bundle\Arr\Arr;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\classes\Ghost\GhostProxy;
use spoova\mi\core\commands\Root\Cli;

abstract class CliPercent {

    /**
     * subject of the animation (i.e the CliPercent object).
     *
     * @var string
     */
    public string $subject;

    /**
     * percentage of the animation
     *
     * @var int
     */
    public int $percent;

    /**
     * next character in sequence 
     *
     * @var string
     */
    public string $chars;

    public function __construct(protected GhostDraft $get, protected ?GhostFunction $proxy = null)
    {
        $this->proxy = GhostProxy::map($this->get->id(), fn() => $this->get->ghost());
        $this->subject = $this->proxy->subject;
        $this->percent = $this->proxy->percent;
        $this->chars = $this->proxy->chars;
    }

    /**
     * Returns the subject message of the CliPercent object.
     *
     * @return string
     */
    public function subject() : string {
        return $this->proxy->subject();
    }

    /**
     * Returns the incremental percentage either as a string (e.g 10%) or an numerical integer (e.g 10)
     * @param string $type optional [string|integer]
     *  - ```string``` : returns value as string
     *  - ```integer``` : returns value as numerical integer
     * @return string|integer
     */
    public function percent(string $type = 'integer') : string|int {
        return $this->proxy->percent($type);
    }

    /**
     * Returns the total number of argument counts
     * @param array $type optional [default|text|state|length|max]
     *  - ```default``` : returns the exact character supplied as the first parameter of the CliPercent callback modifier.
     *  - ```clean``` : returns the exact clean character supplied as the first parameter of the CliPercent callback modifier (i.e with colors stripped off if any).
     *  - ```length``` : returns the incremental integer value used for multiplying the first character supplied
     *  - ```max``` : maximum number of characters available to be displayed
     *  - ```state``` :  returns the current character state
     * @return string
     */
    public function chars($type = 'state') : string {
        return $this->proxy->chars($type);
    }

}