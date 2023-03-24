<?php

use spoova\mi\core\classes\Csrf;
use spoova\mi\core\classes\EInfo;
use spoova\mi\core\classes\Model;
use spoova\mi\core\classes\FormModel;
use spoova\mi\core\classes\FormField;
use spoova\mi\core\classes\Request;

/**
 * This Form class is used to build form inputs
 */
final class Form extends FormField{

    private const inputs = [
        'text', 'textarea', 'textbox', 'hidden', 'email', 'file', 
        'pass', 'password', 'number', 'tel', 'url', 'range', 'date', 
        'dateLocal', 'week', 'month', 'year', 'image', 'color', 
        'checkbox', 'radio', 'search', 'submit', 'button'
    ];

    private static ?Model $model = null;

    /**
     * Form settings
     *
     * @var array
     */
    private static $settings = [
        'error_field' => [
            "type" => 'each',
            "attributes" => '',
            "tag" => 'span',
        ],

        'group_class' => '',  //applied on form group
        'each_class'  => '',  //applied on form group
        'form_class'  => '', //applied on form
        'field_class' => 'flex-full' //applied on input field
    ];
    private static $groupEach = false;
    private static $grouped = false;
    private static $skip = false;
    
    /**
     * Allows form rendering
     *
     * @var boolean
     */
    private static $render = false;
    private static $indexed = '';
    private static $start;
    private static $usedClass;

    function __construct(){}
    
    /**
     * Method to modify the current default settings 
     *
     * @param array $array
     * @return void
     */
    public static function set(array $array){
        self::$settings = array_merge(self::$settings, $array);
    }

