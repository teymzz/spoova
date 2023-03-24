<?php

namespace spoova\mi\core\classes;

/**
 * Time class is used to subtract two time period. It allows for use
 * of UNIX_TIMESTAMP and Date Formats, returning values in time ago
 * where time can be Years, Months, Days, Hours, Minutes (and) Seconds ago.
 */
class TimeClass{

  private $all_set = false;
  private $firstTime;
  private $lastTime;
  private $year;
  private $month;
  private $day;
  private $hour;
  private $min;
  private $sec;
  private $all;
  private $type;

  /**
   * set time to be converted
   *
   * @param string $first old time (or date)
   * @param string $last new time (or date)
   * @param string $type timestamp | date
   * @locale 
   * @return void
   */
  public function setTime($first, $last, string  $type = 'date'){

    if($type !== 'date' and $type !== 'timestamp') trigger_error('type must be date or timestamp', E_USER_ERROR);
    $this->type  = $type;

  }
   
  public function getdifference($difference){
    
    $this->setdifference();
    if($this->all_set == false) return false;
    
    switch($difference){
      case "year":
          return $this->year;
          break;
      case "month":
          return $this->month;
          break;
      case "day":
          return $this->day;
          break;
      case "hour":
          return $this->hour;
          break;
      case "minute":
          return $this->min;
          break;
      case "second":
          return $this->sec;
          break;
      case "all":
          return $this->all;
          break;
    }

  }

  public function valid_minute($num){

    $time_arr = $this->all;
    $year  = $time_arr['year'];
    $month = $time_arr['month'];
    $day   = $time_arr['day'];
    $hour  = $time_arr['hour'];
    $min   = $time_arr['min'];
    $sec   = $time_arr['sec'];
    
    if($year > 0 || $month >0 || $day > 0 || $hour >0 || $min > $num){
        return false;
    }else{
        return true;
    }

  }

  private function setdifference(){

    $firstTime = $this->firstTime; //
    $lastTime  = $this->lastTime; //now
    $cur     = date("Y-m-d H:i:s");
    $now     = new \DateTime($cur);

    if($this->type === 'timestamp'){
      $firstTime = date('Y-m-d H:i:s',$firstTime);
      $lastTime = date('Y-m-d H:i:s',$lastTime);
    }

    if($firstTime!="0000-00-00 00:00:00"){$first = new \DateTime($firstTime); }else{ return "invalid time"; }
    if($lastTime!="0000-00-00 00:00:00"){$last = new \DateTime($lastTime); }else{ return "invalid time"; } //now  

    if(!empty($firstTime)&&!empty($lastTime)){
      $Date = $first->diff($last);
      $this->year  = $Date->y;
      $this->month = $Date->m;
      $this->day   = $Date->d;
      $this->hour  = $Date->h;
      $this->min   = $Date->i;
      $this->sec   = $Date->s;
      $all['year']  = $Date->y;
      $all['month'] = $Date->m;
      $all['day']   = $Date->d;
      $all['hour']  = $Date->h;
      $all['min']   = $Date->i;
      $all['sec']   = $Date->s;
      $this->all    = $all;
      $this->all_set = true;
    }
  }

  /**
   * This method will subtract the data supplied from the current time
   *
   * @param int|string $date time or date to be subtracted
   * @param string $type as type of $date as 'date' or 'timestamp'
   * @return string
   */
  public function distanceFrom($date, $type = 'date'){
    if($type ==='timestamp'){
      $date = date('Y-m-d H:i:s', $date);
    }
    return $this->convert_time($date);
  }


  public function convert_time(&$date){
   
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
       
      if($year>0){
        $time = $year." ".$this->textFrom($year, 'year');
      }elseif($month>0){
        $text = $this->textFrom($month, "month");
        $time = $month." ".$text." ago ";
      }elseif($day>0){
        $text = $this->textFrom($day, "day");;
        $time = $day." ".$text." ago ";
      }elseif($hour>0){
        $text = $this->textFrom($hour, "hour");
        $time = $hour." ".$text." ago ";
      }elseif($min>0){
        $text = $this->textFrom($min, "min");
        $time = $min." ".$text." ago ";
      }elseif($sec>0){
        $time = "just now";
      }
       return $time;
    }
  }

  /**
   * Undocumented function
   *
   * @param integer $value integer value of time
   * @param string $name 
   * @return string
   */
  private function textFrom(int $value, string $name){
    return ($value > 1)? $name."s" : $value;
  }

}

//USAGE
//---------------
//$Timer = new TimeClass;
//$Timer->setTime(first,last)
//$Timer->getDifference(second || minute || hour || day || month || year || all)
//$Timer->convert_time(&$date) coverts date using the present moment as the difference //result(yr|mth|sec|mins ago)
?>
