<?php

use spoova\mi\core\classes\CSRF;
use spoova\mi\core\classes\Model;
use spoova\mi\core\classes\Notice;
use spoova\mi\core\classes\Request;
use spoova\mi\core\classes\FormModel;
use spoova\mi\core\classes\FormBuilder;
use spoova\mi\core\classes\DB\DBHandler;
use spoova\mi\core\classes\Forms\Traits\FormTrait;

/**
 * This Form class is used to build form inputs
 */
final class Form extends FormBuilder {

    private static array $castedErrors = [];
    
    /**
     * This contains the user authenticated data pulled during user authentication.
     *
     * @var array
     */
    private static array|string $authBind = '*';
    protected static array $authData = [];
    private static Form $instance;

    use FormTrait;

    /**
     * This method either sets a new model or returns a predefined form model. 
     * Before a model can be returned, it must be previously defined using the same method. 
     * The model can be later accessed by calling model() without any arguments.
     *
     * @param Model $model
     * @param string $action form action url
     * @return Form|Model
     *    - Returns Form class if arguments to predefine the model are supplied
     *    - Returns Model class if no arguments are supplied. This throws error if model is not predefined
     */
    public static function model(?Model $model = null, $action = '') {
        if(func_num_args() == 0) return self::$model;
        self::$model = $model;
        self::$indexed = $action;
        return self::$instance = new self;
    }

    /**
     * Updates the CSRF component template page
     *  - Note that this uses the "``Window::wvm(':csrf')``" along with {@see Request::strict()} to update the CSRF error page 
     *  while forcing the CSRF token authentication on a strict mode.
     * @param Request $Request The current request class object
     * @param string|null $path CSRF rex template component path (e.g csrf.template)
     * @return void
     */
    public static function csrf(Request $Request, ?string $path = null){
        if($path) {
            Window::wvm(':csrf',$path);
            $component = to_dirslash('windows/Rex/'.$path, true).'.rex.php';
            if(!is_file($component)){
                throw new Error('window cannot find CSRF rex component file: "'.$path.'"');
            }
        }
        $Request->strict();
    }

    /**
     * This method is used to register a form account.
     * 
     * @param String|Closure $open 
     *  - When set as string, it is assumed to be a key which must 
     *    exist in request data before $call is called. 
     *  - When set as Closure, it is assumed to be the callback called when a post request is sent.
     * 
     * @param Closure $call A callback to be called if $open is string
     * 
     * @return false|mixed
     *  - This will always return the data type returned by the callback or a false value.
     */
    public static function onSubmit(String|Closure $open, ?Closure $call = null) {

        if(func_num_args() == 1 && ($open instanceof Closure)) {
            if((new Request())->isPost()){
                return $open();
            }
        }elseif(func_num_args() == 2 && (is_string($open)) && ($call instanceof Closure)){
            $modifier = explode(':',$open, 2);
            $Request = new Request;
            
            if(count($modifier) === 2 && trim($modifier[1])){
                $method = $modifier[0];
                $datakey = $modifier[1];
            }elseif(count($modifier) === 1 && trim($modifier[0])){
                $method = 'post'; //use default method
                $datakey = $modifier[0];
            }
            
            if(isset($method) && $Request->method() === $method){
                /** @var string $datakey */
                if($Request->has($datakey)){
                    return self::register($datakey, $call);
                }
            }else{
                Form::setError('invalid request method');
                return false;
            }
        }
        return false;
    }

    /**
     * Sets a model custom error
     *   - Shorthand for Form::model()->setError();
     *
     * @param string $error
     *      - resolves as model error if argument 2 is not defined  
     *      - resolves an error key if argument 2 (error value) is defined  
     * @param string $value
     *      - [optional] - if $value defined, serves as error value while argument 1 serves as error key
     * @throws Exception if model is not set
     * @return void 
     */
    public static function setError(string $error, string $value = '') {
        if(!self::$model){
            self::model(new FormModel);
        }
        self::$model->setError(...func_get_args());
    }

    /**
     * Returns the form model errors
     * @param array &$inputErrors referenced variable that contains only input errors
     * 
     * @return array errors are only returned if a form model is defined
     */
    public static function errors(&$inputErrors = []) : array {
 
        if(self::$model) {
            $errs = $inputErrors = self::$model->errors();

            if($errs) {
                $errors = array_values($errs);

                if(isset($errors[0])){

                    if(is_array($errors[0])){
                        $errs[':index'] = $errors[0][0] ?? '';
                    }else{
                        $errs[':index'] = $errors[0] ?? '';
                    }

                }else{
                    $errs[':index'] = '';
                }
            }
            if(!$errs && DBStatus::err()) {
                $errs[':dbe'] = 'database error: something is wrong';
                $errs[':dbm'] = 'something is wrong';
                $errs[':dbi'] = DBStatus::err();
            }

            if($ecsrf = CSRF::error()) {
                $errs = [':csrf' => $ecsrf];
            }
            
            return $errs;
        }
        
        return $inputErrors = [];
    }

