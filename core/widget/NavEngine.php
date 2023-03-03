<?php

namespace teymzz\spoova\core\widget;

/**
 * This class is used to build dynamic Navigation Bars
 */
class NavEngine extends NavBuild{
    private static $menuarray = [];
    private $calledmenu;
    private static $hiddenMenus = [];
    private static $hiddenOptions = [];
    public $class;
    public $main_attrs;
 
    function __construct(){
      $variable = get_class_vars(__CLASS__);
      foreach ($variable as $key) {
         $key = null;
       } 
       return $this;
    }

    private function calledmenu(&$menu){
        if(isset($this->calledmenu)){
            if(isset(self::$menuarray[$this->calledmenu])){
                $menu = $this->calledmenu;
                return $menu;
            }
            return false;
        }
        return false;
    }

    private function getMenus(&$menus = []){
     $menuarray = self::$menuarray;    
     $menus = array_keys($menuarray);
     if(empty($menus)) return false;
     return $menus;
    } 
    
    private function getOps(&$ops,$menu = ''){
      $menuarray = self::$menuarray; 
      if($menu == '') $menu = $this->calledmenu;
      
      $ops = [];
      
      if($this->class === true || 
       ! isset($menuarray[$menu])
      ){
        return false;
      } 
      
      if(array_key_exists('options',$menuarray [$menu])){
        $ops = array_keys($menuarray[$menu]['options']);
        return $ops;
      }else{
        return false;
      } 
    } 

     
    /**
     * private menu setter
     *
     * @return void
     */
    private function setmenu(){
        if(!isset(self::$menuarray[$this->calledmenu])){
            self::$menuarray[$this->calledmenu] = array();
        }
    } 

    /**
     * sets main attributes from class scope
     *
     * @param array $array
     * @return void
     */   
    public function main_attrs(array $array){
        if(!$this->class === true) return ;
        $this->main_attrs = $array;
    }
    
    /**
     * sets a new menu
     *
     * @param string $menu this should not be called
     * @return NavEngine
     */
    public function newmenu($menu){
        if(isset($this->calledmenu)){
            return $this;            
        }
        $this->class = false;
        $this->calledmenu = $menu;
        $this->setmenu();
        return $this;
    }   

    /**
     * injects back a removed menu without its properties
     *
     * @return void|NavEngine
     */
    public function inject(){
        if(isset($this->calledmenu)){
            $this->setmenu();
            return $this;            
        }
    }
    
    /**
     * detertimes the call scope as global or specific
     *
     * @return NavEngine
     */
    public function classcall(){
      $this->class = true;
      return $this;
    }

    
    /**
     * removes a menu from the menu list
     *
     * @param string $menu
     * @return void
     */
    public function unsetmenu($menu = ''){
        if($this->class === true){
            if($menu == "*"){
                //get menus
                $menus = $this->getMenus();
                foreach($menus as $menu){
                    unset(self::$menuarray[$menu]);
                }
            }else{
                if(isset(self::$menuarray[$menu])){
                    unset(self::$menuarray[$menu]);
                }
                return;
            } 
        }
        if(isset(self::$menuarray[$this->calledmenu])){
            unset(self::$menuarray[$this->calledmenu]);
        }
    } 
    
