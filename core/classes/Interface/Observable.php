<?php

namespace spoova\mi\core\classes\Interface;

use spoova\mi\core\classes\Interface\Observer;

interface Observable {

    public function attach(Observer $observer);
    public function detach(Observer $observer);
    public function notify();

}
