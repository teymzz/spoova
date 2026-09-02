<?php 

namespace spoova\mi\core\commands\Root\Cli\CliForms;

use Closure;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliKey;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\commands\Root\Cli\CliDraw;
use spoova\mi\core\commands\Root\Cli\CliForms;
use spoova\mi\core\commands\Root\Cli\CliScreen;

Trait CliSelect {

    /**
     * Create an optional radio button form easily... 
     *
     * @param array $options options to be displayed in a selection box
     * @param string|null $selected index (or access key) of selected option
     * @param boolean $flow determines the continuous flow of arrows. This will also support TAB key.
     * @param array $design sets the selection box design. 
     *  - width: sets the with of textbox. 
     *  - indent: sets the left margin of textbox.
     *  - shape: optional [square|round].
     *  - color: sets the text color. 
     *  - borderColor: sets the selection box border color.
     * @param ?Closure $onEnd callback function closure(CliTransmit $key) triggered when the form is submitted or terminated.
     * @return string
     */
    public static function select(array $options, ?string $selected = null, string $hint = '', bool $flow = false, array $design = ['width' => 50, 'indent' => 0, 'shape'=>'square','color'=>CliForms::text_field_color,'borderColor'=>CliForms::text_field_color], ?Closure $onEnd = null) : string
    {

      self::use_requirements();

      //requires options and arrows .... 
      if(!is_numeric($selected) || !array_key_exists($selected, $options)){
        $selected = 0;
      }

      $indent = $design['indent'] ?? 0;
      $indent = (is_numeric($indent)) ? (int) $indent : 0;

      $width = $design['width'] ?? 50;
      $width = (is_numeric($width)) ? (int) $width : 50;
      
      // Ensure width is not greater than screen width at initial draw
      $indent = CliDraw::fitIndent($indent);            // guard against excessive indent
      $width  = CliDraw::fitWidth($width, $indent);     // keep box within the screen

      CliForms::setLines(3);
      Cli::hideCursor();

      /**
       * @var object
       * Creates a method to display options 
       *  ##### ***displayOptions($options, $selected, $margin)***
       *  - @param array **``$options``** - option to be displayed
       *  - @param string **``$selected``** - selected option
       *  - @param string **``$indent``** - left margin
       *  ##### drawField($color) - ***draw a new text field***
       *  ##### ``` $color: specifies the border color for text field ```
       */
      $Ghost = new GhostFunction(['displayOptions','drawField']);

      // Define activity to draw input field when method is called
      $Ghost->drawField(function($color = CliForms::text_field_color, int $marginTop = 0) use($indent, $hint, $width){      
        
        // Draw a text field
        CliDraw::textBox($width, indent: $indent, color: $color, title: $hint);
        
        // Update cursor position inside text field for text space allowance 
        Cli::moveUp($marginTop)->moveFront(1)->saveCursor();
        Cli::moveStart($indent + $width - 2)->textView('▼')->restoreCursor();

      });

      // Defines activity to display options
      $Ghost->displayOptions(function($options, $selected){
        foreach ($options as $index => $option){
            if($index === $selected){
              Cli::textView(Cli::valid(Cli::emo('bullet')." ".$option));
            }else{
            //   Cli::textView(Cli::emo('bullet')." ".$option);
            }
        }
      });
      
      $selected = (($selected - 1) >= 0)? $selected-1 : 0;
      
      // echo $selected;
      $Ghost->drawField();
      $Ghost->displayOptions($options, $selected, $indent);
      
      return Cli::input(function(CliKey $key) use(&$selected, $options, $indent, $flow, $Ghost, $onEnd){
       
        if($key->isExit() || $key->isEnter()){

            if($onEnd){
                Cli::moveDown()->break(1);
                $message = $onEnd(new CliTransmit($key, $options[$selected]));
                if($key->isExit()) Cli::break(2);
                return $message;
            }else{
                if($key->isEnter()){
                    Cli::break(3);
                    $key->exit();
                    return $options[$selected];
                }else{
                    Cli::textView(Cli::warn('message:').' form terminated', $indent);
                }
            }

        }elseif($key->isArrow()){
            if($key->isArrow('up')){
                if($selected !== 0){
                    if(($selected - 1) >= 0){
                        Cli::moveDown()->clearUp(2);
                        $selected = $selected - 1;
                        $Ghost->drawField();
                        $Ghost->displayOptions($options, $selected, $indent);
                    }
                }else{
                    if($flow){
                        $selected = count($options);
                        Cli::clearLine();
                        Cli::moveDown()->clearUp(2);
                        $selected = $selected - 1;
                        $Ghost->drawField();
                        $Ghost->displayOptions($options, $selected, $indent);
                    }
                }
            }elseif($key->isArrow('down')){
                if($selected !== (count($options) - 1)){
                    if(($selected + 1) < (count($options))){
                        Cli::clearLine();
                        Cli::moveDown()->clearUp(2);
                        $selected = $selected + 1;
                        $Ghost->drawField();
                        $Ghost->displayOptions($options, $selected, $indent);
                    }
                }else{
                    if($flow){
                        $selected = array_keys($options)[0];
                        Cli::clearLine();
                        Cli::moveDown()->clearUp(2);
                        $selected = $selected;
                        $Ghost->drawField();
                        $Ghost->displayOptions($options, $selected, $indent);
                    }
                }
            }
        }elseif($key->isTab()){
          if($flow){
            if($selected !== (count($options) - 1)){
              if(($selected + 1) < (count($options))){
                Cli::clearLine();
                Cli::moveDown()->clearUp(2);
                $selected = $selected + 1;
              $Ghost->drawField();
                $Ghost->displayOptions($options, $selected, $indent);
              }
            }else{
              $selected = array_keys($options)[0];
              Cli::clearLine();
              Cli::moveDown()->clearUp(2);
              $selected = $selected;
              $Ghost->drawField();
              $Ghost->displayOptions($options, $selected, $indent);
            }
          }
        }
      });
      
    }

}