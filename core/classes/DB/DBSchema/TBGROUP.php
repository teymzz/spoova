<?php 

namespace spoova\mi\core\classes\DB\DBSchema;

use spoova\mi\core\commands\Cli;

trait TBGROUP {


    public static string $LASTCALLED = '';
    
    protected static $error;

    /**
     * Type of DRAFT to be applied (e.g [ [CREATE] | [ALTER] | [ALTER, MODIFY] ]
     *
     * @var string 
     */
    protected static array $TYPE = [];

    /**
     * Currently selected field (or column)
     * 
     * @var string $field 
     */
    public static string $field = '';

    /**
     * Declares the type of field to be generated when create function is applied
     *
     * @var string
     */
    public static string $fieldType = '';

    // public static $formats = [];

    protected $uniqueFields = [];

    protected $constraints = [];

    protected static DRAFT $instance;

    
    /**
     * Get the current field being drafted
     *
     * @return array array of the current field and fieldType
     */
    protected function currentField(){

        return [self::$instance::$field, self::$instance::$fieldType];

    }

    protected static function options($option = '') : array {

        $options = [
            
            'BLOB' => ['BLOB'=>'BLOB','TINY'=>'TINYBLOB','TINYBLOB'=>'TINYBLOB','MEDIUM'=>'MEDIUMBLOB','MEDIUMBLOB'=>'MEDIUMBLOB','LONG'=>'LONGBLOB','LONGBLOB'=>'LONGBLOB'],
            'TEXT' => ['TEXT'=>'TEXT','TINY'=>'TINYTEXT', 'TINYTEXT'=>'TINYTEXT','MEDIUM'=>'MEDIUMTEXT', 'MEDIUMTEXT'=>'MEDIUMTEXT','LONG'=>'LONGTEXT','LONGTEXT'=>'LONGTEXT'],
            'INT'  => ['INT'=>'INT','TINY'=>'TINYINT','TINYINT'=>'TINYINT','SMALL'=>'SMALLINT','SMALLINT'=>'SMALLINT','BIG'=>'BIGINT','BIGINT'=>'BIGINT'],
            'CONSTRAINT'  => ['INDEX'=>'INDEX','UNIQUE'=>'UNIQUE','PRIMARY KEY'=>'PRIMARY KEY','FOREIGN KEY'=>'FOREIGN KEY'],
            'PARTITION_BY'=> ['RANGE', 'LIST']

        ];

        if($option) return $options[$option] ?? [];

        return $options;

    }

    protected static function callables(string $function){
        $callables = [
            "CREATE" => [
                "ID","BIT","BINARY", "BOOL", "JSON", 
                "VARCHAR", "CHAR", 
                "TEXT", "TEXTFIELD","TINYTEXT","MEDIUMTEXT","LONGTEXT", 
                "INT", "INTFIELD","TINYINT","SMALLINT","BIGINT",  
                "SERIAL", "FLOAT", "DOUBLE", "DECIMAL", 
                "REAL", "DATE", "DATETIME", "TIMESTAMP", "TIME", 
                "YEAR", "BLOB", "BLOBFIELD", "TINYBLOB","MEDIUMBLOB","LONGBLOB",
                "NULL", "NOT_NULL", "DEFAULT", "ON_UPDATE", "UNIQUE", "PRIMARY_KEY", "FOREIGN_KEY", 
                "AUTO_INCREMENT","CHECK", "INDEX","CONSTRAINT", "CREATE_INDEX",
                "CASCADE", "RESTRICT", "COMMENT",
                "PARTITION_BY","COLUMNS","PARTITION","VALUE",
            ],
            'ALTER' => [

                //Add fields
                "BIT","BINARY", "BOOL", "JSON", 
                "VARCHAR", "CHAR", 
                "TEXT", "TEXTFIELD","TINYTEXT","MEDIUMTEXT","LONGTEXT",  
                "INT", "INTFIELD","TINYINT","SMALLINT","BIGINT",   
                "SERIAL", "FLOAT", "DOUBLE", "DECIMAL", 
                "REAL", "DATE", "DATETIME", "TIMESTAMP", "TIME", 
                "YEAR", "BLOB", "BLOBFIELD", "TINYBLOB","MEDIUMBLOB","LONGBLOB", 
                "NULL", "NOT_NULL", "DEFAULT", "ON_UPDATE", "UNIQUE", "PRIMARY_KEY", "FOREIGN_KEY", 
                "AUTO_INCREMENT","CHECK", "INDEX","CONSTRAINT", "COMMENT",
                "FIRST", "AFTER",

                //Drop directives
                "DROP", "DROP_TABLE",

                //Modifiers
                "MODIFY", "CHANGE", "RENAME_TO", "CONVERT_TO",

                //Partition
                "PARTITION_BY","COLUMNS","PARTITION","VALUE",
            ]
        ];

        self::$LASTCALLED = $function;
        $TYPE = self::$TYPE[0] ?? '';
        $accepted = $callables[$TYPE];

        $modifiers = ['MODIFY', 'CHANGE'];

        if(in_array($function, $modifiers)) {
            self::$TYPE[1] = $function;
        }

        // if(isset(self::$TYPE[1])){
        //     if(!in_array(self::$TYPE[1], $modifiers)){
        //         self::$TYPE[1] = 'FIELDS';
        //     }
        // }

        if(!in_array($function, $accepted)){
            return self::callError(Cli::error("invalid method [".Cli::warn($function)."] called within DBSCHEMA::{$TYPE}() on DRAFT"), 0, "|2");
        }
    }

    /**
     * Build the TABLE DRAFT depending on the type of function called
     *
     * @return string
     */
    public static function BUILD() : string {
        $TYPE = "BUILD_".(self::$TYPE[0]??'');
        return self::$TYPE(...func_get_args());
    }

    /**
     * Sets an error and returns false
     *
     * @param string $error
     * @return false
     */
    public static function callError(string $error) : bool{
        self::$error = $error;
        return false;
    }

}