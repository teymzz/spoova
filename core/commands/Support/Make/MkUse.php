<?php

namespace spoova\mi\core\commands\Support\Make;

use ErrorHandler;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use spoova\mi\core\commands\Support\Make\MkBase;

/**
 * This class is an alias for MKWinRoute
 */
class MkUse extends MkBase{

    public function __construct(array $args)
    {
       if($args && (method_exists($this, $args[0]))){
            $command = $args[0]; unset($args[0]);
            $this->{$command}(array_values($args));
       }else{
        Cli::textView(Cli::danger(Cli::emo('point-list').' use '));
        Cli::break(2);
        Cli::textView(Cli::warn('option:').(' [map] - creates a new map file'), '2');
        Cli::break(1)->bashBreak(1);
       }
    }

    public function map(array $args){

        //generate a new map file
        $map = '{

            "\\RouteName" : "Controller"

        }';

        $Filemanager = new Filemanager;

        Cli::textView(Cli::danger(Cli::emo('point-list').' use map'));
        Cli::break(1)->bashBreak(1);

        if(is_file('windows/map')){
            Cli::textView(Cli::warn('Notice: ').('map file already exists.'));
            Cli::break(1)->bashBreak(1);
        }else{
            if($Filemanager->openFile(url: 'windows/map')){
                file_put_contents('windows/map', $map);
                Cli::textView(Cli::success('map file added successfully.'));
                Cli::break(1)->bashBreak(1);
            }else{
                Cli::textView(Cli::error('map cannot be created'));
                Cli::break(1)->bashBreak(1);
            }
        }


    }


    public function build() : bool{

        echo 1; exit;

        return true;

    }


}