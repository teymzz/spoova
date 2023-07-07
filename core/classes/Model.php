<?php

namespace spoova\mi\core\classes;

use User;
use DBStatus;
use Form;
use spoova\mi\core\classes\DB\DBHandler;
use spoova\mi\core\classes\DB\DBModel;
use spoova\mi\core\tools\Input;

 abstract class Model extends DBModel{

    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_NOT = 'not';
    public const RULE_UNLIKE = 'unlike';
    public const RULE_NOT_CHARS = 'not_chars';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_ISOLATED = 'isolated';
    public const RULE_TEXT = 'text';
    public const RULE_PATTERN = 'pattern';
    public const RULE_PHONE = 'number'; //may not be entirely true for some data
    public const RULE_INTEGER = 'integer'; //Note:: Zero(0) though a valid integer will return 0 which may be considered as false unless strictly checked
    public const RULE_NUMBER = 'number'; //same as is_numeric
    public const RULE_URL = 'url';

    public const RULE_RANGE = 'range';
    public const RULE_UNIQUE = 'unique';
    public const RULE_NOSPACE = 'nospace';

    //reserved properties
    private static array $MODEL_Error = []; 
    private array $MODEL_ErrorLog = []; 
    private array $MODEL_LoadData = [];
    private array $MODEL_FormData = [];
    private Input $MODEL_Input;
    private string $id = '';
    private static string $insertID = '';
    private DBHandler $conn;


    /**
     * load data is used to load data into the model
     *
     * @param array $data data to be validated (request or form data)
     * @param array $mods as list of smart modifications that detects new additions or subtractions.
     *  - Values that do not exist in $data but are needed for uploading can be supplied into $mod.
     *  - Values that exists in $data but are not needed for uploading can be supplied into $mod
     *  - $mod will automactically remove or add data need. To reduce human errors define all inclusions or exclusions by
     *          - ['inc' => ['firstname','lastname'], 'exc'=> ['token'] ]
     * @return void
     */
    public function loadData(array $data, array $mods = []){

        $this->MODEL_Input = new Input;
        $reserved = ['MODEL_ErrorLog', 'MODEL_LoadData', 'MODEL_Input', 'MODEL_FormData']; //reserved properties
        $incs = array_key_exists('inc', $mods)? (array) $mods['inc'] : [];
        $excs = array_key_exists('exc', $mods)? (array) $mods['exc'] : [];

        $loadData = $data;

        if(($incs) || ($excs)){
            
            //remove existing data keys 
            if($excs){ 
                $data = array_diff_key($data, array_flip($excs));
            }

            //add new data keys
            foreach ($incs as $inc) {
                $this->$inc = $data[$inc]?? $this->$inc?? '';
                $data[$inc] = $data[$inc]?? $this->$inc?? '';
            }

        }

        //use smart modificator to filter out or filter in data.
        if(!$incs and !$excs){
            foreach ($mods as $mod) {
                
                if(array_key_exists($mod, $data)){

                    //unset old keys
                    unset($data[$mod]);

                }else{
                    //add new properties
                    if(!property_exists($this, $mod)) {
                        $this->$mod = '';
                        $data[$mod] = '';
                    }else{
                        $data[$mod] = $this->$mod;
                    }
                    
                }
            }            
        }
        
        //store only data to be uploaded
        $this->MODEL_FormData =  $data;

        //set attributes (properties) within the class only if it exists
        foreach($loadData as $requestKey => $requestValue){
            if(in_array($requestKey, $reserved)) {
                throw new \Error($requestKey.' is a reserved property');
            }else{
                if(property_exists($this, $requestKey)) {
                    $this->$requestKey = $requestValue;
                } 
            }
        }

    }

    /**
     * Returns an array list of validation rules
     *
     * @return array
     */
    abstract public function rules(): array;


    /**
     * Returns true if all required validation rules are successfully met
     *
     * @return bool
     */
    final public function validated() : bool{

        //using the input class ('tool') for validations
        $Input = $this->MODEL_Input;

        foreach($this->rules() as $attribute => $rules){

            $value = (string) $this->{$attribute} ;

            //rules (above) as set of rules supplied on a specific attribute

            foreach($rules as $key => $val){

                if( (is_int($key) ) ) {

                    $rule = $val;

                }else {
             
                    $rule = [$key => $val];

                }

                $ruleName = $rule; 

                if (is_array($ruleName)) { 
                    $ruleDesc =  array_keys($rule);
                    $ruleName = $ruleDesc[0]?? '';
                    $ruleValue = $rule[$ruleName];
                    $rule = [0 => $ruleName, 1 => $ruleValue];
                } 



                if($ruleName === self::RULE_REQUIRED and !$value){
                    $this->addError($attribute, $ruleName);
                }

                if($ruleName === self::RULE_NOSPACE and strpos(trim($value), ' ') !== false){
                    $this->addError($attribute, $ruleName);
                }

                if($ruleName === self::RULE_EMAIL and !$Input->set($value, ['type'=> 'email'])){
                    $this->addError($attribute, $ruleName);
                }

                if($ruleName === self::RULE_MIN and strlen($value) < $rule[1] ?? 0) {
                    $this->addError($attribute, $ruleName, $rule);
                }

                if($ruleName === self::RULE_MAX and strlen($value) > $rule[1] ?? 0) {
                    $this->addError($attribute, $ruleName, $rule);
                }                 
                
                /* match a pattern set using Input class */
                if($ruleName === self::RULE_PATTERN and !$Input->set($value, ['pregmatch'=>$rule[1]])) {
                    $this->addError($attribute, $ruleName, $rule);
                }  

                /* match an integer */
                if($ruleName === self::RULE_INTEGER and !$Input->set($value, ['type'=>'integer'])) {
                    $this->addError($attribute, $ruleName);
                }          

                /* match a numeric value */                
                if($ruleName === self::RULE_NUMBER and !$Input->set($value, ['type'=>'number'])) {
                    $this->addError($attribute, $ruleName, $rule);
                }         
                
                /* match a phone number */
                if($ruleName === self::RULE_PHONE and !$Input->set($value, ['type'=>'phone'])) {
                    $this->addError($attribute, $ruleName);
                }                      

                /* match only text strings */
                if($ruleName === self::RULE_TEXT and !$Input->set($value, ['type'=>'text'])) {
                    $this->addError($attribute, $ruleName);
                }               

                /* set valid url patterns */
                if($ruleName === self::RULE_URL and !$Input->set($value, ['type'=>'url'])) {
                    $this->addError($attribute, $ruleName);
                }

                /* set valid range of data that must be matched */
                if($ruleName === self::RULE_RANGE and !$Input->set($value, ['type'=>'string', 'range'=> $rules[1] ])){ 
                    $this->addError($attribute, $ruleName);
                }
                
                
                /* match the value of a property set (e.g $this->password) */
                if($ruleName === self::RULE_MATCH and $value !== $this->{$rule[1]}) {
                    $this->addError($attribute, $ruleName, $rule);
                }

                /* set not duplicated fields */
                if($ruleName === self::RULE_NOT && $rule[1]){
                    $fields = is_array($rule[1])? $rule[1] : (array) $rule[1]; 
                    
                    $entries = [];
                    foreach($fields as $field){
                        $entries[$field] = $this->{$field};
                    }

                    $field = array_search($value, $entries);

                    if($field) {
                        $this->addError([$attribute, $field], $ruleName);
                    }

                }  
                
                
                /* set invalid characters. */
                if($ruleName === self::RULE_NOT_CHARS && $rule[1]){ 
                    
                    $characters = is_array($rule[1])? $rule[1] : (array) $rule[1]; 

                    foreach($characters as $character) {

                        if(trim($character, ' ')){
                            if(strpos($value, $character) !== false) {
                                $this->addError([$attribute, $character], $ruleName);
                                break;
                            }
                        }

                    }

                }

                /* set contrast fields */
                if($ruleName === self::RULE_UNLIKE && $rule[1]){

                    $fields = is_array($rule[1])? $rule[1] : (array) $rule[1]; 
                    
                    $entries = [];

                    foreach($fields as $field){
                        $fval = $this->{$field};
                        $input1 = substr($value, 0, 4);
                        $input2 = substr($this->{$field}, 0, 4);
                        if( 
                            ($input1 && (strpos($fval, $input1) !== false)) ||
                            ($input2 && (strpos($value, $input2) !== false)) 
                        ) {
                            $this->addError([$attribute, $field], $ruleName);
                            break;
                        }
                    }

                }   

                /* set isolated fields */
                if($ruleName === self::RULE_ISOLATED && $rule[1]){

                    $data = Form::model()->loadedData();

                    if($data){

                        unset($data[$attribute]);

                        $data = array_map(fn($val) => substr($val, 0, 4), $data);

                        $input = substr($value, 0, 4);

                        if($field = array_search($input, $data)){
                            $this->addError([$attribute, $field], $ruleName);
                        }
                    }

                }   

                /* prevent duplicate entries on unique fields */ 
                if($ruleName === self::RULE_UNIQUE) {

                    if(isset($rule[1]['tableName'])){
                        $tableName = strtolower($rule['tableName']);
                    } else {
                        $tableName = static::table();
                    }

                    /* select from database table where field (or $attribute) has $value */
                    $uniqueAttr = $rule[1]['fields']?? $attribute;
                    $auth = User::auth();
                    
                    if(is_string($uniqueAttr)){
                        $auth->table($tableName)->where([
                            $uniqueAttr => $value 
                        ]);                        
                    }elseif(is_array($uniqueAttr)){
                        $values = array_fill_keys($uniqueAttr, $value);
                        $auth->table($tableName)->where(
                            $values
                        );                        
                    }

                    if($auth->find()) $this->addError($attribute, $ruleName);

                }
            }
        }       
        
        return empty($this->MODEL_ErrorLog) && !Csrf::error();
    }

    /**
     * Adds an error within the model class
     *
     * @param array|string $attribute 
     * @param string $rule
     * @param array $params
     * @return void
     */
    private function addError($attribute, $rule, $params = []){

        $attribute = (array) $attribute;
        $message = sprintf($this->errorMessage($rule), ...$attribute);

        if(count($params) > 1){
            if(is_array($params[1])){
                EInfo::view('invalid array supplied to "addError" on '.$params[0]);
            }
            $message = str_replace("{{$params[0]}}", $params[1], $message);
        }

        $attribute = $attribute[0];
        if($attribute) $this->MODEL_ErrorLog[$attribute][] = $message; 

    }

    /**
     * Sets a new custom error
     *
     * @param string $error
     *      - resolves as model error if argument 2 is not defined  
     *      - resolves an error key if argument 2 (error value) is defined  
     * @param string $value
     *      - [optional] - if $value defined, serves as error value while argument 1 serves as error key
     * @return void
     */
    final public function setError(string $error, string $value = ''){
        if(func_num_args() < 2){
            if($error) self::$MODEL_Error[':mod'] = $error;
        }else{ 
            if($error) self::$MODEL_Error[$error][] = $value;
        }
    }
    

    /**
     * Return array list of encountered errors 
     * for each attributes validated
     *
     * @return array
     */
    final public function errors() : array{
        $modelErrors = self::$MODEL_Error;
        if($modelErrors) return $modelErrors;
        return $this->MODEL_ErrorLog;
    }

    /**
     * Returns the first error encountered for an attribute 
     * based on its numerical position in a list of 
     * encountered errors. If the index does not exist an empty 
     * string is returned.
     * 
     * @return string
     */
    final public function errorIndex(int $index = 0) : string{
        $errors = array_values($this->MODEL_ErrorLog);
        return isset($errors[$index])? $errors[$index][0] : ''; 
    }

    /**
     * This returns the loaded request data only if
     * the data key exists as a property
     * within the model class. The data returned by 
     * this method will only be available for validation 
     *
     * @return array
     */
    final public function formdata() : array {
        $modeldata = $this->MODEL_FormData;

        $formdata = []; $iformdata = [];
     
        foreach($modeldata as $data => $value){
            if(property_exists($this, $data)){
                 $formdata[$data] = $this->$data;
            }
        }

        //map input field name with database columns
        $map = static::mapform(); //for database

        foreach($formdata as $column => $value){
            $fieldName = $map[$column]?? $column;
            $fieldName = is_string($fieldName)? $fieldName : $column; 
            $iformdata[$fieldName] = $value;
        }

        return $iformdata;
    }

    public function id() : string {
        
        if(!$this->id){
            if($id = $this->conn->insertID()){
                $this->id = $id;
            }
        }
       
        return $this->id;
    }

    /**
     * Update formdata
     *
     * @return void
     */
    final public function dataupdate(array $updates){
        foreach($updates as $column => $value){

            if( isset($this->MODEL_FormData[$column]) ){
                $this->MODEL_FormData[$column] = $value;
            }
        }
    }

    /**
     * Get loaded data
     *
     * @return array
     */
    final public function loadedData() : array {
        return $this->MODEL_FormData;
    }


    /**
     * Saves data into defined database table using 
     * User::auth() settings. Returns true if data was inserted.
     *
     * @param array $update array of existing column name and new value key pairs
     * @param boolean $show_error enables or disables database error display.
     * @return boolean
     */
    final public function saved(array $update = [], bool $show_error = false) : bool{

        $this->id = '';
        
        if($data = $this->formdata()){ 

            //update existing columns with new value
            foreach($update as $column => $newvalue){
                if(!is_array($newvalue) && array_key_exists($column, $data)){
                    $data[$column] = $newvalue;
                }
            }

            $dbh = isset($this->conn)? $this->conn : $this->connection();
            
            if($dbh){
                $dbh->insert_into(static::table(), $data);
                $insert = $dbh->insert();
                self::$insertID = $dbh->insertID();
    
                if(!$insert){
                    if($show_error) return EInfo::view(DBStatus::err());
                    Form::setError(DBStatus::err());
                    return false;
                }
    
                if(isset($data[User::idField()])){
                    $this->id = $data[User::idField()];
                }else{
                    $this->id = self::$insertID;
                }    
                return true;
            }

            return false;

        }

        return false;

    }

    protected function errorMessage($rule){

        $messages = [
            self::RULE_REQUIRED => '%s field is required',
            self::RULE_EMAIL => '%s field must be a valid email',
            self::RULE_MIN => '%s must be a minimum of {min} characters',
            self::RULE_MAX => '%s must be a maximum of {max} characters',
            self::RULE_MATCH => '%s field does not match {match}', //tested with another field
            self::RULE_PATTERN => 'value supplied in %s field is not valid',
            self::RULE_INTEGER => '%s field must be a valid integer',
            self::RULE_NUMBER => '%s field must be a valid number',
            self::RULE_PHONE => '%s field must be a valid phone number',
            self::RULE_TEXT => '%s field must a valid text',
            self::RULE_URL => '%s field must be a valid url',
            self::RULE_RANGE => '%s field is not within the range of valid characters',
            self::RULE_UNIQUE => '%s already exists', //tested with database field
            self::RULE_NOT => '%s cannot be the same as %s', //tested with another field
            self::RULE_UNLIKE => '%s cannot be like as %s', //tested with another field
            self::RULE_NOSPACE => '%s cannot contain spaces',
            self::RULE_NOT_CHARS => '%s cannot contain "%s" character',
            self::RULE_ISOLATED => '%s cannot match "%s" character',
        ];
        return $messages[$rule]?? '';
    }

    final static function insertID() {
        return self::$insertID;
    }

    /**
     * Map input field name with database columns.
     * This is useful for securing database column names.
     * It follows a key pair of input field name having its 
     * equivalent database column name as its value. 
     *
     * @return array
     */
    abstract protected static function mapform() : array;

    /**
     * This method is used to test form authentication,  or perform database operations.
     * It is also the last method called by Form::isAuthenticated() method. Hence, must be the
     * last action performed by any model.
     * 
     * @notice - This returns true by default if no errors are found.
     * @return mixed
     */
    public function isAuthenticated() : bool {
        return self::errors()? false : true;
    }

    /**
     * Set and return database connection using user authetication
     * @param DBHandler $dbh database connection handler
     * @return DBHandler|null
     */
    final function connection(DBHandler $dbh = null) : DBHandler|null{
        $this->id = '';
        if(func_num_args() < 1){
            if(isset($this->conn)) return $this->conn;
            if($dbh = (User::auth())->dbh()){
                return $this->conn = $dbh;      
            }else{
                Form::setError('database connection failed!');
            }     
        }
        if($dbh) $this->conn = $dbh;
        return isset($this->conn)? $this->conn : $dbh;
    }

 }