<?php

namespace spoova\mi\core\classes\DB;

/**
 * This class forms the basis of all connection handlers
 * Helper methods are included in the DBBridge and DB classes
 */
Interface DBHelpers{

    /**
     *  Default valid database class names
     */    
    public const conNames = 
        ['MiSQL', 'MiPDO'];

    /**
     * Default valid database class types
     */
    public const conTypes = 
        ['MySQLi', 'PDO'];  

    /**
     * Returns the current connection database class name (MiSQL, MiPDO)
     *
     * @return string 
     */
    public function conName();


    /**
     * Returns the real current connection database manager name for the current connection (MySQLi, PDO)
     * 
     * @return string 
     */
    public function conType();

    /**
     * Returns the last database connection response.
     * This message is returned only when database connection fails
     *
     * @return string
     */
    public function conResponse();
    
    /**
     * Return the currently selected or active database name within a database manager
     *
     * @return string 
     */
    public function currentDB();

    /**
     * Returns true if a sql database connection was successful.
     *
     * @return boolean
     */
    public function isConnected();

}