<?php 

namespace spoova\mi\core\tools;

use Closure;
use Traversable;
use ReflectionClass;
use ReflectionMethod;
use ReflectionFunction;
use ReflectionProperty;
use spoova\mi\core\tools\Inspector\InspectorChroma;
use spoova\mi\core\tools\Inspector\InspectorBridge;

/**
 * This class is designed for listing the content of a given value.
 * In Cli, this class will return responses similar to the PHP var_dump() function.
 */
class Inspector extends InspectorBridge{


    private static bool $unlocked = false ;
    private static string $theme = 'dracula' ;

    /**
     * Defines the data types to be automatically expanded
     *
     * @var array
     */
    private static array $expanded = [] ;

    public static  function unmask(bool|Closure $callback = true){
        if($callback instanceof Closure){
            self::$unlocked = true;
            $callback();
            self::$unlocked = false;
        }else{
            self::$unlocked = $callback;
        }
    }

    /** 
     * Set data types to be automatically expanded.
     *
     * @param array|string $data data types to be expanded 
     *  - Closures will include data type to the default data types
     * @param integer $level optional [1|2] sets the expansion level 
     *  - When set as 1, only the first level is expanded
     *  - When set as 2, all levels are expanded
     * @return void
     */
    public static function expand(array|string|Closure $data = ['int','str','boo','dou','null'], int $level = 1){
        $default = ['int','str','boo','dou','null'];
        if($data instanceof Closure){
            $data = $data();
            if(!is_object($data)) {
                $data = (array) ($data);
                $data = array_merge($default, $data);
            }
        }
        self::$expanded = (array) $data;
    }

    /**
     * Inspect one or more values
     *
     * @param mixed[] $data
     * @return void
     */
    public static function inspect($data) : void {
        echo self::transmit($data);
    }

    /**
     * Inspect one or more values
     *
     * @param mixed[] $data
     * @return void
     */
    public static function transmit($data) {

        if(isCli()){
            var_dump(func_get_args());
            die();
        }

        InspectorBridge::keyLen(80);
        $args = func_get_args();
        $list = '';

        foreach($args as $value){
    
            $traversable = ($value instanceof Traversable)? ' (Traversable)' : '';
            $type = $vtype = (gettype($value));
            if($type === 'array'){
                $type = "Data [$type$traversable]";
                $reel = self::dataArray($value);
            }elseif($type === 'object'){
                $type = "Data [".basename(to_dirslash($value::class))."]";
                $reel = self::dataObject($value);
            }else{
                $dataType = gettype($value);
                $type = "Data [".$dataType."]";
                $open = 'open';
                $reel = self::dataDump($value);
            }
            $open = (in_array(substr($vtype, 0, 3), self::$expanded) || in_array($vtype, self::$expanded)) ? 'open' : '';
            $list .= "<details :inspect='$vtype' $open><summary>$type</summary><div class='inspection-field main'>";
            $list .= ($reel);
            $list .= "</div></details>";
        }
            
        $list = self::style(__FUNCTION__) . $list;

        return $list;
    }

    private static function dataDump(string|int|float|bool|null $data){
        
        $type = gettype($data); //⦿
        if($type === 'string') {
            $info = '[string:'.strlen($data).']';
            $data = htmlentities($data);
        }elseif($type === 'boolean'){
            $info = '[bool]';
            $data = $data ? 'true' : 'false';
        }elseif($type === 'NULL'){
            $info = '[bool]';
            $data = 'NULL';
        }elseif($type === 'integer'){
            $info = '[integer:'.strlen($data).']';
        }else{
            $info = '['.$type.']';
        }

        $reel = "<div class='flex-grid'><span class='item-key flex' style='align-items: center;'>→ </span> <div class='flex-col item-val mvs-1 flex-l'><span><div class='item-info'>$info</div></span><span class='item-type item-$type pxv-4'><span class='item-btn'>{$data}</span> </span></div></div>";
        return $reel;
    }

