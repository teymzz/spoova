<?php

namespace spoova\core\commands;

/**
 * Animation class for cli
 */
class Anime 
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
        'close'     => '⮿ ' , 
        'envelope'  => '✉  ', 
        'share'     => '➦  ', 
        'view'      => '➥  ', 
        'checkbox'  => '☑  ', 
        'timesbox'  => '☒  ', 

        /* marked */
        'flash'     => '⭍  ',
        'yin-yang'  => '☯  ',
        'diamond'   => '◈  ',        
        'eye'       => '◉  ',  
    ]; 

    private static $anime = 'normal'; 
    private static $animes = [
        'normal' => ['/', '-', '\\'], /* 10000 - 500000 */
        'dotted' => ['/', '-', '\\'], /* 10000 - 500000 */ 
        'roller' => ['/', '-', '\\'], /* 10000 - 500000 */ 
        'arrows' => ['>', ' ','>>', ' ', '>>>', ' '], /* 10000 - 500000 */ 
        'timer'  => ['◴', '◷','◶', '◵'],
        'circle' => ['◜','◝','◞','◟'], /* 40000 - 50000 */
        'angles' => ['◣','◤','◥','◢'],
        'steps' => ['☰','☱','☲','☴'],
        'braill' => ['⠿','⠷','⠯','⠟', '⠻', '⠽', '⠾'],
    ]; 

    private static $spchars = [
        'timer','circle','angles','steps','braill'
    ];

    private static $loadTime = 60000;

    private static $textView = '';

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
     * @return void
     * @notice when animating, yield false is used to denote that an error has occured
     */
    static function runAnime($function, $final_callback = []) {

        return (new self)->animeLoad(true, $function, $final_callback);

    }

    /**
     * Display a message to a console or page
     *
     * @param string $message
     * @param integer|array|bool|string $yield
     * @param integer $pause pause after animation in seconds
     * @return void
     * 
     * @notice: when $yield is set as integer, it must not be less than 1.
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

        $message .= (self::isSpecial())? '' : ' ';

        print $message;

        //yield 
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
     * @notice: when $yield is set as integer, it must not be less than 1.
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
     * @param integer spaces number of prefixed spaces
     * @return void
     * 
     * @notice when bool of false is supplied, textView clears the current line
     */
    static function textView(string $message, int $pause = 0, $break = 0, int $spaces = 0){
        $sp = (self::isSpecial())? '' : ' ';

        self::$textView = $message;
        if($break === false) {
            self::clearLine();
            $break = 0;
        }
        $spaces = str_repeat(' ', $spaces);
        print br($spaces.$message, $break);
        sleep($pause);
    }

    /**
     * This function makes it easier to write a conclusion or returning 
     * text after all commands have been executed.
     *
     * @param string $message
     * @return void
     */
    static function endView(string $message = '') {
        Anime::textView($message, 2, 1); 
    }
    
    /**
     * A sample iterable heavy function to test progress bar
     *
     * @return void
     */
    static function animeTest(){
        $i = 0;
        
        yield 1; // Stage 1 - function processing
        // while($i < 20){ usleep(50000); $i++; if($i == 20){ $i = 0; break; } }
        
        yield 2; // Stage 2 - function processing
        // while($i < 20){ usleep(50000); $i++; if($i == 20){ $i = 0; break; } }

        yield 3; // Stage 3 - function processing
        //slows progress bar  
        while($i < 20){ usleep(50000); $i++; if($i == 20){ $i = 0; break; } }

        yield 4; // Stage 4 - function processing
        //slows progress bar more 
        while($i < 100){ usleep(50000); $i++; if($i == 100){ $i = 0; break; } }

        yield 5; // Stage 5 - function processing
        //slows progress bar even more  
        while($i < 200){ usleep(50000); $i++; if($i == 200){ $i = 0; break; } }

        yield 6; // Stage 5 - function processing
        //slows progress bar much more      
        // while($i < 1000){ usleep(50000); $i++; if($i == 1000){ $i = 0; break; } }

        // last stage (yield true) completed here
        yield true;
    }

    /**
     * A sample final callback function
     *
     * @return void
     */
    function animeDone() {
        print 'process completed successfully';
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
     *      - 'function'   => function
     *      - ['method'] => [current_class_object, 'method']
     *      - ['class', 'method'] => ['class', 'method']
     * @param array|string $final a final callback once loading is completed
     * @return void
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
            #Handle second array value
            // else{
                
            // }
        }

        $callback[1] = [$callback[1] ?? []];

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

        if(is_callable($callback[0])) { 
            $loop = call_user_func_array($callback[0], $callback[1]);

            foreach($loop as $process){

                if($process === false){
                    return false;
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
     * By default, the special characters
     * have been prefixed to two spaces to enable good display
     * to fix this, the number of spaces must be defined
     *
     * @param string $name special character name
     * @return string
     * 
     * @notice: A space of zero(0) is not allowed
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
                $emo .=  $spaces - 2;
            }
        }
        return $emo;
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

    private static function clearLine(){
        echo "\033[2K\r";
    }

}