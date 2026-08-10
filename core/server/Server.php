<?php

use spoova\mi\core\classes\Base;
use spoova\mi\core\classes\Container\Container;
use spoova\mi\core\classes\CSRF;
use spoova\mi\core\classes\Sensor\Sensor;
use spoova\mi\core\server\Serve;
use spoova\mi\core\classes\Spinner;
use spoova\mi\core\commands\Root\Cli;

/**
 * This class contains window entry file. It should not be modified unless you have an idea 
 * about what you are doing
 */
class Server extends Base{

  private static $logic = '';


  /**
   * Start server
   *
   * @param string $type
   */
  final function __construct(string $type = '')
  {
      if(isCli()){
        self::$logic = $type; return;
      }
      static::htcaliber($this);
      
      /* preload data */
      static::loadRoutes(); 
      static::bindFormData();
      static::loadBase(uri);
      response(200, 'found', true);

      static::start($type);

      Session::control();

  }
    
  final static function run(string $logic = '') {
    if(is_file(domroot(to_dirslash(ltrim(strtok(uri, '?'),'/'))))) return false;
    new static(...func_get_args());
  }

  /**
   * Start server 
   *
   * @param string $type optional [basic|index|standard (default)]
   *  If index is not the base route name, the route name can also be supplied
   * @return void
   */
  protected static function start(string $type){

    ob_start();
    //initialize the index page
    if($type === '') $type = 'standard';
    
    if(isCli()) {
      Cli::break();
      Cli::textView(Cli::error('index access denied.'));
      Cli::break(2);
      return false;
    }
    
    error_reporting(E_ALL);
    // ini_set('display_errors', 0);
    Serve::ini();

    if($type === 'index'){
      self::$logic = 'index';
      Serve::indexlogic();
    } elseif($type === 'standard') {
      self::$logic = 'standard';
      Serve::standardlogic();
    } else {
      self::$logic = 'basic';
      Serve::baselogic(ucfirst($type));
    }

    if($lastWindow = Window::getLast()){
      if(method_exists($lastWindow, '__onFinal')) {
        Container::callMethod($lastWindow, '__onFinal');
        // $lastWindow::__onFinal();
      }
    }

    ob_end_flush();

  }

  /** runs at initialization */
  protected static function loader(){

    $spinner = new Spinner;

    $spinnerText = '<span>S<span style="text-decoration:underline">poova</span></span>';

    return  '
      <div class="wi widget-wall spoova">
          <div class="flex mid w-2 w-red">
            '.$spinner->widget($spinnerText).'
            <div class="mxl-10 font-em-d85 c-red">Loading</div>
          </div>
      </div>
    ';
   
  }

  public static function logic() : string{
    return self::$logic ?: 'standard';
  }

  function __destruct(){}
   
}