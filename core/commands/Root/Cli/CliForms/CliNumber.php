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

trait CliNumber {

  /**
   * Creates an input text field on the CLI screen
   *
   * @param string $placeholder a default text when field is empty.
   * @param string $hint title of the text field.
   * @param int $value default value of text field.
   * @param boolean $required determines when a text field must be filled.
   * @param int $maxlength determines maximum length of input.
   * @param array $design sets a list of predefined design keys and value pairs
   *   - borderColor : sets default border color
   *   - textColor   : sets default text color
   *   - shape       : sets input field shape
   *   - width       : sets width of input field, the minimum is 25.
   * @param Closure|null $modifier sets a border color or text color for input field.
   * @param Closure|null $onEnd callback closure(CliTransmit $form) function triggered when the form is submitted or terminated.
   * @return string response
   */
  public static function number(string $placeholder = '', string $hint = '',  ?int $value = null, bool $required = false, ?int $maxlength = null, array $design = ['width'=>25, 'indent' => 0, 'shape'=>'square','color'=>CliForms::text_field_color,'borderColor'=>CliForms::text_field_color], ?Closure $modifier = null, ?Closure $onCancel = null){
      self::use_requirements();
      $width = $design['width'] ?? 25;
      $margin = $design['indent'] ?? 0;
      $shape = $design['shape'] ?? 'square';
      $color = $design['color'] ?? CliForms::text_field_color;
      $borderColor = $design['borderColor'] ?? CliForms::text_field_color;

      // set accepted configuration for default values 
      if(!in_array($shape, ['square','round'])) $shape = 'square';
      if(!in_array($color, ['red','blue','white','yellow'])) $shape = CliForms::text_field_color;
      if(!in_array($borderColor, ['red','blue','white','yellow'])) $borderColor = CliForms::text_field_color;
      $width = (!is_numeric($width) || ($width < 25))? 25 : (int) $width;
      $margin = (!is_numeric($margin))? 0 : (int) $margin;
      $margin = CliDraw::fitIndent($margin);            // guard against excessive indent
      $width  = CliDraw::fitWidth($width, $margin);     // keep box within the screen

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
      $info['bound'] = 0;

      $info['bdcolor-state'] = CliForms::text_field_color;
      $info['text-state'] = '';
      $required = false;

      if(!$modifier){
        $modifier = function(array $chars){
          
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
      $GhostFunction = new GhostFunction(['drawField','writeInput','showText','toAsterisk'],'GhostFunction');

      // Define activity to draw input field when method is called
      $GhostFunction->drawField(function($color = CliForms::text_field_color, int $marginTop = 0) use($shape, $width, $height, $margin, $hint){      

        CliDraw::textBox($width, $height, $margin, $color, $hint, $shape);
        Cli::moveUp($marginTop); //fit cursor using margin specified.

      });
      
      //Define activity to write a new text into the text box created
      $GhostFunction->writeInput(function($text = '') use($margin, $width) {
        Cli::moveStart($margin + 1)
            ->textPlain(str_repeat(' ', $width))
            ->moveStart($margin + 1);
        if($text) Cli::textPlain($text);
      });

      // Define activity for displaying a text below the input field (For testing purpose)
      $GhostFunction->showText(function($text, $indent = 0){
        Cli::saveCursor();
        Cli::moveDown(2)->clearLine()->textPlain($text, $indent);
        Cli::restoreCursor();
      });

      $GhostFunction->drawField($color); // Start by drawing the input field
      if($info['placeholder']){
        $GhostFunction->writeInput($info['placeholder']);
        Cli::moveStart($info['margin'] + 1);
      }

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
      
      // Stream input into the text box field ......................................................................
      return Cli::input(function(CliKey $key) use (&$info, &$cursor, &$required, $GhostFunction,$onCancel, $modifier) {
        
        if($key->isSignal()){

          if(!$onCancel){
            if($key->inSignals([SIGTERM, SIGTSTP, SIGQUIT, SIGSTOP, SIGINT])){
              $text = Cli::textIndent('❌  Cancelling ...', $info['margin']);
    
              Cli::break(2)->hideCursor(function() use($text){
                Cli::pulseView($text, eachChar: fn($char) => Cli::danger($char))
                      ->wait(50000)
                      ->pulseToggle(3, 10, 50000)
                      ->pulseBack(strlen($text))
                      ->showCursor()
                      ->break(1)
                    ;
              });
            }
          }else{
            $onCancel();
          }
          
        }elseif($key->isBackspace()){

          $chars = $info['chars'];
          unset($chars[$cursor - 1]);
          if($info['bound'] > 0 && (count($info['chars']) < $info['x'])) $info['bound']--;
          if($cursor > 0) $cursor--;
          $info['chars'] = array_values($chars);

          $modifier = $modifier($chars);
          if(is_array($modifier)) $modifier = (object) $modifier;

          if(is_object($modifier)){
            $borderColor = property_exists($modifier, 'borderColor') ? $modifier->borderColor : CliForms::text_field_color;
            $textColor = property_exists($modifier, 'textColor') ? $modifier->textColor : CliForms::text_field_color;  
          }else{
            $borderColor = CliForms::text_field_color;
            $textColor = CliForms::text_field_color;
          }

          //get full characters string
          $charsText = implode('', $info['chars']);
          
          //get characters starting from cursor position to the end of string
          $charsRange = mb_substr($charsText, $cursor - $info['bound'], $info['x']);
          
          // get left and right characters from textbox view using cursor column in boundary
          $charsAtLeft = mb_substr($charsRange, 0, $info['bound']);
          $charsAtRite = mb_substr($charsRange, $info['bound']);

          $charsString = mb_substr($charsAtLeft." ".$charsAtRite, 0, $info['x']);
          
          // Clear entire input text field
          Cli::moveDown()->clearUp($info['y'] + 1);

          $info['bdcolor-state'] = $borderColor;

          $GhostFunction->drawField($borderColor);
          if((count($info['chars']) === 0)){
            if($info['placeholder']) $charsString = $info['placeholder'];
            if($info['required']){
              $GhostFunction->showText(Cli::danger('﹡Required'), $info['margin']);
              $required = true;
            }
          }
          $info['text-state'] = Cli::color($charsString, $textColor);
          $GhostFunction->writeInput($info['text-state']);
          Cli::moveStart($info['margin'] + 1);

          if($info['bound'] > 0) Cli::moveFront($info['bound']);

        }elseif ($key->isArrow('left')){

          $home = ($info['bound'] === 0)? true : false;
          if($info['bound'] - 1 >= 0) $info['bound']--;

          if($info['bound']>=0){

            $chars = $info['chars'];
            $modifier = $modifier($chars);
            if(is_array($modifier)) $modifier = (object) $modifier;

            if(is_object($modifier)){
              $borderColor = property_exists($modifier, 'borderColor') ? $modifier->borderColor : CliForms::text_field_color;
              $textColor = property_exists($modifier, 'textColor') ? $modifier->textColor : CliForms::text_field_color;  
            }else{
              $borderColor = CliForms::text_field_color;
              $textColor = CliForms::text_field_color;
            }

            $info['bdcolor-state'] = $textColor;

            if($home){
              if(array_key_exists($cursor - 1, $info['chars'])){
                $newText = array_slice($info['chars'], $cursor - 1);
                $newText = implode('',$newText);
                Cli::saveCursor();
                $text = ' '.Cli::color(mb_substr($newText, 0, $info['x'] - 1), $textColor);
                $info['text-state'] = $text;
                Cli::textPlain($text)->restoreCursor();
                if(($cursor - 1) > -1)$cursor--;
              }
            }else{
              if($cursor >= 0){
                if($info['bound'] >= 0){
                  if(array_key_exists($cursor - 1, $info['chars'])){
                    $text = ' '.Cli::color($info['chars'][$cursor - 1]??'', $textColor);
                    $textItem = implode('', $info['chars']);
                    $textItem = mb_substr($textItem, abs(($cursor-1) - $info['bound']), $info['x']);
                    $textLeft = mb_substr($textItem, 0, $info['bound']);
                    $textRight = mb_substr($textItem, $info['bound']);
                    $textItem = mb_substr($textLeft." ".$textRight, 0, $info['x']);
                    $info['text-state'] = $textItem;
                    Cli::moveBack()->textPlain($text)->moveBack(2);
                  }
                }
                if(($cursor - 1) > -1)$cursor--;
              }
            }

          }
          
          // $GhostFunction->showText($info['bound'].':'.$cursor);

        }elseif ($key->isArrow('right')){
          
          //get extreme right boundary with consideration for cursor occupying position
          $xe = ($info['bound'] === ($info['x'] - 1))? true : false;

          $chars = $info['chars'];
          $modifier = $modifier($chars);
          if(is_array($modifier)) $modifier = (object) $modifier;

          if(is_object($modifier)){
            $borderColor = property_exists($modifier, 'borderColor') ? $modifier->borderColor : CliForms::text_field_color;
            $textColor = property_exists($modifier, 'textColor') ? $modifier->textColor : CliForms::text_field_color;  
          }else{
            $borderColor = CliForms::text_field_color;
            $textColor = CliForms::text_field_color;
          }

          $info['bdcolor-state'] = $textColor;

          if($xe){
            if($cursor !== count($info['chars'])){
              $cursor++;
              $bitChar = implode('',array_slice($info['chars'], $cursor - $info['bound'], $info['x'] - 1));
              $text = Cli::color($bitChar.' ', $textColor);
              $info['text-state'] = $text;
              Cli::moveStart($info['margin']+1)->textPlain($text)->moveBack();
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
                $text = Cli::color($bitChar.' ', $textColor);
                $textItem = implode('', $info['chars']);
                $textItem = mb_substr($textItem, abs(($cursor+1) - $info['bound']), $info['x']);
                $textLeft = mb_substr($textItem, 0, $info['bound']);
                $textRight = mb_substr($textItem, $info['bound']);
                $textItem = mb_substr($textLeft." ".$textRight, 0, $info['x']);
                $info['text-state'] = $textItem;
                Cli::textPlain($text)->moveBack();
                $cursor++;
              }
  
            }

          }

        }elseif ($key->isWritable()) {
          
          $value = $key->fetch();
          
          if(!is_numeric($value)) {
              $bdColor = $info['bdcolor-state'];
              Cli::saveCursor();
              Cli::moveDown()->clearUp($info['y'] + 1);
              $GhostFunction->drawField('red');
              $GhostFunction->writeInput($info['text-state']);
              Cli::restoreCursor();
              Cli::wait(100000);
              Cli::moveDown()->clearUp($info['y'] + 1);
              $GhostFunction->drawField($bdColor);
              $GhostFunction->writeInput($info['text-state']);
              Cli::restoreCursor();
              return false;
          }

          if($info['maxlength'] !== null){
            if(count($info['chars']) === $info['maxlength']) return false;
          }
          if($info['bound'] + 1 < $info['x']) $info['bound']++;

          $leftChars = array_values(array_slice($info['chars'], 0, $cursor)); // start point to cursor point 
          $rightChars = array_values(array_slice($info['chars'], $cursor)); // cursor point to end point
          $leftChars[] = $value; // append key pressed to characters in left position

          $fullChars = array_merge($leftChars, $rightChars); //all available characters in array list
          $fullString = implode('', $fullChars);

          $info['chars'] = $fullChars;
          $info['color'] = ((count($info['chars']) -1) > 5)? 'red' : CliForms::text_field_color;

          $modifier = $modifier($fullChars);
          if(is_array($modifier)) $modifier = (object) $modifier;

          if(is_object($modifier)){
            $borderColor = property_exists($modifier, 'borderColor') ? $modifier->borderColor : CliForms::text_field_color;
            $textColor = property_exists($modifier, 'textColor') ? $modifier->textColor : CliForms::text_field_color;  
          }else{
            $borderColor = CliForms::text_field_color;
            $textColor = CliForms::text_field_color;
          }

          $info['bdcolor-state'] = $textColor;

          if($required){
            $required = false;
            $GhostFunction->showText('', $info['margin'] + 1);
            // Cli::moveDown()->saveCursor()->clearUp(10)->restoreCursor()->moveUp();
          }
          // Clear entire input text field
          Cli::moveDown()->clearUp($info['y'] + 1);
          
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
          $info['text-state'] = Cli::color(mb_substr($charsString, 0, $info['x']), $textColor);
          $GhostFunction->writeInput($info['text-state']);

          if($info['bound'] < ($info['x']-1)){
            $bound = $info['bound']+1;          
            if($info['bound'] < $info['x']) {
              $bound -= 1;
            //  $info['bound']++;
            }
          }else if($info['bound'] == ($info['x']-1)){
            $bound = $info['bound'];
          }else{
            $bound = $info['bound'] - 1;
          }

          Cli::moveStart($info['margin']+1)->moveFront($bound);
          
          $cursor++;
          
        }elseif($key->isEnter()){

          Cli::break(3);
          $key->exit();
          return implode('', $info['chars']);

        }

        //Apply validations here ... 

      });

  }
    
}