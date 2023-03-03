<?php

namespace teymzz\spoova\core\classes\DB;

use teymzz\spoova\core\classes\DB\DBCollection;

/**
 * This class contains modifier relationships that can be applied on models 
 * when reading from database
 */
class DBModel extends DBCollection {

    
    /** 
     * One-One: Simple Database Relationship
     * 
     * @param string $class class owned (full namespace)
     * @param string $foreignKey foreign key of the child (or owned) model database table 
     * @param string $localKey foreign key of the parent model database table. Default is "id".
     *
     * @return DBCollectibles 
     */
    final static protected function matchOne(string $class,  string $foreignKey = '', string $localKey = ''): DBCollectibles{

        $model = new static();

        //parent model database table name
        $modelName = $model::table();

        //child model database table name
        $className = $class::table();

        $localKey = $localKey ?: 'id'; 
        $foreignKey = $foreignKey ?: $modelName.'_id'; 

        //Select the child table ($className) first, where $modelName is parent table
        $query = ["{$className}", "JOIN {$modelName} ON {$modelName}.{$localKey} = {$className}.{$foreignKey}"];

        $collectibles = DBCollectibles::collect($model, $modelName, ['ownsOne', $className], $query, $foreignKey, $localKey);

        return $collectibles;
    }
    
    /** 
     * One-One: matches the current model with another model using a third model 
     * 
     * @param string $superClass the parent class (or table)
     * @param string $subClass the child class (or table) sdfsd sfsafa sadassdf sadas
     * @param array $superKeys 
     *      - The array format is [superClassForeignKey, superClassLocalKey] 
     *      - The first and second array value must be the foreign key and local key of $superClass (i.e parent table)
     *      - This foreign key is used by $subClass while its local key belongs to $superClass
     * 
     * @param string $subKeys 
     *      - The array format is [subClassForeignKey, subClassLocalKey]
     *      - The first and second array value must be the foreign key and local key of $subClass (i.e child table). 
     *      - This foreign key is used by current model while its local key belongs to $subClass.
     * @return DBCollectibles 
     */
    final static protected function matchOneFor(string $superClass, string $subClass,  array $superKeys = [], array $subKeys = []): DBCollectibles{

        $model = new static();

        $modelTable = $model::table();

        //parent model database table name
        $superTable = $superClass::table();

        //child model database table name
        $subTable = $subClass::table();

        $superDefaultKeys = [toSingular($superTable).'_id', 'id'];
        $subDefaultKeys   = [toSingular($subTable).'_id', 'id'];

        $superCustomKeys  = array_merge($superDefaultKeys, $superKeys);
        $subCustomKeys    = array_merge($subDefaultKeys, $subKeys);
        
        $superLocalKey = $superCustomKeys[1];
        $superForeignKey = $superCustomKeys[0];
        
        $subLocalKey = $subCustomKeys[1];
        $subForeignKey = $subCustomKeys[0];

        $JOIN  = " JOIN {$subTable} ON {$modelTable}.{$subForeignKey} = {$subTable}.{$subLocalKey} ";
        $JOIN .= " JOIN {$superTable} ON {$subTable}.{$superForeignKey} = {$superTable}.{$superLocalKey} ";

        $query = ["{$modelTable}", $JOIN];

        $collectibles = DBCollectibles::collect($model, $modelTable, ['ownsOne', $superTable] , $query, $subCustomKeys, $superCustomKeys);

        return $collectibles;
    }

    /**
     * One-Many Database Relationship
     *
     * @param string $className child class (or table) to be matched
     * @param string $foreignKey foreign key name of current model on child's table
     * @param string $localKey local key of the current model in the current model's (i.e parent) table
     * @return DBCollectibles
     */
    final static protected function matchMany(string $className, string $foreignKey = '', string $localKey = ''): DBCollectibles {

        $model = new static();

        //parent database table name
        $modelName = $model::table();

        //child database table name
        $className = $className::table();

        $localKey = $localKey ?: 'id'; 
        $foreignKey = $foreignKey ?: toSingular($modelName).'_id'; 

        // Select the child table ($className) first, where (Model) is the parent table
        $query = " JOIN {$className} ON {$modelName}.{$localKey} = {$className}.{$foreignKey}";

        $dbcollectibles = DBCollectibles::collect($model, $className, ['matchMany', $className], [$modelName, $query],  $foreignKey, $localKey);

        return $dbcollectibles;
    }
    
