<?php


namespace spoova\mi\core\server;

use Server;
use spoova\mi\core\classes\Activity;
use spoova\mi\core\classes\Ajax;
use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use spoova\mi\core\classes\Hasher;
use spoova\mi\core\classes\Init;
use spoova\mi\core\classes\Router;
use spoova\mi\core\classes\Sensor\Sensor;

class Serve {

    private static $mapped = false;

    static function ini(){

        if(!isCli()){
            $phpINI = php_ini_loaded_file();
            $passkey = $phpINI ?: '1a2b3xyz';
            $Hasher = new Hasher([to_frontslash(domroot()),getOs()], $passkey);
            $token = $Hasher->hashify('sha1');
            $iniToken = Init::key('INI-Token');
            
            if($token !== $iniToken) {
                Init::set('INI-Path', $phpINI);
                Init::set('INI-Token', $token);
            }
        }

    }

    /**
     * Standard logic for running application (recommended)
     *  - Note: This logic is managed and controlled by framework
     * 
     * @return void
     */
    static function standardlogic() {

        Activity::bench();
        $map  = Router::map();

        $win = window('root') ?: 'index';
        $winlow = strtolower($win);
        $wininv = "!".$winlow;
        $roots = $map[':root'] ?? [];
        $iroot = [];

        //resolve map file values
        array_map(function($value, $key) use(&$iroot){
            $key = (substr($key, 0, 1) === '!')? $key : strtolower($key); 
            $iroot[$key] = $value;
        }, $roots, array_keys($roots));
        $roots = $iroot;

        //hierachy: ".*", root[!root], root[root], map[root], Root 
        $window = $roots[$wininv] ?? $roots[$win] ?? $map[$win] ?? ucfirst($win);

        $mroots = ($map[':root']??[]);
        $mroots = $mroots[$wininv] ?? $mroots[$win] ??  $map[$win] ?? false;
        if($mroots){ 
            $mapped_route = true;
        }

        $root = Router::relate($window, $map); //hierachy: {map:".*, :root, window"}, {default:"window"}, ,

        if(!Ajax::isAjax()){
            self::$mapped = $mapped_route ?? false;    
            
            if(!Server::callRoute(ucfirst($root?:'index'))) 
            {
                Server::close();
            } 
            
        } else{
            self::$mapped = $mapped_route ?? false;

            if(!Server::callRoute(ucfirst($root?:'index'))) {
                Ajax::withJson('not found', 404);
                response(404, 'not found');    
            }
        }

    }


    /**
     * Base logic for running application
     *  - This can only be applied within the Server::start() method
     *  - This logic is controlled by specified root route controller file
     * @return void
     */
    static function baselogic(string $name = 'index') {
        //initialize the specified index page
        Server::callRoute($name);
        
    }

    /**
     * This logic can only be applied within the server file page
     *  - Server must be replaced with "self"
     *  - Entire logic is controlled by an Index file.
     * 
     * @param string $name route file name
     * @return void
     */
    static function indexlogic() {

        Server::callRoute('Index');

    }

    /**
     * Determines if page is mapped
     *
     * @return bool
     */
    static function mapped() : bool {
        return self::$mapped;
    }

}