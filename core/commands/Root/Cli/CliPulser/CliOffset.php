<?php

namespace spoova\mi\core\commands\Root\Cli\CliPulser;

use spoova\mi\core\commands\Root\Cli;

abstract class CliOffset extends CliBits{

    /**
     * Tries to detect and return the current selected word string. Words are mostly detected through spaces.
     * @return string
     */
    public function text() : string {
        return $this->proxy->text;
    }

    /**
     * Returns the current selected word string
     * 
     * @param string[] $texts
     * @return string
     */
    public function word(array|string|null $texts = null) : string|bool {
        $message = $this->proxy->message;
        
        $msg = preg_replace('/(?<=[\p{L}\p{N}\)\]\}"\'’])([.,;!?]+)(?=(\s|$))/u','',$message);
        $words = preg_split('/\s+/', $message, -1, PREG_SPLIT_NO_EMPTY);

        $index = $this->proxy->index;

        $offset = 0; $word = false;
        foreach($words as $w){
            $wstart = strpos($message, $w, $offset) + 1;
            $word = $w;
            $wend = $wstart + strlen($word) - 1;
            $offset = $wend + 1;
            if(inRange($index, $wstart, $wend)) break;
        }

        if(is_array($texts)){
            return in_array($word, $texts, true);
        }

        return $word ?? ''; 
    }

    /**
     * Returns the current selected word string
     * 
     * @param string[] $texts texts to be search.
     * $param boolean $case TRUE applies case sensitivity.
     * @return string
     */
    public function smartword(array|string|null $texts = null, bool $case = false) : string|bool {
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
     * Check if current Cli pulse character is within range of specified word.
     *
     * @return int
     */
    public function in(string $word) : int{
        return $this->proxy->index + 1;
    }


    public function inRange(int $start, int $stop) : bool{
        $index = $this->proxy->index;
        return inRange($index, $start, $stop);
    }

}