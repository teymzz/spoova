<?php

namespace spoova\mi\core\classes;

use Error;

class UrlMapper {

    private $urlbase;

    /**
     * Sets the Prefix of the path to be mapped
     *
     * @param string $url
     * @return void
     */                 
    function setbase($url){
        $this->urlbase = $url;
    }

    /**
     * sets the path to be mapped
     *
     * @param string|array $path path to be mapped 
     *   - array format : [path, link]
     * @param string $pointer navigation pointer
     * @param int[] $exc excluded paths using positional index starting from 1 above.
     * @return string
     */
    function map(array|string $path, $pointer = '/', string|int|array $exc = []) : string {
        $path = (array) $path;

        if(!is_array($exc)) $exc = [$exc];
        $exc =  array_unique($exc);
        
        $link = isset($path[1])? $path[1] : $path[0];
        $path = $path[0];
        $lowerpath = strtolower($path);
        $lowerlink = strtolower($link);
        if($lowerlink !== $lowerpath) throw new Error('mapped paths signatures mismatch');
        $paths = explode('/', str_replace(' ', '',$path));
        $links = explode('/', str_replace(' ', '',$link));

        $prev = ''; $linked = '';
        if(empty($pointer)) return $path;

        foreach($paths as $i => $path){
            $prev .= trim($links[$i], '/ ').'/';
            if(in_array($i+1, $exc)){
                $linked = $pointer.$path;
            }else{
                $linked .= $pointer.'<a href="'.trim($this->urlbase.$prev, '/').'">'.$path.'</a>';
            }
        }
        
        return explode($pointer, $linked, 2)[1];

    }

}