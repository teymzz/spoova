<?php

namespace spoova\mi\core\classes;

/**
 * Split a string into attributes and values
 * 
 * @author Akinola Saheed <github teymzz>
 */
class Attribs {

    private static $text;

    /**
     * Text string supplied to be splitted
     * Text format should be attribute:value; attribute:value 
     *
     * @param string $text
     *  - If text is returned, a space will preceed the string
     * @param bool $is_array return as array
     * @return array|string
     */
    static function split($text = '', bool $is_array = false) : array|string{
        
        $text = rtrim(preg_replace('/\s+/', ' ', trim($text)),'; ');

        //split into chunks
        $splits = explode(';', $text);

        $attributes = $is_array ? [] : '';

        if($is_array){
            foreach($splits as $split){

                $attribs = explode(':', $split);
                $attributes[$attribs[0]] = $attribs[1]?? '';

            }    
            return $attributes;  //returned as array    
        }else{
            foreach($splits as $split){

                $attributes .= " ".str_replace(':', '="', $split).'"';

            }   
            return ($attributes)? $attributes.' ' : $attributes; // returned as string
        }

    }

    /**
     * Joins array of string and value pairs into string attributes format
     *
     * @param array $array
     * @return string single trailing space is appended to both sides of the 
     * string only if a text string is returned. This can be easily trimmed with rtrim(), ltrim() or trim() 
     * functions depending on requirements. 
     */
    static function join(array $array) : string {

        $attributes = '';

        foreach($array as $key => $value){

            $attributes .= ' '.$key.'="'.$value.'"';

        }
        
        return ($attributes)? $attributes.' ' : $attributes; 
    }
    
    /**
     * Updates default keys and value pairs with new keys or adds new keys to default if it does not already exist.
     *
     * @param array $oldList Default keys to be updated
     * @param string|array $newList string attributes or arrays of keys to be replaced or added
     * @param bool $return_array determines if array should be returned or string.
     * @return array|string
     */
    static function update(array $oldList, array|string $newList, bool $is_array = false) : array|string {

        if(is_string($newList)){
            $newList = self::split($newList, true);
        }

        $newList = array_replace($oldList, $newList);

        return ($is_array)? $newList : self::join($newList);

    }

}