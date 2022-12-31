<?php

namespace spoova\core\classes;

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
     * return the current connection database class name
     *  (MiSQL, MiPDO)
     *
     * @return string 
     */
    public function conName();


    /**
     * return the real current connection database of the current connection
     *  (MySQLi, PDO)
     * 
     * @return string 
     */
    public function conType();

    /**
     * returns the last database connection response
     * This message is returned only when database connection failed
     *
     * @return void
     */
    public function conResponse();
    
    /**
     * return the currently selected database name
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