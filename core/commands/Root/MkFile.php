<?php

namespace spoova\mi\core\commands\Root;

use Res;
use spoova\mi\core\commands\Root\Entry;

class MkFile extends Entry{

    function __construct($args){

        if(!$args) return $this->addError('invalid argument count!'.PHP_EOL);

        $meth = array_shift($args);
        ksort($args, SORT_REGULAR);

        Res::mkFile($meth, $args);

    }

}