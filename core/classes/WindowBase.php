<?php

namespace spoova\mi\core\classes;

use Closure;
use Exception;
use Ress;
use Session;
use spoova\mi\core\classes\Ajax;
use spoova\mi\core\classes\Bundle\API\API;
use spoova\mi\core\classes\Bundle\API\APIResponse;
use spoova\mi\core\classes\Compiler;
use spoova\mi\core\classes\Controller;
use spoova\mi\core\classes\EInfo;
use spoova\mi\core\classes\Request;
use spoova\mi\core\classes\Res\Rex;
use spoova\mi\core\classes\UrlMapper;
use Window;

class WindowBase extends Controller
{

  /**
   * Globally sets strict url casing for shutters if not negated by inverse character.
   */
  public const STRICT = ':STRICT';

  /**
   * Specifies a parent path for all supplied routes within "smartcall" or "call" shutter scope
   */
  public const ORIGIN = ':ORIGIN';

  /**
   * Sets shutter variable parameters (or arguments) 
   */
  public const ARG = ':ARG';

  /**
   * Alias for Window::ARG
   * Sets shutter variable parameters (or arguments)
   *
   * @notice This resolves to the same shutter key as self::ARG. Both cannot be
   * supplied within the same shutter list since the last one supplied overwrites the first.
   */
  public const PARAMS = ':ARG';

  /**
   * Sets handler function or class for managing url slugs
   */
  public const SLUGS = ':SLUGS';

  /**
   * Sets a middleware handler function limited scope
   */
  public const ONCALL = ':ONCALL';

  /**
   * Sets a middleware handler function global scope 
   */
  public const INCALL = ':INCALL';

  /**
   * Sets a shutdown function if a channel shuts down
   */
  public const ONSHUT = ':SHUTDOWN';

  /**
   * Sets a middleware handler function that is always executed if a route path (resolved or unresolved) is triggered.
   *  - Triggers for  SELF::ONCALL and SELF::ONSHUT
   */
  public const ONLOAD = ':ONLOAD';

  /**
   * Enables smartcall shutter to filter urls increasing route performance.
   */
  public const TRUNK = ':TRUNK';

  /**
   * Defines all essential shutter keys
   *
   * @notice self::PARAMS is intentionally left out because it is only an alias of
   * self::ARG. Listing it would duplicate ":ARG" within this list.
   */
  public const SHUTTER_KEYS = [
    self::STRICT, self::ORIGIN, self::ARG, self::SLUGS, self::ONCALL, self::INCALL, self::ONSHUT, self::ONLOAD, self::TRUNK
  ];

  #define private constants only
  private const folder = 'windows';
  private const Server = 'Server';

  #resolved classes
  protected bool $resolved = false;

  #closed route
  protected static bool $shutdown = false;

  #inherent local variables
  protected static $variables = null;

  /**
   * set window error response type
   *
   * @var string $e_response optional [direct|(api/json)|ajax]
   */
  protected static $e_response = 'direct'; //

  protected static $wvm = [

    #url mappers
    'window' => '', /* entry point */
    'root' => '',   /* alias for window */
    'path' => '',   /* direct path after widow */
    'base' => '',   /* window + path (fullpath) */

    #url error - 404 error rex file
    'error' => 'errors.404',

    #csrf error - 404 csrf error rex file
    'csrf'  => 'errors.e-csrf',


    #variables
    'variables' => null,

    #authentications - unused
    'secure' => ['GUEST' => [], 'AUTH' => []],

    #close window
    'close' => false,

    #sleep window
    'sleep' => false,

    #pend close window
    'pend' => false,

    #keep dot convention
    'keep' => false,

    #preloaded callbacks
    'preload' => [],

    'onCall' => [
      'cast' => [],
      'root' => [],
      'base' => [],
      'path' => [],
      'e404' => []
    ],

    /**
     * store call responses
     * This will be added in future versions
     */
    'onCallResponse' => [
      'cast' => [],
      'root' => [],
      'base' => [],
      'path' => [],
      'e404' => []
    ],

    /**
     * set headers accepted or rejected
     */
    'headers' => [
      'accepted' => [],
      'rejected' => [],
    ],

    /**
     * Convert other response headers from default config
     */
    'translations' => [

      '404' => 'error.404',
      '302' => 'error.302',

    ]

  ];

