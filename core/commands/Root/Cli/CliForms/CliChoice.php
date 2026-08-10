<?php 

namespace spoova\mi\core\commands\Root\Cli\CliForms;

use Closure;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliKey;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\classes\Ghost\GhostProxy;
use spoova\mi\core\classes\TClass;
use spoova\mi\core\commands\Root\Cli\CliDraw;
use spoova\mi\core\commands\Root\Cli\CliForms;

Trait CliChoice {

    /**
     * Create an optional radio button form easily... 
     *
     * @param array $options options to be displayed in line
     * @param string|null $selected index of selected option
     * @param boolean $fluid determines the continuous flow of arrows. This will also support TAB key.
     * @param array $design sets the box width and left margin
     * @return void
     */
    public static function choice(array $options, ?string $selected = null, string $hint = '', bool $fluid = false, array $design = ['width' => 50, 'indent' => 0, 'shape'=>'square','color'=>'white','borderColor'=>'white'], ?Closure $onEnd = null)
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
      $Ghost->drawField(function($color = 'white', int $marginTop = 0) use($indent, $hint, $width){      
        
        // Draw a text field
        CliDraw::textBox($width, indent: $indent, color: $color, title: $hint);

        // Update cursor position inside text field for text space allowance 
        Cli::moveUp($marginTop)->moveFront(1);

      });

      // Defines activity to display options
      $Ghost->displayOptions(function($options, $selected){
        foreach ($options as $index => $option){
            if($index === $selected){
              Cli::textView(Cli::valid(Cli::emo('bullet')." ".$option));
            }else{
              Cli::textView(Cli::emo('bullet')." ".$option);
            }
            if($index !== (count($options) - 1)) Cli::textPlain(' / ');
        }
      });
      
      $selected = (($selected - 1) >= 0)? $selected-1 : 0;
      
      // echo $selected;
      $Ghost->drawField();
      $Ghost->displayOptions($options, $selected, $indent);
      
      return Cli::input(function(CliKey $key) use(&$selected, $options, $indent, $fluid, $Ghost, $onEnd){
       
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
            if($key->isArrow('up') || $key->isArrow('left')){
                if($selected !== 0){
                    if(($selected - 1) >= 0){
                        Cli::moveDown()->clearUp(2);
                        $selected = $selected - 1;
                        $Ghost->drawField();
                        $Ghost->displayOptions($options, $selected, $indent);
                    }
                }else{
                    if($fluid){
                        $selected = count($options);
                        Cli::clearLine();
                        Cli::moveDown()->clearUp(2);
                        $selected = $selected - 1;
                        $Ghost->drawField();
                        $Ghost->displayOptions($options, $selected, $indent);
                    }
                }
            }elseif($key->isArrow('down') || $key->isArrow('right')){
                if($selected !== (count($options) - 1)){
                    if(($selected + 1) < (count($options))){
                        Cli::clearLine();
                        Cli::moveDown()->clearUp(2);
                        $selected = $selected + 1;
                        $Ghost->drawField();
                        $Ghost->displayOptions($options, $selected, $indent);
                    }
                }else{
                    if($fluid){
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
          if($fluid){
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

    private static function modified($modifier, array $chars){
      $md = array_values(TClass::funcParams($modifier));

      $data = ['ghostData'];
      
      if(count($md)>0 && $md[0][0] === CliFlow::class){
        
        $Ghost = new GhostFunction($data);
        $data = [
          'chars' => $chars,
          'count' => count($chars), 
          'textColor' => 'white', 
          'borderColor' => 'white'
        ];
        
        $Ghost->ghostData(fn($key) => $data[$key] ?? null);

        GhostProxy::new($Ghost, fn(GhostDraft $draft) => new class($draft) extends CliFlow{});

        $flow = GhostProxy::object();
        
        $modifier($flow);
        $mod = $flow;
      }else{
        $mod = $modifier($chars);
        if(is_array($mod)) {
          $Ghost = new GhostFunction(['ghostData']);
          $Ghost->ghostData(fn($key) => $mod[$key] ?? null);
          GhostProxy::new($Ghost, fn(GhostDraft $draft) => new class($draft) extends CliFlow{});
          $mod = GhostProxy::object();
        }
      }

      return $mod;
    }

}