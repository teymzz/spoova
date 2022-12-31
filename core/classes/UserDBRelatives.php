<?php

namespace spoova\core\classes;

use User;

abstract class UserDBRelatives implements DBStaticInterface{

    protected static $table;
    protected static $userClass;
    protected $token = '';

    final public function __construct(){

        $token = $this->token = randice(4);
        
        $userTB = User::tableName();     
        $selfTB = self::tableName();     

        SET('DBTABLE', self::tableName());
        
        //$self = new static; 
        $hashString  = randice(10);
        SET((string) $token, $hashString, SETTER::LOCK);

        // $dbWhere = ( new UserDBWhere($this, $token, '', []) );

        // return $dbWhere;
    }
    
    public static function where($sqlWhere, array $params = []) {
        
        $tthis = new static; 
        $dbWhere = ( new UserDBWhere($tthis, $tthis->classID(), $sqlWhere, []) );
        return $dbWhere;

    }
    
    /**
     * read from relative database table
     *
     * @param array $fields
     * @param array $limits
     * @return array|bool 
     *  - bool:false is returned if error occurs
     */
    public static function read(array $fields, $limits = []) : array {

        $userTB = User::tableName();
        $selfTB = self::tableName();
        SETTER::SET('JOIN', "JOIN {$userTB} ON $userTB.id = $selfTB.userid");
        $fields = DBConstruct::Fields($fields);

        $defaultSql1 = "SELECT $fields FROM ";
        $defaultSql2 = "SELECT $fields FROM {$userTB} JOIN {$userTB} ON $userTB.id = $selfTB.userid";
        return [];
    }
    
    /**
     * Insert into Posts::insert()
     *
     * @param [type] $data
     * @return boolean
     */
    public static function insert($data) : bool {
        
        $selfTB = self::tableName();

        $defaultSql = "INSERT INTO {$selfTB}";

        if($dbh = User::Auth()->dbh()){

            $dbh->query($defaultSql, $data);
            return $dbh->insert()? true : false;

        }

        return false;

    }
    
    public static function delete(int $limit = null) {
        
        $selfTB = self::tableName();

        $defaultSql = "DELETE FROM {$selfTB}";
        $limit = is_integer($limit)? "LIMIT {$limit}" : $limit; 

        if($dbh = User::Auth()->dbh()){

            return $dbh->query($defaultSql)->delete($limit);
        }

        return false;

    }

    public static function tableName() : string {
        $class = get_called_class();
        $className = basename(to_frontslash($class));
        return $className;
    }

    public function classID()
    {
        //print_r(randice(2).br());
        return $this->token;
    }

}