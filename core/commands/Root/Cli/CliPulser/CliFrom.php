<?php

namespace spoova\mi\core\commands\Root\Cli\CliPulser;

abstract class CliFrom extends CliBits{

    /**
     * Returns the index of the first character of the starting word
     *
     * @return integer
     */
    public function start() : int {
        return $this->proxy->start;
    }

    /**
     * Returns the index of the last character of the ending word
     *
     * @return integer
     */
    public function end() : int {
        return $this->proxy->end;
    }

    /**
     * Compares or returns the total number of character movements made between 
     * the first and last word specified.
     *  
     * @return boolean
     */
    public function turn(array|int|string|null $turns = null) : int|bool {
        $index = $this->proxy->ghostData('index');
        $start = $this->proxy->ghostData('start');
        $turns = (is_array($turns))? $turns : [$turns];
        $turn =  ($index - $start);
        if($turns === null) return $turn;
        return in_array($turn, $turns);
    }
    
    /**
     * Returns the matched text string part corresponding to the specified word(s) range.
     *
     * @return boolean
     */
    public function text() : string {
        return $this->proxy->text;
    }

    /**
     * Returns the full text string existing within a matched text string.
     *
     * @return string|boolean
     */
    public function word(array|string|null $word = null, ?array $keys = null) : string|bool|null {
        $found = $this->proxy->ghostData('found');
        $starter = $this->proxy->ghostData('starter');
        if($word === null) return $found;
        $word = is_array($word)? $word : [$word];
        if($keys !== null){
            if(!isset($starter[$found])){
                return false;
            }elseif(!array_key_exists($found, $starter)){
                return false;
            }
            return in_array($found, $word) && in_array($starter[$found], $keys);
        }
        return in_array($found, $word);
    }

    /**
     * Returns the current selected word string or compares supplied word(s) with the current animation word string.
     * 
     * @return string|bool
     */
    public function smartword(string|array|null $texts = null, bool $case = false) : string|bool { 
        
        $message = $this->proxy->message;
        $message = $case? $message : strtolower($message);
        
        $msg = preg_replace('/(?<=[\p{L}\p{N}\)\]\}"\'’])([.,;!?]+)(?=(\s|$))/u','',$message);
        $words = preg_split('/\s+/', $message, -1, PREG_SPLIT_NO_EMPTY);
        $wordsCap = preg_split('/\s+/', $msg, -1, PREG_SPLIT_NO_EMPTY);

        $index = $this->proxy->index;

        $offset = 0; $word = false;
        foreach($words as $i => $w){
            $wstart = strpos($message, $w, $offset) + 1;
            $word = $wordsCap[$i];
            $wend = $wstart + strlen($word) - 1;
            $offset = $wend + 1;
            if(inRange($index, $wstart, $wend)) break;
            $word = $w;
        }

        if(is_string($texts)) $texts = [$texts];
        
        if(is_array($texts)){
            if(!$case) $texts = array_map(fn($val)=>strtolower($val), $texts);
            return in_array($word, $texts, true);
        }

        return $word ?? ''; 

    }

}