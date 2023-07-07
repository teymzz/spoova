<?php

namespace spoova\mi\core\commands;

use Closure;

/**
 * Animation class for cli
 */
class Cli 
{

    public const emos = [

        /* starred */

        'point-list'=> '►  ',
        'pointer'   => '☞  ',  
        'link'      => '☍  ', 
        'linkb'     => '⚯  ',
        'checkmark' => '✔  ',
        'crossmark' => '✘  ',
        'hot'       => '♨  ',
        'capture'   => '⛶  ',
        'flagb'     => '⛿  ',
        'umbrella'  => '☂  ',
        'plane'     => '✈  ',
        'cloud'     => '☁  ',
        'sun'       => '☀  ',
        'cut'       => '✀  ',
        'close'     => '⮿  ', 
        'envelope'  => '✉  ', 
        'share'     => '➦  ', 
        'view'      => '➥  ', 
        'checkbox'  => '☑  ', 
        'timesbox'  => '☒  ', 
        'clock'     => '◷  ', 

        /* marked */
        'flash'     => '⭍  ',
        'yin-yang'  => '☯  ',
        'diamond'   => '◈  ',        
        'eye'       => '◉  ',
        'ribbon-arrow' => '⮱  ',   
        'light-arrow' => '⌁  ',   
        'infinite-arrow' => '↝  ',   
        'xs-arrow' => '⥂  ',   
        'barb-arrow' => '⥊  ',   
        'bullet-arrow' => '⥤  ',   
    ]; 

    private static $colors = [

        'white' => "1;37",

        /* gray */
        'bold-gray' => "0;37",
        'dark-gray' => "1;30",

        'black' => "0;30",

        /* red */
        'red' => "0;31",
        'bold-red' => "1;31",

        /* green */
        'green' => "0;32",
        'bold-green' => "1;32",

        /* blue */
        'blue' => "0;34",
        'bold-blue' => "1;34",

        /* cyan */
        'cyan' => "0;36",
        'bold-cyan' => "1;36",

        /* purple */
        'purple' => "0;35",
        'bold-purple' => "1;35",

        /* yellow */
        'yellow' => "0;33",
        'bold-yellow' => "1;33",
    ];

    private static $bgcolors = [
        
        'white' => "47",

        'light-gray' => "47",

        'black' => "40",

        'red' => "41",
        
        'green' => "42",
        
        'blue' => "44",
        
        'cyan' => "46",
        
        'purple' => "45",
        
        'yellow' => "43",

    ];

    private static $anime = 'normal'; 
    private static $animes = [
        'normal' => ['/', '-', '\\'], /* 10000 - 500000 */
        'normal' => ['/', '-', '\\'], /* 10000 - 500000 */
        'dotted' => ['/', '-', '\\'], /* 10000 - 500000 */ 
        'roller' => ['/', '-', '\\'], /* 10000 - 500000 */ 
        'arrows' => ['>', ' ','>>', ' ', '>>>', ' '], /* 10000 - 500000 */ 
        'forward' => ['⟩','⟫','⟩', '⟫'], /* 10000 - 500000 */ 
        'timer'  => ['◴', '◷','◶', '◵'],
        'circle' => ['◜','◝','◞','◟'], /* 40000 - 50000 */
        'angles' => ['◣','◤','◥','◢'],
        'steps' => ['☰','☱','☲','☴'],
        'braill' => ['⠿','⠷','⠯','⠟', '⠻', '⠽', '⠾'],
    ]; 

    private static $spchars = [
        'timer','forward','circle','angles','steps','braill'
    ];

    private static $colorInt = [
         0 => 'black',
         1 => 'white',
         2 => 'blue',
         3 => 'yellow',
         4 => 'green',
         5 => 'red',
    ];

    private static $loadTime = 60000;

    private static $textView = '';

    private static $prompt = [];
    private static $ipromptCounter = 0;
    private static $q = [];

    private static $storage = [];

    /**
     * Animation loader type
     *
     * @param string $anime [normal|dotted|roller|arrows|timer|circle|angles|steps|braill]
     * @return void
     */
    static function animeType($anime = 'normal'){
        if(array_key_exists($anime, self::$animes)){
            self::$anime = $anime;
        }
    }

    /**
     * method to run progressbar
     *
     * @param array|string $function 
     * @param array|string $final_callback
     * @return bool
     * @notice - when animating, yield false is used to denote that an error has occured
     *         - class methods must be set as public to make it callable
     */
    static function runAnime(array|string $function, $final_callback = []) {

        return (new self)->animeLoad(true, $function, $final_callback);

    }

