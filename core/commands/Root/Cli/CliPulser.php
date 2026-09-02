<?php

namespace spoova\mi\core\commands\Root\Cli;

use Error;
use Closure;
use ReflectionFunction;
use ReflectionNamedType;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\classes\Bundle\Arr\Arr;
use spoova\mi\core\classes\Debug;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostProxy;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\commands\Root\Cli\CliPulser\CliFrom;
use spoova\mi\core\commands\Root\Cli\CliPulser\CliMatch;
use spoova\mi\core\commands\Root\Cli\CliPulser\CliOffset;
use spoova\mi\core\commands\Root\Cli\CliPulser\CliRange;
use spoova\mi\core\commands\Root\Cli\CliPulser\CliWords;

abstract class CliPulser {

    public function __construct(protected GhostDraft $get, protected ?GhostFunction $proxy = null)
    {
        $this->proxy = GhostProxy::map($this->get->id(), fn() => $this->get->ghost());
    }

    /**
     * Returns the current character index
     *
     * @return int
     */
    public function index() : int{
        return $this->proxy->index;
    }

    /**
     * Returns the current index character
     * @return string
     */
    public function char() : string {
        return $this->proxy->char;
    }

    /**
     * Returns the pulse message
     * @return string
     */
    public function message() : string {
        return $this->proxy->message;
    }

    
    /**
     * Specifies positional index offset ranges where callbacks should be applied. 
     *  - First character index is assumed to start from 1.
     *
     * @param string[]|int[] $offsets numerical positional indexes of each character desired to be matched.
     *   - int: specifies only the starting index 
     *   - string[] : specifies the starting and stopping index if two numerical values are supplied. 
     * @param Closure $callback a callback that takes {@see CliOffset} object.
     * @return boolean|string
     */
    public function offset(array|string $offsets, ?Closure $callback = null) {
        $index = $this->proxy->index; $char = $this->proxy->char;
        $message = $this->proxy->message;
        $offsets = is_string($offsets)? [$offsets] : $offsets;
        //create and append CliBits modifier object
        $startIndex = $offsets[0];
        $stopIndex = $offsets[1] ?? strlen($message);
        if($startIndex < 1) return false;

        if($callback) {
            
            $format = self::resolveCliBits($callback, CliOffset::class);

            if($format === 'bits'){
                $arguments = [];
            }elseif($format === 'char-bits'){
                $arguments = [$char];
            }elseif($format !== 'bits'){
                $arguments = [$char, $index];
            }
            
            $Ghost = new GhostFunction([
                ['index'=> $index], ['char' => $char], ['message'=>$message],
                ['text' => substr($message, $startIndex - 1, $stopIndex - $startIndex + 1)], 
                ['firstChar' => $index === $startIndex],
                'ghostData'
            ]);

            GhostProxy::new($Ghost, fn(GhostDraft $draft) => new class($draft) extends CliOffset{});

            $mod = GhostProxy::object();

            // Define method to access value of required variables.
            $Ghost->ghostData(function($key) use($startIndex, $stopIndex){
                if(in_array($key, ['startIndex','stopIndex'])) return $$key;
                throw new Error('"$'.$key.'" value is not available for CliPulser::from() method');
            });

            if(isset($arguments)) $arguments[] = $mod;
            return inRange($index, $startIndex, $stopIndex)? $callback(...($arguments??[])) : $char;
        }
        return inRange($index, $startIndex, $stopIndex);
    }

