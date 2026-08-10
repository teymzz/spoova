<?php

namespace spoova\mi\core\classes;

use Form;
use User;

class Model extends ModelAbstract{

    public $error;

    /**
     * Define model rules
     *
     * @return array
     */
    public function rules() : array {
        return [];
    }

    /**
     * This maps form data keys to database fields
     *
     * @return array
     */
    public static function mapform() : array {
        return [];
    }

    /**
     * Implements logic that determines when form data is finally validated.
     *
     * @return boolean
     */
    public function isAuthenticated(): bool {
        return true;
    }

    /**
     * This method sets a form data to be validated or returns a validated request data through the {@see Form::data()} method
     * - ##### If no arguments are supplied, this will return the current server request data. 
     * - ##### If arguments are supplied, this method will perform a similar function as {@see Form::loadData()} and returns an empty array
     * - ##### By default, this method returns a CSRF valid data unless data validation return is turned off. 
     * - ##### When valid data keys (mapped keys inclusive) are returned, the keys must exist as a property of the form's given model.
     * 
     * @param Request|array $arg incoming Request class or request data
     * @param array $mods form request modifier keys
     * 
     * @return array data keys returned are subject of redefined mapped keys.
     */
    public static function data(Request|array $arg = [], array $mods = []) : array {
        return Form::data(...func_get_args());
    }
    
    /**
     * Returns the direct id of relative user.
     *
     * @return string
     */
    public static function dataid() : string {
        if($db = (User::auth())->dbh()) {

            $useridField = User::idField(); //defined user id field
            $fields = $db->tables(tbname: User::tableName());

            if(in_array($useridField, $fields)){

                $data   = Form::data(); //validated & mapped form data
                $formID = Form::id(); //inserted data id

                if(in_array($useridField, $data)){
                    return $data[$useridField]; //return from submitted data 
                } else if(isset(self::$authData[':userid'])) {
                    return self::$authData[':userid']; //return from authenticated data 
                }else if($formID){
                    return $formID;
                }

            }

        }
        return Form::model()->id(); //inserted data id or null
    }

    /**
     * Syntactic sugar for {@see Form::model()} and {@see Form::process()}. 
     *  - Internally, this method initializes {@see Form::model()} using the 
     * current Model class while the argument parameters are in relation to the {@see Form::process()} method.
     *
     * @param array|Request $Request Request class object or request data
     * @param array $mods as list of smart modifications that detects new additions or subtractions.
     *  - Values that do not exist in $data but are needed for uploading can be supplied into $mod.
     *  - Values that exists in $data but are not needed for uploading can be supplied into $mod
     *  - $mod will automactically remove or add data key need. To reduce human errors define all inclusions or exclusions by
     *          ##### ['inc' => ['datakey', ...], 'exc'=> ['datakey'] ]
     * 
     * @return Model
     */
    public static function model(Request|array $Request = new Request, array $mods = []): Model {
        Form::model($model = new static);
        Form::process(...func_get_args());
        return $model;
    }

    /**
     * Syntactic sugar for {@see Form::model()} and {@see Form::process()}. 
     *  - Internally, this method initializes {@see Form::model()} using the 
     * current Model class while the argument parameters are in relation to the {@see Form::process()} method.
     * 
     * @param array|Request $Request Request class object or request data
     * @param array $mods as list of smart modifications that detects new additions or subtractions.
     *  - Values that do not exist in $data but are needed for uploading can be supplied into $mod.
     *  - Values that exists in $data but are not needed for uploading can be supplied into $mod
     *  - $mod will automatically remove or add data key need. To reduce human errors define all inclusions or exclusions by
     *          ##### ['inc' => ['datakey', ...], 'exc'=> ['datakey'] ]
     *
     * @return Form
     */
    public static function form(Request|array $Request = new Request, array $mods = []): Form {
        $form = Form::model(new static);
        Form::process(...func_get_args());
        return $form;
    }

    /**
     * Return database table name
     *
     * @return string
     */
    public static function tablename(): string {
        return strtolower(pathbase(get_called_class()));
    }

    /**
     * Resolve conflicting database table's columns. This 
     * method must be owned by the base Model where relationship is defined.
     *
     * @return array
     */
    public static function translate(): array {
        return [];
    }

}