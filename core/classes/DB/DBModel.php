<?php

namespace spoova\mi\core\classes\DB;

use spoova\mi\core\classes\DB\DBCollectors;

/**
 * This class contains modifier relationships that can be applied on models 
 * when reading from database
 */
class DBModel extends DBCollectors {

    
    /** 
     * One-One: Simple Database Relationship
     * 
     * @param string $class class owned (full namespace)
     * @param string $foreignKey foreign key of the child (or owned) model database table 
     * @param string $localKey foreign key of the parent model database table. Default is "id".
     *
     * @return DBMediators 
     */
    final static protected function matchOne(string $class,  string $foreignKey = '', string $localKey = ''): DBMediators{

        $model = new static();

        //parent model database table name
        $modelName = strtolower(pathbase($model::tablename()));

        //child model database table name
        $className = strtolower(pathbase($class::tablename()));

        $localKey = $localKey ?: 'id'; 
        $foreignKey = $foreignKey ?: toSingular($modelName).'_id'; 

        //Select the child table ($className) first, where $modelName is parent table
        $query = ["{$className}", "LEFT JOIN {$modelName} ON {$modelName}.{$localKey} = {$className}.{$foreignKey}"];

        $collectibles = DBMediators::collect($model, $modelName, ['ownsOne', $className], $query, $foreignKey, $localKey);

        return $collectibles;
    }
    
    /** 
     * One-One: matches the current model with another model using a third model 
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
     * @return DBMediators 
     */
    final static protected function matchOneFor(string $superClass, string $subClass,  array $superKeys = [], array $subKeys = []): DBMediators{

        $model = new static();

        $modelTable = strtolower(pathbase($model::tablename()));

        //parent model database table name
        $superTable = strtolower(pathbase($superClass::tablename()));

        //child model database table name
        $subTable = strtolower(pathbase($subClass::tablename()));

        $superDefaultKeys = [toSingular($superTable).'_id', 'id'];
        $subDefaultKeys   = [toSingular($subTable).'_id', 'id'];

        /* array_replace overlays by index, which is what an override needs. array_merge
           appends instead, so a caller's keys landed at index 2 and 3 while only 0 and 1
           are ever read - the supplied keys were silently discarded. Empty entries are
           dropped first so that supplying only the second key leaves the first defaulted,
           matching how maps() handles its own foreign keys. */
        $superCustomKeys  = array_replace($superDefaultKeys, array_unset($superKeys, ''));
        $subCustomKeys    = array_replace($subDefaultKeys, array_unset($subKeys, ''));
        
        $superLocalKey = $superCustomKeys[1];
        $superForeignKey = $superCustomKeys[0];
        
        $subLocalKey = $subCustomKeys[1];
        $subForeignKey = $subCustomKeys[0];

        /* A plain JOIN, unlike matchManyFor below. This relationship asks for the one
           record standing at the end of the chain, so a row whose chain does not resolve has
           no such record to report and is left out. "Many" may legitimately be none, which
           is why the many variant keeps its outer joins. Both steps must agree: a mixed pair
           would still emit a row carrying nulls, which is the very thing being excluded. */
        $JOIN  = " JOIN {$subTable} ON {$modelTable}.{$subForeignKey} = {$subTable}.{$subLocalKey} ";
        $JOIN .= " JOIN {$superTable} ON {$subTable}.{$superForeignKey} = {$superTable}.{$superLocalKey} ";

        $query = ["{$modelTable}", $JOIN];

        $collectibles = DBMediators::collect($model, $modelTable, ['ownsOne', $superTable] , $query, $subCustomKeys, $superCustomKeys);

        return $collectibles;
    }