    /**
     * Store form error into a unique identifier space. This 
     * method is used after a form model's authentication method has been called.
     *
     * @param string $name cast storage name
     * @return void
     */
    static function castError(string $name = ''){

        $errors = Form::errors();
        $casts = [];

        if(isset($errors[':csrf'])){
            $casts['csrf:title'] = $errors[':csrf']['title'];
            $casts['csrf:info']  = $errors[':csrf']['info'];
            unset($errors[':csrf']);
        }

        if(isset($errors[':mod'])){
            $casts['mod:'] = $errors[':mod'];
            unset($errors[':mod']);
        }

        if(isset($errors[':index'])){
            $casts['index:'] = $errors[':index'];
            unset($errors[':index']);
        }

        if($flash = flash(':user-error')){
            $casts['flash:user-error'] = $flash;
        }

        $casted = array_values($casts)[0] ?? '';
        
        if($casted && is_string($casted)) {
            $casts['any:'] = $casted;
        }

        $flashes = (new Notice)->flashes();

        foreach($flashes as $flash => $message){
            if($flash === ':user-error') continue;
            $casts['flash:'.$flash] = $message;
        }
        
        foreach($errors as $key => $value){
            if(is_string($value) && !array_key_exists($key, $casts)){
                $casts[$key] = $value;
            }elseif(is_array($value) && isset($value[0]) && is_string($value[0])){
                $casts[$key] = $value[0];
            }
        }

        $casts[$name] = $casts;

        self::$castedErrors = $casts;

    }

    /**
     * Returns a specified error key's value wihtin the specified cast name
     *
     * @param string $castName cast identifier name
     * @param string $castKey cast error identifier key
     * @return string cast error value
     */
    static function castedError(string $castName, string $castKey) : string {

        $casts = self::$castedErrors;

        if(isset($casts[$castName])){
            $casts = $casts[$castName];
            if( isset($casts[$castKey]) ){
                return $casts[$castKey];
            }
        }

        return '';

    }

    /**
     * This method sets a form data to be validated or returns a validated request data
     * - ##### If no arguments are supplied, this will return the current loaded server request data. 
     * - ##### If arguments are supplied, this method will perform a similar function as {@see Form::loadData()} and returns an empty array
     * - ##### By default, this method returns a CSRF valid data unless data validation return is turned off. 
     * - ##### When valid data keys (mapped keys inclusive) are returned, the keys must exist as a property of the form's given model.
     * - ##### NOTE: To use this method, a form model must have been specified
     * 
     * @param Request|array $arg incoming Request class or request data
     * @param array $mods form request modifier keys
     * 
     * @return array data keys returned are subject of redefined mapped keys.
     */
    public static function data(Request|array $arg = [], array $mods = []) : array {
        if(func_num_args() > 0){
            self::loadData(...func_get_args());
            return [];
        }
        return self::$model->formdata();
    }

    /**
     * This returns the connection insert id through the {@see Model::id()} method.
     *
     * @return string
     */
    public static function id() : string {
        return self::$model->id();
    }

    /**
     * Returns the direct id of relative user.
     *
     * @return string
     */
    public static function dataid() : string {
        return self::$model->dataid(); //inserted data id or null
    }

    /**
     * Returns a value from validated form data (mapped inclusive) key if the supplied key exists. 
     * 
     * @param string $key form's mapped request data key.
     * 
     * @return array|string|false
     */
    public static function datakey(string $key) : array|string|false {
        $data = self::$model->formdata();
        return $data[$key] ?? false;
    }

    /**
     * Returns the relative value of a key form an accepted form data.
     * 
     * @param string $key form's request data key name or mapped request data key name.
     * 
     * @return array|string|false
     */
    public static function mapped(string $key) : array|string|false {
        $data = self::$model->mapped($key);
        return $data[$key] ?? false;
    }

    /**
     * Return true if form data (mapped inclusive) has specified key
     * 
     * @return bool
     */
    public static function haskey(string $key) : bool {
        $data = self::$model->formdata();
        return array_key_exists($key, $data);
    }

    /**
     * Returns a value from validated form request data (mapped inclusive). This will trigger an error  
     * if the key does not exist in the specified formdata and
     * $strict is set as true which will return an empty string instead
     * 
     * @param string $key a key which exists in form data
     * @param boolean $strict TRUE throws error rather than return empty string if $key does not exist in data.
     * @return string
     */
    public static function dataval(string $key, bool $strict = false) : mixed {
        $data = self::$model->formdata();
        if($strict) return $data[$key];
        return $data[$key] ?? '';
    }

    
    /**
     * Set and return database connection using user authetication
     * @param DBHandler $dbh database connection handler
     * @return DBHandler model's connection handler instance
     */
    public static function connection(?DBHandler $dbh = null) : DBHandler {
        return self::$model->connection(...func_get_args());
    }

