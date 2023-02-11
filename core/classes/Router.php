<?php

namespace spoova\core\classes;

use Window;

class Router extends Slicer{

    public $request;
    protected $method;
    public $response;
    protected $routes = [];
    protected $data = '';
    protected bool $methodset = false;
    private $route = []; //details of the current route
    private $errorFile = '';
    

    /**
     * @param \core\classes\Request $request
     * @param \core\classes\Response $response
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

        //$epath = ($pathext == '' || $pathext === 'rex')? $path.'.php' : $path;
        $path = rtrim($path, '.php');
        $path = rtrim($path, '.rex');

        $filePath = $path.".rex.php";

        if(!is_file(docroot.DS.WIN_REX.$filePath)){

          //error => file does not exist

          $this->response->setStatusCode(400); 
        
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
        $Filemanager = new FileManager;

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

}