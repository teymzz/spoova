<?php 

namespace spoova\mi\core\tools\IconExtractor;

use Override;
use spoova\mi\core\classes\Ghost\GhostClass;

abstract class IconList extends GhostClass {

    private array $icons;

    private array $resolvedIcons = [];

    function ghostInit(): void
    {
        $this->icons = $this->resolvedIcons = $this->proxy->icons;
    }

    function limit(int $count = 0) { 
        if($count){
            $i = 0; $list = [];
            foreach($this->icons as $icon){
                if($i === $count) break;
                $name = basename($icon);
                $name = \pathinfo($name, \PATHINFO_FILENAME);
                $list[$name] = $icon;
                $i++; 
            }
            return $this->resolvedIcons = $list;
        }
        return $this;
    }

    function render() : array {
        return $this->resolvedIcons;
    }

}