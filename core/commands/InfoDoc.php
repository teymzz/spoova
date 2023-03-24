<?php

namespace spoova\mi\core\commands;

class InfoDoc {

    private const locations = [
        'classes' => '\core\classes\\',
        'tools'   => '\core\tools\\',
    ];

    public static function doc($foldername, $classname){

        if($path = (self::locations[$foldername]?? false)){ 

            if(@class_exists($path.$classname)){
                $methods = get_class_methods($path.$classname);
                $header = $classname.' methods : ';
                foreach($methods as $method){ 
                    $header .=" ++ > ".$method.'()';
                }
                Console::log($header);
                // return ($header);
            } else 
            {
                return ('class not found');
            }

        }

        return ('Invalid directive supplied');

    }


}