    private static function dataArray($data){
        
        $reel = self::arrayInspection($data, function($call){
                    return self::dataObject($call);
                });
        return $reel;
    }

    private static function arrayInspection($data, callable|null $callback = null){

        if(!$callback) {
            $callback = fn() => '';
        }
        $result = [];
        if(is_array($data)){
            foreach($data as $key => $val) {
                if((InspectorBridge::keyLen() < 120) && strlen($key) > 10){
                    InspectorBridge::keyLen(120);
                }
                $type = gettype($val);
                if(is_array($val)){
                    $result[] = "<div class='flex-grid'><span class='item-key'>#$key</span> <div class='flex-col item-val mvs-1 flex-l'><details dt-type='$type'><summary class=''><span class='item-type item-$type pxv-4'><span class='item-btn'>array</span> ".count($val)."</span></summary><div>".self::arrayInspection($val, $callback) ."</div></details></div></div>";
                }elseif(!is_object($val)){

                    $string = $val;

                    if(is_string($val)) {
                        $hasHTML = preg_match('/<\/?\w+((\s+\w+(\s*=\s*(["\']?).*?\4)?)+\s*|\s*)\/?>/',$val);

                        if($hasHTML){
                            $vals = explode("\n", $val);
                            if(count($vals) > 1){
                                
                                $baseIndent = strlen($vals[1]) - strlen(ltrim($vals[1]));
                                
                                $vals = array_map(function($value, $index) use($baseIndent){
                                    
                                    $textIndent = strlen($value) - strlen(ltrim($value));
                                    if($index !== 0 && (($textIndent - $baseIndent) >= 0)){
                                        return substr($value, $baseIndent, strlen($value));
                                    }
                                    return $value;
                                }, $vals, array_keys($vals));
    
                                $val = implode("\n", $vals);

                            }
                            
                            $val = '<div
                            style="white-space:pre">'.htmlentities($val).'</div>';
                        }

                    }elseif(is_bool($val)){
                        $val = ($val === true)? 'true' : 'false';
                    }elseif($val === null){
                        $val = 'NULL';
                    }
                    
                    if(in_array($type, ['string','integer'])){
                        $info = '['.$type.':'.strlen($string).']';
                    }else{
                        $info = '['.$type.']';
                    }
                    $result[] = "<div class='flex-grid'><span class='item-key'>#$key</span> <span class='flex gap-2 item-type item-val flex-l'><span class='item-pointer'>·</span> <span class='item-type item-$type flex-col'><div class='item-info'>$info</div><span>$val</span></span></span></div>";
                }else{
                    $traversable = ($val instanceof Traversable)? '::Traversable' : '';
                    $parameters = [];
                    if(is_closure($val)){
                        $reflection = new ReflectionFunction($val);
                        $params = $reflection->getParameters();
                        foreach($params as $param){
                            $parameters[] = ($param->getType()? basename(to_dirslash($param->getType())).' ' : '').'$'.$param->getName();
                        }
                    }
                    $parameters = enplode([', ','(',')'], $parameters);
                    $result[] = "<div class='flex vmain v-object'><span class='item-key pxv-2 mvs-1'>#$key</span> <span class='item-type item-val item-object flex-col'><div class='flex gap-2'><span class='item-pointer'>·</span><div class='item-info'>[object]</div></div>".$callback($val)."</span></div>";
                }
            }
            if(empty($data)){
                $type = gettype($data);
                $info = '['.$type.':0]';
                $result[] = "<div class='flex-grid'><span class='item-key'>-></span> <div class='flex-col item-val mvs-1 flex-l'><details dt-type='$type'><summary class='none'><span class='item-type item-$type pxv-4'><span class='item-btn'>[void]</span></span></summary><div></div></details></div></div>";

                // $result[] = "<div class='flex-grid'><span class='item-key'>-></span> <span class='flex gap-2 item-type item-val flex-l'><span class='item-pointer'>·</span> <span class='item-type item-$type flex-col'><div class='item-info'>$info</div><span></span></span></span></div>";
            }
        }else{
            print 123;
            $type = gettype($data);
        }
        return implode("", $result);
    }


