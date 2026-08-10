<?php

/**
 * @author Akinola Saheed <akinolasaheed001@gmail.com> .
 * 
 * This class is for development process. 
 * Warning: The usage of this class will alter installation files. 
 * This may cause app to break or lead to other undesired errors.
 */
namespace spoova\mi\core\commands\Support;

use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Entry;

class Add extends Entry{

    private $recompile;

    /**
     * array of arguments
     *
     * @param array $args
     */
    function __construct($args = []) {
      
      if(!$args){
        Cli::cls();
        Cli::headerView('add', break: 2);
        Cli::errorView('add expects a valid syntax.', break : 2);
        Cli::infoView(' Info ', 'use [mi] '.Cli::alert("info add").' to check syntax.', color: 'warn', break : 1);
        return false;
      }

        /* 
        add Frame User windows\UserFrame

        add Windows User windows
        */
        if(suppress_error(E_WARNING, fn() => class_exists(scheme('core\commands\Support\Make\Mk').(ucfirst($args[0]??''))))){
            $class = scheme('core\commands\Support\MkFile');
            new $class($args);
        } else {
            Cli::textView(Cli::danger(Cli::emo('point-list').' add:'.Cli::warn($args[0]).' ?'));
            Cli::break(2).
            Cli::textView(Cli::error('"add:'.Cli::warn($args[0]).'" not found!'), '2');
            Cli::break(2);
            Cli::textView(Cli::notice('controller file may be missing or command does not exist.', title: 'Notice: '), '2');
            Cli::break(2);
            Cli::textView(Cli::notice('type -'.self::mi('info', pointer:'').Cli::warn('add','1').' - without dashes to see command options.', title: 'Notice: '), '2');
            Cli::break(2);
        }

    }

}