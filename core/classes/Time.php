<?php

namespace spoova\core\classes;

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

  }
  

  public static function difference($difference){
    
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

  public static function valid_minute($num){

    $time_arr = self::$all;
    $year  = $time_arr['year'];
    $month = $time_arr['month'];
    $day   = $time_arr['day'];
    $hour  = $time_arr['hour'];
    $min   = $time_arr['min'];
    $sec   = $time_arr['sec'];
    
    if($year > 0 || $month > 0 || $day > 0 || $hour > 0 || $min > $num){
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

  private static function time_ago($year, $month, $day, $hour, $min, $sec) {
      if($year>0){
        $time = $year." ".self::textFrom($year, 'year');
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
      }elseif($sec>0){
        $time = "just now";
      }
       return $time;    
  }

  private static function time_diff($year, $month, $day, $hour, $min, $sec) {
      if($year > 0){
        $time = $year."".self::textFrom($year, 'year').", ";
      }elseif($month > 0){
        $time = $month."".self::textFrom($year, 'month').", ";
      }elseif($day > 0){
        $time = $day."".self::textFrom($year, 'day').", ";
      }elseif($hour > 0){
        $time = $hour."".self::textFrom($year, 'hour').", ";
      }elseif($min > 0){
        $time = $min."".self::textFrom($min, 'hour').", ";
      }elseif($sec > 0){
        $time = $sec."".self::textFrom($sec, 'hour').", ";
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
    return ($value > 1)? $name."s" : $value;
  }

}

//USAGE
//---------------
//Time::setTime(first,last)
//Time::difference(second || minute || hour || day || month || year || all)
//Time::convert(&$date, 'ago) coverts date using the present moment as the difference //result(yr|mth|sec|mins ago)
?>