  /**
   * set window response type
   *
   * @var bool|string $winAPI optional [false|ajax|json|(ajax:json)|true]
   */
  protected static $winAPI = false;
  
  protected static array $integrateAPIResponse = [];

  /**
   * Open a new path
   *
   * @param string $path a new url path to be processed
   * @return void
   */
  final public static function open($path = ''): void
  {
    static::bindFormData(); //allow opening of new data
    static::loadBase($path);
    static::onOpen($path);
  }


  private static function onOpen($path = '')
  {

    if ($path) static::loadBase($path);
    $path = scheme(static::folder . '\\' . ucfirst(static::wvm('root')), false);

    if (@class_exists($path)) {
      http_response_code(200);
      $path::protect();
      echo (new $path(new Request));
      if (!static::wvm('close')) return;
    }

    if (@class_exists(static::Server)) {
      http_response_code(200); //default response
      $index = (static::Server);
      new $index;
      if (!static::wvm('close')) return;
    }

    static::close();
  }

  /**
   * Set or Fetches wvm windows paramters
   *
   * @param string $key wvm key to be set or fetched
   * @param mixed $value respective value to be set
   * @return array|string
   * @notice if key does not exists returns empty string
   */
  final public static function wvm(?string $key = null, mixed $value = null)
  {
    if ($key == ':404') $key = 'error';
    if ($key == ':csrf') $key = 'csrf';
    if (func_num_args() == 0) return static::$wvm;
    if (func_num_args() == 1) {

      $marker = '';
      $firstChar = substr($key, 0, 1);

      if (($firstChar === '!') || ($firstChar === '@')) {
        $key = substr($key, 1, strlen($key));
        $marker = $firstChar;
      }

      if (strpos($key, ':') !== false) {
        /* resolve as path */
        $expkey = explode(":", $key, 2);
        $key = $expkey[0] ?: 'root';
        $path = $expkey[1] ?? '';
        if (!self::wvm('keep')) $path = str_replace('.', '/', $path);
        $basepath = static::$wvm[$key] ?? '';
        if (($firstChar === '@')) {
          $marker = '';
          if (!$basepath && $key !== 'path') {
            $basepath = 'index';
          }
        }

        $newpath = $basepath . '/' . $path;
        return $marker . rtrim($newpath, '/');
      } else {
        /* resolve as window key */
        $value = static::$wvm[$key] ?? '';
        if ($value === '' && $marker === '@' && $key !== 'path') $value = 'index';
        return $value;
      }
    }

    if (func_num_args() > 1) {
      if (static::$wvm ?? false) static::$wvm[$key] = $value;
    }
    return  '';
  }

