<?php

namespace spoova\windows\Routes\Docs;
use Res;
use spoova\windows\Frames\UserFrame;

class Resource extends UserFrame{


    public function __construct(){ 

        $pointer = self::mapurl('Tutorial/Resource', ' <span class="bi-chevron-right"></span> ');
    
        $vars = [
            'title' => 'Tutorial - Resource',
            'pointer' => $pointer
        ];

        self::call($this, [
            window(':resource')          => 'index',
            window(':resource.grouping') => 'grouping',
            window(':resource.flash')    => 'flash',
            SELF::ARG => $vars
        ]);
    
    }

    public function index($vars) {

        Res::load('docs.resource.index', fn() => compile($vars));
        
    }

    public function grouping($vars) {
        Res::load('docs.resource.groupings', fn() => compile());
    }

    public function flash() {

        $pointer = self::mapurl('Tutorial/Resource/Flash', ' <span class="bi-chevron-right"></span> ');
        
        $vars = [
            'title'   => 'Tutorial - Resource',
            'pointer' => $pointer
        ];

        Res::load('docs/resource/flashes', fn() => compile($vars));
    }

}