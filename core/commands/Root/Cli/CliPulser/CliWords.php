<?php

namespace spoova\mi\core\commands\Root\Cli\CliPulser;

use spoova\mi\core\commands\Root\Cli;

abstract class CliWords extends CliBits{

    /**
     * Returns the current selected word string or compares supplied word(s) with the current animation word string.
     * 
     * @return string|bool
     */
    public function word(string|array|null $word = null, ?array $index = null) : string|bool { 
        
        $wording = $this->proxy->ghostData('wording');
        $counter = $this->proxy->ghostData('counter');
        
        if($word === null && $index === null) return $wording;
        $word = is_array($word)? $word : [$word];
        
        if($index === null) return in_array($wording, $word, true);

        return in_array($wording, $word, true) && in_array($counter, $index);

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

    /**
     * Returns the all matched words in a pulse text
     * @param boolean $text TRUE returns wordings retrieved from pulsated text while 
     * FALSE returns the word matching index order starting from 1 and above and relative to searched words.
     * @return array
     */
    public function wordings(bool $texts = true) : array {
        
        $word = $this->proxy->ghostData('word');
        if($texts === true) return $word;

        return range(1, count($word));
        // return $this->proxy->wordings($texts);
    }

    /**
     * Checks if current word's relative character index matches a list of indexes compared 
     *  - Note that the character index of each word is initialized from 1 above.
     * 
     * @param int|int[] $pos list of character positions to compare in a matched word relative to that word.
     * @return boolean
     */
    public function charPos(int|array $pos) : bool { 

        $currentPosition = $this->proxy->ghostData('currentPosition');                       
        $cPos = $currentPosition;
        $pos = is_array($pos)? $pos : [$pos];
        return in_array($cPos, $pos);

    }

    /**
     * Checks if the bit is at the beginning character of the string selected or matched
     * 
     * @param int|null $count if specified, returns TRUE only if the character bits count is not greater than the count value supplied.
     * @return boolean
     */
    public function firstChar(?int $count = null) : bool {
        if($count !== null){
            $bit = $this->proxy->bit;
            return ($bit > $count)? false : true;
        }
        return $this->proxy->firstChar;
    }   

    /**
     * Checks if the the bit is at the ending character of the string selected or matched
     * @return boolean
     */
    public function lastChar(?int $count = null) : bool {
        if($count !== null){
            $bit = $this->proxy->bit;
            $wording = $this->proxy->ghostData('wording');
            $wordLength = strlen($wording);
            return (($bit > ($wordLength - $count)) >= $count)? true : false;
        }
        return $this->proxy->lastChar;
    }

    /**
     * Returns the current word positional index in a pulsated text string
     * 
     * @param array|int|null $index indexes from which the current animation index must exist.
     * @param array|string|null $word word lists from which the current animation word must exist.
     * 
     * @return integer|boolean
     *  - integer: This is returned when no argument is supplied referring to the current word index
     *  - boolean: TRUE or FALSE based on the validity of test arguments supplied. 
     */
    public function wordIndex(array|int|null $index = null, array|string|null $word = null) : int|bool {
        
        $listIndex = $this->positionalIndex();

        $wording = $this->proxy->ghostData('wording');

        if($index === null && $word === null) return $listIndex; // positional index

        if($index === null && $word !== null) return false; // no index in words

        if($index !== null && $word === null){
            // match word index with indexes supplied
            $index = is_array($index)? $index : [$index];
            return in_array($listIndex, $index, true);
        }

        // match word index with indexes and words supplied.
        $index = is_array($index)? $index : [$index];
        $word = is_array($word)? $word : [$word];
        return in_array($listIndex, $index, true) && in_array($wording, $word);

    }

    /** This method retrieves the positional index of each pulse word through animation index*/
    private function positionalIndex(){
        $charIndex = $this->proxy->index;
        $words = $this->proxy->ghostData('allwords');

        $pos = 1;

        foreach ($words as $i => $word) {
            $start = $pos;
            $end   = $pos + strlen($word) - 1;

            if ($charIndex >= $start && $charIndex <= $end) {
                return $i + 1; // 0-based index
            }

            // Move to next word (+1 for space)
            $pos = $end + 2;
        }

        return false; // out of range
    }

    /**
     * Returns the current word positional index in a pulsated text string
     * 
     * @param string|string[]|null $word word lists from which the current animation word must exist.
     * @param int|int[]|null $index indexes from which the current animation index must exist.
     * 
     * @return integer|boolean
     *  - integer: This is returned when no argument is supplied referring to the current word index
     *  - boolean: TRUE or FALSE based on the validity of test arguments supplied. 
     */
    public function wordFrequency(array|string|null $word = null, array|int|null $index = null) : int|bool {
        
        $counter = $this->proxy->ghostData('counter');
        $wording = $this->proxy->ghostData('wording');

        if($index === null && $word === null) return $counter; // positional frequency of current word

        if($index === null && $word !== null) return in_array($wording, $word)? $counter : false;

        if($index === null && $word !== null) return false; // no index in words

        if($index !== null && $word === null){
            // match word index with indexes supplied
            $index = is_array($index)? $index : [$index];
            return in_array($counter, $index, true);
        }

        // match word index with indexes and words supplied.
        $index = is_array($index)? $index : [$index];
        $word = is_array($word)? $word : [$word];
        return in_array($counter, $index, true) && in_array($wording, $word);

    }


    /**
     * Returns the character index starting from the beginning of the 
     * currently selected word. This is relative to each selected word rather than the 
     * entire string.
     * 
     * @param int|array|null $count
     *  null: fetches the current bit index starting from 1 and above
     *  array/int: compares the bit index with the supplied value(s) and returns TRUE if matched or FALSE if no match is found.
    *
    * @return int
     *  - if NULL, returns integer of the current character's bit index starting from 1 above
     *  - if array, returns TRUE if the current character's bit index matches the index in specified list
     *  - if int, returns TRUE if the current character's bit index matches the exact value supplied
     */
    public function bit(int|array|null $count = null) : int|bool{
        $bit = $this->proxy->bit;
        if($count !== null) {
            $count = is_array($count)? $count : [$count];
            return in_array($bit, $count);
        }
        return $bit;
    }

}