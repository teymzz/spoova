<?php 

namespace spoova\mi\core\commands\Root\Cli\Enums;

enum console {

    /** Display only keys  */
    case keys;

    /** Display keys and value pairs */
    case pairs;

    /** 
     * Defines acceptable options on console() helper function or method
     *  - To use this, applied method or function must take 2 arguments where the first is an array that defines the console options.
     *  - Sample Format : console(['colors'=>true, 'keys'=>true], console::ops)
     *  - Supported options: [keys,colors]
     * */
    case ops;
}