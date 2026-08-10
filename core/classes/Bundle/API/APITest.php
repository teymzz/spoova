<?php 

namespace spoova\mi\core\classes\Bundle\API;

use Exception;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostProxy;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\classes\Bundle\API\API;
use spoova\mi\core\classes\Debug;
use spoova\mi\core\classes\DebugFilter;
use spoova\mi\core\classes\Ghost\GhostClass;

/**
 * Ghost class for API Bundle. Provides IDE support for data validation
 *  - Note that this class works with the {@see API} class bundle
 * 
 * @uses API class for managing API requests.
 */
abstract class APITest extends GhostClass {

    /**
     * Map GhostProxy id and return GhostFunction data object
     *
     * @return GhostFunction data
     */
    protected function proxy() : GhostFunction {
        return $this->proxy;
    }

    /**
     * Sets error response message for missing data keys that are detected for a given API data validation method.
     *
     * @param string[] $data array of keys and values pair where if test key fails, value is triggered as response.
     *  - The following argument formats are required depending on the validation method: 
     *    - headers : ['header_key'=>'error_message']
     *    - isXMLHttpRequest : ['error_message']
     *    - isReferred : ['error_message']
     *    - queries : ['error_message']
     *    - data : _not supported_ use the {@see APIData::missing()} method instead.
     * @return void
     */
    public function missing(array $data){
        //throw a default error exception for unsupported methods
        $filter = Debug::filter(function(DebugFilter $traces){
            return $traces->class(API::class, sort: true)[0]??[];
        });
        if($filter && isset($filter['function'])){
            throw new Exception('APITest::missing() not supported on API::'.$filter['function'].'() method'); 
        }
    }

    /**
     * Sets error response message for only data keys that exists but their values mismatches expected values of a predefined data key within an API data validation method.
     *
     * @param string[] $data array of keys and values pair where if test key fails, value is triggered as response.
     *  - The following argument formats are required depending on the validation method: 
     *    - headers : ['header_key'=>'error_message']
     *    - isXMLHttpRequest : ['error_message']
     *    - isReferred : ['error_message']
     *    - queries : ['query_name'=>'error_message']
     *    - data : _not supported_ use the {@see APIData::mismatch()} method instead.
     * @return void
     */
    public function mismatch(array $data){ 
        //throw a default error exception for unsupported methods
        $filter = Debug::filter(function(DebugFilter $traces){
            return $traces->class(API::class, sort: true)[0]??[];
        });
        if($filter && isset($filter['function'])){
            throw new Exception('APITest::mismatch() not supported on API::'.$filter['function'].'() method'); 
        }
    }

    /**
     * Sets error response message for invalid data keys detected for a given API data validation method.
     *  - Warning : This method will throw Exception if it is not supported on the extended class object.
     * @param string[] $data array of keys and values pair where if test key fails, value is triggered as response. 
     *    - headers : ['header_key'=>'error_message']
     *    - isXMLHttpRequest : ['error_message']
     *    - isReferred : ['error_message']
     *    - queries : ['query_name'=>'error_message']
     *    - data : _not supported_ use the {@see APIData::invalid()} method instead.
     * @return void
     * @throws Exception if not supported.
     */
    public function invalid(array $data){
        //throw a default error exception for unsupported methods
        $filter = Debug::filter(function(DebugFilter $traces){
            return $traces->class(API::class, sort: true)[0]??[];
        });
        if($filter && isset($filter['function'])){
            throw new Exception('APITest::invalid() not supported on API::'.$filter['function'].'() method'); 
        }
    }

}