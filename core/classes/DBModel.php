<?php

namespace spoova\core\classes;

use spoova\core\classes\DBCollection;

/**
 * This class contains modifier relationships that can be applied on models 
 * when reading from database
 */
class DBModel extends DBCollection {

    
    // /**
    //  * Prevent models from having constructs
    //  */
    // final public function __construct(){}

    // final static function pull(): Model{

    //     return new static();

    // }

    
    /** 
     * One-One Database Relationship
     *
     * @return string 
     */
    final static protected function ownsOne(string $className,  string $foreignKey = '', string $ownerKey = ''): DBCollectibles{

        $model = new static();

        //parent table
        $modelName = $model::tableName();

        //child table
        $className = $className::tableName();

        $ownerKey = $ownerKey ?: 'id'; 
        $foreignKey = $foreignKey ?: $modelName.'_id'; 

        //Select the parent table (Model) first, where $className is child table
        $query = "{$modelName} JOIN {$className} ON {$modelName}.{$ownerKey} = {$className}.{$foreignKey}";

        $collectibles = DBCollectibles::collect($model, $modelName, 'ownsOne', $query, $foreignKey, $ownerKey);

        return $collectibles;
    }
    
    /**
     * One-Many Database Relationship
     * 
     * @return DBCollectibles 
     */
    final static protected function ownsMany(string $className, string $foreignKey = '', string $ownerKey = ''): DBCollectibles {

        $model = new static();

        //parent table
        $modelName = $model::tableName();

        //child table
        $className = $className::tableName();

        $ownerKey = $ownerKey ?: 'id'; 
        $foreignKey = $foreignKey ?: $modelName.'_id'; 

        // Select the child table ($className) first, where (Model) is the parent table
        $query = "{$className} JOIN {$modelName} ON {$modelName}.{$ownerKey} = {$className}.{$foreignKey}";

        $collectibles = DBCollectibles::collect($model, $className, 'ownsMany', $query,  $foreignKey, $ownerKey);

        return $collectibles;
    }
        
    /**
     * One-One / One-Many Inverse Database Relationship
     *
     * @return DBCollectibles 
     */
    final static protected function ownedBy(string $className, string $foreignKey = '', string $ownerKey = ''): DBCollectibles {

        $model = new static();

        //parent table
        $className = $className::tableName();

        //child table
        $modelName = $model::tableName();

        $ownerKey = $ownerKey ?: 'id'; 
        $foreignKey = $foreignKey ?: $className.'_id'; 

        //select the child table (Model) first, where $className is parent table
        $query = "{$modelName} JOIN {$className} ON {$className}.{$ownerKey} = {$modelName}.{$foreignKey}";

        $collectibles = DBCollectibles::collect($model, $className, 'ownedBy', $query,  $foreignKey, $ownerKey);

        return $collectibles;
    }

}