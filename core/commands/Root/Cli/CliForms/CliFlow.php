<?php 

namespace spoova\mi\core\commands\Root\Cli\CliForms;

use spoova\mi\core\classes\Ghost\GhostClass;
use spoova\mi\core\commands\Root\Cli\CliForms;

abstract class CliFlow extends GhostClass{

    /**
     * Specifies input field border color
     *
     * @var string
     */
    public $borderColor = '';

    /**
     * Specifies input field text color
     *
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
     * @var array
     */
    public ?int $count = 0;

    /**
     * Input field's value
     *
     * @var string
     */
    public string $value = '';

    protected function ghostInit(): void {

        $this->borderColor = $this->proxy->ghostData('borderColor')?:CliForms::text_field_color;
        $this->textColor = $this->proxy->ghostData('textColor')?:CliForms::text_field_color;
        $this->count = $this->proxy->ghostData('count')?:0;
        $this->value = $this->proxy->ghostData('value')?:0;
        $this->chars = $this->proxy->ghostData('chars')?:[];
        
    }

}