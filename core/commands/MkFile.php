<?php

namespace teymzz\spoova\core\commands;

use Res;

use teymzz\spoova\core\commands\Entry;

class MkFile extends Entry{

    function __construct($args){

        if(!$args) return $this->addError('invalid argument count!'.PHP_EOL);



        $meth = array_shift($args);
        ksort($args, SORT_REGULAR);

        Res::mkFile($meth, $args);

    }

}