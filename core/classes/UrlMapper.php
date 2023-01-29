<?php

namespace spoova\core\classes;

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
     * @param string $path path to be mapped
     * @param string $pointer navigation pointer
     * @return array
     */
    function map($path, $pointer = '/'){

        $paths = explode('/', str_replace(' ', '',$path));

        $prev = ''; $linked = '';
        if(empty($pointer)) return $path;

        foreach($paths as $path){
            $prev .= trim(strtolower($path), '/ ').'/';
            $linked .= $pointer.'<a href="'.trim($this->urlbase.$prev, '/').'">'.$path.'</a>';
        }
        return explode($pointer, $linked, 2)[1];

    }

}