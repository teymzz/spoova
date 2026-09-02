<?php 

namespace spoova\mi\core\commands\Root\Cli\CliForms;

use Closure;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\commands\Root\Cli\CliDraw;
use spoova\mi\core\commands\Root\Cli\CliForms;
use spoova\mi\core\commands\Root\Cli\CliKey;
use spoova\mi\core\commands\Root\Cli\CliScreen;

trait CliRadio {

    /**
     * Create an optional radio button animation easily... 
     *
     * @param array $options options to be listed.
     * @param string|null $selected selected option's relative index value.
     * @param string $hint title of the form field.
     * @param boolean $flow determines the flow of navigation (Supports TAB key).
     * @param array $design specifies the design format for the radio field 
     *   - width: specifies the width of the radio button's input field where the default width value is 50
     *   - indent: specifies the margin of input field from the left of the CLI screen 
     *   - shape: specifies the shape of the corners of the input radio field. Value are either specified as ```square``` or ```round``` 
     *   - textColor: specifies colors of text characters which may be specified using supported color names (e.g danger, red, blue)
     *   - borderColor: specifies colors of text characters which may be specified using supported color names (e.g danger, red, blue)
     * @param Closure|null $onEnd callback closure(CliTransmit $form) function triggered when the form is submitted or terminated.
     * @return string $message
     */
    public static function radio(array $options, ?string $selected = null, string $hint = '', bool $flow = false, array $design = [], ?Closure $onEnd = null)
    {

      self::use_requirements();
      
      //requires options and arrows .... 
      if(!is_numeric($selected) || !array_key_exists($selected, $options)){
        $selected = 0;
      }

      $indent = $design['indent'] ?? 0;
      $indent = (is_numeric($indent)) ? (int) $indent : 0;
      $indent = CliDraw::fitIndent($indent);            // guard against excessive indent

      $width = $design['width'] ?? 50;
      $width = (is_numeric($width)) ? (int) $width : 50;
      $width = CliDraw::fitWidth($width, $indent);      // keep box within the screen

      $colors = ['red','green','blue','white','yellow','purple'];

      $textColor = $design['textColor'] ?? CliForms::text_field_color;
      $textColor = in_array($textColor, $colors)? $textColor : CliForms::text_field_color;

      $borderColor = $design['borderColor'] ?? CliForms::text_field_color;
      $borderColor = in_array($borderColor, $colors)? $borderColor : CliForms::text_field_color;

      $height = count($options);
      CliForms::setLines($height+2);

      /**
       * Creates a method to display options 
       *  ##### ***displayOptions($options, $selected, $margin)***
       *  - @param array **``$options``** - option to be displayed
       *  - @param string **``$selected``** - selected option
       *  - @param string **``$margin``** - left margin
       */
      $Ghost = new GhostFunction(['displayOptions', 'drawField']);

      $Ghost->displayOptions(function($options, $selected, $indent){
        foreach ($options as $index => $option){
            if($index === $selected){
              Cli::moveStart($indent + 2)->textView(Cli::valid(Cli::emo('radio').' '.$option));
            }else{
              Cli::moveStart($indent + 2)->textView(Cli::emo('radio').' '.$option);
            }
            if($index !== (count($options)-1)) Cli::break(1);
        }
        Cli::moveStart($indent + 2);
      });

      // Define activity to draw input field when method is called
      $Ghost->drawField(function($color = CliForms::text_field_color, int $marginTop = 0) use($indent, $hint, $width, $height){      
        
        // Draw a text field
        CliDraw::textBox($width, $height, indent: $indent, color: $color, title: $hint);

        // Update cursor position inside text field for text space allowance 
        Cli::moveUp($marginTop);

      });

      $selected = (($selected - 1) > 0)? $selected - 1 : 0;
      
      Cli::hideCursor();
      $Ghost->drawField();
      $Ghost->displayOptions($options, $selected, $indent);

      $value = Cli::input(function(CliKey $key) use(&$selected, $options, $indent,  $flow, $Ghost, $onEnd){
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

        }elseif($key->isArrow('up') || $key->isArrow('left')){
          if($selected !== 0){
            if(($selected - 1) >= 0){
              Cli::moveDown()->clearUp(count($options)+1);
              $selected = $selected - 1;
              $Ghost->drawField();
              $Ghost->displayOptions($options, $selected, $indent);
            }
          }else{
            if($flow){
              $selected = count($options);
              Cli::moveDown()->clearUp(count($options)+1);
              $selected = $selected - 1;
              $Ghost->drawField();
              $Ghost->displayOptions($options, $selected, $indent);
            }
          }
        }elseif($key->isArrow('down') || $key->isArrow('right') || ($key->isTab())){

          if($selected !== (count($options) - 1)){
            if(($selected + 1) < (count($options))){
              Cli::moveDown()->clearUp(count($options)+1);
              $selected = $selected + 1;
              $Ghost->drawField();
              $Ghost->displayOptions($options, $selected, $indent);
            }
          }else{
            if($flow){
              Cli::moveDown()->clearUp(count($options)+1);
              $selected = 0;
              $Ghost->drawField();
              $Ghost->displayOptions($options, $selected, $indent);
            }
          }
        }
      });
      
      Cli::showCursor();
      
      return $value;
      
    }


}