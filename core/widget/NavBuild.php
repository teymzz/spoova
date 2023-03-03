<?php

namespace spoova\core\widget;

/**
 * @abstract NavBuild
 * This class compiles the NavHandle and NavEngine classes
 */
abstract class NavBuild{

    /**
     * NavBuild Container Variable
     *
     * @var NavBuild
     */
    private $NavBar;

    public $build;

    protected $navsetts = [
        'options_view' => true,
    ] ;  //settings of nav

    /**
     * Save data from the current NavBuild      
     *
     * @param NavBuild $navbar
     * @return void
     */
    public function savebuild(NavBuild $navbar){
      $this->NavBar = $navbar;      
    }

    /**
     * Add to / Return previous settings  
     *
     * @param string $array
     * @return array|bool|NavBuild
     *      - If $array is array NavBuild is returned
     *      - If $array is Null array or previous settings irs returned
     *      - If $array is not of valid type array or null, bool of false is returned
     */
    public function settings(array $array = null){
        if($array === null){
            return $this->navsetts;
        }
        if(!is_array($array)){ 
            return false; 
        }
        foreach($array as $properties=>$value){
            $this->navsetts[$properties] = $value;
        }
        return $this;
    }

    /**
     * Returns a string of navbar
     *
     * @param string $build
     * @param string $settings
     * @return string|bool
     *   - Bool:false is returned if no build is set.
     */
    public function getBuild(&$build = '',&$settings = ''){
        if(!isset($this->build)) {
            if(method_exists($this,'build')){
                $this->build();
            }else{
                return false;
            }
        }
            
        $settings = $this->navsetts;
        $build    = $this->build;
        return $build;
    }

    abstract public function build(string $id = 'menu-box', array $main_attrs = []);

}