<?php 

namespace spoova\mi\core\commands\Root\Cli\CliCanvas;

use Closure;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\classes\Ghost\GhostProxy;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliDraw;

abstract class CliDrawer { 

    protected Cli $cli;
    protected $shape;
    protected $color;
    protected $write;
    protected $draw = [];
    protected ?array $textStarts = null;

    public function __construct(protected GhostDraft $get, protected ?GhostFunction $proxy = null)
    {
        $this->proxy = GhostProxy::map($this->get->id(), fn() => $this->get->ghost());
        $this->cli = new Cli;
    }

    public function initial() {
        return $this->proxy->ghostData('initial');
    }

    public function height() {
        return $this->proxy->ghostData('height');
    }

    public function width() {
        return $this->proxy->ghostData('width');
    }

    /**
     * Return the left or right indent of box
     *
     * @param string $type optional [left|right]
     * @return int
     */
    public function indent(string $type) : int {
        $indents = $this->proxy->ghostData('indent'); 
        if($type === 'left') return $indents[0] ?? 0;
        if($type === 'right') return $indents[1] ?? 0;
        return 0;
    }

    public function type() {
        return $this->proxy->ghostData('type');
    }


    public function write($text, ?Closure $mod = null) {
        
        $this->entry();
        $width = $this->proxy->ghostData('width');
        $height = $this->proxy->ghostData('height');

        $texts = str_split($text, $width); 

        foreach($texts as $i => $t){
            if($i === ($height)) break;
            $this->entry(); 
            echo Cli::moveDown($i);
            Cli::textPlain($mod? $mod($t) : $t);
        }        

        // store settings
        $this->write['text'] = $text;
        $this->write['mod'] = $mod;
        $this->write['indent'] = $mod;
        $this->write['row'] = $this->proxy->ghostData('row') + 1;
        $this->write['col'] = $this->proxy->ghostData('col') + 1;

    }

    /** box input entry */
    public function entry($rowplus = 0, $colplus = 0) {

        $startTexts['col'] = $this->textStarts['x']; 
        $startTexts['row'] = $this->textStarts['y']; 
        // $startTexts['col'] = $this->draw['startX'] + 1 + $this->draw['indentLeft']; 
        
        if($startTexts['row'] < 0) $startTexts['row'] = 0;
        if($startTexts['col'] < 0) $startTexts['col'] = 0;

        Cli::moveTo($startTexts['col'], $startTexts['row']);
    }

    public function draw($shape = 'square', $color = '', $title='') : CliDrawer {
        
        $width = $this->proxy->ghostData('width');
        $height = $this->proxy->ghostData('height');

        if(!isset($this->draw['indentLeft'])){
            $indentXL = $this->draw['indentLeft'] = $this->indent('left');
        }else{
            $indentXL = $this->draw['indentLeft'];
        }


        // Draw lines axis
        if(!isset($this->draw['startX'])) $this->draw['startX'] = $this->proxy->ghostData('col');
        if(!isset($this->draw['startY'])) $this->draw['startY'] = $this->proxy->ghostData('row');
        if(!isset($this->draw['endX'])) $this->draw['endX'] = $this->draw['startX'] + $width + $indentXL + 1;
        if(!isset($this->draw['endY'])) $this->draw['endY'] = $this->draw['startY'] + $height + 1;
        
        // Text input first character axis
        if(!isset($this->textStarts)) $this->textStarts = $this->proxy->ghostData('textStarts');
        $textStarts = $this->textStarts;

        // Move cursor to last line axis
        Cli::moveTo($this->draw['endX'], $this->draw['endY']);

        for($i=0; $i <= $height+1; $i++){
            Cli::moveback($width + 1);
            Cli::textPlain(str_repeat(' ',$width+2));
            Cli::moveBack(1)->moveUp(1);
        }

        Cli::moveTo($this->draw['startX'], $this->draw['startY']);

        $this->shape = $shape;
        $this->color = $color;

        if($shape === 'round'){
            CliDraw::roundBox($width, $height, $indentXL, $color, $title);
        }elseif($shape === 'cap-round'){
            CliDraw::captureRound($width, $height, $indentXL, $color, $title);
        }elseif($shape === 'banner'){
            CliDraw::banner($width, $height, $indentXL, $color, $title);
        }elseif($shape === 'capture'){
            CliDraw::captureSquare($width, $height, $indentXL, $color, $title);
        }else{
            CliDraw::squareBox($width, $height, $indentXL, $color, $title);
        }

        Cli::saveCursor();
        return $this;
    }

