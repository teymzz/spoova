<?php 

namespace spoova\mi\core\commands\Root\Cli\CliForms;

use Closure;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliKey;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\commands\Root\Cli\CliDraw;
use spoova\mi\core\commands\Root\Cli\CliScreen;

trait CliAlpha {

  /**
   * Creates an input that supports only alphabets (no spaces allowed)
   *
   * @param string $placeholder placeholder text for alpha box
   * @param string $hint hint text for alpha box (or box title)
   * @param string $value default alpha box form value
   * @param string $required determines if field is required
   * @param string $maxlength maximum length of value
   * @param array $design extended design features
   *   - width: specifies width of text field
   *   - indent: specifies margin from left
   *   - shape: optional [square|round]
   *   - textColor: specifies color of typed text.
   *   - borderColor: specifies border color of alpha text box.
   * @param ?Closure $modifier specifes a callback function triggered when the input is written
   * @param ?Closure $onEnd specifes a callback function triggered when the input field is terminated or value submitted
   * @uses Cli::input()
   * @return string
   */
  public static function alpha(string $placeholder = '', string $hint = '',  ?string $value = null, bool $required = false, ?int $maxlength = null, array $design = ['width'=>25, 'indent' => 0, 'shape'=>'square','textColor'=>'white','borderColor'=>'white'], ?Closure $modifier = null, ?Closure $onEnd = null){
      self::use_requirements();
      $width = $design['width'] ?? 25;
      $indent = $design['indent'] ?? 0;
      $shape = $design['shape'] ?? 'square';
      $color = $design['textColor'] ?? 'white';
      $borderColor = $design['borderColor'] ?? 'white';

      // set accepted configuration for default values 
      if(!in_array($shape, ['square','round'])) $shape = 'square';
      if(!in_array($color, ['red','blue','white','yellow'])) $shape = 'white';
      if(!in_array($borderColor, ['red','blue','white','yellow'])) $borderColor = 'white';
      $width = (!is_numeric($width) || ($width < 25))? 25 : (int) $width;
      $indent = (!is_numeric($indent))? 0 : (int) $indent;

      // Ensure width is not greater than screen width at initial draw
      $indent = CliDraw::fitIndent($indent);            // guard against excessive indent
      $width  = CliDraw::fitWidth($width, $indent);     // keep box within the screen

      $box = [];
      $info['x'] = $width; //width
      $info['y'] = $height = 1; //height
      $info['chars'] = []; // keep text characters
      $info['charsNum'] = 0; // keep text characters
      $info['margin'] = $indent; // left margin
      $info['placeholder'] = $placeholder; // left margin
      $info['color'] = 'white';
      $info['required'] = $required;
      $info['maxlength'] = $maxlength;
      $cursor = 0; // text end point
      $info['bound'] = 0;

      $info['bdcolor-state'] = 'white';
      $info['text-state'] = '';
      $required = false;

      if(!$modifier){
        $modifier = function(array|CliFlow $chars){
          
          return (object) [
            'chars' => $chars, 
            'count' => count($chars), 
            'value' => implode('', $chars),
            'textColor' => 'white', 
            'borderColor' => 'white', 
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
      $GhostFunction->drawField(function($color = 'white', int $marginTop = 0) use($shape, $width, $height, $indent, $hint, &$box){      
        
        (!$box)? ($box['area'] = Cli::cursor('col')) : Cli::moveTo(...$box['area']);// move to the box area first
        CliDraw::textBox($width, $height, $indent, $color, $hint, $shape);
        Cli::moveUp($marginTop); //fit cursor using margin specified.

      });
      
      //Define activity to write a new text into the text box created
      $GhostFunction->writeInput(function($text = '') use($indent, $width, &$box) {
        if(!isset($box['text-start'])){
          Cli::moveStart($indent + 1)
              ->textPlain(str_repeat(' ', $width))
              ->moveStart($indent + 1);
          $box['text-start'] = Cli::cursor('col');
        }else{
          Cli::moveTo(...$box['text-start']);
        }
        if($text) Cli::textPlain($text);
      });

      // Define activity for displaying a text below the input field (For testing purpose)
      $GhostFunction->showText(function($text, $indent = 0){
        $cursor = Cli::cursor('col');
        Cli::moveDown(2)->clearLine()->textPlain($text, $indent);
        Cli::moveTo(...$cursor);
      });


      if($info['placeholder'] && !$value){
        $GhostFunction->drawField($color); // Start by drawing the input field
        $GhostFunction->writeInput($info['placeholder']);
        Cli::moveTo(...$box['text-start']);
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
              $borderColor = property_exists($mod, 'borderColor') ? $mod->borderColor : 'white';
              $textColor = property_exists($mod, 'textColor') ? $mod->textColor : 'white';  
          }else{
              $borderColor = 'white';
              $textColor = 'white';
          }

          $GhostFunction->drawField($borderColor); // Start by drawing the input field
          $GhostFunction->writeInput(Cli::color($value, $textColor));
          $cursor = strlen($value);
      }


      Cli::blinkCursor(); // Start by blinking cursor
      
      // Stream input into the text box field ......................................................................
      return Cli::input(function(CliKey $key) use (&$info, &$cursor, &$required, $GhostFunction, $modifier, $onEnd) {
        
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

          Cli::hideCursor(); Cli::wait(2000);
          $chars = $info['chars'];
          unset($chars[$cursor - 1]);
          if($info['bound'] > 0 && (count($info['chars']) < $info['x'])) $info['bound']--;
          if($cursor > 0) $cursor--;
          $info['chars'] = array_values($chars);
          
          $modifier = self::modified($modifier, $chars);

          if(is_object($modifier)){
            $borderColor = property_exists($modifier, 'borderColor') ? $modifier->borderColor : 'white';
            $textColor = property_exists($modifier, 'textColor') ? $modifier->textColor : 'white';  
          }else{
            $borderColor = 'white';
            $textColor = 'white';
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
          Cli::showCursor();

        }elseif ($key->isArrow('left')){

          $home = ($info['bound'] === 0)? true : false;
          if($info['bound'] - 1 >= 0) $info['bound']--;

          if($info['bound']>=0){

            $chars = $info['chars'];
            
            $modifier = self::modified($modifier, $chars);

            if(is_object($modifier)){
              $borderColor = property_exists($modifier, 'borderColor') ? $modifier->borderColor : 'white';
              $textColor = property_exists($modifier, 'textColor') ? $modifier->textColor : 'white';  
            }else{
              $borderColor = 'white';
              $textColor = 'white';
            }

            $info['bdcolor-state'] = $textColor;

            if($home){
              if(array_key_exists($cursor - 1, $info['chars'])){
                $newText = array_slice($info['chars'], $cursor - 1);
                $newText = implode('',$newText);
                $posx = Cli::cursor('col');
                $text = ' '.Cli::color(mb_substr($newText, 0, $info['x'] - 1), $textColor);
                $info['text-state'] = $text;
                Cli::textPlain($text)->moveTo(...$posx);
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
          $modifier = self::modified($modifier, $chars);

          if(is_object($modifier)){
            $borderColor = property_exists($modifier, 'borderColor') ? $modifier->borderColor : 'white';
            $textColor = property_exists($modifier, 'textColor') ? $modifier->textColor : 'white';  
          }else{
            $borderColor = 'white';
            $textColor = 'white';
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
          
          Cli::hideCursor();
          Cli::wait(1000);
          $value = $key->fetch();
          
          if(!preg_match('/^[A-Za-z_]+$/',$value)) {
              $bdColor = $info['bdcolor-state'];
              $cursorPox = Cli::cursor('col');
              Cli::moveDown()->clearUp($info['y'] + 1);
              $GhostFunction->drawField('red');
              $GhostFunction->writeInput($info['text-state']);
              Cli::moveTo(...$cursorPox);
              Cli::wait(100000);
              Cli::moveDown()->clearUp($info['y'] + 1);
              $GhostFunction->drawField($bdColor);
              $GhostFunction->writeInput($info['text-state']);
              Cli::moveTo(...$cursorPox);
              Cli::showCursor();
              return false;
          }

          if($info['maxlength'] !== null){
            Cli::showCursor();
            if(count($info['chars']) === $info['maxlength']) return false;
          }
          if($info['bound'] + 1 < $info['x']) $info['bound']++;

          $leftChars = array_values(array_slice($info['chars'], 0, $cursor)); // start point to cursor point 
          $rightChars = array_values(array_slice($info['chars'], $cursor)); // cursor point to end point
          $leftChars[] = $value; // append key pressed to characters in left position

          $fullChars = array_merge($leftChars, $rightChars); //all available characters in array list
          $fullString = implode('', $fullChars);

          $info['chars'] = $fullChars;
          $info['color'] = ((count($info['chars']) -1) > 5)? 'red' : 'white';

          $modifier = self::modified($modifier, $fullChars);

          if(is_object($modifier)){
            $borderColor = property_exists($modifier, 'borderColor') ? $modifier->borderColor : 'white';
            $textColor = property_exists($modifier, 'textColor') ? $modifier->textColor : 'white';  
          }else{
            $borderColor = 'white';
            $textColor = 'white';
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
          Cli::showCursor();
          
        }elseif($key->isEnter()){

          Cli::break(3);
          $key->exit();
          return implode('', $info['chars']);

        }

        //Apply validations here ... 

      });

  }

}