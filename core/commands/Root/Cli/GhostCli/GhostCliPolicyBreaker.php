<?php

namespace spoova\mi\core\commands\Root\Cli\GhostCli;

use spoova\mi\core\classes\Ghost\GhostClass;

abstract class GhostCliPolicyBreaker extends GhostClass {

    private string $key;
    private string $message;
    private string $title;

    /**
     * Triggered an exit message when a policy key breaks 
     *
     * @param string $key
     * @param string $message
     * @param string $title
     * @return void
     */
    function onBreak(string $key, string $message, string $title = ' Error '){

            $keys = $this->proxy->keys();

            if(!in_array($key, $keys,  true)){
                throw new \ErrorException('key "'.$key.'" supplied does not exist in policy breaker.');
            }
            if($key === $this->proxy->failedKey()){
                $this->key = $key;
                $this->message = $message;
                $this->title = $title;
            }

    }

    function onBreakAny(string $message, string $title = ' Error '){

            if(!isset($this->key)){
                $this->message = $message;
                $this->title = $title;
            }

    }

    /**
     * Returns a defined message for a broken policy
     *
     * @return array
     */
    function response() : array {
        $data = [];
        if(isset($this->message)) $data['message'] = $this->message;
        if(isset($this->title)) $data['title'] = $this->title;
        return $data;
    }

}