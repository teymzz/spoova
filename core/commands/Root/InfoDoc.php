<?php

namespace spoova\mi\core\commands\Root;

class InfoDoc {

    private const locations = [
        'classes' => '\core\classes\\',
        'tools'   => '\core\tools\\',
    ];

    public static function doc($foldername, $classname){

        if($path = (self::locations[$foldername]?? false)){ 
            $path = scheme($path);
            if(@class_exists($path.$classname)){
                $methods = get_class_methods($path.$classname);
                $header = $classname.' methods : ';
                foreach($methods as $method){ 
                    $header .=" ++ > ".$method.'()';
                }
                Console::log($header);
            } else {
                return ('class not found');
            }

        }

        return ('Invalid directive supplied');

    }


}