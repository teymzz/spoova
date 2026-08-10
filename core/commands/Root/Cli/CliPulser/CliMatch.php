<?php

namespace spoova\mi\core\commands\Root\Cli\CliPulser;

use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\classes\GhostProxy;
use spoova\mi\core\commands\Root\Cli;

/**
 * Matches the index or indexes of a specific word.
 */
abstract class CliMatch extends CliBits {

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
    public function wordFrequency(array|int|null $index = null) : int|bool {
        
        $frequency = $this->proxy->ghostData('frequency');

        if($index === null) return $frequency; // positional frequency of current word

        // match word index with indexes supplied
        $index = is_array($index)? $index : [$index];
        return in_array($frequency, $index, true);

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
     * This returns the word indices used for resolving matched strings.
     *  - Note that by default, returned array indices returned do not contain
     *  zero(0) index keys but runs starting from array key index of 1 and above.
     *
     * @param integer $frequency this refers to the matched word expected frequency which must start from 1
     * @return array|int|false
     *  - array : list of retrieved word indices.
     *  - int : current word index
     *  - false : returned when frequency supplied is not matched.
     */
    public function indices(int|null $frequency = null) : array|int|false {
        $indices = $this->proxy->ghostData('indices');
        if($frequency === null){
            return $indices;
        }
        return array_key_exists($frequency, $indices)? $indices[$frequency] : false;
    }


}