    /**
     * Specifies index ranges where callbacks should be applied.
     *
     * @param array|boolean $start word whose characters must be searched
     *  - when string is supplied, refers to the first word to be match before callback triggers
     *  - For arrays with two words, both words specifies the starting and ending words respectively through which 
     *    the callback is applied. The array keys can be used to define the position of words. 
     *    For example ``['2'=>'foo',1=>'bar']`` means start from the second foo word and end in the first bar word.
     * @param Closure|null $callback closure callback applied only on matched words: ``closure($char, $index)`` [true]
     * @return bool|string
     */       
    public function inRange(array|bool $start, ?Closure $callback = null) {
        $index = $this->proxy->index; $char = $this->proxy->char;
        $message = $this->proxy->message;
        if($start === false) return '';

        if($start === true) $start = [1, strlen($message)];


        if($callback) {
            
            $format = self::resolveCliBits($callback, CliRange::class);

            if($format === 'bits'){
                $arguments = [];
            }elseif($format === 'char-bits'){
                $arguments = [$char];
            }elseif($format !== 'bits'){
                $arguments = [$char, $index];
            }
            
            //create and append CliBits modifier object
            $startIndex =  $start[0];
            $stopIndex =  $start[1]; //- $start[0]
            
            $Ghost = new GhostFunction([
                ['index'=> $index], ['char' => $char], ['message'=>$message],
                ['text' => substr($message, $startIndex - 1, $stopIndex - $startIndex + 1)], 
                ['firstChar' => $index === $start[0]],
                'ghostData'
            ]);

            GhostProxy::new($Ghost, fn(GhostDraft $draft) => new class($draft) extends CliRange{});

            $mod = GhostProxy::object();

            // Define method to access value of required variables.
            $Ghost->ghostData(function($key) use($startIndex, $stopIndex){
                if(in_array($key, ['startIndex','stopIndex'])) return $$key;
                throw new Error('"$'.$key.'" value is not available for CliPulser::from() method');
            });

            if(isset($arguments)) $arguments[] = $mod;
            return inRange($index, $start[0], $start[1])? $callback(...($arguments??[])) : $char;
        }
        return inRange($index, $start[0], $start[1]);
    }

    /**
     * Checks if an index is within the range of assumed relatively valid indices of a word
     *
     * @param string $text a given base text string where all indices are matched from
     * @param Closure|null $callback callback triggered when indices of a word in a given base string actually exists: ``closure($char, $index)``
     * @return boolean|string
     *  TRUE or FALSE when $callback is NULL. Expected to return STRING character if callback is defined.
     */
    public function match(string $text, ?Closure $callback = null) : bool|string {
        
        $index = $this->proxy->index; 
        $char = $this->proxy->char;
        $message = $this->proxy->message;

        $indices = Cli::textIndices($message, $text, 1, false); // use soft indices
        $indices = array_map(fn($val) => $val+1, $indices);

        if($callback) {
            $format = self::resolveCliBits($callback, CliMatch::class);

            if($format === 'bits'){
                $arguments = [];
            }elseif($format === 'char-bits'){
                $arguments = [$char];
            }elseif($format !== 'bits'){
                $arguments = [$char, $index];
            }

            //create and append CliBits modifier object

            if(!is_array($indices)) $indices = [$indices];
            $matched = Cli::match($text, $indices, $index, $match, $frequency);

            $Ghost = new GhostFunction([
                ['index' => $index], ['char' => $char], ['message' => $message],
                'ghostData',
            ]);

            // Define method to access value of required variables.
            $Ghost->ghostData(function($key) use($indices, $frequency, $match){
                if(in_array($key, ['indices','frequency','match'])) return $$key;
                throw new Error('"$'.$key.'" value is not available for CliPulser::from() method');
            });

            GhostProxy::new($Ghost, fn(GhostDraft $draft) => new class($draft) extends CliMatch{});

            $mod = GhostProxy::object(); 

            if(isset($arguments)) $arguments[] = $mod;

            return $matched? $callback(...($arguments??[])) : $char;
        }
        return Cli::match($text, $indices, $index);
    }