  /**
   * Determines the response data behaviour (i.e HTML or JSON) of shutter methods 
   * under an API environment when configured with basic route requirements. For API arguments {@see API}
   *  
   * @param bool|string $type optional [ajax|json|(TRUE/ajax:json)|FALSE]
   *  - Each option is described below:
   *    - ``ajax`` : an XMLHttpRequest header must be available along with a valid Referer URL.
   *    - ``json`` or ``API::JSON`` : Converts shutter 404 response error to JSON format.
   *    - ``jsox`` or ``API::JSOX`` : Converts shutter 404 response error to JSON format and sets route headers content-type to 'application/json'
   *    - ``TRUE, ajax:json`` : applies features of both 'ajax' and 'json' option.
   *    - ``ajax:jsox``, API::AJOX  applies features of both 'ajax' and 'jsox' option.
   *    - ``FALSE`` : Applies no API integration
   *  - All ajax related options (i.e ajax, ajax:json) applies {@see spoova\mi\core\classes\Bundle\API\API::channel()} method
   *  
   * @param array $emessage sets the default error status code and message for integrateAPI options using ':404' and ':ajax' response configuration keys as discussed [here](https://www.spoova.com/docs/wvm/apis).
   *  #### **```Format: [':404'=>[code, message], ':ajax'=>[code, message]]```**
   * - The ':404' response is triggered if shutter fails (i.e 404 route error)
   * - The ':ajax' response is triggered if XMLHttpRequest header or URL referer is considered missing. (legacy key 'ajax' is also accepted)
   * #### **```Note: response behaviour depends on the type of API integration option applied```**
   * 
   * @return void|false
   * 
   * @Notice supplying arguments ($emessage) declares that the page request must be through ajax only
   */
  final static function integrateAPI(bool|string $type = false, array $emessage = [])
  {

    $validsOptions = ['', 'ajax', 'json', 'jsox', 'ajax:json','ajax:jsox'];

    if (func_num_args() > 0) {
      if (!in_array($type, $validsOptions) && !is_bool($type)) {
        return EInfo::view('Invalid option supplied on argument 1 <i><u>integrateAPI()</u></i>' . " in " . get_called_class());
      }
      static::$winAPI = $type;
      if($emessage){
        $e404 = $emessage[':404'] ?? false;
        $ajax = $emessage[':ajax'] ?? $emessage['ajax'] ?? false; // 'ajax' accepted for back-compat
        unset($emessage[':404'], $emessage[':ajax'], $emessage['ajax']);
        if($emessage) throw new Exception('invalid argument key supplied integrateAPI($emessage) ');
        if($e404) self::$integrateAPIResponse[':404'] = $e404;
        if($ajax) self::$integrateAPIResponse[':ajax'] = $ajax;
      }
    }

    $realType = static::$winAPI;
    $type = strtolower(static::$winAPI);

    if (!in_array($type, $validsOptions) && !is_bool($realType)) {

      if ($parentClass = get_parent_class(get_called_class())) {
        $parentClass = br() . "&nbsp;:: <b>Parent Class: </b>" . $parentClass;
      }
      return EInfo::view('Invalid option set for property <i><u>$winAPI</u></i> in ' . get_called_class() . $parentClass);
    }
  }

  /**
   * Set headers accepted for a route
   *
   * @param array|int $headers
   * @param boolean $reset
   * @return void
   */
  final public static function acceptHeaders(array|int $headers, bool $reset = false)
  {

    $headers = (array) $headers;

    if ($reset) {
      self::$wvm['headers']['accepted'] = $headers;
    } else {
      foreach ($headers as $header) {
        self::$wvm['headers']['accepted'][] = $header;
      }
    }
  }

  /**
   * Set headers rejected for a route
   *
   * @param array|int $headers
   * @param boolean $reset
   * @return void
   */
  final public static function rejectHeaders(array|int $headers, bool $reset = false)
  {

    $headers = (array) $headers;

    if ($reset) {
      self::$wvm['headers']['rejected'] = $headers;
    } else {
      foreach ($headers as $header) {
        self::$wvm['headers']['rejected'][] = $header;
      }
    }
  }

  //* This method may be used later for securing routes
  final protected static function secure($route, $session = '')
  {
    $session = strtoupper($session);
    static::$wvm['secure'][$session][] = $route;
  }


  /**
   * Test if the current page or value supplied is index page
   *
   * @param mixed $Index optional url root (or window) name to be tested.
   *  - If a non empty string is supplied, that value is tested instead of the current url root.
   *  - Any other value (e.g a window instance) is ignored and the current url root is tested.
   * @return boolean
   */
  final static function isIndex($Index = '') : bool
  {

    $root = (is_string($Index) && trim($Index) !== '') ? $Index : window('root');

    $root = trim((string) $root, '/ ');
    $root = strtok($root, '?') ?: '';      // discard any query string supplied
    $root = explode('/', $root, 2)[0];     // only the first path segment defines a root

    return (!$root || (strtolower($root) === 'index'));
  }

  /**
   * Checks if supplied path exists in the windows/Routes folder
   *
   * @param string $path 
   *  - Supplied path will be searched within the windows/Routes folder
   * @return bool true if route file exists
   */
  final static function inRoutes(string $path)
  {

    return (routeExists($path));
  }

