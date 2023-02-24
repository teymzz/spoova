<?php

namespace spoova\core\widget;

/**
 * @abstract NavSettings
 * This class provides the settings options to @package NavHandle
 */

abstract class NavSettings{

    /**
     * Undocumented variable
     *
     * @var NavBuild
     */
    private ?NavBuild $NavBar = null;

    public string $build;

    /**
     * Settings for NavHandle
     *
     * @var array
     */
    private $navsetts = [
        'favicon' => '',
        'menu_view' => true
    ] ; 


    public function savebuild($navbar){
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
    public function settings($array = ''){
        if($array === ''){
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
     * Return the entire build data
     *
     * @param string $build
     * @param string $settings
     * @return string
     */
    public function getbuild(&$build = '',&$settings = '') : string {
        if(!isset($this->build)) return null;
        $settings = $this->navsetts;
        $build    = $this->build;
        return $build;
    }


}