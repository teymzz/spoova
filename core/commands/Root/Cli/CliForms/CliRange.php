<?php 

namespace spoova\mi\core\commands\Root\Cli\CliForms;

use Closure;
use spoova\mi\core\classes\Debug;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliKey;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\commands\Root\Cli\CliForms;
use spoova\mi\core\commands\Root\Cli\CliInput;
use spoova\mi\core\commands\Root\Cli\CliDraw;
use spoova\mi\core\commands\Root\Cli\CliScreen;

trait CliRange {

    /**
     * Creates an input range on the CLI screen
     *
     * @param string $type optional [lines|bar|slider]
     *  - The type may be defined along with animation delay interval using dashes. For example 'line-3000' 
     *    specifies both the animation type and effect interval. 
     * @param array $value data specification key and value pairs
     *  - List of ranges and corresponding values representing percentage increment. For example the keys of an array
     *    ['18 - 25'=>25, '26 - 40'=>40] specifies ranges while their values is the percentage increase.
     * @param string|null $selected default specification range. For example '18 - 25' selects this range.
     * @param string $placeholder a default text when zero percentage increase is made
     * @param string $hint title of the range field
     * @param array $design sets a list of predefined design keys and value pairs
     *   - borderColor : sets default border color
     *   - textColor   : sets default text color
     *   - shape       : sets input field shape
     *   - width       : sets width of input field, the minimum is 25.
     * @param Closure|null $modifier sets a border color or text color for input field
     * @param Closure|null $onEnd callback closure(CliTransmit $form) function triggered when the form is submitted or terminated.
     * @return string response
     */
    public static function range($type = 'lines', array $value = [], ?string $selected = null, string $placeholder = '', string $hint = '', array $design = ['width'=>25, 'indent' => 0, 'shape'=>'square','textColor'=>CliForms::text_field_color,'borderColor'=>CliForms::text_field_color], ?Closure $modifier = null, ?Closure $onEnd = null){
        self::use_requirements();
        $min_width = 25;
        $width = $design['width'] ?? $min_width;
        $indent = $design['indent'] ?? 0;
        $shape = $design['shape'] ?? 'square';
        $color = $design['textColor'] ?? CliForms::text_field_color;
        $borderColor = $design['borderColor'] ?? CliForms::text_field_color;
        $keys = array_keys($value);
        $percents = array_values($value);
        $prevVal = null;
        CliForms::setLines(3);

        foreach($value as $key => $val){
            if($prevVal === null) {
                $prevVal = $percents[0];
            }else{

                if($val < $prevVal){
                    Cli::textView(Cli::error('invalid value format detected for input range'))->break(2);
                    exit;
                }

                if($val > 100){
                    Cli::textView(Cli::error('invalid value format detected for input range'))->break(2);
                    exit;
                }
                $prevVal = $val;
            }
        }
  
        // set accepted configuration for default values 
        if(!in_array($shape, ['square','round'])) $shape = 'square';
        if(!in_array($color, ['red','blue',CliForms::text_field_color,'yellow'])) $color = CliForms::text_field_color;
        if(!in_array($borderColor, ['red','blue',CliForms::text_field_color,'yellow'])) $borderColor = CliForms::text_field_color;
        $width = (!is_numeric($width) || ($width < $min_width))? $min_width : (int) $width;
        $indent = (!is_numeric($indent))? 0 : (int) $indent;
        $indent = CliDraw::fitIndent($indent);            // guard against excessive indent
        $boxWidth = CliDraw::fitWidth($width, $indent);   // actual drawn width, kept within the screen
        
        $info['x'] = $width; // registered width
        $info['y'] = $height = 1; // registered height
        $info['box-w'] =& $boxWidth;
        $info['margin'] = $indent;
        $info['placeholder'] = $placeholder;
        $info['color'] = CliForms::text_field_color;
        $info['bound'] = 0;
        $info['inc'] = 0;
        $info['keys'] = $keys;
        $info['percents'] = $percents;
        $charAnimes = ['bar' => ' ', 'lines'=>'|', 'slider'=> '─'];
        $types = explode('-', $type, 2);
        $type = $types[0];
        $animationEffect = $types[1] ?? null;
        
        if(($animationEffect !== null)){
            if(!is_numeric($animationEffect) || !is_int($animationEffect + 0)){
                $trace = Debug::get(0);
                Cli::textView(Cli::error('invalid animation time effect supplied in '.$trace['file'].' on line '.$trace['line']));
                Cli::break(2);
                exit;
            }
        }

        $charAnime = $charAnimes[$type] ?? '─';

        $increase = 0;
  
        if(!$modifier){
          $modifier = function($chars){
            
            return (object) [
              'chars' => $chars,
              'count' => count($chars),
              'value' => implode('', $chars),
              'textColor' => CliForms::text_field_color, 
              'borderColor' => CliForms::text_field_color, 
            ];
  
          };
        }
  
        /**
         * @var object
         *  ##### drawField($color) - ***draw a new text field***
         *  ##### ``` $color: specifies the border color for text field ```
         * 
         *  ##### writeInput($text) - ***writes a new text into the input field***
         *  ##### ``` $text: text to be written ```
         * 
         *  ##### showText($text) - ***For Testing: this displays a text below the input field***
         *  ##### ``` $text: text to be written ```
         */
        $GhostFunction = new GhostFunction(['drawField','writeInput','showText'],'GhostFunction');
        $box = [];

        // Define activity to draw input field when method is called
        $GhostFunction->drawField(function($color = CliForms::text_field_color, int $marginTop = 0, &$increase = 0) use($shape, $width, &$boxWidth, $height, $indent, $hint, $type, &$info, &$box){  

            $title = strlen($hint)+5 >  $boxWidth ? substr($hint, 0, $boxWidth - 5)."..." : $hint; 
            $top = "─"; $right = "│"; // top and right borders

            if($shape === 'round'){
                $topLeft = '╭'; $topRight = '╮';
                $btmLeft = '╰'; $btmRight = '╯';
            }else{
                $topLeft = '┌'; $topRight = '┐';
                $btmLeft = '└'; $btmRight = '┘';
            }

            // Remove top-right and right border for slider type
            if($type !== 'slider'){ $top = " "; $right = ""; $topRight = " "; };

            // Prepare input box lines
            $input['top'] = Cli::color(str_repeat("─", 1).$title.str_repeat($top, $boxWidth - (strlen($title)+1)).$topRight, $color);
            $input['mid'] = Cli::color("│" . str_repeat(" ", $boxWidth) . $right, $color)."\n";

            $underLeft = $btmLeft.str_repeat("─", 1);
            $underRight = str_repeat("─", $boxWidth - 1 - strlen($info['keys'][$increase])).$btmRight;

            $btm = $underLeft.$info['keys'][$increase].$underRight;
            $input['btm'] = Cli::color($btm, $color)."\n";

            if(!isset($box['area'])){
                $box['area'] = Cli::cursor(); // save starting position of box
            }else{
                $area = $box['area'];
                Cli::moveTo($area['col'], $area['row']); // use saved starting position of box
            }

            Cli::textView(Cli::color($topLeft.$input['top'], $color), $indent, break: '|1');
            Cli::textView($input['mid'], $indent);
            Cli::textView($input['btm'], $indent);

            if(!isset($box['text-start'])){
                // Set cursor position inside box 
                Cli::moveUp($height + 1)->moveStart($indent);
                Cli::moveUp($marginTop); //fit cursor using margin specified.
                $box['text-start'] = Cli::cursorPosition(); // starting text position in box
            }else{
                $textStart = $box['text-start'];
                Cli::moveTo($textStart['col'], $textStart['row']); // use starting text position in box
            }
  
        });
        
        //Define activity to write a new text into the text box created
        $GhostFunction->writeInput(function($text = '') use($indent, &$boxWidth) {
          Cli::moveStart($indent + 1)
             ->textPlain(str_repeat(" ", $boxWidth))
             ->moveStart($indent + 1);
          if($text) Cli::textPlain($text);
        });

        // Define activity for displaying a text below the input field (For testing purpose)
        $GhostFunction->showText(function($text, $indent = 0){
          Cli::saveCursor();
          Cli::moveDown(2)->clearLine()->textPlain($text, $indent);
          Cli::restoreCursor();
        });

        $baseInc = $selected ? $value[$selected] : 0;

        $mod = self::modified($modifier, str_split("$baseInc"), 'string');
        $color = property_exists($mod, 'textColor')? $mod->textColor : CliForms::text_field_color;
        $bdcolor = property_exists($mod, 'borderColor')? $mod->borderColor : '';

        if($charAnime === ' '){
            $bgcolor = Cli::bgcolor($charAnime, $bdcolor ?: $color);
        }else{
            $bgcolor = Cli::color($charAnime, $bdcolor ?: $color);
        }

        // slider reserves 2 columns for the roller, so its track is box-w - 2
        $divider = ($type === 'slider') ? ($info['box-w'] - 2) : $info['box-w'];

        if(!$selected){
            $increment = intval(($percents[0]??0) / 100 * $divider);
            $percentIncrease = str_repeat($bgcolor, max(0, $increment));
            if($type === 'slider'){
                $percentIncrease .= Cli::bgColor('  ', $color);
                $percentIncrease .= str_repeat($charAnime, max(0, ($info['box-w'] - 2) - $increment));
            }
        }else{
            if(!array_key_exists($selected, $value)){
                $trace = Debug::get(0);
                Cli::textView(Cli::error('invalid default range supplied in '.$trace['file'].' on line '.$trace['line']));
                Cli::break(2);
                exit;
            }
            $increment = intval(($value[$selected]) / 100 * $divider);
            $percentIncrease = str_repeat($bgcolor, max(0, $increment));
            if($type === 'slider'){
                $percentIncrease .= Cli::bgColor('  ', $color);
                $percentIncrease .= str_repeat($charAnime, max(0, ($info['box-w'] - 2) - $increment));
            }
            $increase = array_search($selected, $keys);
        }

        // Start by drawing the input field
        $initialPos = Cli::cursor();
        $GhostFunction->drawField($color, increase: $increase);

        $finalPos = Cli::cursor();
        if($percentIncrease){
          $GhostFunction->writeInput($percentIncrease);
          $info['bound'] = intval(($percents[$increase] / 100) * $divider);
        }elseif($info['placeholder']){
          $GhostFunction->writeInput($info['placeholder']);
          Cli::moveStart($info['margin'] + 1);
        }

        $incremental = null; $resizing = false;
  
        Cli::hideCursor(); // Start by hiding cursor
        
        // Stream input into the text box field ......................................................................
        return CliInput::input(function(CliKey $key) use ($type, $animationEffect, &$resizing, $initialPos, $finalPos, &$info, $GhostFunction, $color, $bgcolor, $percentIncrease, $percents, $onEnd, $modifier, &$increase, $indent, $charAnime, &$incremental) {
          
          // if($key->isSignal(SIGWINCH)){ /* no support provided ... */ }
            
          // $info['box-w'] = $boxWidth = CliScreen::width() - 2;
          // $start = $finalPos['row'] + 4;
          // $end = $initialPos['row'];
          // Cli::moveTo(1, $start)->clearLine();
          // for($i = $start; $i >= $end; $i--){
          //     echo "\033[2K";
          //     echo Cli::moveTo(1, $i);
          //     echo "\033[2K";
          //     Cli::clearLine();
          // }

          if($key->isExit() || $key->isEnter()){
            
            if($onEnd){
                Cli::moveDown()->break(1);
                $message = $onEnd(new CliTransmit($key, $info['keys'][$increase]));
                if($key->isExit()) Cli::break(2);
                return $message;
            }else{
                if($key->isEnter()){
                    Cli::break(3);
                    $key->exit();
                    return $info['keys'][$increase];
                }else{
                    Cli::textView(Cli::warn('message:').' form terminated', $indent);
                }
            }
            
          }elseif ($key->isArrow('left') || $key->isArrow('down')){
            
            $incremental = $increase;
            $divider = $type === 'slider'? $info['box-w'] - 2 : $info['box-w'];
            if(($info['bound'] >= 0) && (array_key_exists($increase - 1, $info['percents']))) {
                $increase--; 
                $inc = $info['percents'][$increase];
                $inc = intval(($inc / 100) * ($divider));
                $info['bound'] = $inc;
            }else{
                return false;
            }
            
            if($modifier){
                $text = str_repeat($charAnime, $inc<0?0:$inc);
                // $mod = $modifier($info['percents'][$increase]);
                // if(is_array($mod)) $mod = (object) $mod;
                $mod = self::modified($modifier, str_split((string)$info['percents'][$increase]), 'string');
                $color = property_exists($mod, 'textColor')? $mod->textColor : CliForms::text_field_color;
                $bdcolor = property_exists($mod, 'borderColor')? $mod->borderColor : CliForms::text_field_color;
                
                
                if($type === 'slider'){
                    $text = Cli::color($text, $color);
                    $text .= Cli::bgcolor('  ', $color); //slider
                    $rollerGrow = $info['box-w'] - 2 - $inc;
                    $rollerGrow = $rollerGrow < 0? 0 : $rollerGrow;
                    $text .= str_repeat($charAnime, $rollerGrow);
                }else{
                    $text = ($charAnime === ' ')? Cli::bgcolor($text, $color) : Cli::color($text, $color);
                }
            }

            if($animationEffect){
                if($incremental !== $increase){

                    $oldPoint = $info['percents'][$incremental]; 
                    $newPoint = $info['percents'][$increase];
    
                    $oldPoint = intval(($oldPoint / 100) * $divider);
                    $newPoint = intval(($newPoint / 100) * $divider);
                    
                    $i = 0;
                    for($oldPoint; $oldPoint >= $newPoint; $oldPoint--){
                        $flow = round(($oldPoint / $divider) * 100);
                        $inc = $oldPoint;
                        $info['bound'] = $inc;
    
                        $text = str_repeat($charAnime, $inc);
                        // $mod = $modifier($flow);
                        // if(is_array($mod)) $mod = (object) $mod;
                        $mod = self::modified($modifier, str_split((string)$flow), 'string');
                        $color = property_exists($mod, 'textColor')? $mod->textColor : CliForms::text_field_color;
                        $bdcolor = property_exists($mod, 'borderColor')? $mod->borderColor : CliForms::text_field_color;
    
                        if($type === 'slider'){
                            $text = Cli::color($text, $color);
                            $text .= Cli::bgcolor('  ', $color); // slider
                            $rollerGrow = $info['box-w'] - 2 - $inc;
                            $rollerGrow = $rollerGrow < 0? 0 : $rollerGrow;
                            $text .= str_repeat($charAnime, $rollerGrow);
                        }else{
                            $text = ($charAnime === ' ')? Cli::bgcolor($text, $color) : Cli::color($text, $color);
                        }
    
                        $i++;
                        Cli::moveDown()->clearUp(2);
                        $GhostFunction->drawField(increase: $increase, color: $bdcolor);
                        $GhostFunction->writeInput($text);
                        Cli::moveBack();
                        Cli::wait($animationEffect);
                    }
                    if($newPoint === 0 && $type !== 'slider'){
                        if($info['placeholder']){
                            $GhostFunction->drawField(increase: $increase, color: $bdcolor);
                            $GhostFunction->writeInput($info['placeholder']);
                            echo Cli::moveStart($info['margin'] + 1);
                            return false;
                        }
                    }
                    $incremental = $increase;
                }
            }else{
                if($increase === 0 && $type !== 'slider'){
                    if($info['placeholder']){
                        $GhostFunction->drawField(increase: $increase, color: $bdcolor);
                        $GhostFunction->writeInput($info['placeholder']);
                        echo Cli::moveStart($info['margin'] + 1);
                        return false;
                    }
                }
                Cli::moveDown()->clearUp(2);
                $GhostFunction->drawField(increase: $increase, color: $bdcolor);
                $GhostFunction->writeInput($text);
                Cli::moveBack();
      
            }
  
          }elseif ($key->isArrow('right') || $key->isArrow('up')){
            
            $divider = $type === 'slider'? $info['box-w'] - 2 : $info['box-w'];

            $incremental = $increase;
            if(($info['bound'] < $info['box-w']) && (array_key_exists($increase + 1, $info['percents']))) {
                $increase++;
                $inc = $info['percents'][$increase];
                $inc = intval(($inc / 100) * ($divider));
                $info['bound'] = $inc;
            }else{
                return false;
            }

            if($modifier){
                $text = str_repeat($charAnime, $inc);
                // $mod = $modifier($info['percents'][$increase]);
                // if(is_array($mod)) $mod = (object) $mod;
                
                $mod = self::modified($modifier, str_split((string)($info['percents'][$increase])),'string');
                $color = property_exists($mod, 'textColor')? $mod->textColor : CliForms::text_field_color;
                $bdcolor = property_exists($mod, 'borderColor')? $mod->borderColor : CliForms::text_field_color;

                if($type === 'slider'){
                    $text = Cli::color($text, $color);
                    $text .= Cli::bgcolor('  ', $color); // slider
                    $rollerGrow = $info['box-w'] - 2 - $inc;
                    $rollerGrow = $rollerGrow < 0? 0 : $rollerGrow;
                    $text .= str_repeat($charAnime, $rollerGrow);
                }else{
                    $text = ($charAnime === ' ')? Cli::bgcolor($text, $color) : Cli::color($text, $color);
                }

            }
            
            // Animation removal

            if($animationEffect){
                if($incremental !== $increase){
                    $oldPoint = $info['percents'][$incremental]; 
                    $newPoint = $info['percents'][$increase];
    
                    $oldPoint = intval(($oldPoint / 100) * $divider);
                    $newPoint = intval(($newPoint / 100) * $divider);
                    
                    $i = 0;
                    for($oldPoint; $oldPoint <= $newPoint; $oldPoint++){
                        $flow = round(($oldPoint / $divider) * 100);
                        $inc = $oldPoint;
                        $info['bound'] = $inc;

                        $text = str_repeat($charAnime, $inc);
                        // $mod = $modifier($flow);
                        // if(is_array($mod)) $mod = (object) $mod;
                        
                        $mod = self::modified($modifier, str_split((string)$flow), 'string');
                        $color = property_exists($mod, 'textColor')? $mod->textColor : CliForms::text_field_color;
                        $bdcolor = property_exists($mod, 'borderColor')? $mod->borderColor : CliForms::text_field_color;
    
                        if($type === 'slider'){
                            $text = Cli::color($text, $color);
                            $text .= Cli::bgcolor('  ', $color); // slider
                            $rollerGrow = $info['box-w'] - 2 - $inc;
                            $rollerGrow = $rollerGrow < 0? 0 : $rollerGrow;
                            $text .= str_repeat($charAnime, $rollerGrow);
                        }else{
                            $text = ($charAnime === ' ')? Cli::bgcolor($text, $color) : Cli::color($text, $color);
                        }
    
                        $i++;
                        Cli::moveDown()->clearUp(2);
                        $GhostFunction->drawField(increase: $increase, color: $bdcolor);
                        $GhostFunction->writeInput($text);
                        Cli::moveBack();
                        Cli::wait($animationEffect);
                    }
                    $incremental = $increase;
                }
            }else{

                Cli::moveDown()->clearUp(2);
                $GhostFunction->drawField(increase: $increase, color: $bdcolor);
                $GhostFunction->writeInput($text);
                Cli::moveBack();
      
            }
          }
  
          //Apply validations here ... 
  
        });
  
    }
}