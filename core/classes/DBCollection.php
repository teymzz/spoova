<?php

namespace spoova\core\classes;

use User;
use DBStatus;
use spoova\core\classes\EInfo;
use spoova\core\classes\Collection;
use spoova\core\classes\DBConstruct;
use spoova\core\classes\Collectibles;
use spoova\core\classes\DBCollectibles;

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

    // /**
    //  * Binds two field under a single parent table
    //  *
    //  * @param string $fieldname
    //  * @return DBCollectibles
    //  */
    // static function bind(string $fieldname) : DBCollectibles {

    // }

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
    static function read(array $fields = [], array $limit = []) : DBCollectibles {
        



        $model = new static();

        $collectibles = new DBCollectibles($model);

        //parent table
        // $className = $className::tableName();

        //child table
        // $modelName = $model::tableName();

        // $ownerKey = $ownerKey ?: 'id'; 
        // $foreignKey = $foreignKey ?: $className.'_id'; 

        // //select the child table (Model) first, where $className is parent table
        // $query = "{$modelName} JOIN {$className} ON {$className}.{$ownerKey} = {$modelName}.{$foreignKey}";

        // $collectibles = DBCollectibles::collect($model, $className, 'ownedBy', $query,  $foreignKey, $ownerKey);
        $collectibles->autoCall = $model;
        return $collectibles;

        // $fields = DBConstruct::Fields($fields);
        // $tthis  = self::$tthis;

        // $select = $tthis->sql['SELECT'];
        
        // $select = sprintf($select, $fields);
        
        // $query  = $select.$tthis->sql['QUERY'];
        // $params = $tthis->sql['PARAMS'];

        // $db     = self::$dbh;

        // $db->query($query, $params)->read(...$limit);

        // //get Model
        // $modelTable = static::tableName();

        // if(DBStatus::err()){
        //     $tthis->databaseError = DBStatus::err();
        // }else{
        //     $tthis->{$modelTable} = new Collection($db->results());
        // }

        // return new Collectibles($db->results(), $tthis, $modelTable);
        // return $tthis;

    }

    /**
     * delete from database
     *
     * @return DBCollection|DBCollectibles
     */
    static function delete(int $limit = null) : DBCollection {

        return self::$tthis;

    }

    /**
     * Update dabase
     *
     * @return DBCollection|DBCollectibles
     */
    static function update() : DBCollection {

        return self::$tthis;

    }

    /**
     * Join database
     *
     * @return DBCollection|DBCollectibles
     */
    static function on() : DBCollection {

        return self::$tthis;

    }

    /**
     * Undocumented function
     *
     * @return DBCollectibles
     */
    static function ofUser(int $userid = null, string $ForeignKey = null) : DBCollectibles {
        
        return self::dbcollectibles()->ofUser($userid, $ForeignKey);

    } 

    /**
     * This relationship selects data owned by an another table where $ownerTB is the owner 
     * and the model class is owned.
     *
     * @param string $ownerTB name of database table
     * @param string|int|null $ForeignId a model foreignId if not default 
     * @param string|int|null $ForeignKey a new model foreignkey if not default 
     * @return DBCollectibles
     */
    static function of(string $ownerTB, string $ForeignId = null, string $ForeignKey = null) : DBCollectibles {
        
        return self::dbcollectibles()->of(...func_get_args());

    } 

    /**
     * The value supplied on this must be a valid model else, this may throw a fatal error
     *
     * @param string $model
     * @return void
     */
    static function from(string $modelClass) {

        return self::dbcollectibles()->from($modelClass);
    }

    /**
     * Returns the table name currently set for data insertion
     *
     * @return string 
     */
    public static function tableName(): string {

        return basename(to_frontslash(get_called_class()));

    }

    
    public static function pull() {

        $model = new static();

        return $model;

    }


    /**
     * Returns a new collectibles instance.
     *
     * @return DBCollectibles
     */
    private static function dbcollectibles() {

        $model = new static();

        //This method will be pulled in from model
        $tableName = static::tableName();

        $collectibles = new DBCollectibles($model);

        return $collectibles;

    }

}