  /**
   * This method is to push requested form data through an eternal route
   * back to the current route using an automatic redirection.
   *
   * @return void
   */
  final protected static function pushFormData()
  {
    if (isset($_SERVER['HTTP_REFERER'])) {
      if ($_SERVER['HTTP_REFERER'] != $_SERVER['REQUEST_URI']) {

        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

        $Request = new Request;

        /**
         * Read the request data without authentication. Unlike $_POST or $_GET, this
         * also resolves the body carried methods (i.e PUT, PATCH and DELETE) whose
         * request data is only available through "php://input"
         */
        $raw  = $Request->prompt();
        $raw  = is_array($raw) ? $raw : [];

        $file = $_FILES ?? [];

        //redirect action
        $action = $raw[':form-action'] ?? '';
        $ref    = dirname(rtrim($_SERVER['HTTP_REFERER'], '/'));

        if ($action) {
          $action = $ref . '/' . $action;
        } else {
          $action = $_SERVER['HTTP_REFERER'];
        }

        $csrfSent = $raw['CSRF_TOKEN'] ?? '';
        $csrfSess   = Session::base()->value('CSRF', 'TOKEN');

        $data = $Request->data();
        $data = is_array($data) ? $data : [];

        $CSRF_VALID = ($csrfSent && ($csrfSent === $csrfSess));
        $CSRF_TIME  = Session::base()->value('CSRF', 'TIME');

        $formdata['DATA']   = $data;
        $formdata['FILES']  = $file;
        $formdata['METHOD'] = $method;
        $formdata['URI']    = $_SERVER['REQUEST_URI'];
        $formdata['CSRF_REF'] = [
          'VALID'   => $CSRF_VALID,
          'valid'   => $CSRF_VALID,
          'isValid' => $CSRF_VALID,
          'time'    => $CSRF_TIME,
          'TIME'    => $CSRF_TIME,
        ];
        Session::base()->save(':FORM', $formdata);
        redirect($action);
      }
    }
  }


  /**
   * Automatically Re-binds route-to-route referred form data into accessible environment key. 
   * This data is pushed into enviroment key when {@see WindowBase::pushFormData()} is called from routes.
   * 
   * @return void
   */
  final protected static function bindFormData()
  {
    if (Session::base()->has(':FORM')) {

      //fetch method
      $FORM    = Session::base()->value(':FORM');
      $method  = strtoupper($FORM['METHOD'] ?? 'GET');
      $formURI = $FORM['URI'] ?? '';

      if ($formURI != ($_SERVER['REQUEST_URI'] ?? '')) {

        $_SERVER['REQUEST_METHOD'] = $method;

        $data  = is_array($FORM['DATA'] ?? null) ? $FORM['DATA'] : [];
        $files = is_array($FORM['FILES'] ?? null) ? $FORM['FILES'] : [];

        //rebind request data into the superglobal of the request method
        if ($method === 'POST') {
          $_POST = $data;
        } elseif ($method === 'GET') {
          $_GET = $data;
        } else {
          /**
           * Body carried methods (i.e PUT, PATCH, DELETE) have no superglobal and their
           * original "php://input" stream is gone after the redirection. Their data is
           * therefore restored on the environment key where {@see PHPInput()} rereads it.
           */
          $_ENV[':FORM'][':INPUT'] = $data;
        }

        $_REQUEST = $data;

        //rebind request files
        $_FILES = $files;
      }

      //set CSRF Data into Environment
      $_ENV[':FORM']['CSRF_REF'] = $FORM['CSRF_REF'] ?? [];
      Session::base()->remove(':FORM');
    }
  }

