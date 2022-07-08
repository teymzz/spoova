<?php

 namespace spoova\core\commands;
 
  /**
   * class Console 
   * 
   * @author Akinola Saheed <teymss@gmail.com>
   * @package core\commands
   * 
   * Spoova custom console class for logging console
   * 
   * Characters and Meanings.
   *  
   * ( >> ) directs console to add a new line with prefix of "syntax". dfs
   * 
   * ( << ) directs console to add a new line with prefix of "fix".
   * 
   * ( ++ ) directs console to add a new line (list).
   * 
   * NOTE: All lines added are automatically indented. This may not be accurate in some cases
   */
 class Console{

  /**
   * Application Name
   *
   * @var string
   */
  private static string $appName = '';

  protected static $isLoading;

  /**
   * Maximum number of commands
   *
   * @var integer
   */
  protected const max_commands_level = 5;

  /**
   * name of command supplied
   *
   * @var array
   */
  protected string $commandName = '';

  /**
   * description of command supplied
   *
   * @var string
   */
  protected string $commandDesc = '';

  /**
   * options of command supplied
   *
   * @var string
   */
  protected array $commandOptions = [];
  

  /**
   * message to be displayed when no argument is supplied
   *
   * @var string
   */
  protected $no_arguments_message; // default message when no argument is supplied
 
  /**
   * list of commands supplied along with information
   *
   * @var array
   */
  protected array $directives = [];

  /**
   * console_messages list of messages displayed on the console
   *
   * @var array
   */
  protected static array $console_messages = [];

  
  private const base_eol = PHP_EOL.PHP_EOL;

  public function __construct($appName = ''){

      self::$appName = $appName;

  }

  public function addCommand($name) {
    $this->directives[$name]['desc'] = '';
    $this->directives[$name]['options'] = [];
  }

  /**
   * Sorts all declared syntaxes found in arrays or strings
   *
   * @param array $outputs
   * @return void
   */
  public static function syntaxBuild(array $outputs){
            
    $newouput = [];

    foreach ($outputs as $output => $value) {
        if(is_array($value)){
            $newouput[$output] = self::syntaxBuild($value);
        }else{
            $newouput[$output] = self::buildConsole($value);
        }
    }

    return $newouput;

   }

   /**
    * logs  a message into the shell by using "says ->" when appName is supplied
    *
    * @param string  $message message to be printed out
    * @param string $name prefix of statement
    * @return void
    */
  public static function say(string $message = '', $name = ''){
    $says = self::$appName? ' : ' : '';
    $text = ($name)? self::$appName." ($name) " : self::$appName;
    self::log($text.$says.$message);
  }

  /**
   * logs a message into the shell
   *
   * @param mixed $output
   * @return self
   */
   public static function log($output){
             
        if(is_string($output)){
            $output = self::buildConsole($output);
        }elseif(is_array($output)){
            $output = self::syntaxBuild($output);
        }

        print(PHP_EOL);
        print_r($output);
        return new self;
  }

  function display($message, $spaces = 0){
    static $count = 0;
    $count++;

    $br = isCli()? PHP_EOL : '<br>';
    $spaces = str_repeat(' ', $spaces);

    if($count == 1){
      print $br.$spaces.$message.$br.$br; 
    }else{
      print $spaces.$message.$br.$br; 
    }

  }

  /**
   * To generate a loading animation
   *
   * @param boolean $run
   * @param integer $time
   * @return void
   */
  function loading($run = true, $time = 300000){

    static $posit = 0;
    if($posit > 2) $posit = 0;

    static $chr   = ['/', '-', '\\'];

    echo $chr[$posit];
    usleep($time);           
    echo chr(8);      

    $posit++; 

    if($run){
      $this->loading($run);      
    }

  }

  function setInterval($func, $milliseconds){
    $seconds = (int) $milliseconds / 1000;
    $done = false;
    while(!$done){
      $done = $func(); //check loading
      sleep($seconds);
    }
  }

  /**
   * Adds a new line with prefix of error 
   *
   * @param string $message
   * @return void
   */
  public static function notice( string $message = null){
    $notice = self::$appName." notice: ";
    self::log(PHP_EOL.$notice.$message);
  }
  
  /**
   * Adds a new line with prefix of error 
   *
   * @param string $message
   * @param string $name
   * @return void
   */
  public static function error( string $message = null, string $name = '' ){
    if(self::$appName) self::$appName = "  ".self::$appName;
    $error = ($name)? self::$appName." error: ($name) " : self::$appName." error: ";
    self::log($error.$message);
  }

  /**
   * Adds a new line to php console
   *
   * @param integer $breaks number of breaks
   * @return void
   */
  public function br(int $breaks =  1){
    print str_repeat(PHP_EOL, $breaks);
  }

  public static function commands($key = '', $name = ''){
    $argV = ($GLOBALS['argv']);
    $args = func_num_args();
    if(isset($argV[0])){
        unset($argV[0]);
    }

    $argV = array_values($argV);
    array_trim($argV);
    
    if($args === 0) {
        return $argV;
    }

    if($args === 1){
        return $argV[$key] ?? false;
    }else{
        return $argV[$key][$name] ?? false;
    }
    return '';
  }

  /**
   * Reformats messages displayed on php console
   *
   * @param string $message
   * @return string
   */
  private static function buildConsole($message){

    //add a new line
    $expline = explode(" ++ ", $message);

    if(count($expline) > 1){
      $message = str_replace('++ ', PHP_EOL.str_repeat(" ", 10), $message);
    } 

    //add a new line with "syntax" as prefix
    $exp = explode(">>", $message, 2);

    if(count($exp) > 1){
      $eol = substr(ltrim($message, " "), 0, 2) == ">>"? '' : self::base_eol;
      $syntax =  $exp[0].$eol;
      $syntax .= str_repeat(" ",13)."syntax >> ".$exp[1].PHP_EOL;

    }else{

      $syntax = isset($exp[0])? $exp[0].PHP_EOL : '';

    }

    //add a new line with "fix" as prefix
    $exp = explode("<<", $message, 2);

    if(count($exp) > 1){
      $eol = substr(ltrim($message, " "), 0, 2) == "<<"? '' : self::base_eol;
      $syntax =  $exp[0].$eol;
      $syntax .= str_repeat(" ",13)."fix >>".$exp[1].PHP_EOL;

    } 

    return $syntax;
  
  }

  /**
   * Trigger an error when a method does not exist
   *
   * @param string $method
   * @param array  $args
   * @return void
   */
  public function __call($method, $args){ 

    // if($args){
      
    //   array_unshift($args, $method);
     
    //   self::error('command "'.implode(" ", $args).'" not recognized');        
    // }

    //return;  

  }

  /**
   * Adds an error into messages
   *
   * @param mixed $message
   * @return void
   */
  public function addError($message = ''){
    self::$console_messages['error'][] = $message; 
  }

  /**
   * Adds a message into messages
   *
   * @param mixed $message
   * @return void
   */
  public function addLog($message){
    self::$console_messages['log'][] = $message; 
  }

  /**
   * Clears console
   *
   * @return void
   */
  public function cls(){
    echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
  }

  /**
   * Adds a message into messages
   *
   * @param mixed $message
   * @return void
   */
  public function addFix($message){
    self::$console_messages['log'][] = " << ".$message; 
  }  

  /**
   * Adds a notice into messages
   *
   * @param mixed $message
   * @return void
   */
  public function addNotice($message){
    self::$console_messages['notice'][] = $message; 
  }  

  /**
   * Processs commands before execution
   *
   * @return void
   */
  protected function process_commands(){

    $total_commands = count(self::commands());

    if($total_commands > self::max_commands_level){

        self::error("invalid arguments supplied");
        return;

    }

    $this->execute(self::commands());
    return true;

  }

  //function to execute
  protected function execute(array $commands= []){ }

  /**
   * Run console
   *
   * @return void
   */
  public function run(){ 

    if(empty($this->commands)){ 
      if($this->no_arguments_message){
          self::log($this->no_arguments_message);       
      }
    }

    //Running execution before messages are logged
    $this->process_commands();

    foreach (self::$console_messages as $console_messages => $messages){

        $log = (method_exists($this, $console_messages)) ? $console_messages : 'log';

        foreach($messages as $value){

            if(is_array($value)){
                foreach($value as $valkey => $val) {
                  
                  if(is_string($val)){
                    $textval = (is_string($val) and empty($val))? $val :  " => ".$val;
                    self::$log(str_repeat(" ", 6).$valkey.$textval);
                  }else{
                    self::log($val);        
                  }

                }                
            } else {
              self::$log($value);
            }

        }

    }
  

  }



 }