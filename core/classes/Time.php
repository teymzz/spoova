<?php

namespace spoova\mi\core\classes;

/**
 * Time class is used to subtract two time period. It allows for use
 * of UNIX_TIMESTAMP and Date Formats, returning values in time ago
 * where time can be Years, Months, Days, Hours, Minutes (and) Seconds ago.
 */
class Time{

  private static $type;
  private static $all_set = false;
  private static $firstTime;
  private static $lastTime;
  private static $year;
  private static $month;
  private static $day;
  private static $hour;
  private static $min;
  private static $sec;
  private static $all;

  /**
   * set time to be converted
   *
   * @param string $first old time (or date)
   * @param string $last new time (or date)
   * @param string $type timestamp | date
   * @locale 
   * @return void
   */
  public static function setTime($first, $last, string  $type = 'date'){

    if($type !== 'date' and $type !== 'timestamp') trigger_error('type must be date or timestamp', E_USER_ERROR);
    self::$type  = $type;

    /* the two times used to be dropped on the floor here, which left setdifference()
       comparing NULL against NULL and every difference() reading FALSE */
    self::$firstTime = $first;
    self::$lastTime  = $last;

    // the previous span's readings are no longer the answer to this one
    self::$all_set = false;

  }
  
  /**
   * Return the time difference in seconds, minutes, hour, day, month or year
   *
   * @param string $difference optional [all|year|month|day|hour|minute|second]
   *  - all : this option will return the full difference using a year - seconds format 
   *  - Other options will return value in respect to the option defined.
   * @return void
   */
  public static function difference(string $difference){
    
    self::setdifference();
    if(self::$all_set == false) return false;
    
    switch($difference){
      case "year":
          return self::$year;
          break;
      case "month":
          return self::$month;
          break;
      case "day":
          return self::$day;
          break;
      case "hour":
          return self::$hour;
          break;
      case "minute":
          return self::$min;
          break;
      case "second":
          return self::$sec;
          break;
      case "all":
          return self::$all;
          break;
    }

  }

  /**
   * This checks if number of minutes supplied is not greater than the difference obtained from two time ranges previously calculated.
   *
   * @param int $min the minute to be compared with the difference obtained from two time ranges.
   * @return void
   */
  public static function valid_minute($min){

    $time_arr = self::$all;
    $year  = $time_arr['year'];
    $month = $time_arr['month'];
    $day   = $time_arr['day'];
    $hour  = $time_arr['hour'];
    $dmin   = $time_arr['min'];
    $sec   = $time_arr['sec'];
    
    if($year > 0 || $month > 0 || $day > 0 || $hour > 0 || $dmin > $min){
        return false;
    }else{
        return true;
    }

  }

  private static function setdifference(){

    $firstTime = self::$firstTime; //
    $lastTime  = self::$lastTime; //now
    $cur     = date("Y-m-d H:i:s");
    $now     = new \DateTime($cur);

    if(self::$type === 'timestamp'){
      $firstTime = date('Y-m-d H:i:s',$firstTime);
      $lastTime = date('Y-m-d H:i:s',$lastTime);
    }

    if($firstTime!="0000-00-00 00:00:00"){$first = new \DateTime($firstTime); }else{ return "invalid time"; }
    if($lastTime!="0000-00-00 00:00:00"){$last = new \DateTime($lastTime); }else{ return "invalid time"; } //now  

    if(!empty($firstTime)&&!empty($lastTime)){
      $Date = $first->diff($last);
      self::$year  = $Date->y;
      self::$month = $Date->m;
      self::$day   = $Date->d;
      self::$hour  = $Date->h;
      self::$min   = $Date->i;
      self::$sec   = $Date->s;
      $all['year']  = $Date->y;
      $all['month'] = $Date->m;
      $all['day']   = $Date->d;
      $all['hour']  = $Date->h;
      $all['min']   = $Date->i;
      $all['sec']   = $Date->s;
      self::$all    = $all;
      self::$all_set = true;
    }
  }

  /**
   * This method will subtract the data supplied from the current time
   *
   * @param int|string $date time or date to be subtracted
   * @param string $type as type of $date as 'date' or 'timestamp'
   * @return string
   */
  public static function distanceFrom($date, $type = 'date'){
    if($type ==='timestamp'){
      $date = date('Y-m-d H:i:s', $date);
    }
    return self::convert($date, 'ago');
  }

  /**
   * Converts the time supplied to "time ago" or time difference (i.e in y,m,d,h,i,s)
   *
   * @param string $date date to be converted
   * @param string $type optional [ago|diff]
   *  - ago: returns difference in time ago 
   *  - diff: returns the full difference starting from highest unit (i.e years months days hours minutes seconds)
   * @return void
   */
  public static function convert(&$date, $type = 'ago'){
   
    $cur     = date("Y-m-d H:i:s");
    $now     = new \DateTime($cur);

    if($date!="0000-00-00 00:00:00"){
      $date = new \DateTime($date); 
    }else{
      return "invalid time"; 
    }

    if(!empty($date)){

      $Date = $date->diff($now);
      
      $year  = $Date->y;
      $month = $Date->m;
      $day   = $Date->d;
      $hour  = $Date->h;
      $min   = $Date->i;
      $sec   = $Date->s;
       
      if($type == 'ago') {
        return self::time_ago($year, $month, $day, $hour, $min, $sec);
      }

      if($type == 'diff') {
        return self::time_diff($year, $month, $day, $hour, $min, $sec);
      }
    }
  }