    /**
     * Modifies each character of a string using starting and/or ending word(s) character's positional index range.
     *
     * @param array|string $word defines the starting and/or ending word boundary range on which the callback is applied on each character within that range.
     *  - Ex 1 (string): ``'foo'`` means starting from the first character of the first 'foo' word encountered till the end of the entire string
     *  - Ex 2 (array): ``['foo','bar']`` means starting from the first character of the first 'foo' word encountered till the last character of the first 'bar' word encountered.
     *  - Ex 3 (array): ``[['foo'=>2],['bar'=>1]]`` means starting from the first character of the second 'foo' word in a string till the last character of the first 'bar' in that string.
     *    means to start from the second 'foo' and end in the first 'bar' within a given string.
     * @param Closure|null $callback triggered on each text character whose postional index that matches the range of specified word(s) defined in argument(#1).
     * @return string
     */ 
    public function from(array|string $word, ?Closure $callback = null) : string {
        $index = $this->proxy->index; 
        $char = $this->proxy->char; 
        $message = $this->proxy->message; 
        if(!$word) throw new Error('invalid string supplied on Cli::pulseView character modifier object method(from)');
        $list = (array) $word;
        if(count($list) > 2) throw new Error('maximum word counts exceeded on Cli::pulseView character modifier object method(from)');
        $nlist = array_values($list);
        $nkeys = array_keys($list);
        if(is_array($word) && Arr::inside($word)){
            $fromData = $word[0]?? [];
            $toData = $word[1]?? [];
            if(empty($fromData) || empty($toData)){
                throw new Error('from(#1) argument should be defined with two non-empty array values of text and positional index pairs');
            }
            $key1 = array_keys($fromData);
            $key2 = array_keys($toData);
            $from = Cli::textIndices($message, $key1[0]);
            $start = $fromData[$key1[0]] - 1;
            $start = $from[$start];
            $to = Cli::textIndices($message, $key2[0]);
            $end = $toData[$key2[0]] - 1;
            if(!isset($to[$end])){
                $debug= Debug::get(2);
                Cli::errorView('destination word "'.$key2[0].'('.$toData[$key2[0]].')" exceeds total word\'s frequency available at: '.dompath($debug['file'],'app').'('.$debug['line'].')', break: 2)->exit();
            }
            $end = $to[$end] + strlen($key2[0]);

        }else{
            $from = Cli::textIndices($message, $nlist[0]); // returns index of starting text in message
            $to = isset($nlist[1])? Cli::textIndices($message, $nlist[1]) : null ;
            $start = $from[0] ?? false;
            if($to !== null) {$end = $to[0] + strlen($nlist[1]);}else{ $end = strlen($message); }
        }
        if($start === false) return false;
        $format = self::resolveCliBits($callback, CliFrom::class);
        $string = substr($message, $start, $end);

        if($format === 'bits'){
            $arguments = [];
        }elseif($format === 'char-bits'){
            $arguments = [$char];
        }elseif($format !== 'bits'){
            $arguments = [$char, $index];
        }
        
        $Ghost = new GhostFunction([
            ['index'=> $index], 
            ['char' => $char], 
            ['message'=>$message],
            ['start'=> $start+1], 
            ['end'=> $end],
            ['text'=>$string],
            'turn','word',
            'ghostData' // used this to return variables that contain required values.
        ]);

        $words = [];
        $word = preg_split("/[^\p{L}\p{N}'_-]+/u", trim($message), -1, PREG_SPLIT_NO_EMPTY); // fetch each word.
        $offset = 0;
        foreach($word as $w){
            $wstart = strpos($message, $w, $offset) + 1;
            $wend = $wstart + strlen($w) - 1;
            $offset = $wend + 1;
            $words[] = [
                'word' => $w,
                'start' => $wstart,
                'end' => $wend
            ];
        }

        $starter = []; 
        $found = null;

        foreach($words as $w){
            $ipos = $index ;
            if($w['start'] < $start) continue; 
            if(($ipos >= $w['start']) && ($ipos <=$w['end'])){
                $found = $w['word']; 
                $starter[$found] = ($starter[$found] ?? 0)+1;
                break;
            }
            $starter[$w['word']] = ($starter[$w['word']] ?? 0)+1;
        }

        // Define method to access value of required variables.
        $Ghost->ghostData(function($key) use($found, $starter, $index, $start){
            if(in_array($key, ['found','starter','index','start'])){
                return $$key;
            }
            throw new Error('"$'.$key.'" value is not available for CliPulser::from() method');
        });

        // import methods from the CliFrom method.
        GhostProxy::new($Ghost, fn(GhostDraft $draft) => new class($draft) extends CliFrom{});

        $mod = GhostProxy::object();

        if(isset($arguments)){
            $arguments[] = $mod;
        }else{
            $arguments = [];
        }

        if(isset($end)){
            if($callback) return inRange($index, $start, $end)? $callback(...$arguments) : $char;
            return inRange($index, $start, $end);
        }else{
            if($callback) return (($index) >= $start)? $callback(...$arguments) : $char;
            return (($index) >= $start)? $callback($char, $index) : $char;
        }
    }

