<?php 

namespace spoova\mi\core\commands\Root\Cli\CliForms;

use Closure;
use DateTime;
use spoova\mi\core\classes\Debug;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\classes\Ghost\GhostProxy;
use spoova\mi\core\classes\TClass;
use spoova\mi\core\commands\Root\Cli\CliDraw;
use spoova\mi\core\commands\Root\Cli\CliForms;
use spoova\mi\core\commands\Root\Cli\CliKey;

Trait CliDate {

    use CliFormsModifier;

    /**
     * Creates a date form field
     *
      * @param array|string $date date as d-m-Y; an optional second array item bounds the range.
     * @param string $hint
      * @param bool $required determines if an invalid date must be corrected before submission.
     * @param array $design containing array keys :  
     *   - indent : as indent from the left 
     *   - width : as the width of the date input box 
     * @param Closure|null $onEnd callback triggered when form is submitted (ENTER) or cancelled {@see CliKey::EXIT_SIGNALS}.
     * @return string
     */
    public static function date(array|string $date, string $hint = '', bool $required = false, array $design = [], ?Closure $onEnd = null){
      
        self::use_requirements();
        Cli::hideCursor();

        $date1 = is_array($date)? ($date[0] ?? date('d-m-Y')) : $date;
        $date2 = is_array($date)? ($date[1] ?? null) : null;
        $hasSecondDate = $date2 !== null && $date2 !== '';

        $separator = (is_string($date1) && strpos($date1, '/') !== false)? "/" : "-";

        $dateTime1 = self::parseCalendarDate($date1);
        $dateTime2 = $hasSecondDate? self::parseCalendarDate($date2) : null;
        if(!$dateTime1 || ($hasSecondDate && !$dateTime2)){
          $trace = Debug::get(0);
          Cli::textView(Cli::error('invalid input date supplied in '.$trace['file'].' on line '.$trace['line']));
          Cli::break(2);
          exit;
        }

        $rangeStart = null;
        $rangeEnd = null;
        if($dateTime2){
          $rangeStart = ($dateTime1 <= $dateTime2)? $dateTime1 : $dateTime2;
          $rangeEnd = ($dateTime1 <= $dateTime2)? $dateTime2 : $dateTime1;
        }
  
        $indent = $design['indent'] ?? 0;
        $indent = (is_numeric($indent)) ? (int) $indent : 0;
  
        $width = $design['width'] ?? 50;
        $width = (is_numeric($width)) ? (int) $width : 50;
        if($width < 16) $width = 16;
        $indent = CliDraw::fitIndent($indent);           // guard against excessive indent
        $width  = CliDraw::fitWidth($width, $indent);    // keep box within the screen
  
        $date = self::calendarDateParts($dateTime1);
        $datex[0] = self::calendarDateParts($rangeStart ?? $dateTime1);
        if($rangeEnd) $datex[1] = self::calendarDateParts($rangeEnd);
  
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
        $Ghost = new GhostFunction(['displayOptions','drawField','getColor','showText']);

        // Define activity to draw input field when method is called
        $Ghost->drawField(function($color = CliForms::text_field_color, int $marginTop = 0, array $posit = []) use($indent, $hint, &$date, $datex, $width, $separator){      
          
          // Draw a text field
          Cli::moveDown(1)->clearUp(2);
          CliDraw::textBox($width, indent: $indent, color: $color, title: $hint);
  
          // Update cursor position inside text field for text space allowance 
          Cli::moveUp($marginTop)->moveFront(1);
  
          $prefix = "Date:";
          $prefix = '';
          if($prefix) Cli::textPlain($prefix)->moveFront(1);
  
          $dateCount = count($date);
          $datemarks = $date;
  
          if($posit[0] === 1){
            $datemarks[0][$posit[1]] = Cli::underline($datemarks[0][$posit[1]]);
          }elseif($posit[0] === 2){
            $datemarks[1][$posit[1]] = Cli::underline($datemarks[1][$posit[1]]);
          }else{
            $datemarks[2][$posit[1]] = Cli::underline($datemarks[2][$posit[1]]);
          }
  
          $view = [implode('',$datemarks[0]), implode('',$datemarks[1]), implode('',$datemarks[2])];
          $view = implode(" $separator ", $view);
          Cli::textPlain($view);
  
          Cli::moveStart(($indent + 1) + 1 + strlen($prefix));
        });
  
        $Ghost->getColor(function($date) use($rangeStart, $rangeEnd){
          return self::isDateAllowed($date, $rangeStart, $rangeEnd)? CliForms::text_field_color : 'red';
        });

        $Ghost->showText(function($text, $indent = 0){
          $position = Cli::cursor('col');
          Cli::moveDown(2)->clearLine()->textPlain($text, $indent);
          Cli::moveTo(...$position);
        });
  
        $posit = [1, 0]; // set default at day and positional index at 0.
        
        Cli::break();
        $box['area'] = Cli::cursorPosition('col');
        $Ghost->drawField(posit: $posit);
  
        // Open input handler ........................................................................
        return Cli::input(function(CliKey $key) use(&$posit, &$Ghost, &$date, $datex, $rangeStart, $rangeEnd, $required, $indent, $onEnd, $box){
          
          $datemap['d'] = $date[0];
          $datemap['m'] = $date[1];
          $datemap['y'] = $date[2];
  
          $datemap['date'] = $posit[0]; // date index 1,2,3
          $datemap['cursor'] = $posit[1]; // cursor index 0,1,2
  
          if($key->isExit() || $key->isEnter()){ 
            
            $valid = self::isDateAllowed($date, $rangeStart, $rangeEnd);
            $color = $valid? CliForms::text_field_color : 'red';

            $posix = Cli::cursorPosition('col'); // store current position
            Cli::moveTo(...$box['area']);
            $Ghost->drawField(color: $color, posit: $posit);
            Cli::moveTo(...$posix); // move back to previous position

            if($key->isEnter() && !$valid && $required){
              $Ghost->showText(Cli::danger('﹡Required'), $indent);
              return false;
            }
                  
            $response = [
              'd' => implode('',$date[0]) + 0, 
              'm' => implode('',$date[1]) + 0,
              'y' => implode('',$date[2]) + 0,
            ];

            if($onEnd){
              
                Cli::moveDown()->break(1);
                $message = $onEnd(new CliTransmit($key, $valid? $response : false));
                if($key->isExit()) Cli::break(2);
                return $message;

            }else{
                if($key->isEnter()){
                    if(!$valid){
                      if($required) $Ghost->showText(Cli::danger('﹡Required'), $indent);
                      return false;
                    }
                    Cli::break(3);
                    $key->exit();
                    return $response;
                }else{
                    Cli::textView(Cli::warn('message:').' form terminated', $indent);
                    Cli::break(2);
                }
            }

          }elseif($key->isTab()){

            $front = 5 * $posit[0]; // cursor steps forward using date index
  
            $posit[1] = 0; // reset cursor index
            $posit[0]++; // increase date index
  
            if($posit[0] > count($date)){
              $posit[0] = 1;
              $front = 5 * 0;
            }
            Cli::moveTo(...$box['area']);
            $color = $Ghost->getColor($date);
            $Ghost->drawField(color: $color, posit: $posit);
            Cli::moveFront($front);

          }elseif($key->isArrow()){

            if($key->isArrow('right')){
            
              $datemark = $posit[0] - 1; // adjust date index
              $posit[1]++; // cursor positional index
              
              if($posit[1] > (count($date[$datemark]) - 1)) {
                $posit[1] = 0;
              }
              $posix = (($posit[0] - 1) * 5) + $posit[1];
    
              Cli::moveTo(...$box['area']);
              $color = $Ghost->getColor($date);
              $Ghost->drawField(color: $color, posit: $posit);
    
              Cli::moveFront($posix);

            }elseif($key->isArrow('left')){
    
              $datemark = $posit[0] - 1; //current section marker as day, month or year
              $posit[1]--; //positional index
              
              if($posit[1] < (0)) {
                $posit[1] = count($date[$datemark]) - 1;
              }
              $posix = (($posit[0] - 1) * 5) + $posit[1];
    
              $color = $Ghost->getColor($date);
              Cli::moveTo(...$box['area']);
              $Ghost->drawField(color: $color, posit: $posit);
    
              Cli::moveFront($posix);
    
            }elseif($key->isArrow('down')){
    
              $datemark = $posit[0] - 1; //current section marker as day, month or year
              $cal = ['d','m','y'];
              $type = $cal[$datemark];
    
              if($type === 'd'){
                $monthStart = DateTime::createFromFormat('!Y-n-j', implode('', $date[2]).'-'.implode('', $date[1]).'-1');
                if(!$monthStart) return false;
                $daysInMonth = (int) $monthStart->format('t');
                $value = implode('',$date[0]) + 0;
                $value--;
                if($value < 1){
                  $value = $daysInMonth;
                }
                $value = ($value < 10)? '0'.$value : $value;
                $date[0] = str_split($value);
                $date = self::normalizeCalendarDate($date, $rangeStart, $rangeEnd);
                $color = $Ghost->getColor($date);
                Cli::moveTo(...$box['area']);
                $Ghost->drawField(color: $color, posit: $posit);
              }else if ($type == 'm') {
                $value = implode('',$date[1]) + 0;
                $value--;
                if($value < 1){
                  $value = 12;
                }
                $value = ($value < 10)? '0'.$value : $value;
                $date[1] = str_split($value);
                $date = self::normalizeCalendarDate($date, $rangeStart, $rangeEnd);
                $color = $Ghost->getColor($date);
                Cli::moveTo(...$box['area']);
                $Ghost->drawField(color: $color, posit: $posit);
              }else if ($type == 'y') {
                $value = implode('',$date[2]) + 0;
                $value--;
                if(isset($datex[1])){
                  $minYear = implode('',$datex[0][2]);
                  $maxYear = implode('',$datex[1][2]);
                  if($minYear > $maxYear){
                    $min = $minYear; $max = $maxYear;
                    $minYear = $max; $maxYear = $min;
                  }
                  if($value < $minYear) {
                    $value = $maxYear;
                  }
                }elseif($value < 1){
                  $value = 9999;
                }
                $date[2] = str_split($value);
                $date = self::normalizeCalendarDate($date, $rangeStart, $rangeEnd);
                $color = $Ghost->getColor($date);
                // Cli::saveCursor();
                Cli::moveTo(...$box['area']);
                $Ghost->drawField(color:$color, posit: $posit);
                Cli::moveFront($posit[1]);
                // Cli::restoreCursor();
              }
    
            }elseif($key->isArrow('up')){

              $datemark = $posit[0] - 1; //current section marker as day, month or year
              $cal = ['d','m','y'];
              $type = $cal[$datemark];
    
              if($type === 'd'){
                $monthStart = DateTime::createFromFormat('!Y-n-j', implode('', $date[2]).'-'.implode('', $date[1]).'-1');
                if(!$monthStart) return false;
                $daysInMonth = (int) $monthStart->format('t');
                $value = implode('',$date[0]) + 0;
                $value++;
                if($value > $daysInMonth){
                  $value = 1;
                }
                $value = ($value < 10)? '0'.$value : $value;
                $date[0] = str_split($value);
                $date = self::normalizeCalendarDate($date, $rangeStart, $rangeEnd);
                $color = $Ghost->getColor($date);
                Cli::moveTo(...$box['area']);
                $Ghost->drawField(color: $color, posit: $posit);
              }else if ($type == 'm') {
                $value = implode('',$date[1]) + 0;
                $value++;
                if($value > 12){
                  $value = 1;
                }
                $value = ($value < 10)? '0'.$value : $value;
                $date[1] = str_split($value);
                $date = self::normalizeCalendarDate($date, $rangeStart, $rangeEnd);
                $color = $Ghost->getColor($date);
                Cli::moveTo(...$box['area']);
                $Ghost->drawField(color: $color, posit: $posit);
              }else if ($type == 'y') {
                $value = implode('',$date[2]) + 0;
                $value++;
                if(isset($datex[1])){
                  $minYear = implode('',$datex[0][2]);
                  $maxYear = implode('',$datex[1][2]);
                  if($minYear > $maxYear){
                    $min = $minYear; $max = $maxYear;
                    $minYear = $max; $maxYear = $min;
                  }
                  if($value > $maxYear) {
                    $value = $minYear;  
                  }
                }
                if($value > 9999){
                  $value = 1;
                }
                $date[2] = str_split($value);
                $date = self::normalizeCalendarDate($date, $rangeStart, $rangeEnd);
                $color = $Ghost->getColor($date);
                // Cli::saveCursor();
                // $cursor = Cli::cursorPosition();
                Cli::moveTo(...$box['area']);
                $Ghost->drawField(color:$color, posit: $posit);
                // Cli::moveTo($cursor['col'],$cursor['row']);
                Cli::moveFront($posit[1]);
                // Cli::restoreCursor();
              }

            }

            if($required && self::isDateAllowed($date, $rangeStart, $rangeEnd)){
              $Ghost->showText('', $indent + 1);
            }

          } elseif($key->isWritable()){
            
            $char = $key->fetch();
  
            if(is_numeric($char)){
  
              $cursorIndex = $posit[1];
  
              $value = $char + 0; // currently entered value
              $modified = false;
  
              if($posit[0] === 1){
                $firstChar = $date[0][0] + 0;
                $secondChar = $date[0][1] + 0;
                // manage days in date
                if($cursorIndex === 0){
                  if($value > 3) return false;
                  if($value > 2 && $secondChar > 1){
                    return false; // prevent input from exceeding number of months.
                  }elseif($value === 0){
                    if($secondChar === 0){
                      $date[0][1] = 1;
                      $modified = true;
                    }
                  }
                }elseif($cursorIndex === 1){
                  if(($firstChar === 0) && ($value === 0)){
                    $date[0][1] = 1; // reset second number
                    $modified = true;
                    $return = true;
                  }
                }
              }elseif($posit[0] === 2){
                // manage months
                $firstChar = $date[1][0] + 0;
                $secondChar = $date[1][1] + 0;
                if($cursorIndex === 0){
                  if($value > 1) return false; // restrict first month character to 1
                  if(($value > 0) && $secondChar > 2) {
                    if($value === 1){
                      $date[1][0] = 1;
                      $date[1][1] = 2; 
                      $modified = true;
                    }
                  }
                  if($value === 0){
                    if($secondChar < 1){
                      $date[1][1] = 1;  // reset second number
                      $modified = true;
                    }
                  }
                }elseif($cursorIndex === 1){
                  if($value > 2) return false;
                  if(($firstChar === 0) && ($value === 0)){
                      $date[1][1] = 1; // 12 conversion to 01
                      $modified = true;
                      $return  = true;
                  }
                }
              }elseif($posit[0] === 3){


               
              }
  
              if($modified){
                $posx = Cli::cursorPosition('col');
                $color = $Ghost->getColor($date);
                Cli::moveTo(...$box['area']);
                $Ghost->drawField(color: $color, posit: $posit);
                Cli::moveTo(...$posx);
                if(!empty($return)) return;
              }
  
              echo Cli::underline($char);
              $date[$posit[0]-1][$posit[1]] = $char;
              if($required && self::isDateAllowed($date, $rangeStart, $rangeEnd)){
                $Ghost->showText('', $indent + 1);
              }
              Cli::moveBack();
  
              $datemark = $posit[0] - 1;
              $current = $date[$datemark]; // current date section
              $posix = $posit[1];
              
              if($posix === (count($current) - 1)){
                $posx = Cli::cursorPosition('col');
                $value = implode('',$current) + 0;
                if($datemark === 0){
                  //resolve day
                  if($value > 31){
                    $date[$datemark][0] = 3;
                    $date[$datemark][1] = 1;
                    $color = $Ghost->getColor($date);
                    Cli::moveTo(...$box['area']);
                    $Ghost->drawField(color: $color, posit: $posit);
                    Cli::moveTo(...$posx);
                  }
                }elseif($datemark === 1){
                  //resolve month
                  if($value > 12){
                    $date[$datemark][0] = 1;
                    $date[$datemark][1] = 2;
                    $color = $Ghost->getColor($date);
                    Cli::moveTo(...$box['area']);
                    $Ghost->drawField(color: $color, posit: $posit);
                    Cli::moveTo(...$posx);
                  }
                }elseif($datemark === 2){
                  ///resolve year
                  
                }
              }
            }
          }
        });
  
      }

    private static function parseCalendarDate(mixed $value): ?DateTime {
      if(!is_string($value)) return null;

      $value = str_replace('/', '-', trim($value));
      if(!preg_match('/^(\d{1,2})-(\d{1,2})-(\d{4})$/', $value, $matches)) return null;

      $date = DateTime::createFromFormat('!d-m-Y', $value);
      $errors = DateTime::getLastErrors();
      if(!$date || ($errors && ($errors['warning_count'] || $errors['error_count']))) return null;
      if(!checkdate((int) $matches[2], (int) $matches[1], (int) $matches[3])) return null;
      if($date->format('d-m-Y') !== sprintf('%02d-%02d-%04d', $matches[1], $matches[2], $matches[3])) return null;

      return $date;
    }

    private static function calendarDateParts(DateTime $date): array {
      return [
        str_split($date->format('d')),
        str_split($date->format('m')),
        str_split($date->format('Y')),
      ];
    }

    private static function isDateAllowed(array $parts, ?DateTime $rangeStart, ?DateTime $rangeEnd): bool {
      $date = self::parseCalendarDate(implode('-', array_map('implode', $parts)));
      if(!$date) return false;
      if($rangeStart && $date < $rangeStart) return false;
      if($rangeEnd && $date > $rangeEnd) return false;
      return true;
    }

    private static function normalizeCalendarDate(array $parts, ?DateTime $rangeStart, ?DateTime $rangeEnd): array {
      $day = (int) implode('', $parts[0] ?? []);
      $month = (int) implode('', $parts[1] ?? []);
      $year = (int) implode('', $parts[2] ?? []);
      if($month < 1 || $month > 12 || $year < 1 || $year > 9999) return $parts;

      $monthStart = DateTime::createFromFormat('!Y-n-j', $year.'-'.$month.'-1');
      if(!$monthStart) return $parts;
      $day = min(max(1, $day), (int) $monthStart->format('t'));

      $date = self::parseCalendarDate(sprintf('%02d-%02d-%04d', $day, $month, $year));
      if(!$date) return $parts;
      if($rangeStart && $date < $rangeStart) $date = $rangeStart;
      if($rangeEnd && $date > $rangeEnd) $date = $rangeEnd;

      return self::calendarDateParts($date);
    }

}