    /**
     * Adds / Completely Overwrites attributes into selected menu parent element
     *
     * @param array|string $props
     * @return void|NavEngine
     */
    public function props($props){  
      
       if($this->class === true){
         $args = func_get_args();
         $this->merge_props(...$args);
         return $this;
       } 
      
        $argsc = func_num_args();
        
        if($argsc > 1  && isset($this->calledmenu)){
          $menu =$this->calledmenu;
          $args =func_get_args();
          $arg1 =$args[0];
          $arg2 =$args[1];
          $arg3 =($argsc > 2)? $args[2] : [];
          if(is_array($arg3)) $arg3 = '';
          $arg3 = explode(' ',$arg3);
          if(is_string($arg1)) {
              if(isset(self::$menuarray[$menu]['menuprops'][$arg1])){
                $props =  self::$menuarray[$menu]['menuprops'][$arg1];
              }else{
                $props = '';
              }
              
            
              $list = $props." ".$arg2;
              
              if($args > 2) {
                foreach($arg3 as $rmv){
                  $list = str_replace($rmv,'',$list);
                }
              } 
              
              self::$menuarray[$menu]['menuprops'][$arg1] = $list;
  
            }
          return $this;
          
        }
        
        $props = !is_array($props)? array() : $props;
        self::$menuarray[$this->calledmenu]['menuprops'] = $props;
        return $this;
    }

        
    /**
     * merging properties for all menu, two menus, or options (overwrites option attributes where necessary)
     * @param [array | string] $param1 [menu new properties | first menu property]   
     * @param [bool | string] $param2 [ menu merge strict type (bool) | 'ops': use merge_ops($param1) ]   
     * @return void|NavEngine
     *      - NavEngine is only returned if arg(#1) is an array and method is called on a global scope
     */
    public function merge_props($param1, $param2 = false){
        
        $menuarray = self::$menuarray;

        if($this->class === true){
            if($param2 === 'ops'  && is_array($param1)){
                $this->merge_ops($param1);
            } else {

                if((func_num_args() > 1) && (is_string($param1))){
                    //get properties of first and second arguments
                    $menu1 = $param1;
                    $menu2 = $param2;
                    
                    if(array_key_exists($menu1,self::$menuarray) and array_key_exists($menu2,self::$menuarray)){
                        $menuprops1 = isset($menuarray[$menu1]['menuprops'])? $menuarray[$menu1]['menuprops'] : [];
                        $menuprops2 = isset($menuarray[$menu2]['menuprops'])? $menuarray[$menu2]['menuprops'] : [];

                        $merge = array_merge($menuprops1,$menuprops2);

                        if(!empty($merge)){
                            //update data:
                            self::$menuarray[$menu1]['menuprops'] = $merge;
                        }

                    }
                    return ;
                }

                if(is_array($param1) && !empty($param1)){
                    $props = $param1;

                    //remove serial indices
                    foreach($props as $key => $value){
                        if(is_integer($key)){
                            unset($props[$key]);
                        }
                    }
                    
                    //merge the menu properties strict @param2 = true;
                    if($param2 === true){
                        foreach($menuarray as $menu => $values){
                            $prev = (isset($values['menuprops']))? $values['menuprops'] : [];
                            $merge = array_merge($prev,$props);
                            self::$menuarray[$menu]['menuprops'] = $merge;
                        }       
                        return;             
                    }

                    //merge the menu properties non-strict @param2 = fasle;
                    if($param2 === false){
                        foreach($menuarray as $menu => $values){
                            $prev = (isset($values['menuprops']))? $values['menuprops'] : [];

                            foreach($props as $newprop => $propval){
                                if(isset($prev[$newprop])){
                                    if($prev[$newprop] !==''){
                                        continue;
                                    }
                                }
                                $prev[$newprop] = $propval;
                            }
                            self::$menuarray[$menu]['menuprops'] = $prev;
                        }  
                        return;                  
                    }                 
                }

                

            }           
 
        } else {
            if(is_array($param1)){
               return $this->merge_ops($param1);
            }
        }

    }

    /**
     * Adds attributes to existing or new option's attributes
     *
     * @param string $name name of new or existing option
     * @param array $props attributes and values
     * @return NavEngine
     */
    public function options(string $name,$props=[]){

        if($this->class === true) return false;
        
        $this->getOps($options);
        if(!isset($options[$name])){
            $previous = array();
        }
        $previous = isset($previous)? $previous : $options[$name]; 
 
        self::$menuarray[$this->calledmenu]['options'][$name] = array_merge($previous,$props);
 
        return $this;
    }  
     