    public function moveLeft($length = 1){

        $length = $length < 0? 0: $length;
        
        $width = $this->proxy->ghostData('width');
        $height = $this->proxy->ghostData('height');

        Cli::moveTo($this->draw['endX'], $this->draw['endY']); // move to last draw line

        $this->clearBox();
        // // wipe box for redrawing
        // for($i=0; $i <= $height+1; $i++){
        //     Cli::moveback($width + 1); 
        //     Cli::textPlain(str_repeat(' ',$width+2));
        //     Cli::moveBack(1)->moveUp(1);
        // }

        //prevent indent from moving beyond the initial point
        for($i=0; $i<=$length; $i++){
            $this->draw['indentLeft'] -= 1;
            if($this->draw['indentLeft'] >= 0){
                $this->textStarts['x'] -= 1;
            }else{
                $this->draw['indentLeft'] = 0;
            }
        }

        Cli::moveTo($this->draw['startX'], $this->draw['startY']); // move to first draw line
        
        $this->draw(shape:$this->shape, color: $this->color); // redraw box
        $this->write($this->write['text'], $this->write['mod']); //write content into box
    }

    public function moveRight($length = 1){

        $length = $length < 0? 0: $length;
        
        $width = $this->proxy->ghostData('width'); // width of box
        $height = $this->proxy->ghostData('height'); // height of box

        Cli::moveTo($this->draw['endX'], $this->draw['endY']); // move to last draw line
        
        $this->clearBox();
        // // Wipe box for redrawing
        // for($i=0; $i <= $height+1; $i++){
        //     Cli::moveback($width + 1); 
        //     Cli::textPlain(str_repeat(' ',$width+2));
        //     Cli::moveBack(1)->moveUp(1);
        // }

        //prevent indent from moving beyond the initial point
        for($i=0; $i<=$length; $i++){
            // This will be modified later to prevent moving beyond available screen width
            $this->draw['indentLeft'] += 1; // indent of box from the left
            $this->textStarts['x'] += 1; // where text starts in box
        }

        Cli::moveTo($this->draw['startX'], $this->draw['startY']);
        
        $this->draw(shape:$this->shape, color: $this->color); // redraw box
        $this->write($this->write['text'], $this->write['mod']); // rewrite box content


    }

    /**
     * Clear the whole box area using exact coordinates
     *
     * @param int|null $indentOverride optional indent to use while clearing
     * @param int|null $extraCols optionally clear extra columns to the right (safety)
     */
    public function clearBox(?int $indentOverride = null, ?int $extraCols = 0) : void {
        // ensure draw coords exist
        $startX = $this->draw['startX'] ?? $this->proxy->ghostData('col');
        $startY = $this->draw['startY'] ?? $this->proxy->ghostData('row');

        $width  = $this->proxy->ghostData('width');
        $height = $this->proxy->ghostData('height');

        $indentLeft = $indentOverride ?? ($this->draw['indentLeft'] ?? $this->indent('left'));

        // compute the total columns to wipe:
        // width = inner text width, indentLeft = left-shift inside the box,
        // +2 covers box border / padding (matches previous code that used $width + 2)
        $clearCols = $width + $indentLeft + 2 + max(0, (int)$extraCols);

        // defensive: don't allow negative or zero
        if($clearCols < 1) $clearCols = $width + 2;

        // save cursor, wipe rows, restore cursor
        Cli::saveCursor();
        for($r = 0; $r <= $height + 1; $r++){
            Cli::moveTo($startX, $startY + $r);
            Cli::textPlain(str_repeat(' ', $clearCols));
        }
        Cli::restoreCursor();
    }

}