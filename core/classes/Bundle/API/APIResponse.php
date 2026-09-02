<?php 

namespace spoova\mi\core\classes\Bundle\API;

use spoova\mi\core\classes\Bundle\API\API;
use spoova\mi\core\classes\Ghost\GhostClass;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\classes\Ghost\GhostProxy;

/**
 * Ghost class for API Bundle. Provides IDE support for shutdown methods
 *  - Note that this class works with the {@see API} class bundle
 * 
 * @uses API class for managing API requests.
 */
abstract class APIResponse extends GhostClass {

    /**
     * Returns the response status code as at when shutdown was triggered.
     *
     * @return int
     */
    public function status() : int {
        return $this->proxy->status();
    }

    /**
     * Returns the string message from API response as at when shutdown was triggered
     * 
     * @return string
     */
    public function message() : string {
        return $this->proxy->message();
    }

    /**
     * Returns the message id from API response as at when shutdown was triggered
     * 
     * @param mixed $id if supplied, will be compared with the test id
     * @return int
     */
    public function id(mixed $id = null) : bool|int {
        return $this->proxy->id($id);
    }

    /**
     * Return the full API response as array or JSON format depending on channel type
     * 
     * @return array|string
     *  - array : array response data
     *  - string : JSON response data
     */
    public function data(bool $extras = false): array|string {
        return $this->proxy->data(...func_get_args());
    }

    /**
     * Displays the full API response as array or JSON format depending on channel type
     * 
     * @param array $response if supplied will set or modify response data keys.
     *    - status : This will overwrite both the reponse header code and response data code
     *    - message: This will overwrite both the reponse header message and response data message
     * @return void
     */
    public function view(array $response = []) {
        print_r($this->proxy->view(...func_get_args()));
    }

    /**
     * Retrieves failed responses
     *
     * @param string|null $type optional [headers|queries|referer|request_method|missing|empty]
     *  - headers : expected header that is invalid or missing
     *  - queries : expected url queries that is invalid or missing
     *  - referer : expected http referers that are not matched by the currently received http referer
     *  - methods : expected request methods that are not matched by current request method
     *  - data : empty or missing request data keys
     * @return void
     */
    public function failed(?string $type = null) {
        return $this->proxy->failed(...func_get_args());
    }

    /**
     * Returns a full data list for a specified key
     *
     * @param string $key an optional catalog's key whose value must be returned. 
     *  - options: [missing|mismatch|invalid]
     * @return array|false
     *  - returns FALSE if catalog key does not exist.
     *  - if catalog key exists returns JSON string or Array depending on channel type
     */
    public function catalog(?string $key = null): array|string|false{
        return $this->proxy->catalog(...func_get_args());
    }
}