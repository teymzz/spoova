<?php

namespace spoova\core\classes;

interface DBOperators {

    /**
     * Select where
     *
     * @return DBCollection|DBCollectibles
     */
    static function where(string $where, array $params = []) : DBCollection|DBCollectibles;

    /**
     * Read from database
     *
     * @return DBCollection|DBCollectibles
     */
    static function read(array $fields = [], array $limit = []) : DBCollection|DBCollectibles|Collectibles;

    /**
     * delete from database
     *
     * @return DBCollection|DBCollectibles
     */
    static function delete(int $limit = null) : DBCollection|DBCollectibles;

    /**
     * Update dabase
     *
     * @return DBCollection|DBCollectibles
     */
    static function update() : DBCollection|DBCollectibles;

    /**
     * Join database
     *
     * @return DBCollection|DBCollectibles
     */
    static function on() : DBCollection|DBCollectibles;

    /**
     * Undocumented function
     *
     * @return DBCollection|DBCollectibles
     */
    static function ofUser(int $userid, string $ForeignKey = null): DBCollection|DBCollectibles;

    /**
     * This relationship selects data owned by an another table where $ownerTB is the owner 
     * and the model class is owned.
     *
     * @param string $ownerTB name of database table
     * @param string|int|null $ForeignId a model foreignId if not default 
     * @param string|int|null $ForeignKey a new model foreignkey if not default 
     * @return DBCollectibles
     */
    static function of(string $ownerTB, string $ForeignId = null, string $ForeignKey = null) : DBCollection|DBCollectibles;

}