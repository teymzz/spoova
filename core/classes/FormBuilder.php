<?php

namespace spoova\mi\core\classes;

use Error;
use Form;
use spoova\mi\core\classes\Model;
use spoova\mi\core\classes\FormField;

class FormBuilder extends FormField{

    
    private const inputs = [
        'text', 'textarea', 'textbox', 'hidden', 'email', 'file', 
        'pass', 'password', 'number', 'tel', 'url', 'range', 'date', 
        'dateLocal', 'week', 'month', 'year', 'image', 'color', 
        'checkbox', 'radio', 'search', 'submit', 'button'
    ];

    protected static ?Model $model = null;

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
        'field_class' => '' //applied on input field
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
    protected static $indexed = '';
    private static bool $start = false;
    private static bool $usedClass = false;

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
     * @param string|null $form referenced variable
     * @param string $method request method
     * @param string $action form action
     * @return string
     */
    public static function open(?string &$form = null, $method = 'post', $action = '') {
        $action = $action? ' action="'.$action.'"' : '';
        $method = $method? ' method="'.$method.'"' : '';
        $class  = self::$settings['form_class']? ' class="'.self::$settings['form_class'].'"' : '';
        $form = new Form();
        return "<form{$action}{$method}{$class}>"; 
    }

    /**
     * Start a new Form with enabled display
     *
     * @param string|null $form referenced variable
     * @param string $method request method
     * @param string $action form action
     * @return void
     */
    public static function init(?string &$form = null, $method = 'post', $action = '') {
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
     * @param string $action value for form action attribute
     * @return string
     */
    public static function post($Form, string $action = ''){
        $action  = self::$indexed? DomUrl(self::$indexed) : '';
        $Form = '<form method="POST" action="'.$action.'">'.$Form.'</form>';
        if(self::$render) print $Form;
        return $Form;
    }

    /**
     * Create a Form with a form wrapper of GET method
     *
     * @param string $Form
     * @param string $action value for form action attribute
     * @return string
     */
    public static function get($Form, $action = ''){
        $action  = self::$indexed? DomUrl(self::$indexed) : '';
        $Form = '<form method="GET" action="'.$action.'">'.$Form.'</form>';
        if(self::$render) print $Form;
        return $Form;
    }

    /**
     * Group each form field
     *
     * @param string $tag wrapper tag name for each field 
     * @param mixed $func function or string
     * @return string
     */
    public static function groupEach(string $tag, $func){
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
    public static function group(string $tag, $func){

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

        if(!trim($attributes)) $attributes = '';

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
    public static function field(string $type = 'text', string $name = '', array $attrs = []){
       
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
    public static function label(array $attrs = [], string $content = ''){
        $attributes = '';
        foreach($attrs as $attr => $attrVal){
            $attributes .= ' '.$attr.'="'.$attrVal.'"';
        }
        return '<label'.$attributes.'>'.$content.'</label>';
    }

    /**
     * Call methods from the Form Field class if it exists
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

    private static function renderTag(string $value){

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

    private static function getAttributes(string $name, string $attributes){
        
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