<?php

    namespace teymzz\spoova\windows\Routes;

    use Window;

    class Test extends Window{

        public function __construct()
        {
            print_r(toJson(['yum'=>'yom']));
        }

        static function super(){
            print 'hi';
        }

    }