    /**
     * modifies an option of a selected menu or all menu (*) 
     * @param array $select [option => attr] 
     * @param string $attr selected attribute(s)
     * @param string $replacement subtitutes
     * @return NavEngine
     */
    public function modify(array $select, string $attrs, $replacement = ""){
        if($this->class=== true) return false;
        //if(!is_string($attr)) die('parameter 2 must be a string');
        $calledmenu = $this->calledmenu;
        $menuarray = self::$menuarray;
       
        $this->getMenus($menus); //get menus
        $ops = $this->getOps($options); //options
       
        [$option, $attr]= $select; //selectors
       
        if($option === "*"){
            $option = $options;
        } else {
            $option = (array) $option;
        } 

        foreach ($option as $opt){

            //option exists, check attribute next
            
            //get option data from menuarray
            $opsdata = $menuarray[$calledmenu]['options'][$opt];
            
            if(!is_array($opsdata)) return $this; 
            
            if(array_key_exists($attr,$opsdata)){
                $optAttrVal = $opsdata[$attr];
            } 

            if(empty($optAttrVal)){
                $optAttrVal = "";
            } 
            
            //modify data now
            $olds = explode(' ',$attrs);//strings to be replaced 
            
            $newattrs = str_replace($olds,'',$optAttrVal); //replace old arrays in values

            $newattrs .= " ".$replacement; 
            
            
            self::$menuarray[$calledmenu]['options'][$opt][$attr] = $newattrs;

        } 

        return $this;
    }
    
    /**
     * Adds a new option to selected menu
     *
     * @param string $name name of option
     * @param [string | array] $props option parent attributes
     * @return NavEngine
     */
    public function option($name,$props=null){
        if(empty($name)){ return $this; }
        if($props === false){
            if(isset(self::$menuarray[$this->calledmenu]['options'][$name])){ 
            unset(self::$menuarray[$this->calledmenu]['options'][$name]);
            self::$menuarray = self::$menuarray; return $this;
            }
            
        }else{
            if(is_array($name)){ trigger_error('invalid array supplied'); return $this; }
            self::$menuarray[$this->calledmenu]['options'][$name] = $props;
        }

        return $this;            
    } 

    /**
     * merges all option attributes for all menu options (global call)
     * merges all option attributes for specified option (specific call)
     * @param array $props new / overwriting properties
     * @return NavEngine
     */
    public function merge_ops(array $props){
        $menuarray = self::$menuarray;
        if($this->class === true){
            //filter out properties;
            foreach($props as $key => $value){
                if(is_integer($key)){
                    unset($props[$key]);
                }
            }
            foreach ($menuarray as $menu => $menuvalues) {
                if(isset($menuvalues['options'])){
                    foreach ($menuvalues['options'] as $menuoptions => $optionattrs) {
                        $oldprops = self::$menuarray[$menu]['options'][$menuoptions];
                        if (!is_array($oldprops)) self::$menuarray[$menu]['options'][$menuoptions] = [];
                        self::$menuarray[$menu]['options'][$menuoptions] = array_merge(self::$menuarray[$menu]['options'][$menuoptions],$props);
                    }  
                }
            }
 
        }else{

            $mcalled = self::$menuarray[$this->calledmenu];   
            if(!isset($mcalled['options'])){
                $mcalled['options'] = array();
            }

            foreach ($mcalled['options'] as $menuoption => $optionattrs) {

              $prev = $optionattrs; //$mcalled['options'][$menuoption];
              if (!is_array($prev)) $prev = [];

              self::$menuarray[$this->calledmenu]['options'][$menuoption] = array_merge($prev,$props);    

            }

        } 
        return $this;
    }

