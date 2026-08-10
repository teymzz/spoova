<?php

namespace spoova\mi\core\classes\DB;

use spoova\mi\core\classes\Model;
use spoova\mi\core\classes\Collection;
use spoova\mi\core\classes\DB\DBExecutors;
use spoova\mi\core\classes\DB\DBMediators;

/**
 * This class is used by DBMediators update method
 */
class DBUpdater implements DBExecutors {

    private DBMediators $handler; 
    private $DBError = false;
    private $hasError = false;
    private $sql = '';

    /**
     * This belongs to the dbcollector class
     *
     * @var DBMediators|array
     */
    protected DBMediators|array $Collector;

    /**
     * @param DBMediators $updater
     * @param Model $model
     * 
     * @return DBUpdater
     */
    public function __construct(DBMediators $updater, ?Model $model)
    {
        $this->handler = $updater;
        
        $this->DBError = $updater->error();

        if($this->DBError) $this->hasError = true; 

        if($model) $this->sql = $model->sql();
    }

    /**
     * Returns the last sql query detected if any.
     *
     * @return string
     */
    public function sql() {

        return $this->sql;

    }

    /**
     * Returns TRUE if sql error was detected.
     *
     * @return bool
     */
    public function failed() : bool {

        return $this->hasError;

    }

    /**
     * Returns TRUE if no sql error was detected.
     *
     * @return bool
     */
    public function succeeds() : bool {

        return !$this->hasError;

    }

    /**
     * Alias for {@see DBUpdater::succeeds()}. Returns TRUE if no sql 
     * error was detected.
     *
     * @return bool
     */
    public function updated() : bool {

        return $this->succeeds();

    }

    /**
     * Return an array list of sql data related information
     *
     * @return array
     */
    public function info() {

        return $this->handler->info();

    }

    /**
     * Returns the last error set by DBViewer
     *
     * @return string
     */
    public function error() {
        return $this->DBError;
    }

}