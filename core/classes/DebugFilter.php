<?php 
namespace spoova\mi\core\classes;

use Closure;
use ReflectionFunction;

/**
 * This class contains methods that determine how {@see Debug::filter()} filters out
 * traces
 */
class DebugFilter {

    public function __construct(private array $traces){}

    /**
     * Filter traces using filename
     *
     * @param string $filename
     * @param integer $length maximum length of data retrieved
     * @param boolean $sort TRUE sort index keys while FALSE maintains index keys
     * @return array
     */
    public function file(string $filename, $length = 1, bool $sort = false) : array{
        $traces = $this->traces;
        $i = 0; $traceList = [];
        $filename = strtolower($filename);
        
        foreach($traces as $ti => $trace){
            if($i === $length) break;
            if(isset($trace['file']) && strtolower($trace['file']) === $filename){
                $traceList[$ti] = $trace;
                $i++;
            }
        }
        return $sort? array_values($traceList) : $traceList;
    }

    /**
     * Filter traces using function (or method) name
     *
     * @param string $funcname
     * @param integer $length maximum length of data retrieved
     * @param boolean $sort TRUE sort index keys while FALSE maintains index keys
     * @return array
     */
    public function function(string $funcname, $length = 1, bool $sort = false) : array{
        $traces = $this->traces;
        $i = 0; $traceList = [];
        $funcname = strtolower($funcname);
        foreach($traces as $ti => $trace){
            if($i === $length) break;
            if(isset($trace['function']) && strtolower($trace['function']) === $funcname){
                $traceList[$ti] = $trace;
                $i++;
            }
        }
        return $sort? array_values($traceList) : $traceList;
    }

    /**
     * Filter traces using class name
     *
     * @param string $classname
     * @param integer $length maximum length of data retrieved
     * @param boolean $sort TRUE sort index keys while FALSE maintains index keys
     * @return array
     */
    public function class(string $classname, $length = 1, bool $sort = false){
        $traces = $this->traces;
        $i = 0; $traceList = [];
        $classname = strtolower($classname);
        foreach($traces as $ti => $trace){
            if($i === $length) break;
            if(isset($trace['class']) && strtolower($trace['class']) === $classname){
                $traceList[$ti] = $trace;
                $i++;
            }
        }
        return $sort? array_values($traceList) : $traceList;
    }

}