    /**
     * This method either sets a new model or returns a predefined form model. 
     * Before a model can be returned, it must be previously defined using the same method. 
     * The model can be later accessed by calling model() without any arguments.
     *
     * @param Model $model
     * @param string $action form action url
     * @return Form|Model
     *    - Returns a the Form class if arguments to predefine the model are supplied
     *    - Returns a Model class if no arguments are supplied. This throws error if model is not predefined
     */
    public static function model(Model $model = null, $action = '') {
        if(func_num_args() == 0) return self::$model;
        self::$model = $model;
        self::$indexed = $action;
        return new self;
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
     * @return array
     * @notice errors are only returned if a form model is set
     */
    public static function errors(&$inputErrors = []) : array {
 
        if(self::$model) {
            $errs = $inputErrors = self::$model->errors();
            if(!$errs && DBStatus::err()) {
                $errs[':dbe'] = 'database error: something is wrong';
                $errs[':dbm'] = 'something is wrong';
                $errs[':dbi'] = DBStatus::err();
            }

            if($ecsrf = Csrf::error()) {
                $errs = [':csrf' => $ecsrf];
            }
            return $errs;
        }
        
        return $inputErrors = [];
    }

    /**
     * Return the validated data of supplied model's formdata
     * This returns the loaded data only 
     * if the data key exists as a property
     * within the model class. The data returned by 
     * this method will only be available for validation 
     * 
     * @notice - data returns attributes with mapped keys (i.e defined database table fields)
     * @return array
     */
    public static function data() : array {
        return self::$model->formdata();
    }

    /**
     * Return a key from validated form data if the key exists
     * 
     * @return string|bool(false)
     */
    public static function dataKey($key) :string|bool {
        $data = self::$model->formdata();
        return $data[$key]?? false;
    }

    /**
     * autoload a form builder
     *
     * @return Form
     */
    public function autoload(){
        self::$render = true;
        return $this;
    }

    /**
     * Start a new Form with disabled display
     *
     * @param string $form referenced variable
     * @param string $method request method
     * @param string $action form action
     * @return string
     */
    public static function open(&$form = null, $method = 'post', $action = '') {
        $action = $action? ' action="'.$action.'"' : '';
        $method = $method? ' method="'.$method.'"' : '';
        $class  = self::$settings['form_class']? ' class="'.self::$settings['form_class'].'"' : '';
        $form = new Form();
        return "<form{$action}{$method}{$class}>"; 
    }

    /**
     * Start a new Form with enabled display
     *
     * @param string $form referenced variable
     * @param string $method request method
     * @param string $action form action
     * @return void
     */
    public static function init(&$form = null, $method = 'post', $action = '') {
        self::$render = true;

        self::open(...func_get_args());
    }    

    /**
     * Close a Form tag
     *
     * @return string
     */
    public static function close() {   
        return '</form>';
    }

    /**
     * Create a Form with a form wrapper of post method
     *
     * @param string $Form
     * @return string
     */
    public static function POST($Form, $action = ''){
        $action  = self::$indexed? DomUrl(self::$indexed) : '';
        $Form = '<form method="POST" action="'.$action.'">'.$Form.'</form>';
        if(self::$render) print $Form;
        return $Form;
    }

    /**
     * Create a Form with a form wrapper of GET method
     *
     * @param string $Form
     * @return string
     */
    public static function GET($Form, $action = ''){
        $action  = self::$indexed? DomUrl(self::$indexed) : '';
        $Form = '<form method="GET" action="'.$action.'">'.$Form.'</form>';
        if(self::$render) print $Form;
        return $Form;
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
    public static function loadData(array $data, $mods = []){
        self::$model->loadData($data, $mods);
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

        return $isValidated && (($authModel)? self::model()?->isAuthenticated() : true);

    }

    /**
     * Uses model save method to save data
     * 
     * @param $data array of column and new value key pairs
     * @show_error enable or disables database error
     * @return bool
     */
    public static function isSaved(array $data = [], bool $show_error = false) : bool {
        return self::$model->saved($data, $show_error);
    }

    /**
     * Group each form field
     *
     * @param string $tag wrapper tag name for each field 
     * @param mixed $func function or string
     * @return string
     */
    public static function GroupEach(string $tag, $func){
        if(self::$groupEach){
            trigger_error('"groupeach" method cannot be self subbed');
        }

        self::$groupEach = $tag;
        $started = self::start();

        if(trim($tag) == '') trigger_error('parameter one cannot be an empty value');

        //render functions (within group) which in turn renders the foreach on either group or field
        $groupEach = $func();

        //close neccessary items
        self::$groupEach = '';
        self::end($started);        

        if($started and self::$render){
            print $groupEach;
        }else{
            return $groupEach;
        }

    }

    /**
     * Group a form fields
     *
     * @param string $tag wrapper tag name 
     * @param mixed $func function or string
     * @return string
     */
    public static function Group(string $tag, $func){

        //check group each
        if(self::$grouped and self::$groupEach){
            trigger_error('"Group" cannot be subbed within a "GroupEach" method');
            return false;
        }

        if($loopedTag = self::$groupEach){
            self::$skip = true;
        }

        if(self::$groupEach){ self::$grouped = true; }

        $started = self::start();

        if(empty(trim($tag))){
            trigger_error('invalid tag supplied in group');
            return false;
        }

        $string = rtrim(ltrim($tag, "<"), ">");
        $exp = explode(" ", $string, 2);
        $tag = $exp[0];
        $attributes = isset($exp[1])? ' '.$exp[1] : ''; 
        
        //get attributes in class in tag
        $attributes = self::getAttributes('group_class', $attributes);

        $opened = "<".$tag.$attributes.">";
        $closed = "</".$tag.">";
        $group = $opened.$func().$closed;
        
        //get the tag for each
        if($loopedTag){
            $group = self::renderTag($group);         
        }

        //add a group each if it exists
        self::$grouped = false;  
        self::$skip = false;
        self::end($started);

        if($started and self::$render){
            echo($group);
        }else{
            return $group;
        }
    }

    /**
     * Create a new form input field
     *
     * @param string $type type of input field
     * @param string $name name attribute value of input field
     * @param array $attrs other attributes form_class, fieldclass, addClass
     * @return string
     */
    public static function Field(string $type = 'text', string $name = '', array $attrs = []){
       
        if(!self::$model) throw new Error('Error accessing model.');

        $started = self::start();
        $args = func_get_args();

        if(self::$settings['field_class']){
            if(func_num_args() < 3){ $args[3] = []; }
            $args[3]['class'] = $args[3]['class']?? self::$settings['field_class'] ;
        }

        if(func_num_args() > 2){
            $attrs = func_get_args()[2];
            if(self::$settings['field_class']){
                $args[2]['class'] = $args[2]['class']?? self::$settings['field_class'] ;
                $args[2]['class'] .= isset($args[2]['addClass'])? ' '.$args[2]['addClass'] : '' ;
            }
        }
        
        array_unshift($args, self::$model);
        
        $newField = new FormField(...$args);
        
        //get group each
        if(self::$groupEach and !self::$skip){
            //run code block only if an each was declared on field
            $newField = self::renderTag($newField);
        }

        if($started and self::$render){
            print $newField;    
            self::end($started);
        }else{
            return $newField;
        }
       
    }

    /**
     * Add a label to a form
     *
     * @param array $attrs
     * @param string $content
     * @return string
     */
    public static function label(array $attrs = [], $content = ''){
        $attributes = '';
        foreach($attrs as $attr => $attrVal){
            $attributes .= ' '.$attr.'="'.$attrVal.'"';
        }
        return '<label '.$attributes.'>'.$content.'</label>';
    }

    /**
     * Call Methods from the Form field class if it exists
     *
     * @param string $type field type
     * @param array $args field attribute settings
     * @return string
     * @throws Error
     */
    public static function __callStatic($type, $args)
    {
        
        if(in_array(strtolower($type), self::inputs)){
            $type = strtolower($type);
            if(strpos($type,"-")){
                $type = str_replace("-",'',$type);
            }
            
            $type = ($type === 'pass')? 'password' : $type;
            $type = ($type === 'textbox')? 'textarea' : $type;    
           
            array_unshift($args, $type); 
            return self::Field(...$args);
        }
        throw new Error('undefined method "'.$type.'"');
    }
    
    /**
     * Declare the highest level of form builder call
     *
     * @return boolean
     */
    private static function start() : bool{

        //if not started, start and return true else return false
        if(!self::$start){
            return self::$start = true;
        }else{
            return false;
        }

    }

    /**
     * Close the (Highest level of) form builder call
     *
     * @param bool $close
     * @return void
     */
    private static function end(bool $close){

        //if end is called in started environment, close
        if($close){
            self::$start = false;
        }
    }

    private static function renderTag($value){

        if(!self::$groupEach) return $value;
        $tag = self::$groupEach;
        $string = rtrim(ltrim($tag, "<"), ">");
        $exp = explode(" ", $string, 2);
        $tag = $exp[0];
        $attributes = isset($exp[1])? ' '.$exp[1] : '';
        $attributes = self::getAttributes('each_class',$attributes);
        $opened = "<".$tag.$attributes.">";
        $closed = "</".$tag.">";
        
        if(is_numeric($tag)) {
            return $value;            
        }

        return $opened.$value.$closed;

    }

    private static function getAttributes($name, $attributes){
        
        $defaultClass = self::$settings[$name]?? '';

        if($attributes){

            preg_match_all('@[A-Za-z_]([A-Za-z0-9_-]+)?=(\'|")([A-Za-z-_\s0-9]+)?(\'|")@', $attributes, $matches);
            $matches = $matches[0];     

            if(!empty($matches)){
                $matches = array_map(function($value) use ($name) {
                    
                    //if class is used in tag and class exists in default scope
                    if((strpos($value, 'class="') !== false) and ($class = self::$settings[$name])){
                        $newValue = substr($value, 0, strlen($value)-1);
                        self::$usedClass = true;
                        return $newValue.' '.$class.'"';
                    }
                    return $value;
                }, $matches);

                $attributes = implode(' ',$matches);  

                if(!self::$usedClass){
                    $attributes .= $defaultClass? ' class="'.$defaultClass.'"' : '';
                    self::$usedClass = false;
                }else{
                    self::$usedClass = false;
                }
            } else {
                //if there are no matches, then add default class if it exists
                $attributes = $defaultClass? ' class="'.$defaultClass.'"' : '';
            }
            
        }else{
            $attributes = $defaultClass? ' class="'.$defaultClass.'"' : '';
        }

        return " ".trim($attributes," ");
    }


}

/* DOCUMENTATION

    Form::Field(fieldType , fieldId, array attributes)
        @param string fieldType -> type of field to be created
        @param string fieldId -> id of field to be created
        @param array attributes -> array attributes associated with current field
    
    Form::Group(tag , callback) -> groups a particular information with first parameteter
        @param string tag : container or wrapper tagname along with attributes (if any)
        @param callback : a string or callback function that should return a string data

    Form::GroupEach(tag, callback)
        groups each of 'Form::Group' or 'Form::Field' declared within it
            @param string tag : container or wrapper tagname along with attributes (if any)
            @param callback : a callback information that should return a string data
            @notice:: Form::GroupEach() cannot be used within another Form::GroupEach()

    other methods SHORTHANDS
    shorthands can be used for Form::Field(). This is done by calling the input type directly. For example

    Form::Range('id_name', ['data-attr'=>'attributes', ...]) 
       The above translates to Form::Field('range','id_name', ['data-attr'=>'attributes', ...])
       
       Fields allowed 
        [   'text', 'button','checkbox',
            'color',  'email', 'file',
            'hidden', 'image',  'number',
            'password', 'radio', 'range', 'reset',
            'search', 'submit', 'tel', 'text', 'time',
            'date',  'dateLocal', 'week', 'month', 'year',
        ]
    
    @Note : for a password field use "Pass" for static call and "password" Field method
    @Note : for a date-local field use "dateLocal" for static call and "date-local" for Field methdd

    SAMPLE STRUCTURE OF FORM

    Form::Group('div class="box form-field pxv-20"', fn() =>
        
        //wraps both fields with a single div tag along with attributes declared)    
        Form::Group('div class="i-flex-full even"', fn() =>
            Form::Text( 'firstname', ['name'=>'firstname','placeholder'=> 'firstname'] )
            .Form::Text( 'lastname', ['name'=>'lastname','placeholder'=> 'lastname'] )
        )

        //add div tag to each Form field (attributes may be supplied like above)
        .Form::GroupEach('div', fn() =>
        
            Form::Text( 'firstname', ['name'=>'firstname','placeholder'=> 'firstname'] )
            .Form::Text( 'lastname', ['name'=>'lastname','placeholder'=> 'lastname'] )
        )
        .
        Form::Button('submit', ['text' => 'Register', 'addClass' => 'btn btn-primary p-3'])

    )


*/