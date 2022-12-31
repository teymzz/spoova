<?php

namespace spoova\windows\Routes;
use Window;

class Docs extends Window {

    public function __construct(){

        $base = ucwords(str_replace('/', ' / ', window('base')));

        $pointer = self::mapurl( $base , ' <span class="bi-chevron-right"></span> ');

        $vars    = ['pointer' => $pointer];

        //direct path call
        self::call($this,
            [
                window(':') => 'root',
                window(':installation') => 'installation',
                window(':live-server')  => 'liveserver',

                SELF::ARG => $vars
            ],
            false
        );

        //run other paths on tutorial using classes
        self::basecall($this, 
            [
                window(':database')  => 'win:Routes\Docs\Database',
                window(':database-handling')   => 'win:Routes\Docs\Database',
                window(':routings')  => 'win:Routes\Docs\Routings',
                window(':resource')  => 'win:Routes\Docs\Resource',
                window(':sessions')  => 'win:Routes\Docs\Sessions',
                window(':forms')     => 'win:Routes\Docs\Forms',
                window(':functions') => 'win:Routes\Docs\Functions',
                window(':mails')     => 'win:Routes\Docs\Mails',
                window(':plugins')    => 'win:Routes\Docs\Plugins',
                window(':classes')    => 'win:Routes\Docs\Classes',
                window(':directives')    => 'win:Routes\Docs\Directives',
                window(':useraccounts')  => 'win:Routes\Docs\UserAccounts',
                window(':cli')    => 'win:Routes\Docs\Cli',
                window(':wmv')    => 'win:Routes\Docs\Wmv',
                window(':commands') => 'win:Routes\Docs\Commands',
                window(':setters')  => 'win:Routes\Docs\Setters',
                window(':libraries')  => 'win:Routes\Docs\Libraries',
                window(':other-features')  => 'win:Routes\Docs\Features',
                window(':features')  => 'win:Routes\Docs\Features',

                SELF::ARG => $vars
            ]
        );

    }

    function root() {
        
        $vars['title']  = 'tutorial';

        self::load('about', fn() => compile($vars) );

    }

    function installation($vars) {

        $vars = [
            'title' => 'Installation',
            'pointer' => $vars['pointer']
        ];
  
        self::load('installation', fn() => compile($vars) );

    }

    
    public function LiveServer($vars) {
        
        $vars = [
            'title' => 'Installation', 
            'pointer' => $vars['pointer']
        ];

        self::load('live-server', fn() => compile($vars) );
    } 

    public function Docs() {
        
        $pointer = self::mapurl('Tutorial / Live-Server', ' <span class="bi-chevron-right"></span> ');
        $pointer = ['pointer' => ucwords($pointer) ] ;
        $docs = ['Database', 'Routings', 'Resource', 'Sessions'];      
        foreach($docs as $doc) {
            if( url( window('path') )->isLike($doc, false) ) {

                $ddoc = "\\spoova\windows\Routes\Docs\\".$doc;
                new $ddoc($pointer);
                return;
            }
        }
        
        self::close();

    }


}