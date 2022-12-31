<?php

    namespace spoova\windows\Routes;

    use spoova\core\classes\EInfo;
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