<?php

/**
 * @package core/commands
 * @author Akinola Saheed <teymss@gmail.com> .
 * 
 * This class is for development process. 
 * Warning: The usage of this class will alter installation files. 
 *  This may cause app to break or lead to other undesired errors.
 */
namespace spoova\core\commands;

use spoova\core\classes\FileManager;

class Add extends Entry{

    private $recompile;

    /**
     * array of arguments
     *
     * @param array $args
     */
    function __construct($args = []) {

        /* 
        add Frame User windows\UserFrame

        add Windows User windows
        */
        if(class_exists('\spoova\core\commands\Make\Mk'.(ucfirst($args[0]??'')))){
            new \spoova\core\commands\MkFile($args);
        } else {
            $this->addError('command not found'.PHP_EOL);
        }

    }

}