    /**
     * Display a message to a console or page
     *
     * @param string $message
     * @param integer|array|bool|string $yield]
     * @return void
     * 
     * @notice: - when $yield is set as integer, it must not be less than 1.
     *          - ensure to use yield from textYield().
     */
    static function textYield(string $message, $yield = 1, int $pause = 0){
        
        static $count = 0;
        $count++;

        if(is_numeric($yield)){
            if($yield < 1){
                trigger_error('second parameter cannot be an integer that is less than 1');
                return;
            }
            $yield = array_fill(0, ($yield), '');
        }

        $message .= (self::isSpecial())? '' : '';

        print $message;

        yield from $yield;

        if($pause > 0) sleep($pause);
    
    }

    /**
     * Runs only animations (i.e no text) using textYield
     *
     * @param integer|array|bool|string $yield
     * @param integer $pause pause after animation (in seconds)
     * @return void
     * 
     * @notice: - when $yield is set as integer, it must not be less than 1.
     *          - ensure to use yield from animate() 
     */
    static function animate($yield = 1, int $pause = 0){
        
       yield from self::textYield('', $yield, $pause);
    
    }

    /**
     * Designed method for displaying console text
     *
     * @param string $message
     * @param integer $pause pause after text display (in seconds)
     * @param integer|bool $break add (int) line breaks or clears the current line (bool:false)
     * @param integer spacing number of prefixed spacing
     * @return void
     * 
     * @notice when bool of false is supplied, textView clears the current line
     */
    static function textView(string $message, $spacing = '0|0', $break = '0|0', $pause = '0|0'){
        $sp = (self::isSpecial())? '' : ' ';

        $clearLine = false;

        if(is_bool($break)){
            $break = 0;
            $clearLine = $break;
        }

        
        $spaces = self::toSpaces($spacing);
        $break  = self::toSpaces($break);
        $pause  = self::toSpaces($pause);
        
        $spacel = str_repeat(' ', $spaces[0]);
        $spacer = str_repeat(' ', $spaces[1]);

        self::$textView = $message;

        if($clearLine) self::clearLine();

        sleep($pause[0]);
        print br('', $break[0]).br($spacel.$message.$spacer, $break[1]);
        sleep($pause[1]);
    }

    /**
     * Designed method for displaying console text in an animated format
     *
     * @param int|int[] $yield
     * @param string $message
     * @param int $indent left space margin before animation text is printed
     * @param int|bool $break number of line breaks after animation is done
     *  - when a bool of true is supplied, the entire line is cleared after the animation is done which runs after pause if defined
     * @param int $pause pause after animation (in seconds)
     * @return mixed
     * 
     * @notice when bool of false is supplied, textView clears the current line
     */
    static function play($yield, int $indent = 0, string $message = '', $break = 0, int $pause = 0){
        
        $sp = (self::isSpecial())? '' : ' ';

        $clearLine = false;

        if(is_bool($break)){
            $clearLine = $break;
            $break = 0;
        }
        
        self::$textView = $message;

        print str_repeat(' ', $indent).$message;
        yield from self::animate($yield, $pause);
        self::backspace();
        print br('', $break);
        if($clearLine === true) self::clearLine();

    }

    /**
     * prints or return a break line in cli
     *
     * @param integer $linebreaks number of breaks
     * @param boolean $print false returns break rather than print
     * @return void
     */
    static function break(int $linebreaks = 1, $print = true) {
        if(!$print) return br('', $linebreaks);
        print br('', $linebreaks);
    }

    /**
     * Return a break line in cli
     *
     * @param integer $linebreaks number of breaks
     * @return string|void
     */
    static function br(int $linebreaks = 1){
        return br('', $linebreaks);
    }

    /**
     * This function makes it easier to terminate animation with a final text.
     * @notice: - This should only be used immediately before 'yield false' or 'return'.
     *          - This method automatically adds a text indentation of 2
     * This method may be yielded
     *
     * @param string $message
     * @return bool false.
     */
    static function endAnime(int $pause, int $break_before = 0, string $message = '', int $break_after = 2, int $indent = 2) {
        Cli::pause($pause); 
        Cli::break($break_before);
        Cli::textView($message, $indent, 1); 
        Cli::break($break_after);
        return false;
    }

    /**
     * This function makes it easier to indent a console text
     *
     * @param int $indent number of spaces before text
     * @param string $message
     * @return string
     */
    static function textIndent(string $message = '', $indent = 0) {
        $indent = self::toSpaces($indent);
        return str_repeat(' ', $indent[0]).$message.str_repeat(' ', $indent[1]);
    }

    /**
     * This function makes it easier to write a conclusion or returning 
     * text after all commands have been executed.
     *
     * @param string $message
     * @return void
     */
    static function endView(string $message = '') {
        Cli::textView($message, 2, 1); 
    }
    
