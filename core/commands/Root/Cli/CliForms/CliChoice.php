<?php 

namespace spoova\mi\core\commands\Root\Cli\CliForms;

use Closure;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\classes\Ghost\GhostProxy;
use spoova\mi\core\classes\TClass;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliDraw;
use spoova\mi\core\commands\Root\Cli\CliForms;
use spoova\mi\core\commands\Root\Cli\CliForms\CliFormsModifier;
use spoova\mi\core\commands\Root\Cli\CliKey;

Trait CliChoice {

    use CliFormsModifier;

    /**
     * Create an optional radio button form easily... 
     *
     * @param array $options options to be displayed in line
     * @param string|null $selected index of selected option
     * @param boolean $fluid determines the continuous flow of arrows. This will also support TAB key.
     * @param array $design sets the box width and left margin
     * @return string
     */
    public static function choice(array $options, ?string $selected = null, string $hint = '', bool $fluid = false, array $design = self::flow_design, ?Closure $modifier = null, ?Closure $onEnd = null)
    {
      self::use_requirements();

      // Get : selected, indent, modifier, defaults
      $draft = self::draft('choice', compact('options','selected','design','modifier'));

      $selected = $draft['selected'];
      $shape = $draft['shape'];
      $width = $draft['width'];
      $indent = $draft['indent'];
      $defaults = $draft['defaults'];
      $modifier = $draft['modifier'];
      
      Cli::hideCursor();

      CliForms::setLines(3);

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
      $Ghost = new GhostFunction(['displayOptions','drawField','fixColor','update']);

      $Ghost->fixColor(function($color) : array {    
            $colors = explode('|', $color); 
            $colors[0] = $colors[0] ?? '';
            $colors[1] = $colors[1] ?? '';
            return $colors;
       });

      // Define activity to draw input field when method is called
      $Ghost->drawField(function($color = 'white', int $marginTop = 0) use($indent, $shape, $hint, $width){      
        
        // Draw a text field
        CliDraw::textBox($width, indent: $indent, color: $color, title: $hint, shape: $shape);

        // Update cursor position inside text field for text space allowance 
        Cli::moveUp($marginTop)->moveFront(1);

      });

      // Defines activity to display options
      $Ghost->displayOptions(function($mod, $options, $selected) use ($Ghost){
        [$color1, $color2] =  $Ghost->fixColor($mod->textColor); 

        foreach ($options as $index => $option){
            if($index === $selected){
              Cli::textPlain(Cli::color(Cli::emo('bullet')." ".$option, $color1));
            }else{
              Cli::textPlain(Cli::color(Cli::emo('bullet')." ".$option, $color2));
            }
            if($index !== (count($options) - 1)) Cli::textPlain(' / ');
        }
      });

      // Define method to process modifier
      $Ghost->update(function($selected, $new = false) use($modifier, $defaults, $options, $indent, $Ghost){
              if(!$new){
                Cli::clearLine();
                Cli::moveDown()->clearUp(2);
              }
              $option = $options[$selected];
              $mod = self::modified($modifier, $defaults, mb_str_split($option));

              if(in_array(strtolower($mod->borderColor), ['currentcolor','color'])) $mod->borderColor = $Ghost->fixColor($mod->textColor)[0];
                    
              $Ghost->drawField($mod->borderColor); 
              $Ghost->displayOptions($mod, $options, $selected, $indent);
      });
      
      $selected = (($selected - 1) >= 0)? $selected-1 : 0;
      
      $Ghost->update($selected, true);

      return Cli::input(function(CliKey $key) use(&$selected, $options, $indent, $fluid, $Ghost, $onEnd){
       
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

        }elseif($key->isArrow()){

            if($key->isArrow('up') || $key->isArrow('left')){
                if($selected !== 0){
                    if(($selected - 1) >= 0){
                        $selected = $selected - 1;
                        $Ghost->update($selected);
                    }
                }else{
                    if($fluid){
                        $selected = count($options);
                        $selected = $selected - 1;
                        $Ghost->update($selected);
                    }
                }
            }elseif($key->isArrow('down') || $key->isArrow('right')){
                if($selected !== (count($options) - 1)){
                    if(($selected + 1) < (count($options))){
                        $selected = $selected + 1;
                        $Ghost->update($selected);
                    }
                }else{
                    if($fluid){
                        $selected = array_keys($options)[0];
                        $selected = $selected;
                        $Ghost->update($selected);
                    }
                }
            }
        }elseif($key->isTab()){
          if($fluid){
            if($selected !== (count($options) - 1)){
              if(($selected + 1) < (count($options))){
                $selected = $selected + 1;
                $Ghost->update($selected);
              }
            }else{
              $selected = array_keys($options)[0];
              $selected = $selected;
              $Ghost->update($selected);
            }
          }
        }
      });
      
    }

}