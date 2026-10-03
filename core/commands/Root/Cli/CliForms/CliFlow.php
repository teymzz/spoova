<?php 

namespace spoova\mi\core\commands\Root\Cli\CliForms;

use Override;
use spoova\mi\core\classes\Ghost\GhostClass;
use spoova\mi\core\commands\Root\Cli\CliForms;
use stdClass;

abstract class CliFlow extends GhostClass{

    /**
     * Specifies input field border color
     *     - Preferrable to use terminal safe colors: alert, warn, danger, valid
     *     - Support current text color with "currentcolor" or "color"
     *     - Other color types works on terminal that supports true color e.g violet, #aa3939, rgb(66, 66, 192) 
     * @var string 
     */
    public $borderColor = '';

    /**
     * Specifies input field text color
     *     - Preferrable to use terminal safe colors: alert, warn, danger, valid
     *     - Other color types works on terminal that supports true color e.g violet, #aa3939, rgb(66, 66, 192) 
     * @var string
     */
    public $textColor = '';

    /**
     * Array list of input field's characters
     *
     * @var array
     */
    public ?array $chars = [];
    
    /**
     * Input field value's character length 
     *
     * @var int
     */
    public ?int $count = 0;

    /**
     * Input field's value
     *
     * @var string
     */
    public string|int $value = '';

    /**
     * Determines if an input value entry is further allowed
     *  - Can be used to restrict the maximum total number of characters' length allowed.
     * @var stdClass|null
     */
    private stdClass|null $advance = null;

    protected function ghostInit(): void {

        $this->borderColor = $this->proxy->ghostData('borderColor');
        $this->textColor = $this->proxy->ghostData('textColor');
        $this->count = $this->proxy->ghostData('count')?:0;
        $this->value = $this->proxy->ghostData('value')?:0;
        $this->chars = $this->proxy->ghostData('chars')?:[];

        $this->advance = $this->proxy->ghostData('advance');
        
    }

    /**
     * Check if 2 values matches case-insensitive
     *
     * @param string $value
     * @return boolean
     */
    public function imatches(string $value): bool {
            return strtolower($this->value) === strtolower($value);
    }

    /**
     * Check if input value matches test values matches case-sensitive
     *
     * @param string $value test value
     * @return boolean
     */
    public function matches(string $value): bool {
            return $this->value === $value;
    }

    /**
     * Set the text and border color of a flow field
     *
     * @param string $text text color
     * @param string|bool $border border color
     *      - True : inherits border color from color
     *      - False : does not inherits from color
     *      - String : specifies border color explicitly
     * @return void
     */
    public function color(string $text, string|bool $border = true): void {
            $this->textColor = $text; 
            if($border === true) {
                $this->borderColor = $text;
            }elseif($border){
                $this->borderColor = $border;
            }
    }

    /**
     * Applies input field restriction from entering more characters. 
     *  - Only applies to password, text, textbox, pattern, number and alpha fields.
     *  - Once advance is set as FALSE, only a backspace key can remove the restriction state
     * @param boolean $advance FALSE prevents advancement while TRUE allows advancement.
     * @return void
     */
    public function advance(bool $advance){
        if($this->advance){
            $this->advance->advance = $advance? null : false; // null removes restriction
        }
    }

    #[Override]
    public function __toString()
    {
        return $this->value;
    }

}