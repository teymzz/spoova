<?php

namespace spoova\mi\core\commands\Root\Cli;

use Closure;
use spoova\mi\core\commands\Root\Cli;

class CliKey {
  
    private $isArrow = false;
    private $support = true;
    private $isSignal = false;
    private $key = false;
    private object|false $reader = false;

    /* pcntl supported signals */
    public const SIGNALS = [
      'SIGHUP'    => SIGHUP, // terminal hang up 
      'SIGINT'    => SIGINT, // CTRL+C from terminal 
      'SIGQUIT'   => SIGQUIT, // CTRL+\ from terminal 
      'SIGILL'    => SIGILL, // Illegal instruction 
      'SIGTRAP'   => SIGTRAP, // Debug trap / breakpoint
      'SIGABRT'   => SIGABRT, // (SIGIOT) Abort
      'SIGFPE'    => SIGFPE, // Arithmetic Error
      'SIGUSR1'   => SIGUSR1, // User defined signal
      'SIGSEGV'   => SIGSEGV, // Segmentation fault
      'SIGUSR2'   => SIGUSR2, // User defined signal
      'SIGPIPE'   => SIGPIPE, // Writing to a broken pipe
      'SIGALRM'   => SIGALRM, // Timer signal
      'SIGTERM'   => SIGTERM, // Termination request
      'SIGSTKFLT' => SIGSTKFLT, // Stack default (Linux)
      //'SIGCHLD'   => SIGCHLD, // Child status change
      'SIGCONT'   => SIGCONT, // Continue if stopped
      //'SIGSTOP'   => SIGSTOP, // Uncatchable
      'SIGTSTP'   => SIGTSTP, // Catchable (CTRL+Z)
      'SIGTTIN'   => SIGTTIN, // Background read from terminal
      'SIGTTOU'   => SIGTTOU, // Background write to terminal
      'SIGURG'    => SIGURG, // Urgent I/O on socket
      'SIGXCPU'   => SIGXCPU, // CPU time limit exceeded
      'SIGXFSZ'   => SIGXFSZ, // File size limit exceeded
      'SIGVTALRM' => SIGVTALRM, // Virtual timer expired
      'SIGPROF'   => SIGPROF, // Profiling timer expired
      'SIGWINCH'  => SIGWINCH, // Terminal window size changed
      'SIGIO'     => SIGIO, // (SIGPOLL) Asynchronous I/O
      'SIGPWR'    => SIGPWR, // Power failure
      'SIGSYS'    => SIGSYS, // Bad system call
    ];

    public const EXIT_SIGNALS = [SIGHUP, SIGINT, SIGQUIT, SIGTERM, SIGTSTP];
  
    public function __construct($key, $input, bool $signal =  false) {
      
      if ($key !== false) {
          $this->key = $key;
          $this->isArrow = in_array($key, ['UP', 'DOWN', 'LEFT', 'RIGHT']);
          $this->isSignal = $signal;
          $this->support = $this->isArrow || in_array($key, ['TAB','DELETE','BACKSPACE','ENTER']);
      }
      
      $this->reader = $input;
      
    }
    
    /**
     * This method is the best way to internally terminate Cli::input() reader manually 
     * outside the scope of interruption signals. It forces an input reading process to terminate.
     */
    public function exit(){
      ($this->reader->close)();
      Cli::clearLine();
    }
    
    /**
     * This method runs a callback function if the key pressed is within the 
     * range of internally supported keys by this class. These keys include tab, enter, backspace, delete and arrows. 
     */ 
    public function withSupport(?Closure $callback = null) : bool {
      if($this->support){
        if($callback) $callback();
        return true;
      }
      return false;
    }
   
    /**
     * Returns true if they ASCII character is under the range 27. 
     *  - This can also be used to detect the type of arrow key pressed if option is supplied. 
     * 
     * @param string $type - optional [up|down|left|right]
     */    
    public function isArrow(?string $type = null) : bool
    {
      if($type === null) return $this->isArrow;
      return (strtolower($type) === strtolower($this->key));
    }

