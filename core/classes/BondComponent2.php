<?php 

namespace spoova\mi\core\classes;

use Res;
use spoova\mi\windows\Routes\Home;

abstract class BondComponent{ 

    private static $body = '';
    private static BondComponent $instance;

    final function __construct(){}

    /**
     * Slices a rex template
     *
     * @param string $body
     * @return string sliced body
     */
    final function slice(string $body, array $args = []) : string
    {

        $data = self::bondedData();
// print 'me';
        if(Ajax::isAjax()){        

            $bond = $_POST['bond'] ?? '';
            $call = $_POST['call'] ?? '';
            $class =  scheme('windows/Bonds/'.$bond);

            if(method_exists($class, $call)){

                $class = (new Container($class)); 
                $bclass = $class->getClass();                
                
                foreach($args as $arg => $val) {

                    if(property_exists($bclass, $arg)) {
                        $bclass->$arg = $val;
                    }

                }

                //get public props
                $props = get_object_vars($bclass);

                Slicer::addlocals($props);

                //print_r($props);

                print $call;

                $class->{$call}();

                $item = $class->render();

                if(is_string($item)) {
                    return Slicer::slice($item, true);
                } else {
                    return $item;
                }

            }
            exit;
        } else {
    

        }

        return $body;

    }

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
        
        $namespace = to_frontslash('windows.Bonds.'.$space, true);
        $bondClass = scheme($namespace);

        $bondClass = "\\".to_backslash(url($bondClass)->pathmod(fn($x) => ucfirst($x), -1));

        if(appExists($namespace)) {

            ///instantiate bond class
            $container = new Container($bondClass);
            $container->mount();

            //set class instance
            self::$instance = $instance =  ContainerClass::getClass();

            //get class properties 
            $props = get_class_vars($bondClass::class);

            $newargs = array_merge($args, $props);

            //Slicer::addlocals($props);

            //slice the body
            // if(!Ajax::isAjax()) {

                $content = $container->render();

                if($content instanceof Compiler){

                    $content->setBase(to_frontslash('_bonds/'.$space, true));
                    $content->setArgs($newargs);
                    $content = $content->body($content->raw());

                }else{

                    $Compiler = new Compiler;
                    $Compiler->setBase(to_frontslash('_bonds/'.$space, true));
                    $Compiler->setArgs($newargs);
                    $Compiler->body($content);
                    $content = (string) $Compiler;

                }

                if(Ajax::isAjax()) {
                    $Request = new Request;
                   
                    if($Request->has(['state','bond','event','call'])) {
                        $container->{$Request->auth(false)->data('call')}();
                    }
                }

               return $this::bondSlice($content);

            // }

        } else {

            EInfo::view('Bond class "'.$bondClass.'" missing');

        }

        return '';

    }

    private static function bondSlice($body) : string{

            $filename = basename(to_frontslash(get_class(self::$instance)));
            $body = str_replace(

                [
                    "bond:click=",
                    "bond:load=", 
                    "bond:mouseover=", 
                    "bond:keypress="
                ],
                [
                "rex-url=\"$filename\" rex-event=\"click\" rex-bond=",
                "rex-url=\"$filename\" rex-event=\"load\" rex-bond=", 
                "rex-url=\"$filename\" rex-event=\"mouseover\" rex-bond=", 
                "rex-url=\"$filename\" rex-event=\"keypress\" rex-bond="
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

    private static function bondAjax(){

    }

    private static function bondedData() : array {
        if(Ajax::isAjax()){        

            $bond = $_POST['bond'] ?? '';
            $call = $_POST['call'] ?? '';
            $class = scheme('windows/Bond/'.$bond);

            $data['bond']  = $bond; //name
            $data['call']  = $call; //method
            $data['class'] = $class; //namespace

        }

        return $data?? [];
    }

}