    /**
     * An alternative class for {@see Form::data()} used to process form request data.
     * - ##### Note that this method does not return the mapped data keys unlike {@see Form::data()} method.
     *
     * @param Request|array $data incoming Request class or request data
     * @param array $mods as list of smart modifications that detects new additions or subtractions.
     *  - Values that do not exist in $data but are needed for uploading can be supplied into $mod.
     *  - Values that exists in $data but are not needed for uploading can be supplied into $mod
     *  - $mod will automactically remove or add data need. To reduce human errors define all inclusions or exclusions by
     *          - ['inc' => ['firstname','lastname'], 'exc'=> ['token'] ]
     * @return void
     */
    public static function process(Request|array $data = new Request, array $mods = []): void{
        self::loadData($data, $mods);
    }

    /**
     * Uses the Model class already defined to load data
     *
     * @param array $data data to be validated (request or form data)
     * @param array $mods as list of smart modifications that detects new additions or subtractions.
     *  - Values that do not exist in $data but are needed for uploading can be supplied into $mod.
     *  - Values that exists in $data but are not needed for uploading can be supplied into $mod
     *  - $mod will automactically remove or add data need. To reduce human errors define all inclusions or exclusions by
     *          - ['inc' => ['firstname','lastname'], 'exc'=> ['token'] ]
     * @return void
     */
    public static function loadData(array|Request $data, array $mods = []){
        if($data instanceof Request){
            $data = $data->data();
        }
        self::$model->loadData($data, $mods);
    }

    /**
     * Uses the defined Model class already defined to 
     * return the supplied form request data
     *  - Model must be defined before this method is called, else it throws error.
     *
     * @return array
     */
    public static function loadedData(array $data, $mods = []) : array {
        return self::$model->loadedData();
    }

    /**
     * Check if form is validated using supplied model rules
     * 
     * @return true
     */
    public static function isValidated() : bool {
        return self::$model->validated();
    }

    /**
     * This method handles form authentication in a single call by autoloading 
     * the form model data. It also accept modifiers that defines mode of operation
     *
     * @param array $mod request data modifiers for Form::loadData()
     * @param bool $authModel defines if the model isAuthenticated() method is called
     * 
     * @return boolean
     */
    final public static function isAuthenticated(array $mod = [], bool $authModel = true) : bool{

        $data = Form::model()->loadedData();

        self::loadData($data, $mod);

        $isValidated = self::isValidated();

        if($isValidated){
            if($authModel){
                if(self::model()?->isAuthenticated()){
                    self::$authData = Form::data();
                    //set auth data
                    return true;
                } 
            }else{
                self::$authData = Form::data();
                //set auth data 
              return true;
            }
        }
        
        // return $isValidated && (($authModel)? self::model()?->isAuthenticated() : true);
        return false;

    }

    /**
     * Uses model save method to save data
     * 
     * @param array $data array of column and new value key pairs
     * @param bool $show_error enable or disables database error
     * 
     * @return bool
     */
    public static function isSaved(array $data = [], bool $show_error = false) : bool {
        return self::$model->saved($data, $show_error);
    }

    /**
     * Return authentication data
     *
     * @return array
     */
    public static function authData(): array{
        return self::model()->authData();
        
    }

    /**
     * Authenticates user's data using specified user account credentials
     *
     * @param array $credentials an array of user account database table's column name and value pairs
     * @param Closure|null $callback
     * @return boolean
     */
    public static function auth(array $credentials, ?Closure $callback = null) : bool {
        return self::model()?->auth(...func_get_args());
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
        return self::model()->register(...func_get_args());
    }


    /**
     * Set authentication data to be returned
     *
     * @param array|string $data
     * @return Form
     */
    public static function authBind(array|string $data = '*'): Form {

        Form::model()->authBind(...func_get_args());
        return self::$instance;

    }

    /**
     * Alias for {@see Form::authBind()} which defines user session account data
     *
     * @param array|string $data
     * @return Form
     */
    public static function activate(array|string $data = '*'): Form {

        self::model()->authBind(...func_get_args());
        return self::$instance;

    }

        
    /**
     * This is used for user login where the $userid_key supplied 
     * is a key in the form request data whose value 
     * is equivalent to the session userid.  
     *  - To use this method, a Form model class must have been initialized 
     *  - This method will call the form model's "isAuthenticated()" method.
     *
     * @param Closure $callback - A closure function called after the form is authenticated.
     *  - If authentication is true, the Closure argument will always return an array having a "userid" key along with its 
     *  corresponding "userid" value required for a creating a user's session. 
     * 
     * @return bool true if form is authenticated
     */
    public static function login(Closure $callback) : bool {

        if(Form::isAuthenticated()){
            $callback(self::$authData);
            return true;
        }else{
            $callback(false);
            return false;
        }

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

        return self::$model->isDenied($callback);

    }

}