    /**
     * This is used to hide menu items or menu options
     * 
     *  - Hides a defined navigation menu from global call (NavHandle).
     *  - Hides a defined menu option from menu specific call.
     * 
     * @param array|bool|string $list
     * @return NavEngine
     */
    public function hide($list){
      if(!is_array(self::$menuarray)) return $this;
      
        $menuarray = self::$menuarray;

        if($this->class === true){
            
            //get all menus
            if($list === true){
              $this->getMenus($lists);
            }else{
                $lists = (array) $list;
            }
            
            foreach($lists as $list){
                if(isset($menuarray[$list])){
                    self::$hiddenMenus[] = $list;
                }                
            }          
        }elseif($this->calledmenu($menu)){
            //get all menu options
            if($list === true){
               $this->getOps($lists);
            }else{
               $lists = (array) $list;
            }
            
            if($this->getOps($options)){
                
              foreach($lists as $list){
                
                self::$hiddenOptions[$menu][] = $list;
           
              } 

            } 
            
        }
        return $this;
    }

    /**
     * shows a defined hidden navigation menu from global call
     * shows a defined hidden menu option from specific
     * 
     * @param [array | string] $list
     * @return NavEngine
     */
    public function show($list){
        if($this->class === true){

            //remove menu from global scope

            if($list === true){
                self::$hiddenMenus = [];
                return $this;
            }

            $lists = (array) $list;
            foreach($lists as $list){

                if(isset(self::$menuarray[$list])){
                    if(($key = array_search($list,self::$hiddenMenus)) !== false){
                        unset(self::$hiddenMenus[$key]);
                    }
                }                
            }          
        }elseif($this->calledmenu($menu)){

            //remove menu from specific scope $menu

            if($list === true){
                self::$hiddenMenus = [];
                return $this;
            }

            $lists = (array) $list;
            if(isset(self::$hiddenOptions[$menu])){
                foreach($lists as $list){
                    if(($key = array_search($list,self::$hiddenOptions[$menu])) !== false){
                        unset(self::$hiddenOptions[$menu][$key]);
                    }                                
                }                 
            }
             
        }

      return $this;
    } 

    /**
     * Returns or Displays the current menu array data
     *
     * @param boolean $view - true sets prints out the array
     * @return array
     */
    public function view(bool $view = false){
        
        if($view) print_r (self::$menuarray);

        return (self::$menuarray);
        
    }
 
