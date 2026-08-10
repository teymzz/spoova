<?php

namespace spoova\mi\core\classes;

use Closure;
use User;
use DBStatus;
use ErrorException;
use Form;
use InvalidArgumentException;
use ReflectionFunction;
use spoova\mi\core\classes\DB\DBHandler;
use spoova\mi\core\classes\DB\DBModel;
use spoova\mi\core\classes\Forms\Traits\FormRules;
use spoova\mi\core\classes\Forms\Traits\FormTrait;
use spoova\mi\core\tools\Input;
use TypeError;

abstract class ModelAbstract extends DBModel{

    use FormTrait; use FormRules;

    /**
     * Container variable for model's data keys to be authenticated
     *
     * @var array
     */
    protected array $templates = [];

    /**
     * Contains only error detected through the model data validations
     *
     * @var array
     */
    private static array $MODEL_Error = []; 

    /**
     * Contains specially defined errors
     *
     * @var array
     */
    private static array $auth_errors = []; 

    /**
     * Contains any error detected after data validations
     *
     * @var array
     */
    private array $MODEL_ErrorLog = []; 

    /**
     * Contains data loaded into the model class
     *
     * @var array
     */
    private array $MODEL_LoadData = [];

    /**
     * Contains validated form data after data validations
     *
     * @var array
     */
    private array $MODEL_FormData = [];

    private Input $MODEL_Input;

    /**
     * Refers to the assumed user id
     *
     * @var string
     */
    private string $id = '';

    /**
     * Refers to the database insertion id
     *
     * @var string
     */
    private static string $insertID = '';

    /**
     * This defines the data keys that determines the  
     * session data keys expected to be binded to user account after data validatioj
     *
     * @var array|string
     *  - The "*" string defines that all user data should be binded except the user account's secure password
     */
    protected static array|string $authBind = '*';

    /**
     * This contains the user authenticated data pulled during user authentication.
     *
     * @var array
     */
    protected static array $authData = [];

    /**
     * Determines when data creation or authentication is denied 
     *
     * @var integer
     */
    private static int|false $isDenied = false;

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
        $this->MODEL_LoadData = $data;
        //$reserved = ['MODEL_ErrorLog', 'MODEL_LoadData', 'MODEL_Input', 'MODEL_FormData']; //reserved properties
        $incs = array_key_exists('inc', $mods)? (array) $mods['inc'] : [];
        $excs = array_key_exists('exc', $mods)? (array) $mods['exc'] : [];

        $loadData = $data;

        if(($incs) || ($excs)){
            // use inclusion and exclusion keys to filter out data keys
            if($excs){ 
                //remove existing data keys 
                $data = array_diff_key($data, array_flip($excs));
            }

            foreach ($incs as $inc) {
                //add new data keys
                $this->templates[$inc] = $data[$inc] ?? $this->templates[$inc] ?? '';

                $data[$inc] = $data[$inc]?? $this->templates[$inc] ?? '';
            }

        }

        if(!$incs and !$excs){
            //use smart modificator to filter out or filter in data.
            foreach ($mods as $mod) {
                
                if(array_key_exists($mod, $data)){

                    //unset incoming data key (if modifier key exists in data)
                    unset($data[$mod]);

                }else{

                    //add incoming data key (if modifier key does not exist in data)
                    if(!isset($this->templates[$mod])) {
                        $this->templates[$mod] = '';
                        $data[$mod] = '';
                    }else{
                        $data[$mod] = $this->templates[$mod];
                    }
                    
                }
            }            
        }
        
        //store only data to be uploaded
        $this->MODEL_FormData =  $data;