  /**
   * Parses / Splits a url to a predifined structure recognized by wmv pattern
   * If no url is supplied, the default uri constant is assumed
   *
   * @param string $url
   * @return void
   */
  final public static function loadBase(string $url = '')
  {

    $uri = (!$url) ? uri : $url;

    $uri = strtok($uri, '?');

    if (!online) {
      $base = explode('/', rtrim(ltrim($uri, '/'), '/ '), 2)[1] ?? '';

      $path = explode('/', $base, 2)[1] ?? '';
      $open = explode('/', ltrim($base, '/'), 2)[0] ?? '';
    } else {
      $base = rtrim(ltrim($uri, '/'), '/ ');
      $path = explode('/', $base, 2)[1] ?? '';
      $open = explode('/', rtrim(ltrim($uri, '/'), '/ '), 2)[0] ?? '';
    }

    if (isPHPServer) {
      $base = rtrim(ltrim($_SERVER['PATH_INFO'] ?? $_SERVER['REQUEST_URI'] ?? 'index', '/'), '/ ');

      $path = explode('/', $base, 2)[1] ?? ''; //for PHP-Inbuilt server
      $open = explode('/', ltrim($base, '/'), 2)[0] ?? '';
    }

    $mappers = [
      'window' => $open,
      'root' => $open,
      'base' => $base,
      'path' => $path
    ];

    static::$wvm = array_merge(static::$wvm, $mappers);

    //Set Error Default Directory
    $errorDir = docroot . '/windows/Rex/errors/';

    //Set 404 rex file at window initialization
    $rex404 = static::wvm(':404');
    if (($rex404 === 'errors.e-404') || ($rex404 === 'errors.404')) {
      if (file_exists($errorDir . 'e-404.rex.php')) {
        $e404_file = 'errors.e-404';
      } elseif (file_exists($errorDir . '404.rex.php')) {
        $e404_file = 'errors.404';
      } else {
        $e404_file = '::404';
      }
      static::wvm(':404', $e404_file);
    }

    //Set CS error rex file at window initialization
    $rexCsrf404 = static::wvm(':csrf');
    if ($rexCsrf404 === 'errors.e-csrf') {
      if (!file_exists($errorDir . 'e-csrf.rex.php')) {
        static::wvm(':csrf', '::csrf');
      }
    }
  }

  /**
   * Close a window
   *
   * @param boolean $bool true forces close and stops any pending
   * @param array|string $args determines the behviour of close() method
   *  - ':reserved' : specifies that a shutter method is reserved and replaces shutdown template to reserved template.
   * @return void
   */
  final public static function close(bool $bool = false, string|array $args = [])
  {

    // during route introspection, never render a 404 or terminate the scan
    if (RouteInspector::capturing()) return;

    if ($bool) self::wvm('pend', false);

    $argsc = func_num_args();
    $argss = func_get_args();

    if ($args === ':reserved' && !online) {
      self::wvm('error', 'errors.404-reserved');
    }

    if (self::wvm('pend') && ($argsc > 0) && ($argss[0] === true)) {
      self::wvm('pend', false);
      self::wvm('close', false);
    }

    if (self::wvm('pend') && ($argsc == 0)) return;

    if (self::wvm('close')) return;
    static::wvm('close', true);

    //set and return array of response header
    $response = [404, 'Page not found!', 'coded'=>false];
    if(isset(self::$integrateAPIResponse[':404'])){
      $key1 = self::$integrateAPIResponse[':404'][0];
      $key2 = self::$integrateAPIResponse[':404'][1];
      $response = [$key1, $key2, 'coded'=>false]; // status code, message
    }

    $response = response(...$response);

    if(in_array(static::$winAPI,['json','jsox','ajax:json','ajax:jsox'], true)){
      if(!headers_sent() && (in_array(static::$winAPI, ['jsox','ajax:jsox'], true))) header('content-type:application/json');
      echo $response; /* print response header */
    }else{

      if(static::wvm(':404') === '::404'){
        Ress::new('res/main/')
            
            // # error files ... 
            ->url("css/local/debug/res.css => x-debug:res-css")->named('x-debug-css')
            ->url("js/local/debug/debug.js => x-debug:res-js;type:module")->named('x-debug-js')
            ->bindTo('404')
            ->close();
      }
      
      
      self::$shutdown = true;
      self::load(static::wvm(':404'), fn () => compile());
    }
    exit();

  }