    /**
     * A sample iterable heavy function to test progress bar
     * 
     * @Notice: remember to use yield from animeTest()
     * @return void
     */
    static function animeTest(){
        $i = 0;
        
        yield 1; // Stage 1 - loading
        // while($i < 20){ usleep(50000); $i++; if($i == 20){ $i = 0; break; } }
        
        yield 2; // Stage 2 - loading
        // while($i < 20){ usleep(50000); $i++; if($i == 20){ $i = 0; break; } }

        yield 3; // Stage 3 - loading
        //slows progress bar  
        while($i < 20){ usleep(50000); $i++; if($i == 20){ $i = 0; break; } }

        yield 4; // Stage 4 - loading
        //slows progress bar more 
        while($i < 100){ usleep(50000); $i++; if($i == 100){ $i = 0; break; } }

        yield 5; // Stage 5 - loading
        //slows progress bar even more  
        while($i < 200){ usleep(50000); $i++; if($i == 200){ $i = 0; break; } }

        yield 6; // Stage 5 - loading

        // last stage (yield true) completed here. Exit animation
        yield true;
    }
    
    /**
     * Sets the load time in microseconds
     *
     * @return void
     */
    static function loadTime(int $time = 0){
        if(func_num_args() > 0){
            self::$loadTime = $time;
        }
    }

    /**
     * To use this function, $callback must be iterable
     *
     * @param bool $isLoading tells method to start loading
     * @param array|string $callback an iterable function or method 
     *    - Formats:
     *      - 'function' => where function name is supplied as a string
     *      - function() => where function is supplied as a closure
     *      - ['method'] => where method is a callable method of Anime class
     *      - ['class', 'method'] => where class is unrelated class and method is public
     *      - [['class', 'method'], [...args]] => where class is unrelated class, method is public and args are arguments
     *      - ['function', [...args]] => where function is function name, and args are arguments
     * @param array|string $final a final callback once loading is completed. Supports $callback format.
     * @return bool
     * @notice when animating, yield false is used to denote that an error has occured
     */
    private function animeLoad(bool $isLoading, $callback = [], $final = []) {
        
        static $start = 0;
        static $posit = 0; 
        $anime = self::$anime;

        if($posit > 2) $posit = 0;

        if($anime != 'normal') print PHP_EOL;

        // $this->animeCls(); //clears console

        #Handle String as function call (e.g 'function' as a function)
        if(is_string($callback)){
            $callback[0] = $callback;
            $callback[1] = [];
        }        
        
        #Handle current class/method call (e.g ['method'] as current class method) 
        else if(is_array($callback) && (count($callback) == 1) && !is_array($callback[0])){
            $callback[0] = [$this, $callback[0]] ;
            $callback[1] = []; //attach no arguments
        } 

        #Handle two keys (e.g [key1, key2]) 
        if(count($callback) == 2) {

            #Handle two string keys (e.g ['class', 'method'] with no arguments) 
            if(!is_array($callback[0]) && is_string($callback[1])){
                $callback[0] = [$callback[0], $callback[1]];
                $callback[1] = [];
            } 
            #Note: [string , array ] => [function, args]
            #Handled second array value
        }

        $callback[1] = [ $callback[1] ?? [] ];

        /** This is automatically called by the function after successful completion */
        if(!$isLoading) {
            if(is_callable($callback)) {
                if($callback instanceof \Closure){
                   $response = $callback();
                   if($response) print $response;
                }else{
                    call_user_func_array($callback[0], $callback[1]);
                }
            }
            return true;
        }

        /** Execute this while still running  */
        if(is_callable($callback[0])) { 
            $loop = call_user_func_array($callback[0], $callback[1]);

            foreach($loop as $process){

                if($process === false){
                    return false;
                }elseif($process === true){
                    return true;
                }

                $j = 1; $back = "\033[1D";
                //rolls progress bar at least 5 times for each yield
                for($i = 0; $i <= 5; $i++) {

                    $chr = self::$animes[self::$anime]; //updatable

                    if($posit > (count($chr) - 1)) {
                        //echo str_repeat(chr(8), 1);
                        $posit = 0; $j = 1;
                    }

                    if($j > 4){ $j = 1; }
                    $char = $chr[$posit];
                    echo self::animePadd($char);
                    usleep(self::$loadTime);  
                    // echo str_repeat(chr(8), $j);  
                    if(!in_array(self::$anime, self::$spchars)){
                        echo str_repeat($back, strlen($char)); 
                    } else {
                        echo str_repeat($back, 3); 
                    }
                    $posit++; $j++;
                    
                }
                
                if(!self::isSpecial()){
                    if(self::$anime != 'angles'){
                        echo '.'; 
                        if(self::$anime != 'dotted') echo chr(8); 
                    }
                }
            }            
        } else {
            echo 'error: argument supplied is not iterable';
        }

        echo ' '; //prevent any left over character 
        $this->animeLoad(false, $final); //set function loading to false.

        $start++;

        return true;

    }

    /**
     * Add some padding to animated charaters
     *
     * @param string $chr
     * @return string
     */
    private function animePadd($chr){
        if(self::isSpecial()) return ' '.$chr.' ';
        return $chr;
    }

