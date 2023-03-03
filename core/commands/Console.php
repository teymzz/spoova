<?php


namespace spoova\core\commands;
use spoova\core\commands\Cli;
 
  /**
   * class Console 
   * 
   * @author Akinola Saheed <teymss@gmail.com>
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
  protected const max_commands_level = 4;

  /**
   * name of command supplied
   *
   * @var array
   */
  protected string $commandName = '';

  protected array $commands;

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

  final public function addCommand($name) {
    $this->directives[$name]['desc'] = '';
    $this->directives[$name]['options'] = [];
  }

  /**
   * Sorts all declared syntaxes found in arrays or strings
   *
   * @param array $outputs
   * @return array
   */
  final public static function syntaxBuild(array $outputs) : array{
            
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
  final public static function say(string $message = '', $name = ''){
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
  final public static function log($output){
             
    if(is_string($output)){
        $output = self::buildConsole($output);
    }elseif(is_array($output)){
        $output = self::syntaxBuild($output);
    }

    print(PHP_EOL);
    print_r($output);
    return new self;

  }

  /**
   * Displays a message to console
   *
   * @param string $message
   * @param string $spacing  - Left and Right spaces separated by pipe
   *  - If a single integer is supplied, it is assumed to be left space 
   * @return void
   */
  final function display($message, $spacing = '0|0'){
    static $count = 0;
    $count++;

    $br = isCli()? PHP_EOL : '<br>';

    $spaces = $this->toSpaces($spacing);
    $spacel = str_repeat(' ', $spaces[0]);
    $spacer = str_repeat(' ', $spaces[1]);

    if($count == 1){
      print $br.$spacel.$message.$spacer.$br.$br; 
    }else{
      print $spacel.$message.$spacer.$br.$br; 
    }

  }

  /**
   * To generate a loading animation
   *
   * @param boolean $run
   * @param integer $time
   * @return void
   */
  final function loading($run = true, $time = 300000){

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

  final function setInterval($func, $milliseconds){
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
  final public static function notice( string $message = null){
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
  final public static function error( string $message = null, string $name = '' ){
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
  final public function br(int $breaks =  1){
    print str_repeat(PHP_EOL, $breaks);
  }

  final public static function commands($key = '', $name = ''){
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
   * Converts spacing pipe structure to left and right spaces
   *
   * @param string $space int|string|array $space
   *  - when integer is supplied, it assumes the left side of text
   *  - when string is supplied, pipe can be used to specify the space position as either left or right
   *  - when array is supplied, the first value represents the left spacing while the second value represents the right spacing
   * @return array
   */
  private function toSpaces($space = '0|0') : array{
    
    $spacel = $space;
    $spacer = 0;

    if(is_array($space)){
      $spacel = $space[0]?? 0;
      $spacer = $space[1]?? 1;
    }if(strpos($space, '|') !== false){
      $spaces = explode('|',$space);
      $spacel = $spaces[0] ? (int) $spaces[0]: 0;
      $spacer = $spaces[1] ? (int) $spaces[1]: 0;
    }

    $spacel = (int) $spacel;
    return [$spacel, $spacer];

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

    if($args){
      
      array_unshift($args, $method);
     
      self::error('command "'.implode(" ", $args).'" not recognized');        
    }

    return;  

  }

  /**
   * Adds an error into messages
   *
   * @param mixed $message
   * @return void
   */
  final public function addError($message = ''){
    self::$console_messages['error'][] = $message; 
  }

  /**
   * Adds a message into messages
   *
   * @param mixed $message
   * @return void
   */
  final public function addLog($message){
    self::$console_messages['log'][] = $message; 
  }

  /**
   * Cli prompt
   *
   * @param array $options
   * @param \Closure $callback
   * @return void
   */
  final public function prompt(array $options = [], \Closure $callback = null): string {

    $input = trim(fgets(STDIN, 1024));

    if(func_num_args() > 0){

      $callback($input);

      if(!in_array($input, $options)){

        $this->prompt(...func_get_args());

      }
      
    }

    return $input;

  }

  /**
   * Clears console
   *
   * @return void
   */
  final public function cls(){
    echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
  }

  /**
   * Adds a message into messages
   *
   * @param mixed $message
   * @return void
   */
  final public function addFix($message){
    self::$console_messages['log'][] = " << ".$message; 
  }  

  /**
   * Adds a notice into messages
   *
   * @param mixed $message
   * @return void
   */
  final public function addNotice($message){
    self::$console_messages['notice'][] = $message; 
  }  

  /**
   * Processs commands before execution
   *
   * @return boolean
   */
  protected function process_commands() : bool {

    $total_commands = count(self::commands());

    if($total_commands > static::max_commands_level){

        Cli::textView(Cli::br(1).Cli::danger('Console Error:', '|1').("invalid number of maximum(".static::max_commands_level.") arguments supplied").Cli::br(2));
        return false;

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
  final public function cliRun(){ 

    if(empty($this->commands)){ 
      if($this->no_arguments_message){
          self::log($this->no_arguments_message);       
      }
    }

    //Running execution before messages are logged
    $this->process_commands();

    foreach (static::$console_messages as $console_messages => $messages){

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