    public static function dataObject(object $object) {
        
        $openHTML = $closeHTML = '';

        $Reflection = new ReflectionClass($object);
        $publics = $Reflection->getMethods(ReflectionMethod::IS_PUBLIC);
        $privates = $Reflection->getMethods(ReflectionMethod::IS_PRIVATE);
        $protecteds = $Reflection->getMethods(ReflectionMethod::IS_PROTECTED);
        $statics = $Reflection->getMethods(ReflectionMethod::IS_STATIC);

        $properties = $Reflection->getProperties();
        $public_props = $Reflection->getProperties(ReflectionProperty::IS_PUBLIC);
        $protected_props = $Reflection->getProperties(ReflectionProperty::IS_PROTECTED);
        $private_props = $Reflection->getProperties(ReflectionProperty::IS_PRIVATE);
        $static_props = $Reflection->getProperties(ReflectionProperty::IS_STATIC);
        $objectVars = get_object_vars($object);

        $build   = '';
        $namespace = $object::class;

        foreach($public_props as $pkey => $pval){
            if(array_key_exists($pval->name, $objectVars)){
                unset($objectVars[$pval->name]);
            }
        }
        

        $traversable = ($object instanceof \Traversable)? ' (Traversable)' : '';
        $build .= "<details class='inspection-field v-btn'><summary class='object'><span class='inspection-field v-object title'>".$namespace.$traversable."</span></summary><div>";
        
        if($properties || $objectVars){
          // handle all propeties ...........................................................................................
          $build .= "<details class='inspection-field v-object'><summary class='properties'>properties[".count($public_props) + count($objectVars) + count($private_props) + count($protected_props)."]</summary><div>";
  
          if($public_props || $objectVars){
              //handle public properties
              $pub_props = "<details class='properties public-list'><summary class='public'>public[".count($public_props) + count($objectVars)."]</summary><div>";
              foreach($public_props as $public){
      
                  if(isset($objectVars[$public->name])){
                    unset($objectVars[$public->name]);
                  }

                  if(in_array($public, $static_props)){
                      $public = ":: $".$public->name;
                      $operator = 'static';
                  }else{
                      $public = "-> ".$public->name;
                      $operator = 'instance';
                  }
     
                  $pub_props .="<span class=\"item-property $operator\"> {$public} </span><br>"; 
      
              }
              foreach($objectVars as $key => $val){
      
                  $public = "-> ".$key;
                  $operator = 'instance';
     
                  $pub_props .="<span class=\"item-property $operator\"> {$public} </span><br>"; 
      
              }
              if(empty($public_props) && empty($objectVars)) $pub_props .="<span class=\"item-property none\"> (none) </span><br>"; 
              
              $pub_props .= "</div></details>";
          }

          if(((!empty($properties) || !empty($objectVars)) || (empty($properties) && empty($objectVars) && empty($public_props))) && !empty($pub_props)){
            $build .= $pub_props;
          }
  
          if($protected_props){
              //handle protected properties
              $build .= "<details class='methods protected-list'><summary class='protected'>protected[".count($protected_props)."]</summary><div>";
              foreach($protected_props as $protected){
      
                  if(in_array($protected, $static_props)){
                      $protected = ":: $".$protected->name;
                      $operator = 'static';
                  }else{
                      $protected = "-> ".$protected->name;
                      $operator = 'instance';
                  }
      
                  $build .="<span class=\"item-property $operator\"> {$protected} </span><br>"; 
      
              }
              if(empty($protected_props)) $build .="<span class=\"item-property none\"> (none) </span><br>"; 
              $build .= "</div></details>";
          }
          
          if($private_props){
              //handle private properties
              $build .= "<details class='methods private-list'><summary
              class='private'>private[".count($private_props)."]</summary><div>";
              foreach($private_props as $private){
                
                  if(in_array($private, $static_props)){
                      $private = ":: $".$private->name;
                      $operator = 'static';
                  }else{
                      $private = "-> ".$private->name;
                      $operator = 'instance';
                  }

                  if(!self::$unlocked){
                    $build .="<span class=\"item-property\">🔒Locked </span><br>"; 
                    
                    break;
                  }else{
                    $build .="<span class=\"item-property $operator\"> {$private} </span><br>"; 
                  } 
      
              }
              if(empty($private_props)) $build .="<span class=\"item-property none\"> (none) </span><br>"; 
              $build .= "</div></details>";
          }
  
          $build .= "</div></details>";
        }

        // handle all methods ...................................................................
        $build .= "<details class='inspection-field'><summary
        class='methods'>methods[".count($publics)+count($protecteds)+count($privates)."]</summary><div>";

        if($publics || (empty($publics) && empty($privates) && empty($protecteds))){
            // handle all public methods ...................................................................
            $build .= "<details class='methods public-list'><summary class='public'>public[".count($publics)."]</summary><div>";
            foreach($publics as $public){
    
                if(in_array($public, $statics)){
                    $public = ":: ".$public->name;
                    $operator = 'static';
                }else{
                    $public = "-> ".$public->name;
                    $operator = 'instance';
                }
    
                $build .="<span class=\"item-method $operator\"> {$public}() </span><br>"; 
    
            }
            if(empty($publics)) $build .="<span class=\"item-method none\"> (none) </span><br>"; 
            $build .= "</div></details>";
        }
        
        if($protecteds){
          // handle all protected methods ...................................................................
          $build .= "<details class='methods protected-list'><summary class='protected'>protected[".count($protecteds)."]</summary><div>";
          foreach($protecteds as $protected){
  
              if(in_array($protected, $statics)){
                  $protected = ":: ".$protected->name;
                  $operator = 'static';
              }else{
                  $protected = "-> ".$protected->name;
                  $operator = 'instance';
              }
  
              $build .="<span class=\"item-method $operator\"> {$protected}() </span><br>"; 
  
          }
          if(empty($protecteds)) $build .="<span class=\"item-method none\"> (none) </span><br>"; 
          $build .= "</div></details>";
        }
        
        if($privates){
          // handle all protected methods ...................................................................
          $build .= "<details class='methods private-list'><summary
          class='private'>private[".count($privates)."]</summary><div>";
          foreach($privates as $private){
  
              if(in_array($private, $statics)){
                  $private = "⩴ ".$private->name;
                  $operator = 'static';
              }else{
                  $private = "-> ".$private->name;
                  $operator = 'instance';
              }
  
              if(!self::$unlocked){
                  $build .="<span class=\"item-method\">🔒Locked</span><br>"; 
                  break;
                }else{
                  $build .="<span class=\"item-method $operator\"> {$private}() </span><br>"; 
              }
          }
          if(empty($privates)) $build .="<span class=\"item-method none\"> (none) </span><br>"; 
          $build .= "</div></details>";
        }
        
        

        $build .= "</div></details>";
        
        $build .= "</div></details>";

        return $build;
    }

    /**
     * @see \vdiv()}
     *
     * @param array|string $args
     * @return void
     */
    public static function div(array|string $args) {

        return vdiv(...func_get_args());

    }

    /**
     * @see \vdiv()}
     *
     * @param array|string $args
     * @return void
     */
    public static function list(array|string $args) {

        return vlist(...func_get_args());

    }

    /**
     * @see \vdiv()}
     *
     * @param array|string $args
     * @return void
     */
    public static function dump(array|string $args) {

        return vdump(...func_get_args());

    }

    /**
     * @see \vdiv()}
     *
     * @param array|string $args
     * @return void
     */
    public static function ddump(array|string $args) {

        return ddump(...func_get_args());

    }

    public static function theme($theme) {

        if(is_numeric($theme)) $theme = InspectorChroma::themes[$theme] ?? 'default';
        self::$theme = $theme;

    }

    public static function style() {

        return '<style>'.InspectorChroma::theme(self::$theme).'</style>';

    }

}