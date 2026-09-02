<?php 
namespace spoova\mi\core\classes;

use Closure;
use ReflectionFunction;
use ReflectionNamedType;

/**
 * This class is created to ease the use of PHP's 
 * {@see debug_backtrace()} function 
 */
class Debug {

    /**
     * Contains the real backtrace
     *
     * @var array
     */
    private static $backTrace = []; 

    /**
     * Contains the modified backtrace
     *
     * @var array
     */
    private static $traces = [];
    private static $init = false;
    public const IGNORE_ARGS = DEBUG_BACKTRACE_IGNORE_ARGS; 
    public const PROVIDE_OBJECT = DEBUG_BACKTRACE_IGNORE_ARGS; 


    function __construct(int $options = Debug::IGNORE_ARGS, int $limit = 0)
    {
        self::init(...func_get_args());
    }

    function __invoke()
    {
        return self::get(...func_get_args());
    }

    /**
     * Fetch a key in backtraces.
     *
     * @param integer|array $key
     *  - integer will select a single key out of backtrace
     *  - array will select and store multiple keys out of backtrace
     * 
     * @param integer|boolean $length
     *  - TRUE returns full length of errors starting from specified error index key
     *  - FALSE returns a single error relative to the specified error index key
     *  - INTEGER returns a total number of errors starting from the specified error index key
     * @return array
     */
    static function get(int|array $key, int|bool $length = false) : array {
        self::init();
        $backTraces = self::$traces;
        if(is_array($key)){
            $response = [];
            foreach($backTraces as $tracekey => $trace){
                if(in_array($tracekey, $key)) $response[$tracekey] = $trace;
            }
            return $response;
        }
        if(is_int($length) || ($length === true)){
            if($length === true) $length = count(self::traces());
            $response = [];
            foreach($backTraces as $tracekey => $trace){
                if(($tracekey >= $key) && ($tracekey <= $length)) $response[$tracekey] = $trace;
            }
            return $response;
        }
        return self::$traces[$key] ?? [];
    }

    /**
     * Fetch all traces key in backtrace.
     *
     * @return array
     */
    static function traces() : array {
        self::init();

        return self::$traces;
    }

    /**
     * Filter all traces key in backtrace.
     *
     * @return array
     */
    static function filter(Closure $filter) : array {
        self::init();

        $reflection = new ReflectionFunction($filter);
        $params = $reflection->getParameters();
        $type = '';
       
        foreach($params as $param){
            $type = $param->getType();
            if($type instanceof ReflectionNamedType){
                $type = $type->getName();
            }
            break;
        }
        
        if($type === DebugFilter::class){
            return $filter(new DebugFilter(self::$traces));
        }
        return $filter(self::$traces);
    }

    private static function init(){
        if(self::$init) return;
        $args = func_get_args();
        if(!$args) $args[0] = Debug::IGNORE_ARGS;
        self::$backTrace = $traces = debug_backtrace(...$args);
        unset($traces[0], $traces[1]); // reset the default file
        self::$traces = array_values($traces);
        self::$init = true;
    }

}