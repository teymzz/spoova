<?php 

namespace spoova\mi\core\commands\Root\Cli\CliForms;

use Closure;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliKey;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\commands\Root\Cli\CliDraw;
use spoova\mi\core\commands\Root\Cli\CliForms;
use spoova\mi\core\commands\Root\Cli\CliScreen;

trait CliText {

    /**
     * Creates an input text field on the CLI screen
     *
     * @param string $placeholder a default text when field is empty.
     * @param string $hint title of the text field.
     * @param string $value default value of text field.
     * @param boolean $required determines when a text field must be filled.
     * @param int $maxlength determines maximum length of input.
     * @param array $design sets a list of predefined design keys and value pairs
     *   - borderColor : sets default border color
     *   - textColor   : sets default text color
     *   - shape       : sets input field shape
     *   - width       : sets width of input field, the minimum is 25.
     * @param Closure|null $modifier sets a border color or text color for input field.
     * @param Closure|null $onEnd callback closure(CliTransmit $form) function triggered when the form is submitted or terminated.
     * @uses CliForms::modified()
     * @return string response
     */
    public static function text(string $placeholder = '', string $hint = '',  ?string $value = null, bool $required = false, ?int $maxlength = null, array $design = ['width'=>25, 'indent' => 0, 'shape'=>'square','textColor'=>CliForms::text_field_color,'borderColor'=>CliForms::text_field_color], ?Closure $modifier = null, ?Closure $onEnd = null){

        self::use_requirements();
        $width = $design['width'] ?? 25;
        $margin = $design['indent'] ?? 0;
        $shape = $design['shape'] ?? 'square';
        $color = $design['textColor'] ?? CliForms::text_field_color;
        $borderColor = $design['borderColor'] ?? CliForms::text_field_color;
        $colors = ['red','blue',CliForms::text_field_color,'yellow']; //supported colors
        CliForms::setLines(3);

        // set accepted configuration for default values
        if(!in_array($shape, ['square','round'])) $shape = 'square';
        if(!in_array($color, $colors)) $shape = CliForms::text_field_color;
        if(!in_array($borderColor, $colors)) $borderColor = CliForms::text_field_color;
        $width = (!is_numeric($width) || ($width < 25))? 25 : (int) $width;
        $margin = (!is_numeric($margin))? 0 : (int) $margin;
        $margin = CliDraw::fitIndent($margin);           // guard against excessive indent
        $width  = CliDraw::fitWidth($width, $margin);    // keep box within the screen

        $info['x'] = $width; //width
        $info['y'] = $height = 1; //height
        $info['chars'] = []; // keep text characters
        $info['charsNum'] = 0; // keep text characters
        $info['margin'] = $margin; // left margin
        $info['placeholder'] = $placeholder; // left margin
        $info['color'] = CliForms::text_field_color;
        $info['required'] = $required;
        $info['maxlength'] = $maxlength;
        $cursor = 0; // text end point
        $info['bound'] = 0; // cursor column position within text field

        if(!$modifier){
            $modifier = function(array $chars){
            
                return (object) [
                    'chars' => $chars, 
                    'count' => count($chars), 
                    'textColor' => CliForms::text_field_color, 
                    'value' => implode('', $chars), 
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
        $GhostFunction = new GhostFunction(['drawField','writeInput','showText',['tim'=>'tam']],'GhostFunction');

        // Define activity to draw input field when method is called
        $GhostFunction->drawField(function($color = CliForms::text_field_color, int $marginTop = 0) use($shape, $width, $height, $margin, $hint){      

            CliDraw::textBox($width, $height, $margin, $color, $hint, $shape);
            Cli::moveUp($marginTop); //fit cursor using margin specified.

        });
        
        //Define activity to write a new text into the text box created
        $GhostFunction->writeInput(function($text = '') use($margin, $width) {
            Cli::cursorView(function()use($text,$margin,$width){
                Cli::moveStart($margin + 1)
                ->textPlain(str_repeat(' ', $width))
                ->moveStart($margin + 1);
                if($text) Cli::textPlain($text);
            });
        });
        
        // Define activity for displaying a text below the input field (For testing purpose)
        $GhostFunction->showText(function($text, $indent = 0){
            $posit = Cli::cursor('col');
            $cursorView = Cli::cursorView(); // get cursor view
            Cli::hideCursor(); // hide cursor
            Cli::moveDown(2)->clearLine()->textPlain($text, $indent);
            Cli::moveTo(...$posit); 
            Cli::cursorView($cursorView); // restore cursor view
        });

        if($info['placeholder'] && !$value){
            $GhostFunction->drawField($color); // Start by drawing the input field
            $GhostFunction->writeInput($info['placeholder']);
            Cli::moveStart($info['margin'] + 1);
        }elseif($value){
            $info['chars'] = str_split($value);
            if((strlen($value) < $info['x'])){
                $info['bound'] = strlen($value);
            }else{
                $info['bound'] = $info['x'] - 1;
                $value = substr($value, 0, $info['x'] - 1);
            }
            $mod = self::modified($modifier, mb_str_split($value));

            if(is_object($mod)){
                $borderColor = property_exists($mod, 'borderColor') ? $mod->borderColor : CliForms::text_field_color;
                $textColor = property_exists($mod, 'textColor') ? $mod->textColor : CliForms::text_field_color;  
            }else{
                $borderColor = CliForms::text_field_color;
                $textColor = CliForms::text_field_color;
            }

            $GhostFunction->drawField($borderColor); // Start by drawing the input field
            $GhostFunction->writeInput(Cli::color($value, $textColor));
            $cursor = strlen($value);
        }

        Cli::blinkCursor(); // Start by blinking cursor
        $required = false;
        
        // Stream input into the text box field ......................................................................
        return Cli::input(function(CliKey $key) use (&$info, &$cursor, &$required, $GhostFunction, $onEnd, $modifier) {

            if($key->isExit() || $key->isEnter()){ 

                if($onEnd){
                    Cli::moveDown()->break(1);
                    $message = $onEnd(new CliTransmit($key, implode('', $info['chars'])));
                    if($key->isExit()) Cli::break(2);
                    return $message;
                }else{
                    if($key->isEnter()){
                        Cli::break(3);
                        $key->exit();
                        return implode('', $info['chars']);
                    }else{
                        Cli::textView(Cli::warn('message:').' form terminated', $info['margin']);
                    }
                }

            }elseif($key->isBackspace()){
                $chars = $info['chars'];
                unset($chars[$cursor - 1]);
                if($info['bound'] > 0 && (count($info['chars']) < $info['x'])) $info['bound']--;
                if($cursor > 0) {$cursor--;}
                $info['chars'] = array_values($chars);

                $modifier = self::modified($modifier, $chars);

                if(is_object($modifier)){
                    $borderColor = property_exists($modifier, 'borderColor') ? $modifier->borderColor : CliForms::text_field_color;
                    $textColor = property_exists($modifier, 'textColor') ? $modifier->textColor : CliForms::text_field_color;  
                }else{
                    $borderColor = CliForms::text_field_color;
                    $textColor = CliForms::text_field_color;
                }

                // get full characters string
                $charsText = implode('', $info['chars']);

                // cursor position minus the current cursor column
                $cursorBound = $cursor - $info['bound'];
                if($cursorBound < 0) {
                    $cursorBound = 0;
                    if($info['bound'] > 0) $info['bound']--;
                }

                // get characters starting from cursor position to the end of string
                $charsRange = mb_substr($charsText, $cursorBound, $info['x']);
                // $GhostFunction->showText($cursor.'-'.$info['bound'].':'.$cursorBound);
                
                // get left and right characters from textbox view using cursor column in boundary
                $charsAtLeft = mb_substr($charsRange, 0, $info['bound']);
                $charsAtRite = mb_substr($charsRange, $info['bound']);

                $charsString = mb_substr($charsAtLeft." ".$charsAtRite, 0, $info['x']);
                
                // Clear entire input text field
                Cli::cursorView(fn()=>Cli::moveDown()->clearUp($info['y'] + 1));

                $GhostFunction->drawField($borderColor);
                if((count($info['chars']) === 0)){
                    if($info['placeholder']) $charsString = $info['placeholder'];
                    if($info['required']){
                        $GhostFunction->showText(Cli::danger('﹡Required'), $info['margin']);
                        $required = true;
                    }
                }
                $GhostFunction->writeInput(Cli::color($charsString, $textColor));
                Cli::cursorView(fn() => Cli::moveStart($info['margin'] + 1));
                if($info['bound'] > 0) Cli::moveFront($info['bound']);

            }elseif ($key->isArrow('left')){

                $home = ($info['bound'] === 0)? true : false;
                if($info['bound'] - 1 >= 0) $info['bound']--;

                if($info['bound']>=0){

                    $chars = $info['chars'];
                    $modifier = self::modified($modifier, $chars);

                    if(is_object($modifier)){
                        $borderColor = property_exists($modifier, 'borderColor') ? $modifier->borderColor : CliForms::text_field_color;
                        $textColor = property_exists($modifier, 'textColor') ? $modifier->textColor : CliForms::text_field_color;
                    }else{
                        $borderColor = CliForms::text_field_color;
                        $textColor = CliForms::text_field_color;
                    }

                    if($home){
                        if(array_key_exists($cursor - 1, $info['chars'])){
                            $newText = array_slice($info['chars'], $cursor - 1);
                            $newText = implode('',$newText);
                            Cli::saveCursor();
                            Cli::textPlain(' '.Cli::color(mb_substr($newText, 0, $info['x'] - 1), $textColor))->restoreCursor();
                            if(($cursor - 1) > -1)$cursor--;
                        }
                    }else{
                        if($cursor >= 0){
                            if($info['bound'] >= 0){
                                if(array_key_exists($cursor - 1, $info['chars'])){
                                    Cli::moveBack()->textPlain(' '.Cli::color($info['chars'][$cursor - 1]??'', $textColor))->moveBack(2);
                                }
                            }
                            if(($cursor - 1) > -1)$cursor--;
                        }
                    }

                }
                $GhostFunction->showText($cursor.':'.$info['bound']);
            }elseif ($key->isArrow('right')){
            
                //get extreme right boundary with consideration for cursor occupying position
                $xe = ($info['bound'] === ($info['x'] - 1))? true : false;

                $chars = $info['chars'];
                $modifier = self::modified($modifier, $chars);

                if(is_object($modifier)){
                    $borderColor = property_exists($modifier, 'borderColor') ? $modifier->borderColor : CliForms::text_field_color;
                    $textColor = property_exists($modifier, 'textColor') ? $modifier->textColor : CliForms::text_field_color;  
                }else{
                    $borderColor = CliForms::text_field_color;
                    $textColor = CliForms::text_field_color;
                }

                if($xe){
                    if($cursor !== count($info['chars'])){
                        $cursor++;
                        $bitChar = implode('',array_slice($info['chars'], $cursor - $info['bound'], $info['x'] - 1));
                        Cli::cursorView(fn()=>Cli::moveStart($info['margin']+1)->textPlain(Cli::color($bitChar.' ', $textColor))->moveBack());
                    }
                }else{
                    if(($info['bound'] + 1) < $info['x']){
                        if($info['bound'] < count($info['chars']))$info['bound']++;
                    } 
                    
                    $bound = $info['bound'];
                    
                    if($cursor < count($info['chars'])){

                        if($bound <= ($info['x'] - 1)){
                            // prevent redraw (smooth transition)
                            $bitChar = $info['chars'][$cursor]??'';
                            Cli::cursorView(fn()=> Cli::textPlain(Cli::color($bitChar.' ', $textColor))->moveBack());
                            $cursor++;
                        }
        
                    }

                }

            }elseif ($key->isWritable()) {
            
                if($info['maxlength'] !== null){
                    if(count($info['chars']) === $info['maxlength']) return false;
                }
                if($info['bound'] + 1 < $info['x']) $info['bound']++;

                $leftChars = array_values(array_slice($info['chars'], 0, $cursor)); // start point to cursor point 
                $rightChars = array_values(array_slice($info['chars'], $cursor)); // cursor point to end point
                $leftChars[] = $key->fetch(); // append key pressed to characters in left position

                $fullChars = array_merge($leftChars, $rightChars); //all available characters in array list
                $fullString = implode('', $fullChars);

                $info['chars'] = $fullChars;
                $info['color'] = ((count($info['chars']) -1) > 5)? 'red' : CliForms::text_field_color;

                $modifier = self::modified($modifier, $fullChars);

                if(is_object($modifier)){
                    $borderColor = property_exists($modifier, 'borderColor') ? $modifier->borderColor : CliForms::text_field_color;
                    $textColor = property_exists($modifier, 'textColor') ? $modifier->textColor : CliForms::text_field_color;  
                }else{
                    $borderColor = CliForms::text_field_color;
                    $textColor = CliForms::text_field_color;
                }

                if($required){
                    $required = false;
                    $GhostFunction->showText('', $info['margin'] + 1);
                }
                // Clear entire input text field
                Cli::cursorView(fn()=>Cli::moveDown()->clearUp($info['y'] + 1));
                
                // Redraw input text field with border color
                $GhostFunction->drawField($borderColor);

                // Get Text starting point
                $startPoint = ($cursor - $info['x'] + 1);

                if($startPoint < 0){
                    $startPoint = 0;
                }else{
                    $startPoint = abs($startPoint);
                    if(($info['bound']+1) >= $info['x']){
                        $startPoint += 1;
                    }
                }

                //get characters starting from cursor position to the end of string
                $charsRange = mb_substr($fullString, $cursor+1 - $info['bound'], $info['x']);
                
                // get left and right characters from textbox view using cursor column in boundary
                $charsAtLeft = mb_substr($charsRange, 0, $info['bound']);
                $charsAtRite = mb_substr($charsRange, $info['bound']);

                $charsString = $charsAtLeft." ".$charsAtRite;
                $GhostFunction->writeInput(Cli::color(mb_substr($charsString, 0, $info['x']), $textColor));

                if($info['bound'] < ($info['x']-1)){
                    $bound = $info['bound']+1;          
                    if($info['bound'] < $info['x']) {
                        $bound -= 1;
                    }
                }else if($info['bound'] == ($info['x']-1)){
                    $bound = $info['bound'];
                }else{
                    $bound = $info['bound'] - 1;
                }

                Cli::cursorView(fn() => Cli::moveStart($info['margin']+1)->moveFront($bound));
                
                $cursor++;
            
            }

            // Apply validations later here ... 

        });

    }

}