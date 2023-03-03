<?php

namespace teymzz\spoova\core\classes;

class Response {

    public function setStatusCode(int $code){
        http_response_code($code);
    }

}