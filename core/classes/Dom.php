<?php

namespace spoova\mi\core\classes;

use DOMDocument;
use DOMXPath;

/**
 * @method DOMDocument loadHTML()
 * @method DOMXPath
 */
class Dom {

    private ?DomDocument $dom = null;
    private ?DOMXPath $domxpath = null;

    function __construct(string $version = '1.0', string $encoding = '')
    {
        $this->dom = new DOMDocument(...func_get_args());
    }

    function __call($method, $arguments){

        if($this->dom){
            if(method_exists($this->dom, $method)){
              return $this->dom->$method(...$arguments);
            }else{
                if(!$this->domxpath){
                    return $this->domxpath = new DOMXPath($this->dom);
                }
                if($this->domxpath instanceof DOMXPath && (method_exists($this->domxpath, $method))){
                    return $this->domxpath->$method(...$arguments);
                }else{
                    print "something is wrong!!!";
                    //trigger error
                }
            }
        }      

    }


}