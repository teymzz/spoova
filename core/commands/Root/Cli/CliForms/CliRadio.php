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

    use CliFormsModifier;

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
    *   - color: selected|unselected text colors; textColor is also accepted for compatibility
     *   - borderColor: specifies colors of text characters which may be specified using supported color names (e.g danger, red, blue)
      * @param Closure|null $modifier callback that modifies each option's text and border colors.
      * @param Closure|null $onEnd callback closure(CliTransmit $form) function triggered when the form is submitted or terminated.
     * @return string $message
     */
    public static function radio(array $options, ?string $selected = null, string $hint = '', bool $flow = false, array $design = self::flow_design, ?Closure $modifier = null, ?Closure $onEnd = null)
    {

      self::use_requirements();

      // Get : selected, indent, modifier, defaults
      $draft = self::draft('choice', compact('options','selected','design','modifier'));

      $selected = $draft['selected'];
      $shape = $draft['shape'];
      $width = $draft['width'];
      $height = $draft['height'];
      $indent = $draft['indent'];
      $defaults = $draft['defaults'];
      $modifier = $draft['modifier'];

      CliForms::setLines($height+2); // adjust clear height behaviour

      /**
       * Creates a method to display options 
       *  ##### ***displayOptions($options, $selected, $margin)***
       *  - @param array **``$options``** - option to be displayed
       *  - @param string **``$selected``** - selected option
       *  - @param string **``$margin``** - left margin
       */
      $Ghost = new GhostFunction(['displayOptions', 'drawField','fixColor', 'update']);

      $Ghost->fixColor(function($color) : array {
        $colors = explode('|', $color);
        $colors[0] = $colors[0] ?? '';
        $colors[1] = $colors[1] ?? '';
        return $colors;
      });

      $Ghost->displayOptions(function($mod, $options, $selected, $indent) use ($Ghost){
        [$color1, $color2] = $Ghost->fixColor($mod->textColor);
        foreach ($options as $index => $option){
            if($index === $selected){
              Cli::moveStart($indent + 2)->textView(Cli::color(Cli::emo('radio').' '.$option, $color1));
            }else{
              Cli::moveStart($indent + 2)->textView(Cli::color(Cli::emo('radio').' '.$option, $color2));
            }
            if($index !== (count($options)-1)) Cli::break(1);
        }
        Cli::moveStart($indent + 2);
      });

      // Define activity to draw input field when method is called
      $Ghost->drawField(function($color = CliForms::text_field_color, int $marginTop = 0) use($indent, $hint, $width, $height, $shape){
        // Draw a text field
        CliDraw::textBox($width, $height, indent: $indent, color: $color, title: $hint, shape: $shape);
        // Update cursor position inside text field for text space allowance 
        Cli::moveUp($marginTop);
      });

      // Define method to process modifier
      $Ghost->update(function($selected, $new = false) use($modifier, $defaults, $options, $indent, $height, $Ghost){
              if(!$new){
                Cli::clearLine();
                Cli::moveDown()->clearUp($height + 1);
              }
              $option = $options[$selected];
              $mod = self::modified($modifier, $defaults, mb_str_split($option));
                if(in_array(strtolower($mod->borderColor), ['currentcolor','color'])) $mod->borderColor = $Ghost->fixColor($mod->textColor)[0];
                $Ghost->drawField($mod->borderColor);
              $Ghost->displayOptions($mod, $options, $selected, $indent);
      });

      $selected = (($selected - 1) >= 0)? $selected - 1 : 0;
      
      Cli::hideCursor();
      $Ghost->update($selected, true);

      $value = Cli::input(function(CliKey $key) use(&$selected, $options, $indent,  $flow, $Ghost, $onEnd){
        if($key->isExit() || $key->isEnter()){

            if($onEnd){
                Cli::moveDown()->break(1);
                $message = $onEnd(new CliTransmit($key, $options[$selected]));
                if($key->isExit()) Cli::break(1);
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
              $selected = $selected - 1;
              $Ghost->update($selected);
            }
          }else{
            if($flow){
              $selected = count($options);
              $selected = $selected - 1;
              $Ghost->update($selected);
            }
          }
        }elseif($key->isArrow('down') || $key->isArrow('right') || ($key->isTab())){

          if($selected !== (count($options) - 1)){
            if(($selected + 1) < (count($options))){
              $selected = $selected + 1;
              $Ghost->update($selected);
            }
          }else{
            if($flow){
              $selected = 0;
              $Ghost->update($selected);
            }
          }
        }
      });
      
      Cli::showCursor();
      
      return $value;
      
    }

}