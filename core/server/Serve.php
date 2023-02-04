<?php


namespace spoova\core\server;

use Server;
use spoova\core\classes\Ajax;
use User;

class Serve {


    /**
     * Standard logic for running application (recommended)
     * Note :: Entire logic is managed by framework
     * 
     * @return void
     */
    static function standardlogic() {

        //load window root as window from routes folder
        if(!Ajax::isAjax()){

            if(!Server::callRoute(ucfirst(window('root')?:'index'))) Server::close();

        } else{

            if(!Server::callRoute(ucfirst(window('root')))) {
                Ajax::withJson('not found', 404);
                response(404, 'not found');    
            }
        }

        //Authenticate all sessions
        User::auth()->id()->main();

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
        
        /*  //initialize the index page
            if(server::isIndex($this)){
            
                //load index page
                server::call($this, [
            
                    window('root') => 'root',
                    
                ]);
        
            } else {
        
                //load window root as window from routes folder
                if(!server::callRoute(window('root'))) server::close();
        
            } 
        */

    }

}