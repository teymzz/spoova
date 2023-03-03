<?php

namespace teymzz\spoova\core\classes\DB;

use User;
use DBStatus;
use teymzz\spoova\core\classes\Collectibles;
use teymzz\spoova\core\classes\DB\DBCollectibles;
use teymzz\spoova\core\classes\Model;

abstract class DBCollection implements DBOperators {

    /**
     * Instance of DBCollection
     *
     * @var DBCollection
     */
    public static ?DBCollection $tthis = null;

    public static DBHandler $dbh;

    public Model $model;

    public $sql = [
        'SELECT'   => 'SELECT %s FROM',
        'WHERE' => '',
        'ON' => '',
        'PARAMS' => []
    ];

    function __construct(){

        $this->sql = [
            'SELECT'   => 'SELECT %s FROM',
            'WHERE' => '',
            'ON' => '',
            'QUERY' => '',
            'PARAMS' => []
        ];

        if($dbh   = User::auth()->dbh()){
            static::$dbh = $dbh;
            static::$tthis = $this;
            $this->model = $this;            
        }else{
            DBStatus::err('Database connection error!');
        }
    }

    /**
     * Select where
     *
     * @return DBCollection|DBCollectibles
     */
    static function where(string $where, array $params = []) : DBCollectibles {

        return self::dbcollectibles()->where($where, $params);

    }

    /**
     * Read from database
     *
     * @return DBCollectibles
     */
    static function read(array $fields = [], array $limit = []) : DBCollectibles|Collectibles {
        
        return self::dbcollectibles()->read($fields, $limit);

        //$model = new static();

        //$collectibles = new DBCollectibles($model);

        //$collectibles->autoCall = $model;
        //return $collectibles;

    }

    /**
     * delete from database
     *
     * @return bool
     */
    static function delete(bool|int $limit = null) : bool {
        
        return self::dbcollectibles()->delete($limit);
        return self::$tthis;

    }

    /**
     * Update database
     *
     * @param array $fields array containing field and new value
     * @return bool
     */
    static function update(array $fields) : bool {

        return self::dbcollectibles()->update($fields);

    }

    /**
     * Select data based on current session user id
     *
     * @return DBCollectibles
     */
    static function ofUser(int $userid = null, string $ForeignKey = null) : DBCollectibles {
        
        return self::dbcollectibles()->ofUser($userid, $ForeignKey);

    } 

    /**
     * This relationship selects data owned by an another table where $ownerTB is the owner 
     * and the model class is owned. This is like an inverse of one to many relationshio
     *
     * @param string $ownerTB name of parent database table
     * @param string|int|null $ForeignId a model foreignId if not default 
     * @param string|int|null $ForeignKey a new model foreignkey if not default 
     * @return DBCollectibles
     */
    static function of(string $ownerTB, string $ForeignId = null, string $ForeignKey = null) : DBCollectibles {
        
        return self::dbcollectibles()->of(...func_get_args());

    } 

    /**
     * Returns the table name currently set for data insertion
     *
     * @return string 
     */
    public static function tableName(): string {

        return basename(to_frontslash(get_called_class()));

    }

    /**
     * Returns the model tableName in lower case 
     *
     * @return string 
     */
    final public static function table() {
        return strtolower(static::tableName());
    }


    /**
     * Returns a new collectibles instance.
     *
     * @return DBCollectibles
     */
    private static function dbcollectibles() {

        $model = new static();

        $collectibles = new DBCollectibles($model);

        return $collectibles;

    }

}