    /**
     * Return a 
     *
     * @param string $id
     * @param array $main_attrs
     * @return NavEngine
     */
    public function build(string $id = 'menu-box', array $main_attrs = []){
        
        //$main_attrs = other attributes
        $omain_attrs = $this->main_attrs ?? [];

        $newmerge = array_merge($omain_attrs,$main_attrs);

        //get the dropdown open icon
        if(isset($newmerge['drop-down-open'])){
            $dropdownopen = $newmerge['drop-down-open'];
            unset($newmerge['drop-down-open']);
        }else{
            $dropdownopen = "bi-chevron-down";
        }  

        //get the dropdown close icon
        if(isset($newmerge['drop-down-close'])){
            $dropdownclose = $newmerge['drop-down-close'];
            unset($newmerge['drop-down-close']);
        }else{
            $dropdownclose = "bi-chevron-right";
        }         

        //get the dropdown icon
        if(isset($newmerge['drop-down-icon'])){
            $dropdown = $newmerge['drop-down-icon'];
            unset($newmerge['drop-down-icon']);
        }else{
            $dropdown = "bi-chevron-down";
        }  

        if(($dropdownopen == $dropdownclose) && $dropdownclose ==''){
            $dropdownopen = $dropdownclose = $dropdown;
        }

        //get the dropdown postion
        if(isset($newmerge['drop-down-pos'])){
            $dropdownpos = $newmerge['drop-down-pos'];
            unset($newmerge['drop-down-pos']);
        }else{
            $dropdownpos = "right";
        }        
        
        //filter out empty properties && build data
        $listattrs = '';
        foreach($newmerge as $listProps => $listProp){
            if(!is_array($listProp) && $listProp != '' && $listProps !== 'id'){
                $listattrs .= ' '.$listProps.'="'.$listProp.'"';
            }
        }

        

        $navaLI = '<ul id="'.$id.'"'.$listattrs.' data-nav="webron">';
        
        foreach (self::$menuarray as $key => $value) {

            if(in_array($key,self::$hiddenMenus)){ continue; }
            $navmenu = "";
            $menuprops = MyIsset($value['menuprops']);
            $menuclass = $this->removefilters($menuprops,"class2");
            $menulink  = $this->removefilters($menuprops,"link");
        
            $linkAttrs = $this->removefilters($menuprops,"linkAttrs");
                
            $linkClass = $this->removefilters($linkAttrs,"linkClass");
        
                    
            $options   = isset(self::$menuarray[$key]['options'])? MyIsset(self::$menuarray[$key]['options']) : array();
            
            if(isset(self::$hiddenOptions[$key])){
                $hiddenOptions = self::$hiddenOptions[$key];
                if(count($hiddenOptions) > 1){
                    if(count($hiddenOptions) === count(array_keys($options))){
                        $dropdown = $dropdownclose;
                    }
                }                
            }    

            $menuicon  = $this->removefilters($menuprops,"icon");
            $navangle = isset(self::$menuarray[$key]['options'])? "<span class='".$dropdown." arrow mtp4' style=''></span>" : "";
            
            $menuicon  = ($menuicon != null)? " <span class='".$menuicon."'></span>" : '';
        
            $menuattrs = $this->split_attributes($menuprops);
            $linkattrs = $this->split_attributes($linkAttrs);
            
            //$navmenu   .= " <li".$menuattrs."> ";   //first li
            $navmenu   .= ($menulink != null)? "<li ".$menuattrs."><a href='".$menulink."' class=' c-i h-i wid-full ".$linkClass."' ".$linkattrs.">" :"<li ".$menuattrs.">";
            $navmenu   .= ($menuicon !='')? $menuicon : ''; //icon 
            //$dropdownpos = "left";
            if($dropdownpos == 'left' && $menuicon == ''){
                $navmenu .= " ".$navangle;
                $droprite = '';
            }else{
                $navmenu = " ".$navmenu;
                $droprite = $navangle;
            }
        
            $menuname   = " <span class='$menuclass'> ".$key." ".$droprite." </span> "; //icon
            $navmenu   .=  $menuname;

            $i = 0;
            foreach($options as $option => $option_value){
              
                if(isset(self::$hiddenOptions[$key])){
                    if(in_array($option,self::$hiddenOptions[$key])){
                       continue;
                    }
                }
                
                $rootprops = "";
                if(array_key_exists(':child', self::$menuarray[$key])){
                  
                  $rootprops  = self::$menuarray[$key][':child'];
                  $rootprops = $this->split_attributes($rootprops);

                } 

                
                $navoption   = '';      
                $optionprops = $option;
                $optionclass = $this->removefilters($option_value,"class2");
                $optionlink  = $this->removefilters($option_value,"link");
                $optionicon  = $this->removefilters($option_value,"icon");
                ($optionlink != null)? str_replace($navoption,"<a href='".$optionlink."'>".$navoption."</a>", $navoption) : $navoption;
                $optionicon  = ($optionicon != null)? " <span class='".$optionicon."'></span> " : "";
        
                $optionattrs = $this->split_attributes($option_value); 
                
                //--open     
                $navoption  .= ($i == 0)? "<ul $rootprops>" : "";
                //$navoption  .= ($optionlink != null)? "<li".$optionattrs." class='$optionclass' ><a href='".$optionlink."' class='c-i h-i wid-full '>" :"<li>";
                $itemprops = $optionattrs." class='$optionclass'";
                $linkprops = $liprops = $itemprops;
                if ($optionlink != null) $liprops = '';
                
                if($optionlink != ''){
                  $linkprops = $optionattrs;
                  if(strpos($linkprops, "class='")!== false){
                    $linkprops = str_replace("class='","class='c-i h-i d-i $optionclass",$optionattrs);
                  }else{
                    $linkprops .= " class=' $optionclass' ";
                  } 
                  
                  $itemprops = '';
                }else{
                  $linkprops .= " class='c-i h-i wid-full' ";
                  $itemprops = $optionattrs;
                } 
                
                $navoption  .= "<li".$itemprops. ">";
                $navoption  .= ($optionlink != null)? "<a href='".$optionlink."' $linkprops>" : "";
                $navoption  .= $optionicon; //icon
                $navoption  .= " <span>".$option."</span>"; //icon
                $navoption  .= ($optionlink != null)? "</a>" : "";               
                $navoption  .= "</li>";
                //$navoption  .= ($optionlink != null)? "</a></li>" :"</li>";          
                $navoption  .= ($i+1 == count($options))? "</ul>" : "";  
                //--close 
        
                $navmenu    .= $navoption;
                $i++;
            }
            $navmenu  .= ($menulink != null)? "</a></li>" :"</li>"; 
            $navaLI  .= $navmenu;
        } 
        $navaLI .= "</ul>";
        $this->build = $navaLI;
        return $this;
    }