    /** 
     * One-Many: matches the current model with another model using a third model 
     * 
     * @param string $superClass the parent class (or table)
     * @param string $subClass the child class (or table) 
     * @param array $superKeys 
     *      - The array format is [superClassForeignKey, superClassLocalKey] 
     *      - The first and second array value must be the foreign key and local key of $superClass (i.e parent table)
     *      - This foreign key is used by $subClass while its local key belongs to $superClass
     * 
     * @param string $subKeys 
     *      - The array format is [subClassForeignKey, subClassLocalKey]
     *      - The first and second array value must be the foreign key and local key of $subClass (i.e child table). 
     *      - This foreign key is used by current model while its local key belongs to $subClass.
     * @return DBCollectibles 
     */
    final static protected function matchManyFor(string $superClass, string $subClass,  array $superKeys = [], array $subKeys = []): DBCollectibles{

        $model = new static();

        $modelTable = $model::table();

        //parent model database table name
        $superTable = $superClass::table();

        //child model database table name
        $subTable = $subClass::table();

        $superDefaultKeys = [toSingular($superTable).'_id', 'id'];
        $subDefaultKeys   = [toSingular($subTable).'_id', 'id'];

        $superCustomKeys  = array_merge($superDefaultKeys, $superKeys);
        $subCustomKeys    = array_merge($subDefaultKeys, $subKeys);
        
        $superLocalKey = $superCustomKeys[1];
        $superForeignKey = $superCustomKeys[0];
        
        $subLocalKey = $subCustomKeys[1];
        $subForeignKey = $subCustomKeys[0];

        $JOIN  = " JOIN {$subTable} ON {$modelTable}.{$subForeignKey} = {$subTable}.{$subLocalKey} ";
        $JOIN .= " JOIN {$superTable} ON {$subTable}.{$superForeignKey} = {$superTable}.{$superLocalKey} ";

        //Select the parent table (Model) first, where $className is child table
        $query = ["{$modelTable}", $JOIN];

        $dbcollectibles = DBCollectibles::collect($model, $modelTable, ['matchManyFor', $superTable], $query, $subCustomKeys, $superCustomKeys);

        return $dbcollectibles;
    }
        
    /**
     * One-One / One-Many Inverse Database Relationship.
     * In this relationship the supplied class is the parent table while current model is the child table. 
     * 
     * @param string $className parent model 
     * @param string $foreignKey Foreign key of $className on current model
     * @param string $localkey Local key of the $className (parent model)
     *
     * @return DBCollectibles 
     */
    final static protected function matchedFor(string $className, string $foreignKey = '', string $localKey = ''): DBCollectibles {

        $model = new static();

        //parent table
        $className = $className::table();

        //child table
        $modelName = $model::table();

        $localKey = $localKey ?: 'id'; 
        $foreignKey = $foreignKey ?: $className.'_id'; 

        //select the child table (Model) first, where $className is parent table
        $query = "{$modelName} JOIN {$className} ON {$className}.{$localKey} = {$modelName}.{$foreignKey}";

        $dbcollectibles = DBCollectibles::collect($model, $className, ['ownedBy', $className], $query,  $foreignKey, $localKey);

        return $dbcollectibles;
    }

            
    /**
     * 
     *
     *
     * @return DBCollectibles 
     */
    /**
     * Many-Many Database Relationship
     * 
     * @param string $class related class
     * @param string $mapTable binder table name. Default table name is generated using alphabetic order
     * @param string $modelForeignKey foreign key of current model
     * @param string $classForeignKey forign key of mapped model
     * @return DBCollectibles
     */
    final static protected function maps(string $class, string $mapTable = '', string $modelForeignKey = '', string $classForeignKey = ''){

        $model = new static();

        //parent table
        $modelTable = $model::table();
        
        //child table
        $mappedTable = $class::table();

        $mapTableList = toSingular([$mappedTable, $modelTable]);
        sort($mapTableList);

        $mapTable  = $mapTable ?: implode('_', $mapTableList);

        $defaultForeignKeys = [toSingular($modelTable)."_id", toSingular($mappedTable)."_id"];

        $customForeignKeys  = [$modelForeignKey, $classForeignKey];

        $customForeignKeys = array_unset($customForeignKeys, '');

        $ForeignKeys = array_replace($defaultForeignKeys, $customForeignKeys);

        $modelForeignKey = $ForeignKeys[0];
        $mappedForeignKey = $ForeignKeys[1];


        $JOIN  = " JOIN {$mapTable} ON {$mapTable}.{$modelForeignKey} = {$modelTable}.id "; 
        $JOIN .= " JOIN {$mappedTable} ON {$mapTable}.{$mappedForeignKey} = {$mappedTable}.id "; 

        //select the child table (Model) first, where $className is parent table
        $query = ["{$modelTable}", "{$JOIN}"];

        $dbcollectibles = DBCollectibles::collect($model, $modelTable, ['mapsMany', $mappedTable], $query,  $mappedForeignKey, $modelForeignKey);

        return $dbcollectibles;

    }

}