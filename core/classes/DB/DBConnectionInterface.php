<?php 

namespace spoova\mi\core\classes\DB; 

use spoova\mi\core\classes\DB;
use spoova\mi\core\classes\DB\DBHandler;

interface DBConnectionInterface {

    /**
     * Defines a list of connection parameters relative to the DBClass format
     *
     * @param array|string|null|null $dbname
     * @param string $dbuser
     * @param string $dbpass
     * @param string $dbserver
     * @param string $dbport
     * @param string $dbsocket
     * @return DBHandler|false if connection is successful, the Database handler class is returned
     */
    public static function connection (
        array|string|null $dbname = null,
        string $dbuser = '', 
        string $dbpass = '', 
        string $dbserver = '',
        string $dbport = '', 
        string $dbsocket = ''
    ): DBHandler|false ;

}