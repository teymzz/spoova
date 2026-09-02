<?php

namespace spoova\mi\core\classes;

use Route;

abstract class FrameAbstract extends Route {

    abstract public function onFrame();

}