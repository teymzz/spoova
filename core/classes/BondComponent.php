<?php 

namespace spoova\mi\core\classes;

use DOMDocument;
use DOMElement;
use DOMXPath;
use ReflectionClass;
use ReflectionProperty;

abstract class BondComponent{ 

    private static $body = '';
    private static $bondAjax = [];
    private static BondComponent $instance;
    protected $bondID;

    function __construct() {}

    /**
     * Render components
     *
     * @param string|null $url
     * @param \Closure|false $url
     * @return Compiler|String A compile string or Compiler item.
     * 
     *    - Note: A rendered string should not be returned
     */
    public function render(): Compiler | String {
        return '';
    }

    final public function content() {
       return self::$body;
    }

    /**
     * Resolve bond
     *
     * @param string $space Bond controller space within windows\Bond environment
     * @param array $args
     * @return string
     */
    final public function resolve($space, array $args = []) : string {
        static $id = 0; $id++;
        $namespace = to_frontslash('windows.Bonds.'.$space, true);
        $bondClass = scheme($namespace);

        $bondClass = "\\".to_backslash(url($bondClass)->pathmod(fn($x) => ucfirst($x), -1));

        if(appExists($namespace)) {

            ///instantiate bond class
            $container = new Container($bondClass, [1]);
            $container->setBond($id);
            $container->mount();

            //set class instance
            self::$instance = $instance =  ContainerClass::getClass();

            //get class public properties 
            $props = $instance->bondProperties($instance);

            $assigned = [];

            //overwrite properties if not initially set
            foreach($props as $bondVar => $bondVal) {

                if(!isset($instance->$bondVar)){
                    if(isset($args[$bondVar])){
                        $assigned[$bondVar] = $instance->$bondVar = $args[$bondVar];
                    }
                }else{
                    $assigned[$bondVar] = $instance->$bondVar;
                }

            }
 
            //overide bond directive arguments with assigned properties
            $newargs = $assigned;

            $this->bindAjax($instance, $id, $newargs);

            $content = $container->render();

            if($content instanceof Compiler){

                $content->setBase(to_frontslash('_bonds/'.$space, true));
                $content->setArgs($newargs);
                $content = $content->body($content->raw());
                $content = (string) $content;

            }else{

                $Compiler = new Compiler;
                $Compiler->setBase(to_frontslash('_bonds/'.$space, true));
                $Compiler->setArgs($newargs);
                $Compiler->body($content);
                $content = (string) $Compiler;
                
            }

            //load content element
            $dom =  new DOMDocument();
            $dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            
            $dompath = new DOMXPath($dom);
            $root = $dompath->query('//*'); 
            $rootItem = $root->item(0);
                //$rootTag  = $rootItem->tagName;

            if($rootItem){
                if($rootItem instanceof DOMElement){
                    $attributes = [
                        'bond-root' => $id,
                    ];

                    foreach($attributes as $attr => $val) {
                        $rootItem->setAttribute($attr, $val); 
                    }

                    $forms = $dompath->query('//input|//textarea|//select');

                    $bondArgs = ($this->bondArguments('data'));

                    if($bondArgs){
            
                        $counter = 0;
                        foreach($forms as $form){
                            if(strtolower($form->tagName) === 'textarea'){
                                $form->textContent = $bondArgs[$counter]['value'];
                            }else{
                                $form->setAttribute('value', $bondArgs[$counter]['value']);
                            }
                            $counter++;
                            // print_r($form);
                        }

                        //select all csrf tokens
                        $csrFields = $dompath->query('//input[@type="hidden"][@name="CSRF_TOKEN"]');

                        foreach ($csrFields as $csrfField) {
                            $csrfField->setAttribute('value', Csrf::old());
                        }

                    }


                    $content = $dom->saveHTML();   
                }
                
            }

            return $this::bondSlice($content);

        } else {

            EInfo::view('Bond class "'.$bondClass.'" missing');

        }

        return '';

    }

    final public function setBond(bool $id){
        $this->bondID = $id;
    }

    /**
     * Returns the id of the bond root element
     *
     * @return int
     */
    final public function bondID(){
       return $this->bondID;
    }

    /**
     * Returns the value of a specified bond data key
     *
     * @param string $key
     * @return array
     */
    final public function bondArguments($key) : array {

        return self::$bondAjax[$key] ?? [];

    }

    private function bindAjax(Bond $class, $id, &$args) {
        
        $bondName = 'bondJS';

        $cookie = $_COOKIE[$bondName] ?? [];

        $fulldata = (json_decode($cookie,true));
        
        $data = $fulldata[$class->bondID()] ?? [];

        if(Ajax::isAjax()){

            $post = $_POST;

            $action = $_POST['postdata'] ?? '[]';
            $action = json_decode($action, true) ?? [];
            // $_POST = $action;    

            $bondData = $post['data'] ?? '[]';
            $bondData = json_decode($bondData, true) ?? [];
            self::$bondAjax['data'] = $bondData;

            self::$bondAjax['action'] = $action['action'] ?? '';

            $method = $post['call'];

            foreach($data as $oldprop => $val) {
                $class->$oldprop = $val;
            }

            $class->$method();

            $props = $class->bondProperties($class);

            foreach($props as $prop => $value) {
                $data[$prop] = $class->$prop;
            }
            
            $fulldata[$class->bondID()] = $args = $data;

            setcookie($bondName, json_encode($fulldata), [
                "secure" => true,
                'samesite' => "None",
                'httponly' => true,
            ]);

        } else {

            setcookie($bondName, '[]', [
                'expires' => -36000,
                'secure'  => true,
                'samesite' => "None"
            ]);

        }

    }

    private static function bondSlice($body) : string{


            $body = str_replace(

                [
                    "bond:click=",
                    "bond:click",
                    "bond:load=", 
                    "bond:load", 
                    "bond:mouseover=", 
                    "bond:mouseover", 
                    "bond:keypress=",
                    "bond:keypress",
                    "bond:action="
                ],
                [
                "bond-event=\"click\" bind=",
                "bond-event=\"click\"",
                "bond-event=\"load\" bind=", 
                "bond-event=\"load\"", 
                "bond-event=\"mouseover\" bind=", 
                "bond-event=\"mouseover\"", 
                "bond-event=\"keypress\" bind=",
                "bond-event=\"keypress\"",
                "bond-action="
                ],

                $body

            );

            $body = str_replace(

                [
                    "bond:id=",
                    "bond:model=",
                ],
                [
                "rex-id=",
                "rex-model=",
                ],

                $body

            ); 

            return $body;
    }

    /**
     * Return only public properties of a class
     *
     * @param object $class
     * @return array
     */
    final public function bondProperties(object $class) : array {

        $vars = get_class_vars($class::class);

        $rc = new ReflectionClass($class);
        $propLists = $rc->getProperties(ReflectionProperty::IS_PUBLIC);
        $props = [];
        foreach($propLists as $propList){
            $props[] = $propList->getName();
        }
        
        $publics = (array_intersect_key($vars, array_flip($props)));

        return $publics;

    }

    final static public function postdata() : array {
        return fromJson((new Request())->prompt('postdata')) ?? [];
    }

}

