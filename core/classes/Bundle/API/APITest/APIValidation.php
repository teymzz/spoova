<?php

namespace spoova\mi\core\classes\Bundle\API\APITest;

use spoova\mi\core\classes\Bundle\API\API;

trait APIValidation {

  /**
   * Set the value of a property
   *
   * @param string $name
   * @param mixed $value
   * @return void
   */
  abstract public static function setProp(string $name, mixed $value);

  /**
   * Retrieve the value of a property
   *
   * @param string $name
   * @return mixed
   */
  abstract public static function getProp(string $name);

  /**
   * Set log value for APITraits
   *
   * @param string $name name of log
   * @param string $key access key
   * @param mixed $value  value to be set
   * @return void
   */
  abstract static function setLog(string $name, string $key, mixed $value);
  
  /**
   * Retrieve the value of a key from log
   *
   * @param string $key
   * @return array
   */
  abstract public static function getLog(string $key) : array;


  /**
   * Returns the {@see API::class} object instance
   *
   * @return API
   */
  abstract public static function API(): API;
}