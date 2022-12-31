<?php

namespace spoova\windows\Routes;

use Installer;
use Window;

class Install extends Window{

    function __construct()
    {
        include_once(_core.'installer.php');

        $Installer = new Installer;
        $Installer->install();
        print $Install->content();

    }

}
