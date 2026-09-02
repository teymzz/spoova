<?php

namespace spoova\mi\core\classes\DB;

use spoova\mi\core\classes\DB\DBViewer;
use spoova\mi\core\classes\DB\DBDeleter;
use spoova\mi\core\classes\Paginator;

/**
 * This interface contains basic database operators 
 * useful for navigating how records are retrieved or processed by the database. 
 */
interface DBOperators {

    /**
     * Sets "where" condition on modek sql structure
     *
     * @return DBCollectors|DBMediators
     */
    static function where(string $where, array $params = []) : DBCollectors|DBMediators;

    /**
     * Read from database
     *
     * @return DBViewer
     */
    static function read(array $fields = [], array $limit = []) : DBViewer;

    static function paginate(int $perPage = 15, ?int $page = null) : Paginator;

    /**
     * delete from database
     *
     * @return DBDeleter|bool
     */
    static function delete(?int $limit = null) : DBDeleter|bool; 

    /**
     * Update dabase
     *
     * @return DBUpdater|bool
     */
    static function update(array $fields) : DBUpdater|bool;

    /**
     * A relationship based on the current session id
     *
     * @return DBCollectors|DBMediators
     */
    static function ofUser(int $userid, ?string $ForeignKey = null): DBCollectors|DBMediators;

    /**
     * This relationship selects data owned by an another table where $ownerTB is the owner 
     * and the model class is owned.
     *
     * @param string $ownerTB name of database table
     * @param string|int|null $ForeignId a model foreignId if not default 
     * @param string|int|null $ForeignKey a new model foreignkey if not default 
     * @return DBMediators
     */
    static function of(string $ownerTB, ?string $ForeignId = null, ?string $ForeignKey = null) : DBCollectors|DBMediators;

}