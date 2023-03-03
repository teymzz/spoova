<?php

namespace teymzz\spoova\core\classes\DB\DBSchema;

final class DRAFT {

    use TBGROUP, TBCREATE, TBALTER, TBPARTITION;

    function __construct($DRAFT_TYPE)
    {
        self::$TYPE[0] = $DRAFT_TYPE;

        static::$CREATE = [];
        static::$ALTER = [];
        static::$LASTCALLED = '';

        self::$instance = $this;

    }


    /**
     * Sets the current field name and field type
     *
     * @param string|array $name name of the field
     * @param string $type type of the field
     * @return void
     */
    private static function field($name, $type){
        self::$field = $name;
        self::$fieldType = $type;
        $type = self::$TYPE[1]?? '';

        if(!$type){
            self::$TYPE[1] = 'FIELDS';
        }
    }

    public static function hasError() : bool {
        return self::$error? true : false;
    }


    public static function err() : string {
        return self::$error;
    }



    // $this->ID('size', 'custom_name').  //id int auto_increment not null [signed|unsigned]              

    // $this->JSON('name', 'size', 'DEFAULT|NULL|NOT NULL').

    // $this->VARCHAR('name', 'size', 'DEFAULT|NULL|NOT NULL').
    // $this->CHAR('name', 'size', 'DEFAULT|NULL|NOT NULL').
    // $this->TEXT('name', 'size', 'DEFAULT|NULL|NOT NULL').
    // $this->TEXTFIELD('TEXT|TINY|MEDIUM|LONG', 'name', 'size', 'DEFAULT|NULL|NOT NULL').
    
    // $this->ENUM('name', ['OPTIONS'], 'DEFAULT|NULL|NOT NULL').
    // $this->SET('name', ['OPTIONS'], 'DEFAULT|NULL|NOT NULL').
    
    // $this->BOOL('name', 'DEFAULT|NULL|NOT NULL').                
    // $this->BIT('name', 'DEFAULT|NULL|NOT NULL').
    // $this->BINARY('name', 'DEFAULT|NULL|NOT NULL').
    
    // $this->INT('name', 'size', 'DEFAULT|NULL|NOT NULL').
    // $this->INTFIELD('INT|TINY|SMALL|BIG', 'name', 'size', 'DEFAULT|NULL|NOT NULL').
    
    // $this->SERIAL('name', 'size').
    
    // $this->FLOAT('name', ['size', 'd'], 'default').
    // $this->DOUBLE('name', ['size', 'd'], 'default').
    // $this->DECIMAL('name', ['size', 'd'], 'default').
    // $this->REAL('name', ['size', 'd'], 'default').
    
    // $this->DATE('name', 'size', 'default').
    // $this->DATETIME('name', 'size', 'default').
    // $this->TIMESTAMP('name', 'size', 'default').
    // $this->TIME('name', 'size', 'default').
    // $this->YEAR('name', 'size', 'default').

    // $this->BLOB('name', 'size', 'default').
    // $this->FIELD('BLOB|TINY|MEDIUM|LONG','name', 'size', 'default').

    // ->DEFAULT();
    // ->SIGNED();
    // ->UNSIGNED();


}