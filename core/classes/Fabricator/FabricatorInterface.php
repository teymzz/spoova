<?php

namespace spoova\mi\core\classes\Fabricator;

interface FabricatorInterface {
  
    /**
     * generate values based on dependencies
     */
    public static function fabricate();
    
}