  /**
   * Integrated API feature for resolved valid channels
   * 
   * @return void
   */
  final protected static function integrate_windows_api(){
    if($winAPI = self::$winAPI) {

      $isAjax = false;
      $isJsox = false;
      
      if(is_string($winAPI)){
        $type = explode(':',$winAPI);
        $isAjax = ($type[0]??false) === 'ajax' || ($winAPI === 'ajax');
        $isJsox = ($type[1]??false) === 'jsox' || ($winAPI === 'jsox');
      }

      if($isJsox){
        // set request header as 'application/json'
        header('content-type:application/json');
      }

      if($isAjax){
        // validate referers and xml
        $responseData = [];
        if(isset(self::$integrateAPIResponse[':ajax'])){
          $key1 = self::$integrateAPIResponse[':ajax'][0];
          $key2 = self::$integrateAPIResponse[':ajax'][1];
          $responseData = ['status'=>$key1, 'message' => $key2]; // status code, message
        }
        API::channel(API::JSON, fn() => API::debounce()->isXMLHttpRequest()->isReferred())
            ->shutdown(fn(APIResponse $response) => $response->view($responseData));
      }

      if($winAPI === true){
        
        $responseData = [];

        if(isset(self::$integrateAPIResponse[':ajax'])){
          $key1 = self::$integrateAPIResponse[':ajax'][0];
          $key2 = self::$integrateAPIResponse[':ajax'][1];
          
          $responseData = ['status'=>$key1, 'message' => $key2];
        }
        API::channel(API::JSON, fn() => API::debounce()->isReferred())
            ->shutdown(fn(APIResponse $response) => $response->view($responseData));
      }

    }
  }

  /**
   * Set window error response type
   *
   * @param string $type optional [direct|(api/json)|ajax]
   * When no argument is supplied, it returns the current response type set.
   * @return string
   */
  final function e_response($type = '')
  {
    $response = static::$e_response ?? '';
    if (func_num_args() < 1) return $response;
    if (in_array($type, ['api', 'ajax', 'json', 'direct'])) {
      return static::$e_response = $type;
    }
    return static::$e_response;
  }

  /**
   * set a new 404 error template file
   *
   * @param string $view rsc(resource) file path
   * @return void
   */
  final protected function eview(string $view = '')
  {
    if ($view === '404') $view = 'error';
    static::wvm('error', $view);
    return $this;
  }

  /**
   * Converts a supplied url path to clickable splits
   *
   * @param string|array $url url to be mapped
   *   - array format: [path, link],
   *     - path: this specified the prefix of the link 
   *     - link: this represents the suffix of the link.
   * @param string $separator url separator element
   * @param array $exc excluded paths using positional index starting from 1 and above.
   * @return string
   */
  final protected static function mapurl(string|array $url, string $separator = '/', $exc = [])
  {
    $urlmap = new UrlMapper;

    //$base = DomUrl();
    $urlmap->setbase(DomUrl('/'));
    return $urlmap->map($url, $separator, $exc);
  }

  /**
   * Set a session & cookie keys for the session class
   *
   * @return array
   */
  final protected static function session(): array
  {

    //* Default Session and Cookie name
    return ['user', 'cookie'];
  }

  /**
   * Internally Caliberates project application
   *
   * @param object|string $Server
   * @return void
   */
  final static public function htcaliber(object|string $Server)
  {
    $loader = (method_exists($Server, 'loader')) ? $Server::loader() : '';
    if (self::isIndex()) htCaliber(true, $loader);
  }

  //* Define Integrated Template Helper Methods............................

  /**
   * This method enforces window to add a non-existing rex file when the "load" method is used.
   *
   * @param string $template_path
   * @return void
   */
  final protected static function addRex(string $template_path = '')
  {
    Compiler::addRex(...func_get_args());
  }

  /**
   * Renders and Outputs the rex template files
   * 
   * @param string $path rex template path
   * @param Closure|false $callback template handler function
   *  - The closure must return a compiler function or a string
   * @return void
   */
  final protected static function load($path, Closure|false $callback = false)
  {
    // no compile / template-scaffold / cache-write / render during a route scan
    if(RouteInspector::capturing()) return;
    echo Compiler::read(...func_get_args());
  }

  /**
   * Renders and Returns the rex template files
   * @param string $url res template url
   * @param mixed $callback template handler function
   * @return string
   */
  final protected static function markup($url, $callback)
  {
    if(RouteInspector::capturing()) return '';
    return Rex::markup(...func_get_args());
  }

  /**
   * Rex view function
   *
   * @param string $url
   * @param array|Closure|false|string $callback
   * @param array $args arguments
   * @return void
   */
  final public static function view(string $url, array|Closure|false|string $callback = false, array $args = [])
  {
    if(RouteInspector::capturing()) return;
    if (func_num_args() > 2) {
      echo Rex::view(...func_get_args())->setArgs($args);
    } else {
      echo Rex::view(...func_get_args());
    }
  }    
  
}