    /**
     * Check if animation characters are special characters
     *
     * @return boolean
     */
    private static function isSpecial(){
        return in_array(self::$anime, self::$spchars);
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
     * Returns a string of dots based on required number of strings to be generated
     *
     * @param integer $total total number of characters to be generated
     * @param string $text string character provided
     *  - Note that the total number of characters to be generated (i.e arg(#1)) must be 
     *    greater than the number of characters in the text provided (i.e arg(#2))
     * @return string 
     */
    public static function dots(int $total, string $text = '', $char = ".") : string{
        
        $textNum = strlen($text);

        if($total > $textNum){
            $dotsNum = $total - $textNum;
        }else{
            //$text = limitChars($text, $total);
            $dotsNum = 0;
        }

        return str_repeat($char, $dotsNum);

    }

    /**
     * Store any data type for use later
     *  - This may overwrite existing data
     * @param integer $index
     * @param mixed $value
     * @param boolean $exec determines if a closure value should be executed once.
     * @return mixed 
     *   Returns exact value supplied or value returned by a closure if closure was supplied 
     */
    public static function save(int $index, $value, bool $exec = false){
        
        self::$storage[$index] = $value;
        
        if($exec && ($value instanceof closure)){
            return $value();
        }

        return $value;

    }

    /**
     * Call any closure function using index name if it exists in storage
     *
     * @param integer $index
     * @param mixed $value
     * @return mixed dependent on what function returns (or void)
     */
    public static function fn(int $index){

        if(isset(self::$storage[$index]) && (self::$storage[$index] instanceof Closure)){
           return self::$storage[$index]();
        }

    } 

    
  /**
   * Cli prompt
   *
   * @param array $options Valid options to be tested
   * @param \Closure $callback callback function to be applied on option
   * @param bool|int $terminate terminate prompt (in number of times) if option is not valid
   * @param bool $new determines if a new prompt is called. Default value should not be manually modified
   *    - True terminates once
   *    - Integers determines the number of acceptable error times 
   * @return string
   */
   public static function prompt(array $options = [], \Closure $callback = null, bool|int $terminate = false, bool $new = true): string {

        static $counter = 0;

        if($new){
            $counter = 0;
            self::$prompt = [];
            self::$prompt['maximum_accepted'] = $terminate;
            unset(self::$prompt['invalid']);
        }


        //return if number of times exceeded
        if(is_int($terminate) && ($terminate == $counter) && ($counter !== 0)){
            $trials = $counter;
            $counter = 0;
            self::$prompt['maximum'] = true;
            self::$prompt['invalid'] = true;
            self::$prompt['trials'] = $trials;
            self::$prompt['terminate'] = $terminate;
            if($callback) $callback(self::$prompt['val'] ?? '', $options, self::$prompt);
            return self::$prompt['val'] ?? '';
        }

        $input = '';
        $input = trim(fgets(STDIN, 1024));
        $counter++;
    
        self::$prompt['val'] = $input;

        if(func_num_args() > 0){

            if($options && !in_array($input, $options)){
                
                self::$prompt['trials'] = $counter;
                self::$prompt['terminate'] = $terminate;
                self::$prompt['invalid'] = true;
                if($callback) $callback($input, $options, self::$prompt);

                if( ($terminate === false || is_int($terminate)) ){
                    self::prompt($options, $callback, $terminate, false);
                }else{
                    Cli::break(2);
                }

            }elseif(!$options){                
                
                if( ($terminate === false || is_int($terminate)) && empty($input) ){
                    print " ";
                    self::$prompt['trials'] = $counter;
                    self::$prompt['terminate'] = $terminate;
                    self::$prompt['invalid'] = true;
                    if($callback) $callback($input, $options, self::$prompt);  
                    self::prompt($options, $callback, $terminate, false);
                }else{
                    Cli::break(2);
                }
                
            }
        
        }

        $counter = 0;
        if($options && !in_array($input, $options)) self::$prompt['invalid'] = true;
        return self::$prompt['val'] ?? '';

    }
    
  /**
   * Cli iprompt
   *
   * @param string $input returned value
   * @param \Closure $callback callback function to be tested
   * 
   * @return string
   */
   public static function iprompt(string $input = '',  \Closure $callback = null): string {

        $contents = '';
        $handle = fopen('php://stdin',"r");

        if($callback){
            $array = $callback();

            if(is_array($array)){

                $boot = $array['boot'] ?? '';
                $final = $array['final'] ?? '';

                if($boot && !($boot instanceof Closure)){

                    Cli::error('boot of "iprompt" callback must be a closure.', 0, "|2");
                    return false;
                }
                if($final && !($final instanceof Closure)){

                    Cli::error('final of "iprompt" callback must be a closure.', 0, "|2");
                    return false;
                }
            }else{
                Cli::error('callback of "iprompt" must return an array', 0, "|2");
                return false;
            }
            
        }
        
        self::$ipromptCounter = $counter = $starter = 1;
        while(!feof($handle)){
            if($boot) $boot($starter);
            $starter++;
            $new = fread($handle, 1024);
            if(trim($new) && (trim($new) != ";")) self::$ipromptCounter = $counter++;
            preg_match('~.*?(\)--;?)~', $new, $matches);
            if(isset($matches[0])){
                $new = str_replace(')--', ')- -', $new);
            }
            $contents .= $new;
            if(trim($new) == ";"){
                break;
            }
        };

        fclose($handle);
        
        if($final) $final($contents);

        return $input;

    }

    public static function ipromptCounter() {
        return self::$ipromptCounter;
    }

    /**
     * Open a new stdin prompt channel
     *
     * @param mixed $option optional option to be tested
     * @param Closure $callback must return an array using specific key indexes: init, test, success, failed, maximum each having a closure value. 
     *  - init callback function will run every time the prompt is recalled
     *  - test callback will contain the test logic which must return a bool value of true or false 
     *  - success callback will be called if the test returns a true value 
     *  - failed callback will be called if the test fails. If the callback returns a true value, Cli::q() will be recalled, else it will be terminated 
     *  - maximum callback will be executed if the maximum number of trials defined by $trials is reached
     * @param integer|null $trials
     * @return boolean|string
     */
    public static function q(mixed $option, Closure $callback, int $trials = null)  : bool|string {
        static $counter = 0;

        $callbacks = $callback($option);

        if(!isset(self::$q['val']) || ($counter === 0) ) {
            self::$q['val'] = '';
            if($counter === 0) {
                self::$q['max'] = false;
                self::$q['failed'] = false;
            }
        }
        
        if(is_array($callbacks)){

            //initialize callback argument variables
            $success = '';
            $failed  = '';
            $test    = '';
            $init    = '';
            $maximum = '';

            //test all arguments -----------------------------------------------------------------
            if($counter === 0){
                if(isset($callbacks['init']) && !(($init = $callbacks['init']) instanceof Closure)) {
                    Cli::textView(Cli::error('q(#2) "init" must be a closure'), 0,  "|1");
                    return false;
                }
    
    
                if(isset($callbacks['test']) && !(($test = $callbacks['test']) instanceof Closure)) {
                    Cli::textView(Cli::error('q(#2) "test" must be a closure'), 0,  "|1");
                    return false;
                }elseif(!isset($callbacks['test'])) {
                    Cli::textView(Cli::error('q(#2) "test" must be defined'), 0,  "|1");
                    return false;                
                }
    
                if(isset($callbacks['success']) && !(($success = $callbacks['success']) instanceof Closure)) {
                    Cli::textView(Cli::error('q(#2) "success" must be a closure'), 0,  "|1");
                    return false;
                }
    
                if(isset($callbacks['failed']) && !(($failed = $callbacks['failed']) instanceof Closure)) {
                    Cli::textView(Cli::error('q(#2) "failed" must be a closure'), 0,  "|1");
                    return false;
                }
    
                if(isset($callbacks['maximum']) && !(($maximum = $callbacks['maximum']) instanceof Closure)) {
                    Cli::textView(Cli::error('q(#2) "maximum" must be a closure'), 0,  "|1");
                    return false;
                }
            }else{
                $success = $callbacks['success'] ?? '';
                $failed  = $callbacks['failed']  ?? '';
                $test    = $callbacks['test']    ?? '';
                $init    = $callbacks['init']    ?? '';
                $maximum = $callbacks['maximum'] ?? '';
            }
            
            //Check for maximum trials --------------------------------------------------------------------
            if(is_int($trials) && ($counter == $trials)){
                
                if($maximum) {

                    $counter = 0; 
                    self::$q['max'] = true;
                    $callbacks['maximum'](self::$q['val'], $option, $counter);
                    return self::$q['val'];

                }

            }

            //Run inital command --------------------------------------------------------------------------
            if($init) $init($option, $counter);
    
            //Get input supplied --------------------------------------------------------------------------
            
            self::$q['val'] = trim(fgets(STDIN, 1024));

            $counter++;

            $response = $test(self::$q['val'], $option, $counter); //run the test...

            if(!is_bool($response)){
                Cli::textView(Cli::error('q(#2) "test" must return a bool'), 0, "|1");
                $counter = 0;
                return false;                
            }

            if($response === true){
                self::$q['failed'] = false;
                $count = $counter;
                $counter = 0;
                if($success)  $success(self::$q['val'], $option, $count);                
                
            }else{
                //Re-prompt only if failed closure returns a true
                self::$q['failed'] = true;
                if($failed && $failed(self::$q['val'], $option, $counter)) self::q($option, $callback, $trials, false);     
            }

        }else{
             Cli::textView(Cli::error('Cli::q(#2) closure argument must return an array'), 0, '|1');
            return false;
        }
        $counter = 0;
        return self::$q['val'];
    }

    public static function  qFailed() : bool{
        return self::$q['failed']?? false;
    }

    public static function  qValid() : bool{
        return !self::qFailed();
    }
    public static function  qmax() : bool{
        return self::$q['max']?? false;
    }

    public static function promptInvalid($input = '', array $options = []) : bool {

        if(func_num_args() === 0) return self::$prompt['invalid'] ?? false;

        $maximum_accepted = self::$prompt['maximum_accepted'] ?? false;

        $prompt = self::$prompt;

        if(is_int($maximum_accepted)){

            if((($prompt['trials'] < $maximum_accepted) || ($prompt['terminate'] === false)) && !in_array($input, $options)) {
                self::$prompt['invalid'] = true;
                return true;
            }

        }else{            
            
            if(($prompt['terminate'] === false) && !in_array($input, $options)) {
                self::$prompt['invalid'] = true;
                return true;
            }
            
        }
        self::$prompt['invalid'] = false;
        return false;
    }

    public static function promptIsMax() : bool {
        return self::$prompt['maximum'] ?? false;
    }


    /**
     * Clears cursor back in the number of times defined
     *
     * @return string chr(8)
     */
    public static function backspace(int $time = 1){
        $sp = (in_array(self::$anime, self::$spchars))? '  ' : ' ';
        echo str_repeat($sp.chr(8), $time);
    }

    /**
     * Clears the console current line
     *
     * @return string
     */
    public static function clearLine(){
        echo "\033[2K\r";
    }

    /**
     * Shifts the cursor up the line in the number of times declared
     *
     * @return string
     */
    public static function upLine(int $linesCount = 1){
        echo "\033[{$linesCount}A";
    }
    
    /**
     * clears the console line and shifts cusor up in number of times declared
     *
     * @param integer $linesCount
     * @return string
     */
    public static function clearUp(int $linesCount = 1){
        echo "\033[2K\r"."\033[{$linesCount}A";
    }

    /**
     * Add a list of items
     *
     * @param array $array array of keys and string value
     * @param string $spaces 
     * @param string $spaces
     * @return void
     */
    public static function List(array $array, $spacing = "0|0", $break = "0|0", $interval = "0|0"){

        array_map(function($value, $key) use($spacing, $break, $interval){
            
            if(is_numeric($key)){
                $key += 1;
            }

            //display list
            Cli::textView("$key. $value", $spacing, $break, $interval);

        }, $array, array_keys($array));

    }


    /**
     * One of the three emo methods. This return the emo charaters depending
     * on predefined spaces for left and right sides
     *
     * @param string $name special character name
     * @param int|string|array $space $spacing number of spaces on left and right side of character
     *  - when integer is supplied, it assumes the left side of text
     *  - when string is supplied, pipe can be used to specify the space position as either left or right
     *  - when array is supplied, the first value represents the left spacing while the second value represents the right spacing
     * @return string
     * 
     */
    public static function emo(string $name, $spacing = '0|0'){
        $spaces = self::toSpaces($spacing);
        $emo = trim(self::emos($name, ...$spaces),' ');
        $emo = str_repeat(' ', $spaces[0]).$emo.str_repeat(' ', $spaces[1]);
        return $emo;
    }

    /**
     * One of the three "emo" methods. Spaces added are applied to both left and right sides
     * of character in equal numbers
     *
     * @param string $name special character name
     * @return string $space number of spaces to add to both left and right side of character
     * 
     * @notice: A space of zero(0) removes the all spaces
     */
    public static function emox(string $name, int $space = 2){
        $emo = self::emo($name);
        return Cli::emo($emo,$space.'|'.$space);
    }

    /**
     * The basic emo method. The special characters
     * have been prefixed to two spaces. Spaces defined are 
     * only rendered to fit charater animations. In order to be 
     * specific with spaces, use emo() method instead.
     *
     * @param string $name special character name
     * @return string
     * 
     * @notice: A space of zero(0) removes the all spaces
     */
    public static function emos(string $name, int $spaces = 2){
        if(!isset(self::emos[$name])){
            return self::emos['crossmark']."invalid character name \"{$name}\" ".PHP_EOL.PHP_EOL;
        }

        $emo = self::emos[$name];

        if(func_num_args() > 1){
            if($spaces == 0){
                $emo = substr($emo, 0, (strlen($emo) - 2 ));
            }
            elseif($spaces == 1){
                $emo = substr($emo, 0, (strlen($emo) - 1 ));
            }elseif($spaces > 2){
                $emo =  substr($emo, 0, (strlen($emo) - ($spaces - 2) ));
            }
        }
        return $emo;
    }

    /**
     * Adds color to cli text
     *
     * @param string $text
     * @param string $color
     * @param int|string|array $space
     *  - when integer is supplied, it assumes the left side of text
     *  - when string is supplied, pipe can be used to specify the space position as either left or right
     *  - when array is supplied, the first value represents the left spacing while the second value represents the right spacing
     * @return string
     */
    static function color(string $text, string $color = '', $spacing = '0|0'){

        $space = self::toSpaces($spacing);
        $spacel = $space[0];
        $spacer = $space[1];

        if(array_key_exists($color, self::$colors)) $color = self::$colors[$color];
        $addColor = in_array($color, self::$colors);

        if($addColor) $text = str_repeat(' ', $spacel)."\033[".$color."m".$text."\033[0m".str_repeat(' ', $spacer);

        return $text;

    }

    /**
     * Specified by an alert color (blue), attaches a "NOTICE:" prefix before supplied text
     *
     * @param string $text
     * @param string $textIndent left space margin
     * @param string $colorInt : change text color using predefined integers or color name
     *      - 0 => black
     *      - 1 => white
     *      - 2 => blue
     *      - 3 => yellow
     *      - 4 => green
     *      - 5 => red
     * @notice: if a color does not exist, it falls back to default color.
     * @return string
     */
    public static function notice(string $text, int $textIndent = 0, $colorInt = 2){
        return Cli::color('NOTICE: ', self::colorInt($colorInt, 'blue'), $textIndent).ltrim($text, ' ');
    }

    /**
     * Specified by a danger color (yellow), attaches a "CAUTION:" prefix before supplied text
     *
     * @param string $text
     * @param string $textIndent left space margin
     * @param string $colorInt : change text color using predefined integers or color name
     *      - 0 => black
     *      - 1 => white
     *      - 2 => blue
     *      - 3 => yellow
     *      - 4 => green
     *      - 5 => red
     * @notice: if a color does not exist, it falls back to default color.
     * @return string
     */
    public static function caution(string $text, int $textIndent = 0, $colorInt = 3){
        return Cli::color('CAUTION: ', self::colorInt($colorInt,'yellow'), $textIndent).ltrim($text,' ');
    }


    /**
     * Specified by a warning color (red), attaches a "WARNING:" prefix before supplied text
     *
     * @param string $text
     * @param string $textIndent left space margin
     * @param string $colorInt : change text color using predefined integers or color name 
     *      - 0 => black
     *      - 1 => white
     *      - 2 => blue
     *      - 3 => yellow
     *      - 4 => green
     *      - 5 => red
     * @notice: if a color does not exist, it falls back to default color.
     * @return string
     */
    public static function warning(string $text, int $textIndent = 0, $colorInt = 5){
        return Cli::color('WARNING: ', self::colorInt($colorInt,'red'), $textIndent).ltrim($text,' ');
    }

    /**
     * Specified by a success color (green), attaches an "Success:" prefix before supplied text
     *
     * @param string $text
     * @param string $textIndent left space margin
     * @return string
     */
    public static function success(string $text, int $textIndent = 0){
        return Cli::color('Success: ', 'green', $textIndent).ltrim($text,' ');
    }

    /**
     * Specified by a danger color (red), attaches an "Error:" prefix before supplied text
     *
     * @param string $text
     * @param string $textIndent left space margin
     * @return string
     */
    public static function error(string $text, int $textIndent = 0){
        return Cli::color('Error: ', 'red', $textIndent).ltrim($text,' ');
    }

    /**
     * Specified by an alert color (blue). May also be used to denote code syntax
     *
     * @param string $text
     * @param string $spacing left and right spacing margin separated by pipe
     *  - When a single integer is supplied, it is assumed to be a left space. 
     * @return string
     */
    public static function alert(string $text, $spacing = '0|0'){
        return Cli::color($text, 'blue', $spacing);
    }

    /**
     * Specified by an success color (green). May also be used to denote code syntax
     *
     * @param string $text
     * @param string $spacing left and right spacing margin separated by pipe
     *  - When a single integer is supplied, it is assumed to be a left space. 
     * @return string
     */
    public static function valid(string $text, $spacing = '0|0'){
        return Cli::color($text, 'green', $spacing);
    }

    /**
     * Specified by a warning color (yellow). May also be used to denote code syntax
     *
     * @param string $text
     * @param string $space left and right space margin separated by pipe
     *  - When a single integer is supplied, it is assumed to be a left space. 
     * @return string
     */
    public static function warn(string $text, $spacing = '0|0'){
        return Cli::color($text, 'yellow', $spacing);
    }

    /**
     * Specified by a danger color (red). May also be used to denote code syntax
     *
     * @param string $text
     * @param string $spacing left and right space margin separated by pipe
     *  - When a single integer is supplied, it is assumed to be a left space. 
     * @return string
     */
    public static function danger(string $text, $spacing = '0|0'){
        return Cli::color($text, 'red', $spacing);
    }
    /**
     * Specified by an alert color (blue). May also be used to denote code syntax
     *
     * @param string $text
     * @param string $spacing left and right spacing margin separated by pipe
     *  - When a single integer is supplied, it is assumed to be a left space. 
     *  - Note: A left and right spacing character of 1 is added by default
     * @return string
     */
    public static function bgAlert(string $text, $spacing = '0|0'){
        return Cli::textIndent(Cli::bgcolor($text, 'blue'), $spacing);
    }

    /**
     * Specified by a success color (green). May also be used to denote code syntax
     *
     * @param string $text
     * @param string $space left and right space margin separated by pipe
     *  - When a single integer is supplied, it is assumed to be a left space. 
     * @return string
     */
    public static function bgValid(string $text, $spacing = '0|0'){  
        return Cli::textIndent(Cli::bgcolor($text, 'green'), $spacing);
    }

    /**
     * Specified by a warning color (yellow). May also be used to denote code syntax
     *
     * @param string $text
     * @param string $space left and right space margin separated by pipe
     *  - When a single integer is supplied, it is assumed to be a left space. 
     * @return string
     */
    public static function bgWarn(string $text, $spacing = '0|0'){  
        return Cli::textIndent(Cli::bgcolor($text, 'yellow'), $spacing);
    }

    /**
     * Specified by a danger color (red). May also be used to denote code syntax
     *
     * @param string $text
     * @param string $spacing left and right space margin separated by pipe
     *  - When a single integer is supplied, it is assumed to be a left space. 
     * @return string
     */
    public static function bgDanger(string $text, $spacing = '0|0'){      
        return Cli::textIndent(Cli::bgcolor($text, 'red'), $spacing);
    }

    /**
     * Specified by a neutral color (white). May also be used to denote code syntax
     *
     * @param string $text
     * @param string $spacing left and right space margin separated by pipe
     *  - When a single integer is supplied, it is assumed to be a left space. 
     * @return string
     */
    public static function btn(string $text, $spacing = '0|0'){      
        return Cli::textIndent(Cli::bgcolor($text, 'yellow'), $spacing);
    }

    /**
     * add colors to cli
     *
     * @param string $text 
     * @param string $bgcolor background color
     * @param string $color text color
     * 
     * @notice: background color don't render well with color. Background prints first before color is added to text.
     * @return string
     */
    static function bgcolor(string $text, string $bgcolor = '', string $color = ''){

        if(array_key_exists($color, self::$colors)) $color = self::$colors[$color];
        $addColor = in_array($color, self::$colors);

        if(array_key_exists($bgcolor, self::$bgcolors)) $bgcolor = self::$bgcolors[$bgcolor];
        $addBgColor = in_array($bgcolor, self::$bgcolors);
        
        if($addColor) $text = "\033[".$color."m".$text."\033[0m";
        if($addBgColor) $text = "\033[".$bgcolor."m ".$text." \033[0m";

        return $text;

    }

    /**
     * Delay in seconds
     *
     * @param integer $seconds
     * @return void
     */
    static function wait(int $seconds){
        sleep($seconds);
    }

    /**
     * alias for wait()
     *
     * @param integer $seconds
     * @return void
     */
    static function pause(int $seconds){
        sleep($seconds);
    }

    
    /**
     * Converts spacing pipe structure to left and right spaces
     *
     * @param int|string|array $space
     *  - when integer is supplied, it assumes the left side of text
     *  - when string is supplied, pipe can be used to specify the space position as either left or right
     *  - when array is supplied, the first value represents the left spacing while the second value represents the right spacing
     * @return array
     */
    private static function toSpaces($space = '0|0') : array {
        
        $spacel = $space;
        $spacer = 0;

        if(is_array($space)){
            $spacel = $space[0]?? 0;
            $spacer = $space[1]?? 1;
        }else if(strpos($space, '|') !== false){
          $spaces = explode('|',$space);
          $spacel = $spaces[0] ? (int) $spaces[0]: 0;
          $spacer = $spaces[1] ? (int) $spaces[1]: 0;
        }
    
        $spacel = (int) $spacel;
        return [$spacel, $spacer];
    }

    /**
     * Returns a color based on predefined color integers
     *
     * @param string|integer $colorInt
     * @param string|integer $default default fallback color
     * @notice: if fallback color does not exists, a neutral color of white is returned
     * @return string
     */
    private static function colorInt($colorInt = 1, $default = 1) : string {

        if(!is_numeric($colorInt) && is_string($colorInt)){
            $colorInt = (int) array_search($colorInt, self::$colorInt);
        }
        if(!is_numeric($default) && is_string($default)){
            $default = (int) array_search($default, self::$colorInt);
        }
 
       return self::$colorInt[$colorInt] ?? self::$colorInt[$default] ?? 'white';
    }

}