<?php 

namespace spoova\mi\core\classes; 

/**
 * Resolve the type of a value or a method's argument
 */
class ValueType {

    /**
     * normalize returned named for {@see gettype()} function
     *
     * @param string $type
     * @return void
     */
    public static function normalize(string $type)
    {
       return match (strtolower($type)) {
            'boolean' => 'bool',
            'integer' => 'int',
            'double'  => 'float', 
            'string'  => 'string',
            'array'   => 'array',
            'object'  => 'object',
            'resource' => 'resource',
            'null'    => 'null',
            default   => $type,
        };
    }

    public static function inType(mixed $value, string|array $type): bool {
        
        $actual = get_debug_type($value);

        // If Reflection provided an array of type names
        $types = is_array($type) ? $type : [$type];

        foreach ($types as $datatype) {
            $datatype = trim($datatype);

            // Nullable support: e.g. '?Foo'
            if (str_starts_with($datatype, '?')) {
                $baseType = substr($datatype, 1);
                if ($value === null || self::inType($value, $baseType)) {
                    return true;
                }
                continue;
            }

            $lower = strtolower($datatype);

            // Handle built-ins
            if ($lower === 'mixed') return true;
            if ($lower === 'scalar' && is_scalar($value)) return true;
            if ($lower === 'object' && is_object($value)) return true;
            if ($lower === 'callable' && is_callable($value)) return true;
            if ($lower === 'iterable' && is_iterable($value)) return true;

            // Handle class/interface checks
            if (class_exists($datatype) || interface_exists($datatype)) {
                if ($value instanceof $datatype) return true;
                continue;
            }

            // Fallback scalar match
            if ($lower === strtolower($actual)) return true;
        }

        return false;
    }


}