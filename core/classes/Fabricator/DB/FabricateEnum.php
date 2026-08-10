<?php

namespace spoova\mi\core\classes\Fabricator\DB;

use spoova\mi\core\classes\Fabricator\FabricatorInterface;

class FabricateEnum implements FabricatorInterface {

    /**
     * Generates a random ENUM value from provided options
     *
     * @param string|array $values enum values separated by comma or as array
     * @return string One of the provided enum values
     */
    public static function fabricate(string|array $values = 'active,inactive') : string {
        
        if (is_string($values)) {
            $values = array_map('trim', explode(',', $values));
        }
        
        $values = array_filter($values); // Remove empty values
        
        if (empty($values)) {
            return 'active';
        }
        
        return $values[array_rand($values)];
    }

}
