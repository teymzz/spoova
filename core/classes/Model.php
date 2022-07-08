<?php

namespace spoova\core\classes;

use spoova\core\tools\Input;

/**
 * 
 * @package spoova\core\classes
 * @Author Akinola Saheed <teymss@gmail.com>
 * 
 */
 abstract class Model {

    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_TEXT = 'text';
    public const RULE_PATTERN = 'pattern';
    public const RULE_PHONE = 'number'; //may not be entirely true for some data
    public const RULE_INTEGER = 'integer'; //Note:: Zero(0) though a valid integer will return 0 which may be considered as false unless strictly checked
    public const RULE_NUMBER = 'number'; //same as is_numeric
    public const RULE_URL = 'url';

    public const RULE_RANGE = 'range';
    public const RULE_UNIQUE = 'unique';

    //reserved properties
    private array $MODEL_ErrorLog = []; 
    private array $MODEL_LoadData = [];
    private array $MODEL_FormData = [];
    private Input $MODEL_Input;

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
        
        $this->MODEL_FormData =  $data;

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

    abstract public function rules(): array;

    public function tablename(): string {

        //default table name
        return \User::config('USER_TABLE');

    }

    public function validated(){

        //using the input class ('tool') for validations
        $Input = $this->MODEL_Input;

        foreach($this->rules() as $attribute => $rules){

            $value = $this->{$attribute} ;

            //rules (above) as set of rules supplied on a specific attribute

            foreach($rules as $rule){

                $ruleName = $rule;

                if (is_array($ruleName)){
                    $ruleName = $rule[0];
                }

                if($ruleName === self::RULE_REQUIRED and !$value){
                    $this->addError($attribute, $ruleName);
                }

                if($ruleName === self::RULE_EMAIL and !$Input->set($value, ['type'=> 'email'])){
                    $this->addError($attribute, $ruleName);
                }

                if($ruleName === self::RULE_MIN and strlen($value) < $rule['min']) {
                    $this->addError($attribute, $ruleName, $rule);
                }
                 
                if($ruleName === self::RULE_MATCH and $value !== $this->{$rule['match']}) {
                    $this->addError($attribute, $ruleName, $rule);
                }                  
                
                if($ruleName === self::RULE_PATTERN and !$Input->set($value, ['pregmatch'=>$rule['pattern']])) {
                    $this->addError($attribute, $ruleName, $rule);
                }    

                if($ruleName === self::RULE_INTEGER and !$Input->set($value, ['type'=>'integer'])) {
                    $this->addError($attribute, $ruleName);
                }                
                
                if($ruleName === self::RULE_NUMBER and !$Input->set($value, ['type'=>'number'])) {
                    $this->addError($attribute, $ruleName, $rule);
                }         
                
                if($ruleName === self::RULE_PHONE and !$Input->set($value, ['type'=>'phone'])) {
                    $this->addError($attribute, $ruleName);
                }                      

                if($ruleName === self::RULE_TEXT and !$Input->set($value, ['type'=>'text'])) {
                    $this->addError($attribute, $ruleName);
                }               

                if($ruleName === self::RULE_URL and !$Input->set($value, ['type'=>'url'])) {
                    $this->addError($attribute, $ruleName);
                }

                if($ruleName === self::RULE_RANGE and !$Input->set($value, ['type'=>'string', 'range'=> $rules['range'] ])){ 
                    $this->addError($attribute, $ruleName);
                }

                if($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute']?? $attribute;
                    $tableName = $className::tableName();
                    $auth = \User::auth();
                    $auth->table($tableName)->where([
                        $uniqueAttr =>$value 
                    ]);
                    if($auth->find()) $this->addError($attribute, $ruleName);
                }
            }
        }       
        
        return empty($this->MODEL_ErrorLog);
    }

    private function addError($attribute, $rule, $params = []){

        $message = sprintf($this->errorMessage($rule), $attribute);

        foreach($params as $param => $value){
            $message = str_replace("{{$param}}", $value, $message);
        }
        
        $this->MODEL_ErrorLog[$attribute][] = $message; 

    }

    public function errors(){
        return $this->MODEL_ErrorLog;
    }

    public function formdata(){
        $modeldata = $this->MODEL_FormData;
        $formdata = []; 
        
        foreach($modeldata as $data => $value){
            if(property_exists($this, $data)){
                 $formdata[$data] = $this->$data;
            }
        }
        
        return $formdata;
    }

    public function saved(){

        if($data = $this->formdata()){

            $dbh = \User::auth()->dbh();
            
            $dbh->insert_into($this->tablename(), $data);
            
            if(!$dbh->insert()){
                print \DBStatus::err();
                return false;
            }
            return true;

        }

    }

    protected function errorMessage($rule){

        $messages = [
            self::RULE_REQUIRED => '%s field is required',
            self::RULE_EMAIL => '%s field must be a valid email',
            self::RULE_MIN => '%s must be a minimum of {min} characters',
            self::RULE_MAX => '%s must be a maximum of {max} characters',
            self::RULE_MATCH => '%s field does not match {match}',
            self::RULE_PATTERN => 'value supplied in %s field is not valid',
            self::RULE_INTEGER => '%s field must be a valid integer',
            self::RULE_NUMBER => '%s field must be a valid number',
            self::RULE_PHONE => '%s field must be a valid phone number',
            self::RULE_TEXT => '%s field must a valid text',
            self::RULE_URL => '%s field must be a valid url',
            self::RULE_RANGE => '%s field is not within the range of valid characters',
            self::RULE_UNIQUE => '%s already exists',
        ];
        return $messages[$rule]?? '';
    }


 }