    /**
     * Returns true if current key typed is HOME key.
     */    
    public function isHome() : bool
    {
      return $this->key === 'HOME';
    }

    /**
     * Returns true if current key typed is END key.
     */    
    public function isEnd() : bool
    {
      return $this->key === 'END';
    }

 
    /**
     * Returns true if current key pressed is a function key within the range of specified values.
     *
     * @return boolean
     */  
    public function isF() : bool
    {
      return in_array($this->key, ['F1','F2','F3','F4','F5','F6','F7','F8','F9','F10','F11','F12']);
    }
 
    /**
     * Returns true if current key typed is F1 key.
     * 
     * @return boolean
     */  
    public function isF1() : bool
    {
      return $this->key === 'F1';
    }

    /**
     * Returns true if current key typed is F2 key.
     * 
     * @return boolean
     */  
    public function isF2() : bool
    {
      return $this->key === 'F2';
    }
 
    /**
     * Returns true if current key typed is F3 key.
     * 
     * @return boolean
     */  
    public function isF3() : bool
    {
      return $this->key === 'F3';
    }
 
    /**
     * Returns true if current key typed is F4 key.
     * 
     * @return boolean
     */  
    public function isF4() : bool
    {
      return $this->key === 'F4';
    }
 
    /**
     * Returns true if current key typed is F5 key.
     * 
     * @return boolean
     */  
    public function isF5() : bool
    {
      return $this->key === 'F5' ;
    }
 
    /**
     * Returns true if current key typed is F6 key.
     * 
     * @return boolean
     */  
    public function isF6() : bool
    {
      return $this->key === 'F6' ;
    }
 
    /**
     * Returns true if current key typed is F7 key.
     * 
     * @return boolean
     */  
    public function isF7() : bool
    {
      return $this->key === 'F7';
    }
 
    /**
     * Returns true if current key typed is F8 key.
     * 
     * @return boolean
     */  
    public function isF8() : bool
    {
      return $this->key === 'F8';
    }
 
    /**
     * Returns true if current key typed is F9 key.
     * 
     * @return boolean
     */  
    public function isF9() : bool
    {
      return $this->key === 'F9'; 
    }
 
    /**
     * Returns true if current key typed is F10 key.
     * 
     * @return boolean
     */  
    public function isF10() : bool
    {
      return $this->key === 'F10' ;
    }
 
    /**
     * Returns true if current key typed is F11 key.
     * 
     * @return boolean
     */  
    public function isF11() : bool
    {
      return $this->key === 'F11' ;
    }
 
    /**
     * Returns true if current key typed is F12 key.
     * 
     * @return boolean
     */  
    public function isF12() : bool
    {
      return $this->key === 'F12' ;
    }


    /**
     * Returns true if a signal is received or a supplied signal is matched  
     * 
     * @param int|null $type - optional (e.g SIGINT,SIGTERM,SIGTSTP)
     */    
    public function isSignal(?int $type = null) : bool
    {
      if(func_num_args()>0) {
        if(is_array($type)){
          return in_array($this->key, [$type], true);
        }
        return $this->key === $type;
      }
      return $this->isSignal;
    }
   
    /**
     * Returns true if signal detected is within the range of specified signals
     * 
     * @param string $signals - list of signals to test (e.g SIGINT,SIGTERM,SIGTSTP)
     */    
    public function inSignals(string|array $signals) : bool
    {
      $signals = (array) $signals;
      return in_array($this->key, $signals);
    }
   
    /**
     * Returns signal received in integer (e.g SIGINT,SIGTERM,SIGTSTP)
     * 
     * @return int|false integer for signals while FALSE is returned if no supported signal is received.
     */    
    public function signal() : int|false
    {
      return in_array($this->key, self::SIGNALS)? $this->key : false;
    }
   