  /**
   * Converts a seconds time to a single unit format
   *
   * @param $value seconds to be converted to defined scale. A value below zero is read as zero.
   *   Since a zero span has no reading, both report FALSE.
   * @param string $scale
   *  - minutes : minutes, minute, mins, min, m
   *  - hours : hours, hour, hrs, hr, h
   *  - days : days, day, d
   *  - months : months, month, mon
   *  - years : years, year, yrs, yr, y
   *
   *  A month and a year have no fixed length in seconds, so both are averaged over the
   *  Gregorian calendar: a year of 365.2425 days and a month of exactly a twelfth of it.
   *  Reading a value in months and reading the same value in years therefore stay in step,
   *  which a flat 30 day month and 365 day year would not.
   * @param int|null $round decimal places to report the result to.
   *  - NULL : default. The result is reported in whole units only, so a value that has not
   *           reached the next unit still reads as the current one and 1.2 minutes gives 1.
   *  - 0 : rounds to the nearest whole unit instead, so 1.6 minutes gives 2.
   *  - 1 or above : rounds to that many decimal places.
   *
   * @return string|false FALSE when $value is 0 or below, is not numeric, or $scale is not one of the units above
   */
  public static function secondsTo($value, ?string $scale = null, ?int $round = null): string|false {

      $minute = 60;
      $hour   = $minute * 60;
      $day    = $hour * 24;
      $year   = $day * 365.2425; // mean Gregorian year
      $month  = $year / 12;

      /* every accepted spelling maps straight to its divisor. The previous version read
         the first one or two characters instead, which left "month" matching no branch at
         all even though it was an accepted scale - the undefined divisor then raised a
         DivisionByZeroError rather than returning FALSE. */
      $scales = [
          'minutes' => $minute, 'minute' => $minute, 'mins' => $minute, 'min' => $minute, 'm' => $minute,
          'hours'   => $hour,   'hour'   => $hour,   'hrs'  => $hour,   'hr'  => $hour,   'h' => $hour,
          'days'    => $day,    'day'    => $day,    'd'    => $day,
          'months'  => $month,  'month'  => $month,  'mon'  => $month,
          'years'   => $year,   'year'   => $year,   'yrs'  => $year,   'yr'  => $year,   'y' => $year,
      ];

      $scale = strtolower((string) $scale); // (string) so that a NULL scale does not raise a deprecation

      /* a span of time cannot run backwards, so anything below zero is read as zero. That
         happens before the guard below, so a negative span reports FALSE exactly as a zero
         span does rather than becoming a second way of saying nothing. */
      if(is_numeric($value) && $value < 0) $value = 0;

      if(!isset($scales[$scale]) || !is_numeric($value) || (float) $value === 0.0) return false;

      // a negative $round would otherwise be read by round() as a request to round off whole tens
      if($round !== null && $round < 0) $round = 0;

      $converted = $value / $scales[$scale];

      /* the fraction is discarded rather than floored, so that a negative duration loses
         its fraction the same way a positive one does */
      return ($round === null)? (int) $converted : round($converted, $round);
  }
  
  private static function time_ago($year, $month, $day, $hour, $min, $sec) {
      if($year>0){
        $text = self::textFrom($year, 'year');
        $time = $year." ".$text." ago ";
      }elseif($month>0){
        $text = self::textFrom($month, "month");
        $time = $month." ".$text." ago ";
      }elseif($day>0){
        $text = self::textFrom($day, "day");;
        $time = $day." ".$text." ago ";
      }elseif($hour>0){
        $text = self::textFrom($hour, "hour");
        $time = $hour." ".$text." ago ";
      }elseif($min>0){
        $text = self::textFrom($min, "min");
        $time = $min." ".$text." ago ";
      }else{
        // anything under a minute — including two times that are the same — has no unit to name
        $time = "just now";
      }
       return $time;
  }

  private static function time_diff($year, $month, $day, $hour, $min, $sec) {
      /* every branch below the first used to pluralize against $year and the last two
         named themselves 'hour', so a span of minutes read as a span of hours */
      if($year > 0){
        $time = $year." ".self::textFrom($year, 'year').", ";
      }elseif($month > 0){
        $time = $month." ".self::textFrom($month, 'month').", ";
      }elseif($day > 0){
        $time = $day." ".self::textFrom($day, 'day').", ";
      }elseif($hour > 0){
        $time = $hour." ".self::textFrom($hour, 'hour').", ";
      }elseif($min > 0){
        $time = $min." ".self::textFrom($min, 'min').", ";
      }else{
        $time = $sec." ".self::textFrom($sec, 'sec').", ";
      }
       return $time;
  }
  
  /**
   * Pluralize text string
   *
   * @param integer $value integer value of time
   * @param string $name 
   * @return string
   */
  private static function textFrom(int $value, string $name){
    /* the singular used to report $value rather than $name, so a span of one unit
       printed its count twice instead of naming itself — "1 1 ago" for "1 hour ago" */
    return ($value > 1)? $name."s" : $name;
  }

}

//USAGE
//---------------
//Time::setTime(first,last)
//Time::difference(second || minute || hour || day || month || year || all)
//Time::convert(&$date, 'ago') coverts date using the present moment as the difference //result(yr|mth|sec|mins ago)
?>
