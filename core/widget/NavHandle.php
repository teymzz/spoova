<?php

namespace teymzz\spoova\core\widget;

/**
 * This class is used to build dynamic Navigation Bars
 */

class NavHandle{

    /**
     * Variable containing the NavEngine class
     *
     * @var NavEngine
     */
    private static $Navbar;
  
    /**
     * Initializes the NavEngine
     *
     * @param string $NavItem
     */
    function __construct(&$NavItem = ''){
      if(func_num_args() == 1){
          $NavItem = self::maincall();
      }
    }
    
    /**
     * Set the NavEnine
     *
     * @return void
     */
    private static function startBar(){
       self::$Navbar = new NavEngine;
    }
  
    /**
     * @todo Flush all keys
     *
     * @return void
     */
    public static function freeAll(){
        $variable = get_class_vars(__CLASS__);
        foreach ($variable as $key) {
            $key = null;
        } 
    }
  
    /**
     * Initializes, sets and returns the NavEngine class
     *
     * @return NavEngine
     */
    public static function maincall(){
        self::startBar();
        $call = self::$Navbar->classcall(); 
        return $call;     
    }
    
    /**
     * Sets the Navigation bar attributes only if the 
     * NavEngine has been initialized
     *
     * @param array $array
     * @return void
     */
    public static function set(array $array){
      if(self::$Navbar){
        self::$Navbar->main_attrs($array);
      } else {
        trigger_error('Navigation Engine must be initialized before set can be called');
      }
    } 
  
    /**
     * Add menu to NavHandle
     *
     * @param string $name
     * @return array|NavEngine
     */
    public static function addmenu($name){
        
        if(func_num_args() > 1){
            $nomes = func_get_args();
        }else{
            $nomes = $name;
        }

        if(is_array($nomes)){
            //test array
            
            foreach($nomes as $nom){ 
                if(empty($nom) || is_bool($nom) ||
                   is_numeric($nom) || is_array($nom))
                   {
                       return false;
                    }
                if(strpos($nom," ") !== false){
                    trigger_error('array menus cannot be initiated with spaces, use ::addmenu method instead');
                }
            }
            $name = $nomes;
        }

        
        
        if(!empty($name)&&!is_bool($name)){
            $menus = $name;
            $menus = (array) $menus;
            foreach($menus as $menu){
                self::startBar();
                $call = self::$Navbar->newmenu($menu);
                
                $calls[] = $call;
            }
            
            return (is_array($name))? $calls : $call;    
        }
    }
  
    function __call($method,$args){
        $self = new self;//$me::$Agriculture->
        if(method_exists($self::$Navbar, $method)){
            $results = call_user_func(array($self::$Navbar, $method));
            return $results;      
        }
        return trigger_error("Method does not exist!!!");
    }
  
}


/**
 *  #NavHandle (USAGE)
 *        #----------------@-{} optional
 *        #----------------@-*  required
 *        #----------------@-[-]  not done/not working
 *
 *  $NavBar  = new \core\widget\NavHandle($Nav);              #-----------------new Handle with initialized $Nav as referencing variable.
 *  //$Nav = $NavBar::maincall();        #-----------------class Call if not previously referenced.
 * 
 *  //add menu
 *  $home    = $NavBar::addmenu('home');       #-----------------new menu
 *  $profile = $NavBar::addmenu('profile');    #-----------------new menu
 *  $class   = $NavBar::addmenu('class');      #-----------------new menu
 *  
 *  $Nav->main_attrs()  #------------------- sets default attribute for container field
 * 
 *  $Nav->props() #1 ----------------same as $Nav->merge_props()) 
 *                #2---------------- overwrites all declared menu/option properties (overwrites props() method)
 *                      #2------------------ sets default properties
 *  
 *  $Nav->hide(true)        #1------------------ hide all menu
 *  $Nav->hide($menu)   #2 @param $menu [string|array] menu(s) to be hidden
 * 
 *  $Nav->show(true)        #1------------------ show all menu
 *  $Nav->show($menu)   #2 @param $menu [string|array] menu(s) to be shown
 * 
 *  $home->props(['class'=>'one']);  #1----------------- add menu properties
 *  $home->props(['id'=>'2',class'=>'two']);  #2---------overwrites all properties above
 *  $home->props('class','three blue');  #3---------overwrites class in #2 above
 *  $home->props('class','red col',['blue']);  #1---------changes blue to 'red col' in #3 above
 
 *  $home->merge_props($props) #----------------- overwrites all declared option properties (same as merge_ops())
 *  $home->option('name',['prop'=>'value',...{properties}]);       #----- set menu option *name {with properties}
 *  $home->option_merge(['name'=>"",...{properties}]); #----- merge previous option *name with new one 
 *  $home->merge_ops([]);                              #----- merge all options in menu with new properties
 *   
 *  $home->hide(true)        #1------------------ hide all home options
 *  $home->hide($option)   #2 @param $option [string|array] option(s) to be hidden
 * 
 *  $home->show(true)        #1------------------ show all option
 *  $home->show($option)   #2 @param $option [string|array] option(s) to be shown
 * 
 *  $NavMain->merge_ops([])                            #----- merge all menu options properties
 *  $NavMain->merge_ops(['name'=>""],true)             #----- [-]merge all menu options properties with specific option name
 */
/* 
    # Sample Usage
    $NavBar  = new \core\tools\NavHandle;   #--new Handle (important)
    $NavMain = $NavBar::maincall();           #--class Call (important)

    $home    = $NavBar::addmenu('home');       #--new menu
    $profile = $NavBar::addmenu('profile');    #--new menu
    $class   = $NavBar::addmenu('class');      #--new menu

    #sample modification using home menu $home
    $home->props(['home-attr'=>'bi bi-person']);        #--new menu property
    $home->option('submenu1'); #-- new menu with no property
    $home->option('submenu2',['data'=>'see','me'=>'you']    #--with property
                ); #----------------------------new menu option (submenu1)
    $home->options('submenu3',['name'=>'its']);    #--add new menu + attr
    $home->options('submenu1',['name'=>'its']);    #--add new attr into submenu1
    $home->option('submenu1',['data-iconb'=>'bid']);    #--overwrites all existing attributes in submenu1
    $home->merge_ops(['home-attr'=>'this']);            #--add attribute 'home-attr' to all options (overwrites existing 'home-attr')
    $home->merge_props(['data-ico'=>'this']);           #--same as above
    $NavMain->merge_ops(['data-icon'=>'see','me'=>'you']);  #--add attribute 'data-icon' to all menus options
    $NavMain->merge_props(['data-attr'=>'okay']);           #--add attribute 'data-attr' to all menu (don't overwrite existing 'data-attr') 
    $NavMain->merge_props(['data-attr'=>'okay'],true);      #--add attribute 'data-attr' to all menu (overwrites existing 'data-attr') 
    $home->unsetmenu(); #--------------------------------------unsets menu
    $home->inject(); #------------------------------------------adds a removed menu back as a new menu
    $NavMain->build('menu-id-here'); //build construct
    print_r($NavMain->getBuild()); //return the build data (html)
*/