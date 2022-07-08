<?php

namespace spoova\windows\Docs;
use Res;
use spoova\windows\Frame\UserFrame;

class Resource extends UserFrame{


    public function __construct($value){
        if($value){

            $pointer = self::mapurl('Tutorial/Resource', ' <span class="bi-chevron-right"></span> ');
        
            $vars = [
                'title' => 'Tutorial - Resource',
                'pointer' => $pointer
            ];

            self::pathcall($this, [
                //'resource' => 'index',
                'resource/grouping' => 'grouping',
                'resource/flash' => 'flash'
            ], $vars);
    
            self::basecall($this, [
               'tutorial/resource' => "gp"
            ]);
        }
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
            'title' => 'Tutorial - Resource',
            'pointer' => $pointer
        ];

        Res::load('docs/resource/flashes', fn() => compile($vars));
    }

}