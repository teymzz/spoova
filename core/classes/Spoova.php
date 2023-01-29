<?php

namespace spoova\core\classes;

use spoova\core\classes\FileManager;

class Spoova{

    /**
     * Check if connection is successfull
     *
     * @return boolean
     */
    public static function isConnected() : bool {
        ($dbc = new DB())->openDB();

        return $dbc->isConnected();
    }

    /**
     * Check if configuration is completed
     *
     * @return boolean
     */
    public static function isConfigured(){

        $Filemanager = new FileManager;

        $Filemanager->setUrl(_icore.'init');

        $content = $Filemanager->readFile('SETUP_COMPLETE');

        return (self::isConnected() && $content);
    }

}