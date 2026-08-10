<?php

namespace spoova\mi\core\classes\Fabricator\DB;

use spoova\mi\core\classes\Fabricator\FabricatorInterface;

class FabricateSet implements FabricatorInterface {

    /**
     * Generates a random SET value (comma-separated string) for SET field type
     *
     * @param string|array $options available set options separated by comma or as array
     * @param int $minItems minimum items to select (default 1)
     * @param int $maxItems maximum items to select (default 3)
     * @return string Comma-separated SET values
     */
    public static function fabricate(string|array $options = 'option1,option2,option3,option4', int $minItems = 1, int $maxItems = 3) : string {
        
        if (is_string($options)) {
            $options = array_map('trim', explode(',', $options));
        }
        
        $options = array_filter($options);
        
        if (empty($options)) {
            return 'option1';
        }
        
        $minItems = max(1, min($minItems, count($options)));
        $maxItems = max($minItems, min($maxItems, count($options)));
        
        $count = mt_rand($minItems, $maxItems);
        $selected = array_rand($options, $count);
        
        if (!is_array($selected)) {
            $selected = [$selected];
        }
        
        $values = array_map(fn($index) => $options[$index], $selected);
        
        return implode(',', $values);
    }

}
