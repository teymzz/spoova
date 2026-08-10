<?php

namespace spoova\mi\core\classes;

use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use spoova\mi\core\classes\Request;
use spoova\mi\core\classes\Response;

class Router extends Slicer{

    public ?Request $request = null;
    protected string $method; // get, post, ...
    public ?Response $response = null;
    protected array $routes = [];
    protected string $data = '';
    protected bool $methodset = false;
    private array $route = []; //details of the current route
    private string $errorFile = '';
    

    /**
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function __construct(Request $request, Response $response)
    {
        // code...
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback){

      $this->route['path'] = $path;
      $this->route['name'] = explode('/', $path)[1]?? '';
      $this->method = 'get';
      $this->methodset = false;
      if(!isset($this->routes['get'][$path])){  
        $this->routes['get'][$path] = $callback; 
        $this->methodset = true;      
      } else {
        $this->methodset = false;
        echo $this->error([
          'title' => 'Route Error',
          'message' => ' "get" already called on path',
          'path' => ' "'.$path.'" '
        ]
        );
      }

    }

    public function post($path, $callback){
      $this->route['path'] = $path;
      $this->route['name'] = explode('/', $path)[1]?? '';
      $this->method = 'post';
      $this->methodset = false;
      if(!isset($this->routes['post'][$path])){  
        $this->routes['post'][$path] = $callback; 
        $this->methodset = true;      
      } else { 
        $this->methodset = false;
          echo $this->error([
            'title' => 'Route Error',
            'message' => ' "post" already called on path',
            'path' => ' "'.$path.'" '
          ]
        );
      }
    }

    /**
     * Returns true if path called was set for declared request method (i.e post() or get() ) 
     *
     * @return boolean
     */
    public function methodset() : bool{
      return $this->methodset;
    }

    public function method(){
      return $this->method;
    }

    /**
     * Strip a trailing ".rex" and/or ".php" extension from a route path.
     *
     * Removes the exact suffixes only (".rex.php" -> "", ".php" -> "", ".rex" -> ""),
     * unlike rtrim() which treats its argument as a character set and would wrongly
     * shave trailing letters from extensionless paths (e.g. "/help" -> "/hel").
     *
     * @param string $path
     * @return string
     */
    public static function stripRexExtension(string $path) : string {
      if(str_ends_with($path, '.php')) $path = substr($path, 0, -4);
      if(str_ends_with($path, '.rex')) $path = substr($path, 0, -4);
      return $path;
    }

    public function resolve(){

      $path = $this->request->getPath(); //path of file
      $request = $this->request;
      $requestMethod  = $request->method();
      $routeMethod    = $this->method();
  
      $isArray = false;

      $callback = $this->routes[$requestMethod][$path]?? false;  
      
      if($callback === false){   

        if($path == "/") $path = "/index";     

        //get the first path after slash (/) later!!!
        $pathext = pathinfo($path, PATHINFO_EXTENSION);

        $path = self::stripRexExtension($path);

        $filePath = $path.".rex.php";

        if(!is_file(docroot.DS.WIN_REX.$filePath)){

          //error => file does not exist

          \response(400); 
        
          //if user error file is enabled
          if($this->errorFile && is_file($this->errorFile)){

            $result = view($this->errorFile);
            
            \Res::load();

          }else{
            echo $this->error([
                'title' => 'Route Error : ',
                'message' => 'Page Not Found!',
                'path'    => $path
            ]);
          }

        } else {

        }
        
        return;
      }

      // Restrict resolve only to the proper request url
      if($routeMethod != $requestMethod) return;

      //Load strings as urls 
      if(is_string($callback)){

        $callfile = (pathinfo($callback, PATHINFO_EXTENSION))? $callback : '.rex.php'; 

        if(!is_file($callback)){
          EInfo::view('Invalid rex file path supplied on "'.$this->method().'"');
          return false;
        }

        $result = view($callback);
        self::internalView($result, $path);
        return ;       
      }

      if(is_array($callback)){
         $callback[0] = new $callback[0];
      }

      if(is_array($callback) || $callback instanceof \Closure){
         $data = call_user_func($callback, $request);
         self::internalView($data, $path);
         $this->endSlice();
         return;        
      }

    
    }

    /**
     * Internal render engine for port routing
     *
     * @param string $body
     * @return void
     */
    private static function internalView($body, $path){      

        $content = self::slice($body)->data();
        $rexfile = ltrim($path,'/').'.rex.php';

        $rexfile = str_replace(['/','\\'],'.', $rexfile);

        //create path in storage folder
        $Filemanager = new Filemanager;

        $realFile = docroot.'/core/storage/mvc/'.$rexfile;


        if($Filemanager->openFile(true, $realFile)){
  
            //get lastmodified of $path;
            if(file_exists($realFile)){
              
              //get contents of real file
              $realcontents = file_get_contents($realFile);
  
              if($realcontents != $content){
                //update content
                file_put_contents($realFile, $content);
              }
  
              ob_start();
              include($realFile);
              $templateContent = ob_get_clean();
              print $templateContent;
            }
  
        }

    }

    public function showError(){
      print $this->error(...func_get_args());
    }

    public function error(array $array = []){
      if(func_num_args() > 0){
        $arg = $array;
  
        $title = $arg['title']?? '';
        $message =  $arg['message']?? '';
        $icon    = array_key_exists('icon', $arg)? $arg['icon'] : 'ico-emo-home';
  
        $filePath    = $arg['path']?? '';
        $message = '<span class="fb-6 class="flex-full midv"><span class="ico-emo-house"></span> '.$title. ' <span> ' .$message.'</span></span> : '.$filePath;
        
        return '
          <div class="spoova-route-error pxv-4 c-red-d">
            <div class="box-full pxv-10 bc-white-dd">'.$message.'</div>
          </div>
        ';
      }
    }


    public static function map(&$map = []) : array {
      
      //get map 
      $mapper = to_frontslash(WIN_ROUTES).'.map';

      if(is_file($mapper)){
        
        $contents = file_get_contents($mapper);
        
        $map = json_decode($contents, true);
        $map = is_array($map)? $map : []; 

        return $map;

      }

      return $map = [];

    }

    /**
     * Map a url to map file
     *
     * @param string $url url to be mapped
     * @param array $map if supplied, will be used as map
     * @return string
     */
    static function relate(string $url, array $map = []) : string {
      if(($test1 = isset($map['.*'])) || ((isset($map['*']) && $map && is_string($map['*']) && (strrev($map['*'])[0] !== '\\')))){
        $url = $test1? $map['.*'] : $map['*']; 
      }else{
        $url = ($map['*'] ?? '').$url;
      }
      return ucfirst($url);
    }

}