    /**
     * Replaces the attributes' value of a menu element
     *
     * @param array|String[] $data
     * @return void|bool|Engine
     *     - If called on class void is returned
     *     - If menu upon which this is called is null, bool:false is returned
     *     - If menu upon which this is called is already exists, NavEngine is returned
     */
    public function child($data){

      if($this->class === true) return;

      $cmenu = $this->calledmenu;
      $menuarray = self::$menuarray;
      $argsc  = func_num_args();
      
      
      if($this->menuExists()){

        //get child properties
        $cdata = $menuarray[$cmenu]; //old props
        $cdata = is_array($cdata)? $cdata: [];
        
        if(array_key_exists(':child', $cdata)){
          $childattrs = $cdata[':child'];
        } else {
          $childattrs = [];
        } 

        //process array supplied
        if(($argsc > 1)) {
          //validate contents
          $data = func_get_args();
          
          foreach ($data as $ndata){
            if(is_array($ndata)) return false;
          } 
        }      

        if($argsc > 1){

          $searches = explode(' ', $data[1]);
          $attr = $data[0];
        
          if($argsc == 2){
              //@param == 2, store each attributes with thier values
            self::$menuarray[$cmenu][':child'][$attr] = $data[1];
          }else{

            //$param > 2 process the replacements
            $replacement = $data[2];
            
            if(is_array($replacement)){
              die("parameter 3 cannot be an array");
              return $this;
            }
            
            if(array_key_exists($attr,$childattrs)){
              $attrvals = $childattrs[$attr];
              
            }else{
              $attrvals = "" ;
            }     

            
            foreach ($searches as $search){
              $attrvals = str_replace($search, '', $attrvals);
            }
            
            $attrvals .= " ".$replacement;
            
            self::$menuarray[$cmenu][':child'][$attr] = $attrvals;
            
          }
          
        }
        return $this;
      } 

      //check if menu exists
      if(!array_key_exists($cmenu, $menuarray)) return false;

      //get previous properties       
      $menuarray[$cmenu][':child'] = $data;
      
    }
    
    /**
     * Checks if a menu exists
     *
     * @param boolean $menu
     * @return boolean
     *  If called on class and $menu set as true bool of false is returned
     */
    public function menuExists($menu = true){
      if($menu === true){
        if($this->class === true) return false;
        $menu = $this->calledmenu;
      } 
      
      $menuarray = self::$menuarray;
      
      if(array_key_exists($menu, $menuarray))
        return true;
      
      return false;
    } 
 
    public function declarebuild(){

        // please switch this method name with getbuild later;
        if(isset($this->build)){
            return $this->build ;       
        }
 
    }
 
    private function removefilters(&$array,$filter){

        if(!isset($array[$filter])) return false; 

        $value = $array[$filter];
        unset($array[$filter]);
        $array = $array;
        return $value;
    }

    private function split_attributes($value){
        if(!is_array($value)) return false;
        $props = "";
        foreach ($value as $key => $value) {
            $props .= " ".$key."='".$value."' ";
        }
 
        return $props;
    }
 
}

/* Documentation in NavHandle class */
