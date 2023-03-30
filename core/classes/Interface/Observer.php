<?php

namespace spoova\mi\core\classes\Interface;

use spoova\mi\core\classes\Interface\Observable;

interface Observer {
    public function update(Observable $observed, $count);
}
