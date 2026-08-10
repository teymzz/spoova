<?php

namespace spoova\mi\core\classes;

use Window;

class Base extends Window {

    /**
     * Starting application with specified routing logic
     *
     * @param string $type optional ['index'|'basic'|'']
     *   - Empty value denotes standard logic
     * @return void
     */
    protected static function start(string $type){}

}