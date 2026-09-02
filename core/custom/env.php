<?php

use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use spoova\mi\core\classes\DB\DBConfig;
use spoova\mi\core\classes\Environment;

Environment::path(smart_env_path); // loads env from simulated environment
DBConfig::safeguard($_DBCONFIG, smart_env_path); // loads env from simulated environment