        //set attributes (properties) within the class only if it exists
        foreach($loadData as $requestKey => $requestValue){
            if(array_key_exists($requestKey, $this->templates)) {
                $this->templates[$requestKey] = $requestValue;
            }
        }

    }

    public function mapped(string $key){

        $data = $this->MODEL_LoadData; //raw data loaded into the model class 
        $map = static::mapform(); // form input-to-database map defined by model

        if(array_key_exists($key, $map)){
            if(isset($data[$key])){
                $data[$map[$key]] = $data[$key];
                unset($data[$key]);
            }
            $key = $map[$key];
        }


        return $data[$key] ?? false;

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
        self::$authData = [];

        foreach($this->rules() as $attribute => $rules){

            $value = (string) $this->templates[$attribute] ;

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



                if($ruleName === self::RULE_REQUIRED && !$value){
                    $this->addError($attribute, $ruleName);
                }

                if($ruleName === self::RULE_NOSPACE && strpos(trim($value), ' ') !== false){
                    $this->addError($attribute, $ruleName);
                }

                if($ruleName === self::RULE_EMAIL && !$Input->set($value, ['type'=> 'email'])){
                    $this->addError($attribute, $ruleName);
                }

                if($ruleName === self::RULE_MIN && strlen($value) < $rule[1] ?? 0) {
                    $this->addError($attribute, $ruleName, $rule);
                }

                if($ruleName === self::RULE_MAX && strlen($value) > $rule[1] ?? 0) {
                    $this->addError($attribute, $ruleName, $rule);
                }                 
                
                /* match a pattern set using Input class */
                if(($ruleName === self::RULE_PATTERN) && !$Input->set($value, ['pregmatch'=>$rule[1]])) {
                    $this->addError($attribute, $ruleName, $rule);
                }  

                /* match an integer */
                if(($ruleName === self::RULE_INTEGER) && ($Input->set($value, ['type'=>'integer'], true))) {
                    $this->addError($attribute, $ruleName);
                }          

                /* match a numeric value */                
                if(($ruleName === self::RULE_NUMBER) && !$Input->set($value, ['type'=>'number'])) {
                    $this->addError($attribute, $ruleName, $rule);
                }         
                
                /* match a phone number */
                if(($ruleName === self::RULE_PHONE) && !$Input->set($value, ['type'=>'phone'])) {
                    $this->addError($attribute, $ruleName);
                }                      

                /* match only text strings */
                if(($ruleName === self::RULE_TEXT) && !$Input->set($value, ['type'=>'text'])) {
                    $this->addError($attribute, $ruleName);
                }               

                /* set valid url patterns */
                if(($ruleName === self::RULE_URL) && !$Input->set($value, ['type'=>'url'])) {
                    $this->addError($attribute, $ruleName);
                }

                /* set valid range of data that must be matched */
                if(($ruleName === self::RULE_RANGE) && !$Input->set($value, ['type'=>'string', 'range'=> $rules[1] ])){ 
                    $this->addError($attribute, $ruleName);
                }
                
                
                /* match the value of a property set (e.g $this->password) */
                if(($ruleName === self::RULE_MATCH) && $value !== $this->{$rule[1]}) {
                    $this->addError($attribute, $ruleName, $rule);
                }

                /* set not duplicated fields */
                if(($ruleName === self::RULE_NOT) && $rule[1]){
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
                        $input2 = substr($this->templates[$field], 0, 4);
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

                    $formAttribute = $attribute;

                    if(!isset($rule[1]['fields'])){
                        //use form database map 
                        $attribute = static::mapform()[$attribute] ?? $attribute;
                        $uniqueAttr = $attribute;
                    }
                    
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

                    if($auth->find()) {
                        self::$isDenied = 2; // existing account
                        $this->addError($formAttribute, $ruleName);
                    }

                }
            }
        }       
        
        if(empty($this->MODEL_ErrorLog) && !CSRF::error()){
           self::$authData = self::formdata();
           return true;
        }
        return false;
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
     * This returns the loaded request data (mapped) only if
     * the data key exists as a property
     * within the model class. The mapped form data returned by 
     * this method will only be available for database upload
     *
     * @return array model data
     */
    final public function formdata() : array {
        $modeldata = $this->MODEL_FormData;

        $formdata = []; $iformdata = [];
     
        foreach($modeldata as $data => $value){
            if(isset($this->templates[$data])){
                 $formdata[$data] = $this->templates[$data];
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

    public function id() : string|false {
        
        if(!$this->id){
            if(!isset($this->conn)) return false;
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
     * Get accepted data from loaded request data
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
                self::$authData = $data;
                return true;
            }

            return false;

        }

        return false;

    }


    /**
     * Authenticates user's data using specified user account credentials
     *
     * @param array $credentials an array of user account database table's column name and value pairs
     * @param Closure|null $callback
     * @return boolean
     */
    public function auth(array $credentials, ?Closure $callback = null) : bool {

        self::$authData = [];
        
        if($callback === null){
            throw new InvalidArgumentException('callback must be defined');
        }

        if($db = (User::auth())->dbh()) {

            // Detect password field from argument supplied
            $reflection = new ReflectionFunction($callback);
            $parameters = $reflection->getParameters();
            $password_column = '';

            foreach($parameters as $parameter){
                $i = ($i ?? 0) + 1;
                if($i > 2){
                    throw new ErrorException('callback must take maximum of two arguments');
                }

                if($i === 1){
                    if(!in_array($parameter->getType(), ['','string'])){
                        throw new ErrorException('first argument must be of type string or undefined');
                    }
                    
                    $password_column = $parameter->getName();
                }
            }

            // Query for columns with their relative values (auth)
            $keys = array_keys($credentials);

            $columns = '';
            $values = [];

            $keysCount = count($keys); $i = 0;

            foreach($credentials as $field => $val){
                $i++;

                $field = str_replace('|', ',', $field);

                $fields = explode(',',$field, 2);

                $columns .= enplode(['` = ? OR `', '`',''], $fields, true);
                $columns .= '` = ?';
                if(count($fields) > 1){
                    $columns = '('.$columns.')';
                }
                for($j =0 ; $j < count($fields); $j++){
                    $values[] = $val;
                }

                if($i !== $keysCount) {
                    $columns .= ' AND '; 
                }else{
                    $columns .= ''; 
                }
            }

            $info = (array) self::$authBind;

            if(is_string($info)){
                $info = explode(',', $info);
            }

            if(is_array($info)){

                //resolve for arrays
                if(!in_array($password_column, $info)){
                    $info[] = $password_column;
                }
                if(!in_array(User::idField(), $info)){
                    $info[] = User::idField();
                }

                $fields = enplode(['`,`','`','`'], $info);

                $fields = str_replace('`*`', '*', $fields);

            }
        
            $fields = $fields ?? '';
            $query = "SELECT $fields FROM `".User::tablename()."` WHERE ".$columns;

            $db->query($query, $values);

            if(!$db->read(1)){
                if(!$db->error(true)){
                    Form::setError('invalid user id supplied');
                    self::$isDenied = 3; //invalid account authentication id
                    return $callback(false, []);
                }
                return $callback(false, []);
            }

            $data = $db->results(0);
            $password = $db->results(0, $password_column) ?: '';

            self::$authData = $data;
            self::$authData[':userid'] = $data[User::idField()];
            self::$authData['userid'] = $data[User::idField()];

            //unset password field for security
            unset($data[$password_column]);
            $valid = $callback($password, $data);

            if($valid) return true;
            self::$isDenied = 4; //invalid account authentication key
            Form::setError('invalid password');

            return false;

        }

        return false;
    }

    /**
     * This is used for registration where the $userid_key supplied 
     * is a key in the form request data whose value 
     * is equivalent to the session userid.  
     *  - To use this method, a Form model class must have been initialized 
     *  - This method will call the form model's "isAuthenticated()" method.
     *
     * @param string $userid_key userid key name in form request data
     * @param Closure $callback - A closure function called after the form is authenticated.
     *  - If authentication is true, the Closure argument will always return an array having a "userid" key along with its 
     *  corresponding "userid" value required for a creating a user's session. 
     * 
     * @return bool true if form is authenticated
     */
    public static function register(string $userid_key, Closure $callback) : bool {
        $model = Form::model();
        if($model::class !== get_called_class()){
            throw new TypeError('register method has conflicting Form handler models');
        }
        if(Form::haskey($userid_key)){

            if(Form::isAuthenticated()){
                
                $sessid = Form::dataval(User::idField()) ?? Form::id();

                $data['userid'] = $sessid;
                $data[':userid'] = $sessid;
                self::$authData[':userid'] = $sessid;
                $callback($data);
                return true;
            }else{
                $callback(false);
            }

        }else{
            Form::setError('error: unknown session identifier');
        }

        return false;

    }

    /**
     * Return authentication data
     *
     * @return array
     */
    public function authData(): array{

        $authData = self::$authData;
        $authBind = (array) self::$authBind;
        unset($authData[':userid']);

        if(in_array('*', $authBind)){

            $data = $authData;

        }else{

            foreach ($authData as $datakey => $dataval) {
               if(in_array($datakey, $authBind)){
                    $data[$datakey] = $dataval;
               }
            }

        }

        return $data ?? [];

    }

    /**
     * Set authentication data to be returned
     *
     * @param array|string $data
     * @return Model
     */
    public function authBind(array|string $data = '*') : Model {
        self::$authBind = $data;
        return $this;
    }

    

    /**
     * Alias for {@see Form::authBind()} method. This 
     * will bind the data to be retrieved through the 
     * {@see Form::account()} method when argument is set as true.
     *
     * @param array|string $data
     * @return Model
     */
    public static function activate(array|string $data = '*') : Model {
        Form::authBind(...func_get_args());
        return Form::model();
    }



    protected function errorMessage(string $rule){

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
        return $this->errors()? false : true;
    }

    /**
     * Set and return database connection using user authetication
     * @param DBHandler $dbh database connection handler
     * @return DBHandler|null
     */
    final function connection(?DBHandler $dbh = null) : DBHandler|null{
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

    /**
     * This method helps to handle error response messages using 
     * basic codes.
     *  - code 0 - form validation error
     *  - code 1 - database errors
     *  - code 2 - user creation errors (account exists)
     *  - code 3 - user authentication error (account does not exists)
     *  - code 4 - user authentication error (account access key denied)
     *
     * @return boolean
     */
    public static function isDenied(?Closure $callback = null): bool {

        if(in_array(self::$isDenied, [2, 3, 4], true)){
            if($callback) $callback(self::$isDenied);
            return true;
        }else{
            $errors = Form::errors($input);

            if($errors){
                if($input){
                    $code = 0;
                }else{
                    $code = 1;
                }

                if($callback) $callback($code);
                return true;
            }

        }
        return false;

    }

}