    /**
     * One-Many Database Relationship
     *
     * @param string $className child class (or table) to be matched
     * @param string $foreignKey foreign key name of current model on child's table
     * @param string $localKey local key of the current model in the current model's (i.e parent) table
     * @return DBMediators
     */
    final static protected function matchMany(string $className, string $foreignKey = '', string $localKey = ''): DBMediators {

        $model = new static();

        //parent database table name
        $modelName = strtolower(pathbase($model::tablename()));

        //child database table name
        $className = strtolower(pathbase($className::tablename()));

        $localKey = $localKey ?: 'id'; 
        $foreignKey = $foreignKey ?: toSingular($modelName).'_id'; 

        // Select the child table ($className) first, where (Model) is the parent table
        $query = " LEFT JOIN {$className} ON {$modelName}.{$localKey} = {$className}.{$foreignKey}";

        $DBCollectors = DBMediators::collect($model, $className, ['matchMany', $className], [$modelName, $query],  $foreignKey, $localKey);

        return $DBCollectors;
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
     * @param array $subKeys 
     *      - The array format is [subClassForeignKey, subClassLocalKey]
     *      - The first and second array value must be the foreign key and local key of $subClass (i.e child table). 
     *      - This foreign key is used by current model while its local key belongs to $subClass.
     * @return DBMediators 
     */
    final static protected function matchManyFor(string $superClass, string $subClass,  array $superKeys = [], array $subKeys = []): DBMediators{

        $model = new static();

        $modelTable = strtolower(pathbase($model::tablename()));

        //parent model database table name
        $superTable = strtolower(pathbase($superClass::tablename()));

        //child model database table name
        $subTable = strtolower(pathbase($subClass::tablename()));

        $superDefaultKeys = [toSingular($superTable).'_id', 'id'];
        $subDefaultKeys   = [toSingular($subTable).'_id', 'id'];

        /* array_replace overlays by index, which is what an override needs. array_merge
           appends instead, so a caller's keys landed at index 2 and 3 while only 0 and 1
           are ever read - the supplied keys were silently discarded. Empty entries are
           dropped first so that supplying only the second key leaves the first defaulted,
           matching how maps() handles its own foreign keys. */
        $superCustomKeys  = array_replace($superDefaultKeys, array_unset($superKeys, ''));
        $subCustomKeys    = array_replace($subDefaultKeys, array_unset($subKeys, ''));
        
        $superLocalKey = $superCustomKeys[1];
        $superForeignKey = $superCustomKeys[0];
        
        $subLocalKey = $subCustomKeys[1];
        $subForeignKey = $subCustomKeys[0];

        $JOIN  = " LEFT JOIN {$subTable} ON {$modelTable}.{$subForeignKey} = {$subTable}.{$subLocalKey} ";
        $JOIN .= " LEFT JOIN {$superTable} ON {$subTable}.{$superForeignKey} = {$superTable}.{$superLocalKey} ";

        //Select the parent table (Model) first, where $className is child table
        $query = ["{$modelTable}", $JOIN];

        $DBCollectors = DBMediators::collect($model, $modelTable, ['matchManyFor', $superTable], $query, $subCustomKeys, $superCustomKeys);

        return $DBCollectors;
    }
        
    /**
     * One-One / One-Many Inverse Database Relationship.
     * In this relationship the supplied class is the parent table while current model is the child table. 
     * 
     * @param string $className parent model 
     * @param string $foreignKey Foreign key of $className on current model
     * @param string $localKey Local key of the $className (parent model)
     *
     * @return DBMediators 
     */
    final static protected function matchedFor(string $className, string $foreignKey = '', string $localKey = ''): DBMediators {

        $model = new static();

        //parent table
        $className = strtolower(pathbase($className::tablename()));

        //child table
        $modelName = strtolower(pathbase($model::tablename()));

        $localKey = $localKey ?: 'id'; 
        $foreignKey = $foreignKey ?: toSingular($className).'_id'; 

        //select the child table (Model) first, where $className is parent table
        /* handed over as [base table, join] rather than as one string. collect() only
           overwrites BASE_TABLE when it receives an array, so the string form left
           BASE_TABLE holding the parent table while the query itself already opened with
           the child table - producing "FROM post comments JOIN post ...", which names the
           same table twice and is rejected as a non-unique alias. */
        $query = ["{$modelName}", " LEFT JOIN {$className} ON {$className}.{$localKey} = {$modelName}.{$foreignKey}"];

        $DBCollectors = DBMediators::collect($model, $className, ['ownedBy', $className], $query,  $foreignKey, $localKey);

        return $DBCollectors;
    }

    /**
     * Many-Many Database Relationship
     * 
     * @param string $class related class
     * @param string $mapTable binder table name. Default table name is generated using alphabetic order
     * @param string $modelForeignKey foreign key of current model
     * @param string $classForeignKey foreign key of mapped model
     * @return DBMediators
     */
    final static protected function maps(string $class, string $mapTable = '', string $modelForeignKey = '', string $classForeignKey = ''){

        $model = new static();

        //parent table
        $modelTable = strtolower(pathbase($model::tablename()));
        
        //child table
        $mappedTable = strtolower(pathbase($class::tablename()));

        $mapTableList = toSingular([$mappedTable, $modelTable]);
        sort($mapTableList);

        $mapTable  = $mapTable ?: implode('_', $mapTableList);

        $defaultForeignKeys = [toSingular($modelTable)."_id", toSingular($mappedTable)."_id"];

        $customForeignKeys  = [$modelForeignKey, $classForeignKey];

        $customForeignKeys = array_unset($customForeignKeys, '');

        $ForeignKeys = array_replace($defaultForeignKeys, $customForeignKeys);

        $modelForeignKey = $ForeignKeys[0];
        $mappedForeignKey = $ForeignKeys[1];


        $JOIN  = " LEFT JOIN {$mapTable} ON {$mapTable}.{$modelForeignKey} = {$modelTable}.id "; 
        $JOIN .= " LEFT JOIN {$mappedTable} ON {$mapTable}.{$mappedForeignKey} = {$mappedTable}.id "; 

        //select the child table (Model) first, where $className is parent table
        $query = ["{$modelTable}", "{$JOIN}"];

        $DBCollectors = DBMediators::collect($model, $modelTable, ['mapsMany', $mappedTable], $query,  $mappedForeignKey, $modelForeignKey);

        return $DBCollectors;

    }

}