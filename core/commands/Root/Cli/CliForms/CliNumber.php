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

    use CliFormsModifier;

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
  public static function number(string $placeholder = '', string $hint = '',  ?int $value = null, bool $required = false, ?int $maxlength = null, array $design = self::design, ?Closure $modifier = null, ?Closure $onEnd = null){
      self::use_requirements();

      $draft = self::draft('text', compact('placeholder','required','maxlength','design','modifier') );
        
      // Get : shape, width, height, margin, info, borderColor, textColor, defaults, cursor
      $shape = $draft['shape'];
      $width = $draft['width'];
      $height = $draft['height'];
      $margin = $draft['margin'];
      $info = $draft['info'];
      $borderColor = $draft['borderColor'];
      $textColor = $draft['textColor'];
      $defaults = $draft['defaults'];
      $cursor = $draft['cursor'];
      $advance = $defaults['advance'];
      $modifier = $draft['modifier'];

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

      if($info['placeholder'] && !$value){
          $GhostFunction->drawField($borderColor); // Start by drawing the input field
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

          $mod = self::modified($modifier, $defaults, mb_str_split($value));

          $borderColor = $mod->borderColor;
          $textColor = $mod->textColor;

          $GhostFunction->drawField($borderColor); // Start by drawing the input field
          $GhostFunction->writeInput(Cli::color($value, $textColor));
          $cursor = strlen($value);
      }

      Cli::blinkCursor(); // Start by blinking cursor
      
      // Stream input into the text box field ......................................................................
      return Cli::input(function(CliKey $key) use ($borderColor, $defaults, &$info, &$cursor, &$required, $GhostFunction, $advance, $onEnd, $modifier) {
        
        if($key->isExit() || $key->isEnter()){

                if($key->isExit()){
                  if($onEnd){ 
                    Cli::moveDown()->break(1);
                    $message = $onEnd(new CliTransmit($key, implode('', $info['chars'])));
                    if($key->isExit()) Cli::break(1);
                    return $message;
                  }
                }else{
                  if($required){
                    $chars = implode('', $info['chars']);
                    if(!$chars) {
                          $GhostFunction->showText(Cli::danger('﹡Required'), $info['margin']);
                          return false;
                    }
                  }
                  Cli::moveDown();
                  $key->exit();
                  Cli::moveDown();
                  $message = $onEnd(new CliTransmit($key, implode('', $info['chars'])));
                  return $message;
                }
            
        }elseif($key->isBackspace()){

          $chars = $info['chars'];
          unset($chars[$cursor - 1]);
          if($info['bound'] > 0 && (count($info['chars']) < $info['x'])) $info['bound']--;
          if($cursor > 0) $cursor--;
          $info['chars'] = array_values($chars);
          $advance->advance = null;
          
          $mod = self::modified($modifier, $defaults, $chars);

          $borderColor = $mod->borderColor;
          $textColor = $mod->textColor;

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
            $mod = self::modified($modifier, $defaults, $chars);

            $borderColor = $mod->borderColor;
            $textColor = $mod->textColor;

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

        }elseif ($key->isArrow('right')){
          
          //get extreme right boundary with consideration for cursor occupying position
          $xe = ($info['bound'] === ($info['x'] - 1))? true : false;

          $chars = $info['chars'];
          $mod =  self::modified($modifier, $defaults, $chars);

          $borderColor = $mod->borderColor;
          $textColor = $mod->textColor;

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
          
          $chars = $info['chars'];
          $input =  implode('',$info['chars']);
          
          if(!is_numeric($value)) {

              $mod =  self::modified($modifier, $defaults,  $chars);

              $borderColor = $mod->borderColor;
              $textColor = $mod->textColor;

              $bdColor = $info['bdcolor-state'] ?? $borderColor;
              Cli::saveCursor(); 
              Cli::moveDown()->clearUp($info['y'] + 1);
              Cli::hideCursor();
              $GhostFunction->drawField('danger');
              
              $GhostFunction->writeInput($info['text-state'] ?? $input);
              Cli::restoreCursor();
              Cli::wait(100000);              
              Cli::moveDown()->clearUp($info['y'] + 1);
              Cli::showCursor();
              $GhostFunction->drawField($bdColor);
              $GhostFunction->writeInput($info['text-state'] ?? $input);

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
          $info['color'] = ((count($info['chars']) -1) > 5)? 'red' : $borderColor;

          $mod = self::modified($modifier, $defaults, mb_str_split($input));

          $borderColor = $mod->borderColor;
          $textColor = $mod->textColor;

          $info['bdcolor-state'] = $textColor;

          if($required){
            $required = false;
            $GhostFunction->showText('', $info['margin'] + 1);
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