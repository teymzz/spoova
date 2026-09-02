<?php

namespace spoova\mi\core\classes\DB;

use spoova\mi\core\classes\Model;
use spoova\mi\core\classes\Collection;
use spoova\mi\core\classes\DB\DBExecutors;
use spoova\mi\core\classes\DB\DBMediators;

/**
 * This class contains custom modifier operators for 
 * modifying records already retrieved from database, thereby determining how records 
 * are finally viewed.
 * - Note that this class uses the Collection storage class
 * 
 * @property array|collection $collection return collection data
 *  - This property is reserved and should not be used as a database table's field name. The value is immutable and cannot be modified.
 * @property mixed $* Any dynamically handled property
 */
class DBDeleter implements DBExecutors {

    private DBMediators $handler; 
    private $DBError = false;
    private $hasError = false;
    private $sql = '';

    /**
     * This belongs to the dbcollector class
     *
     * @var array|DBMediators
     */
    protected DBMediators $Collector;

    /**
     * @param DBMediators $updater
     * @param Model $model
     * 
     * @return DBDeleter
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
    public function sql() : string {

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
     * Alias for {@see DBDeleter::succeeds()}. Returns TRUE if no sql 
     * error was detected.
     *
     * @return bool
     */
    public function deleted() : bool {

        return $this->succeeds();

    }

    /**
     * Return an array list of sql data related information
     *
     * @return array
     */
    public function info() : array {

        return $this->handler->info();

    }

    /**
     * Returns the last error set by DBViewer
     *
     * @return string|false
     */
    public function error() : string|false {
        return $this->DBError;
    }

}