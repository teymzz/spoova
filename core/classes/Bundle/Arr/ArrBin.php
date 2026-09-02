<?php

namespace spoova\mi\core\classes\Bundle\Arr; 
/**
 * This interface was generated for IDE support
 */
interface ArrBin {

    /**
     * Checks for presence of direct child values which are of array data type in an array
     *
     * @return boolean|int
     *  - int: integers matches specified integer with total counted values 
     *  - TRUE: returns total counted values 
     *  - FALSE: returns TRUE or FALSE by testing if array contains data type
     */
    function hasArray(bool|int $unit = FALSE): int|bool;
    
    /**
     * Checks for presence of direct child values which are of integer data type in an array
     *
     * @return boolean|int
     *  - int: integers matches specified integer with total counted values 
     *  - TRUE: returns total counted values 
     *  - FALSE: returns TRUE or FALSE by testing if array contains data type
     */
    function hasInteger(bool|int $unit = FALSE): int|bool;

    /**
     * Checks for presence of direct child values which are of string data type in an array
     *
     * @return boolean|int
     *  - int: integers matches specified integer with total counted values 
     *  - TRUE: returns total counted values 
     *  - FALSE: returns TRUE or FALSE by testing if array contains data type
     */
    function hasString(bool|int $unit = FALSE): int|bool;

    /**
     * Check for presence direct child values which are of object data type in an array
     *
     * @return boolean|int
     *  - int: integers matches specified integer with total counted values 
     *  - TRUE: returns total counted values 
     *  - FALSE: returns TRUE or FALSE by testing if array contains data type
     */
    function hasObject(bool|int $unit = FALSE): int|bool;

    /**
     * Check for presence of direct child values which are of float data type in an array
     *
     * @return boolean|int
     *  - int: integers matches specified integer with total counted values 
     *  - TRUE: returns total counted values 
     *  - FALSE: returns TRUE or FALSE by testing if array contains data type
     */    
    function hasFloat(bool|int $unit = FALSE): int|bool;

    /**
     * Check for presence of direct child values which are of boolean data type in an array
     *
     * @param boolean $unit
     *  - int: integers matches specified integer with total counted values 
     *  - TRUE: returns total counted values 
     *  - FALSE: returns TRUE or FALSE by testing if array contains data type
     * @return boolean|int
     */
    function hasBool(bool|int $unit = FALSE): int|bool;

    /**
     * Check for presence of direct child values which are of numerical data type format in an array
     *
     * @param boolean $unit
     *  - int: integers matches specified integer with total counted values 
     *  - TRUE: returns total counted values 
     *  - FALSE: returns TRUE or FALSE by testing if array contains data type
     * @return boolean|int
     */    
    function hasNumeric(bool|int $unit = FALSE): int|bool;

    /**
     * Check for presence of direct child values of an array which can be found in a list of specified values in another array
     *
     * @param array $values refers to the array values desired to be checked.
     *  1. Note that if $values contains object as one of its test values, then $strict must be set as TRUE. 
     *  2. Avoid testing non-empty values with a default array that has a TRUE boolean value in its list of values as this will always return TRUE.
     * @param int $strict sets strict comparison mode for values testing 
     *  - 0: lowest level of strictness all data types (strict bool, strict bool&object, strict all)
     *  - 1: strictness objects comparison
     *  - 2: strictness level for both booleans and objects
     *  - 3: highest level of strictness for all data types
     * @return boolean|int
     */      
    function hasValues(array|string $values, int $strict = 1): int|bool;

    /**
     * Checks if all specified keys exists as keys of test array
     *
     * @param array|string $keys refers to the list of array keys to be 
     * checked which must all exist in an array bin's list before a TRUE value can be returned
     * 
     * @return boolean
     */   
    function hasKeys(array|string $keys): bool;

}