    /**
     * Returns TRUE if signal recieved is within the range of exit signals defined under the 
     * {@see CliKey::EXIT_SIGNALS} constant. These signals are most used for causing interruptions 
     * when reading user input.
     * 
     * @uses CliKey::EXIT_SIGNALS
     */    
    public function isExit() : bool
    {
      return in_array($this->key, self::EXIT_SIGNALS, true);
    }
    
    /**
     * TAB key returns true for ASCII character ord key 9.
     *  - Note that some systems may return different values for TAB key.
     */   
    public function isTab() : bool
    {
      return $this->key === 'CTRL+I' || $this->key === 'TAB';
    }
    
    /**
     * DELETE key returns true for ASCII character ord key 127
     *  Note that some systems may return different values for DELETE key.
     */   
    public function isDelete() : bool
    {
      return $this->key === 'DELETE';
    }
      
    /**
     * BACKSPACE key returns for ASCII character ord key 8 or 127
     */  
    public function isBackspace() : bool
    {
      return $this->key === 'BACKSPACE';
    }
    
    /**
     * ENTER key returns for ASCII character ord key 13 or 10.
     *  - Note that on some systems, ENTER key may return ASCII 10 (LF) instead of 13 (CR).
     */
    public function isEnter() : bool {
      return $this->key === 'ENTER' || $this->key === 'CTRL+J';
    }

    /**
     * Check if CTRL or (CTRL + key) is pressed
     *  - Note that the extra key combination is case insensitive.
     *  - Note that this cannot be used for testing arrows
     *  - Note that if no extra key combination is supplied, this method will return true for 
     *    any CTRL key combination.
     *  - Note that to test for CTRL + C (interruption signal), use {@see CliKey::isExit()} method.
     *  - Note that testing for single CTRL key press is not supported. To pick single CTRL key press, it must 
     *    be combined with another key.
     * @param string|null $combo one extra key combination to be checked.
     * @return boolean
     */
    public function isCTRL(?string $combo = null) : bool {
      if($combo !== null){
        return $this->key === ('CTRL+'.strtoupper($combo));
      }
      return str_starts_with($this->key, 'CTRL+');
    }
    
    /**
     * Check if supplied key is equivalent to the specified key
     *  - Note that this cannot be used for testing arrows
     * @param array $keys the test key
     */   
    public function isKey($key){
      return $this->key === $key;
    }
    
    /**
     * Check if supplied key is within the range of specified keys
     *  - Note that this cannot be used for testing arrows
     * @param array $keys list of test keys
     */
    public function inKey(array $keys) : bool{
      return in_array($this->key, $keys);
    }
    
    /**
     * Check if supplied ascii key is within the range of specified ascii keys
     *  - Note that arrows are tested collectively as group through {@see CliKey::isArrow()} method and not as an individual entity
     * @param array $keys list of test keys
     */
    public function inAscii(array $list) : bool{
      return in_array($this->reader->ascii, $list);
    }
    
    /**
     * Check if supplied ascii key is within the range of specified ascii keys
     *  - Note that arrows are tested collectively as group and not as an individual entity
     * @param array $keys list of test keys 
     */
    public function inAsciiRange(int $min, int $max) : bool{
      if($this->reader){
        if(!property_exists($this->reader, 'ascii')) return false;
      }
      $ascii = $this->reader->ascii;
      return ($ascii >= $min && $ascii <= $max);
    }

    /**
     * Check if supplied ascii key is within the range of writable keys
     *  - Note that writable keys are assumed within the ASCII range of 32 - 124. For better 
     *  ASCII range specification, use the {@see CliKey::inAsciiRange()} method.
     * @param array $keys list of test keys
     */
    public function isWritable() : bool{
      return $this->inAsciiRange(32, 126);
    }
    
    /**
     * Returns the supplied (or pressed) key
     *  - Note that this will not return ascii but the real key supplied.
     * @return string or false
     */
    public function fetch() : string|false {
      return $this->key;
      //return $this->reader->char;
    }

}