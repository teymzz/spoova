<?php

use teymzz\spoova\core\classes\Base;
use teymzz\spoova\core\server\Serve;
use teymzz\spoova\core\classes\Spinner;
use teymzz\spoova\windows\Sessions\UserSession;

/**
 * This class contains window entry file. It should not be modified unless you have an idea 
 * about what you are doing
 */
class Server extends Base{


  /**
   * Start server
   *
   * @param string $type
   */
  final function __construct($type = '')
  {
      static::htcaliber($this);

      /* preload data */
      static::loadRoutes(); 
      static::bindFormData();
      static::loadBase(uri);
      static::start($type);
  }
    
  final static function run($type = '') {
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

    //initialize the index page
    if($type === '') $type = 'standard';

    if($type === 'index'){
      Serve::indexlogic();
    } elseif($type === 'standard') {
      Serve::standardlogic();
    } else {
      Serve::baselogic(ucfirst($type));
    }

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
   
}