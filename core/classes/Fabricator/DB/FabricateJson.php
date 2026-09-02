<?php

namespace spoova\mi\core\classes\Fabricator\DB;

use spoova\mi\core\classes\Fabricator\FabricatorInterface;

class FabricateJson implements FabricatorInterface {

    /**
     * Generates random JSON data
     *
     * @param int $depth nesting depth (default 2)
     * @param int $itemCount number of items in array/object (default 5)
     * @return string Valid JSON string
     */
    public static function fabricate(int $depth = 2, int $itemCount = 5) : string {
        
        $depth = max(0, min($depth, 5));
        $itemCount = max(1, min($itemCount, 20));
        
        $data = self::generateData($depth, $itemCount);
        
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    private static function generateData(int $depth, int $itemCount) : array {
        
        $data = [];
        $types = ['string', 'int', 'bool'];
        
        for ($i = 0; $i < $itemCount; $i++) {
            $key = 'field_' . ($i + 1);
            
            if ($depth > 0 && mt_rand(0, 1)) {
                // Nested array
                $data[$key] = self::generateData($depth - 1, mt_rand(2, 4));
            } else {
                // Simple value
                $type = $types[array_rand($types)];
                $data[$key] = match ($type) {
                    'string' => 'value_' . bin2hex(random_bytes(4)),
                    'int' => mt_rand(1, 1000),
                    'bool' => (bool) mt_rand(0, 1),
                };
            }
        }
        
        return $data;
    }

}
