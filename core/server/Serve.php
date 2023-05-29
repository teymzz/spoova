<?php


namespace spoova\mi\core\server;

use Server;
use spoova\mi\core\classes\Ajax;
use spoova\mi\core\classes\Router;

class Serve {


    /**
     * Standard logic for running application (recommended)
     * Note :: Entire logic is managed by framework
     * 
     * @return void
     */
    static function standardlogic() {

        $map  = Router::map();

        $win = window('root') ?: 'index';
        $winlow = strtolower($win);
        $wininv = "!".$winlow;
        $roots = $map[':root'] ?? [];
        $iroot = [];

        array_map(function($value, $key) use(&$iroot){
            $key = (substr($key, 0, 1) === '!')? strtolower($key) : $key; 
            $iroot[$key] = $value;
        }, $roots, array_keys($roots));
        $roots = $iroot;

        $window = $roots[$wininv] ?? $roots[$win] ?? $map[$win] ?? ucfirst($win);

        $root = Router::relate($window, $map);

        if(!Ajax::isAjax()){

            if(!Server::callRoute(ucfirst($root?:'index'))) Server::close();

        } else{

            if(!Server::callRoute(ucfirst($root?:'index'))) {
                Ajax::withJson('not found', 404);
                response(404, 'not found');    
            }
        }

    }


    /**
     * Base logic for running application
     * Note 1:: This can only be applied within the Server::start() method
     * Note 2:: Entire logic is managed by developer
     * @return void
     */
    static function baselogic(string $name = 'index') {
        //initialize the specified index page
        Server::callRoute($name);
        
    }

    /**
     * This logic can only be applied within the server file page
     * Note 1:: Server must be replaced with "self"
     * Note 2:: Entire logic is managed by developer
     * 
     * @param string $name route file name
     * @return void
     */
    static function indexlogic() {

        Server::callRoute('Index');

    }

}