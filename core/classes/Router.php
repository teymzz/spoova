<?php

namespace spoova\core\classes;

class Router extends Slicer{

    public $request;
    public $response;
    protected $routes = [];
    protected $data = '';
    protected $methodset = false;
    private $route = []; //details of the current route
    private $errorFile = '';
    

    /**
     * @param \core\classes\Request $request
     * @param \core\classes\Response $response
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


    public function methodset(){
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

        $epath = ($pathext == '' || $pathext === 'rex')? $path.'.php' : $path;

        if(!is_file(getDefined('docroot').DS.docroot.DS.scheme.$epath)){
          //error => file does not exist

          $this->response->setStatusCode(400); 
        
          if($this->errorFile){

            $result = view('_404.php');

            self::internalView($result);

          }else{
            echo $this->error([
                'title' => 'Route Error : ',
                'message' => 'Page Not Found!',
                'path'    => $path
            ]);
          }

        } 
        
        return ;
      }

      if($routeMethod != $requestMethod) return;

      if(is_string($callback)){  
        $result = view($callback);
        self::internalView($result);
        return ;       
      }

      if(is_array($callback)){
         $callback[0] = new $callback[0];
      }

      if(is_array($callback) || $callback instanceof \Closure){
         $data = call_user_func($callback, $request);
         self::internalView($data);
         $this->endSlice();
         return;        
      }

    
    }

    /**
     * Internal render engine for port routing
     *
     * @param string $result
     * @return void
     */
    private static function internalView($result){         
         //print self::slice($data)->data();
         //replaced with eval
         eval(' ?>'.self::slice($result)->data().'<?php ');
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
            <div class="mox-full pxv-10 bc-white-dd">'.$message.'</div>
          </div>
        ';
      }
    }
  
    public function data(){
  
      return $this->data;
  
    }

}