<?php

namespace spoova\mi\core\classes\DB;

use User;
use DBStatus;
use spoova\mi\core\classes\DB\DBViewer;
use spoova\mi\core\classes\DB\DBMediators;
use spoova\mi\core\classes\Model;

/**
 * DBCollectors are essential parts of model that contains operators available for 
 * Models to perform database CRUD operations.
 * @uses DBMediators
 */
abstract class DBCollectors implements DBOperators {

    /**
     * Instance of DBCollectors
     *
     * @var DBCollectors
     */
    public static ?DBCollectors $tthis = null;

    public static DBHandler $dbh;

    public Model $model;

    protected $sql = [
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

    private static function initialize(?DBOperators $operator = null) {

    }

    /**
     * Select where
     *
     * @return DBMediators
     */
    static function where(string $where, array $params = []) : DBMediators {

        return self::DBMediators()->where($where, $params);

    }

    /**
     * Select by recent
     *
     * @return DBMediators
     */
    static function byRecent(array|string $field = 'id') : DBMediators {

        return self::DBMediators()->byRecent(...func_get_args());

    }

    /**
     * Read from database
     *
     * @return DBViewer
     */
    static function read(array $fields = [], array $limit = []) : DBViewer {
        
        return self::DBMediators()->read($fields, $limit);

    }

    /**
     * delete from database
     *
     * @return DBDeleter
     */
    static function delete(bool|int|null $limit = null) : DBDeleter {
        
        return self::DBMediators()->delete($limit);
        return self::$tthis;

    }

    /**
     * Update database
     *
     * @param array $fields array containing field and new value
     * @return DBUpdater
     */
    static function update(array $fields) : DBUpdater {

        return self::DBMediators()->update($fields);

    }

    /**
     * Select data based on current session user id
     *
     * @return DBMediators
     */
    static function ofUser(?int $userid = null, ?string $ForeignKey = null) : DBMediators {
        
        return self::DBMediators()->ofUser($userid, $ForeignKey);

    } 

    /**
     * This relationship selects data owned by an another table where $ownerTB is the owner 
     * and the model class is owned. This is like an inverse of one to many relationshio
     *
     * @param string $ownerTB name of parent database table
     * @param string|int|null $ForeignId a model foreignId if not default 
     * @param string|int|null $ForeignKey a new model foreignkey if not default 
     * @return DBMediators
     */
    static function of(string $ownerTB, ?string $ForeignId = null, ?string $ForeignKey = null) : DBMediators {
        
        return self::DBMediators()->of(...func_get_args());

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
     * Returns the model tableName in lower case 
     *
     * @return array 
     */
    final public function sql() {
        return $this->sql;
    }


    /**
     * Returns a new DBViewer instance.
     *
     * @return DBMediators
     */
    private static function DBMediators() :DBMediators {

        $model = new static();

        $DBViewer = new DBMediators($model);

        return $DBViewer;

    }

}