    /**
     * Modifies each character of specified words using word index detection
     *
     * @param array|string|bool $word word whose characters must be searched
     *  - string or array: specifies a word or list of words to be searched
     *  - TRUE: selects all word characters
     * @param Closure|null $callback applied only on matched words
     * @param boolean $strict determines how words are searched 
     *  - FALSE matches any word at any position of a string while TRUE matches only closely related words.
     * @return string
     */
    public function words(array|string|bool $word, ?Closure $callback = null, bool $strict = true) : string {
        $index = $this->proxy->index; // indexes of each word 
        $char = $this->proxy->char; $message = $this->proxy->message;
        $slice = false;

        if($word === false) $word = [];
        if($word === true){
            if($strict === true){
                $word = preg_split('/\s+/', $message, -1, PREG_SPLIT_NO_EMPTY);
            }else{
                $word = preg_split("/[^\p{L}\p{N}'_-]+/u", trim($message), -1, PREG_SPLIT_NO_EMPTY); // fetch each word.
            }
            $strict = true;
            $slice = true;
        }else{
            if($strict === true){
                $allwords = preg_split('/\s+/', $message, -1, PREG_SPLIT_NO_EMPTY);
            }else{
                $allwords = preg_split("/[^\p{L}\p{N}'_-]+/u", trim($message), -1, PREG_SPLIT_NO_EMPTY); // fetch each word.
            }
        }
        $allwords = $allwords ?? $word;
        // Cli::exit($word);
        $wordings = $pulseWords = array_values(!is_array($word)? [$word] : $word); // each word in text

        $wordings = array_unique($wordings);

        foreach($wordings as $wordIndex => $wording){

            $counter = 0;

            $bases = Cli::textIndexes($message, $wording, 0, $strict); // return all indexes of this word
            
            foreach ($bases as $count => $base) { 
                $counter++; 
                // $realIndex = array_keys($pulseWords, $wording); // all positional indexes of word
                $realIndex = $bases[$count]; // current positional index of word
                $endPosition = $base + strlen($wording) - 1; //entire word length
                $currentPosition = (strlen($wording)) - ($endPosition - $index) % strlen($wording); //current character position

                if ($index >= ($base) && $index <= $endPosition) {

                    //................handling callback with preferences (Closure($char, $index, $mod))
                    $format = self::resolveCliBits($callback, CliWords::class);
                    
                    if($format === 'bits'){
                        $arguments = [];
                    }elseif($format === 'char-bits'){
                        $arguments = [$char];
                    }elseif($format !== 'bits'){
                        $arguments = [$char, $index];
                    }

                    //create and append CliBits modifier object

                    $Ghost = new GhostFunction([
                        // Declare accessible properities
                        ['index'=> $index], ['char' => $char], ['message'=>$message],
                        // ['bit'=> $index + $base], 
                        ['bit'=> $currentPosition], 
                        ['firstChar' => $index === $base],
                        ['lastChar' => $index === $endPosition],
                        'ghostData' // define information method
                    ]);

                    // Configure method to access value of required variables.
                    $Ghost->ghostData(function($key) use($counter, $wording, $realIndex, $word, $pulseWords, $allwords, $currentPosition){
                        if(in_array($key, ['counter','wording','pulseWords','allwords','realIndex','word','currentPosition'])){
                            return $$key;
                        }
                        throw new Error('"$'.$key.'" value is not available for CliPulser::from() method');
                    });

                    GhostProxy::new($Ghost, fn(GhostDraft $draft) => new class($draft) extends CliWords{});

                    $mod = GhostProxy::object();

                    if(isset($arguments)){
                        $arguments[] = $mod;
                    }else{
                        $arguments = []; 
                    }
                    $ret = $callback? $callback(...$arguments) : $char;
                    return $ret;
                }
            }
        }
        
        return $char;
    }


    /**
     * Resolve callback by using the number of required arguments.
     *
     * @param Closure $callback
     * @param string $class resolver class
     * @return string
     */
    private function resolveCliBits(Closure $callback, string $class) : string {

        $reflection = new ReflectionFunction($callback);
        $params = $reflection->getParameters();
        $count = count($params);

        if($count > 0){
            $arg1_type = $params[0]->getType();
            if ($arg1_type instanceof ReflectionNamedType) {
                $name = $arg1_type->getName();
                if($name === $class) return 'bits';
            }
            if($count > 1){
                $arg2_type = $params[1]->getType();
                if ($arg2_type instanceof ReflectionNamedType) {
                    $name = $arg2_type->getName();
                    if($name === $class) return 'char-bits';
                }
            }
        }
        return 'char-index-bits';
        
    }


}