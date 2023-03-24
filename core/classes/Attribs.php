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
     * @param bool $array return as array
     * @return array|string
     */
    static function split($text = '', bool $array = false){
        
        //split into chunks
        $splits = explode(';', $text);

        $attributes = $array ? [] : '';

        if($array){
            foreach($splits as $split){

                $attribs = explode(':', $split);
                $attributes[$attribs[0]] = $attribs[1]?? '';

            }            
        }else{
            foreach($splits as $split){

                $attributes .= " ".str_replace(':', '="', $split).'"';

            }   
        }


        return $attributes;

    }


}