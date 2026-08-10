<?php

namespace spoova\mi\core\classes;

use InvalidArgumentException;
use RuntimeException;
use SimpleXMLElement;

class Response
{
    private static ?self $instance = null;
    private static int $code = 0;
    private static array $headers = [];
    private static mixed $data;
    private static array $keyMap = [];
    private static string $format = 'auto';

    /**
     * Stores content types disabled from sending http_response_code.
     *
     * @var array set_reponse
     */
    private static array $skip_http_response_code = [];

    private static bool $sent = false;

    /**
     * Contains the map of status codes to their relative text string description equivalent.
     */
    public const text = [

        // 1xx
        100 => 'Continue', // Continue sending request
        101 => 'Switching Protocols', // Protocol Upgrade (e.g HTTP Websocket)
        102 => 'Processing',  // Ongoing process
        103 => 'Early Hints', // link preload before final response

        // 2xx
        200 => 'Ok', // Success
        201 => 'Created', // Resource created
        202 => 'Accepted', // Resource accepted but not completed
        203 => 'Non-Authoritative Information', // Response modified by a proxy
        204 => 'No content', // Success, no body returned
        205 => 'Reset Content', // Hint to reset form/view
        206 => 'Partial Content', // Partial response
        207 => 'Multi-Status', // Multiple Results
        208 => 'Already Reported', // Same source already reported
        226 => 'IM Used', // Delta Updates applied (HTTP Delta Encoding)

        // 3xx
        300 => 'Multiple Choices', // Multiple possible responses
        301 => 'Moved Permanently', // Resource moved permanently
        302 => 'Found', // Temporary redirect
        303 => 'See Other', // Redirect using GET
        304 => 'Not Modified', // Cached version still valid
        305 => 'Use Proxy', // Must use proxy (deprecated)
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect', 
        326 => 'IM Used', // Delta updates applied (HTTP Delta Encoding)

        // 4xx
        400 => 'Bad Request', // Invalid syntax / request
        401 => 'Unauthorized', // Authentication required.
        402 => 'Payment Required',
        403 => 'Forbidden', // Authenticated, but not allowed.
        404 => 'Not Found', // Resource not found.
        405 => 'Method Not Allowed', // HTTP method not supported.
        406 => 'Not Acceptable', // Content type not acceptable.
        407 => 'Proxy Authentication Required', // Must authenticate with proxy
        408 => 'Request Timeout', // Client took too long to send request
        410 => 'Gone', // Resource permanently gone.
        411 => 'Length Required', // Missing Content-Length.
        412 => 'Precondition Failed', // One or more conditions failed.
        413 => 'Payload Too Large', // Request body too large.
        414 => 'URI Too Long', //Request URI too long.
        415 => 'Unsupported Media Type', // Format not supported.
        416 => 'Range Not Satisfiable', // Invalid range request.
        417 => 'Expectation Failed', // Expect header not met.
        418 => 'I’m a Teapot', // April Fools joke (RFC 2324).
        421 => 'Misdirected Request', // Request sent to wrong server.
        422 => 'Unprocessable Entity', // Request valid but semantic errors (WebDAV).
        423 => 'Locked', // Resource locked (WebDAV).
        424 => 'Failed Dependency', // Dependent request failed (WebDAV).
        425 => 'Too Early', // Server unwilling to process risk of replay.
        426 => 'Upgrade Required', // Client must upgrade protocol.
        428 => 'Precondition Required', // Must provide conditions (to prevent lost updates).
        429 => 'Too Many Requests', // Rate limit exceeded.
        431 => 'Request Header Fields Too Large', // Headers too large.
        451 => 'Unavailable For Legal Reasons', // Blocked for legal reasons.

        // 5xx
        500 => 'Internal Server Error', // Generic server error.
        501 => 'Not Implemented', // Feature not supported.
        502 => 'Bad Gateway', // Invalid response from upstream server.
        503 => 'Service Unavailable', // Server temporarily overloaded or down.
        504 => 'Gateway Timeout', // Upstream server timeout.
        505 => 'HTTP Version Not Supported', // Version not supported.
        506 => 'Variant Also Negotiates', // Content negotiation config error.
        507 => 'Insufficient Storage', // Server out of storage (WebDAV).
        508 => 'Loop Detected', // Infinite loop in request (WebDAV).
        510 => 'Not Extended', // Policy extensions required.
        511 => 'Network Authentication Required', // Must authenticate to network.

    ];

    private function __construct() {}

    private static function instantiate(bool $clean = true): static
    {
        if($clean){
            self::$code = 0;
            self::$data = null;
            self::$headers = [];
            self::$keyMap = [
                'status'  => 'status',
                'msg'     => 'msg',
                'data'    => 'data',
                'headers' => 'headers',
            ];
            self::$format = 'auto';
            self::$sent = false;
        }

        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public static function new(bool $clean = true): static
    {
        return self::instantiate($clean);
    }

    public static function code(int $code = 0): int|static
    {
        if (func_num_args() > 0) {
            $code = abs($code);
            if ($code < 100 || $code > 599) {
                throw new InvalidArgumentException('argument must be within 100–599 valid response codes');
            }
            self::$code = $code;
            return self::$instance;
        }
        return self::$code;
    }

    public function headers(?array $headers = null): array|static
    {
        if ($headers !== null) {
            self::$headers = $headers;
            return self::$instance;
        }
        return self::$headers;
    }

    public function data(mixed $data = null): mixed
    {
        if (func_num_args() > 0) {
            self::$data = $data;
            return self::$instance;
        }
        return self::$data;
    }

    /**
     * Sets a custom response key mapping
     *
     * @param array $map
     * @return static
     */
    public function map(array $map): static
    {
        self::$keyMap = array_merge(self::$keyMap, $map);
        return self::$instance;
    }

    public function state(array $map = []): array
    {
        if(func_num_args() === 0) $map = self::$keyMap;

        $response = self::template(self::$code, self::text(self::$code), null, self::$data, $map);

        return $response;
    }
        
    /**
     *
     * @param boolean $coded
     * @return static
     */
    /**
     * Returns the equivalent string description for the response code supplied
     *
     * @param integer $code response status code within the range of 1xx and 5xx response header codes.
     * @param string $default default message if no description was detected.
     * @return string
     */
    public static function text(int $code, $default= 'Unknown'): string
    {
        return self::text[$code] ?? $default;
    }

    /* ========= FORMATTERS ========= */
    
    /**
     * Sets the response format as JSON
     *
     * @param boolean $coded FALSE disables setting header content-type.
     * @return static
     */
    public static function json(bool $coded = true): static
    {
        self::new(false);
        $type = __FUNCTION__;
        $skip =& self::$skip_http_response_code;
        if(!$coded) {($skip[] = $type);} else{ unset($skip[array_search($type, $skip)]); };
        self::$format = $type;
        return self::$instance;
    }

    /**
     * Sets the response format as XML
     *
     * @param boolean $coded FALSE disables setting header content-type as 'text/xml'.
     * @return static
     */
    public static function xml(bool $coded = true): static
    {
        self::new(false);
        $type = __FUNCTION__;
        $skip =& self::$skip_http_response_code;
        if(!$coded) {($skip[] = $type);} else{ unset($skip[array_search($type, $skip)]); };
        self::$format = $type;
        return self::$instance;
    }

    /**
     * Sets the response format as HTML
     *
     * @param boolean $coded FALSE disables setting header content-type as 'text/html'.
     * @return static
     */
    public static function html(bool $coded = true): static
    {   
        self::new(false);
        $type = __FUNCTION__;
        $skip =& self::$skip_http_response_code;
        if(!$coded) {($skip[] = $type);} else{ unset($skip[array_search($type, $skip)]); };
        self::$format = $type;
        return self::$instance;
    }

    /**
     * Sets the response format as TEXT
     *
     * @param boolean $coded FALSE disables setting header content-type as 'text/plain'.
     * @return static
     */
    public static function plain(bool $coded = true): static
    {
        self::new(false);
        $type = __FUNCTION__;
        $skip =& self::$skip_http_response_code;
        if(!$coded) {($skip[] = $type);} else{ unset($skip[array_search($type, $skip)]); };
        self::$format = $type;
        return self::$instance;
    }

    /**
     * Sets the response format to automatic detection.
     *
     * @param boolean $coded FALSE disables setting header content-type for auto-detected response data type.
     * @return static
     */
    public static function autoFormat(bool $coded = true): static
    {
        self::new(false);
        $type = 'auto';
        $skip =& self::$skip_http_response_code;
        if(!$coded) {($skip[] = $type);} else{ unset($skip[array_search($type, $skip)]); };
        self::$format = $type;
        return self::$instance;
    }

    private static function formatResponse(mixed $data = []): string
    {
        $data = func_num_args() > 0 ? $data : (self::$data??[]);

        switch (self::$format) {
            case 'json':
                self::$headers['Content-Type'] = 'application/json';
                return json_encode($data, JSON_PRETTY_PRINT);

            case 'xml':
                $xdata = (array) $data;
                self::$headers['Content-Type'] = 'application/xml';
                $xml = new SimpleXMLElement('<response/>');
                array_walk_recursive($xdata, fn($v, $k) => $xml->addChild($k, $v));
                return $xml->asXML();

            case 'html':
                self::$headers['Content-Type'] = 'text/html';
                return is_scalar($data) ? (string) $data : print_r($data, true);

            case 'plain':
                self::$headers['Content-Type'] = 'text/plain';
                return is_scalar($data) ? (string) $data : print_r($data, true);

            case 'auto':
            default:
                if (is_array($data) || is_object($data)) {
                    self::$headers['Content-Type'] = 'application/json';
                    return json_encode($data, JSON_PRETTY_PRINT);
                }
                self::$headers['Content-Type'] = 'text/plain';
                return (string) $data;
        }
    }
    
    /**
     * Template format for {@see Response::from()} and {@see Response::fake()}
     *
     * @param int $code Validly acceptable response codes
     * @param mixed $msg
     * @param boolean|null $success
     * @param array $data
     * @param array $map
     * @return array
     */
    private static function template($code, mixed $msg, ?bool $success = null, $data = [], $map = []) : array {

        $success ??= ($code >= 200 && $code < 400);

        $response_format = [
            'status' => $code,
            'msg' => $msg,
            'success' => $success,
            'error' => !$success,
            'data' => $data
        ];
       
        $response = [];
        foreach($response_format as $key => $value){
            $nkey = $map[$key]??$key;
            $nkey = $nkey === true? $key : $nkey;
            $nkey = is_scalar($nkey)? trim((string)$nkey) : '';
            if($nkey) $response[$nkey] = $value;
        }

        // set extras ....
        if(($map['headers']??false) === true){
            $response['headers'] = self::$headers;
        }
        if(($map['type']??false) === true){
            $response['type'] = self::$format;
        }
        return $response; // new response template
    }

    /* ========= SEND / FAKE / FROM ========= */
    public function send(array $map = []): never
    {
        if (self::$sent) {
            throw new RuntimeException("Response already sent");
        }
        self::$sent = true;

        if ($map) {
            self::$instance->state($map);
        }
        
        if($code = self::$code) {
            $msg = self::text($code);
            http_response_code($code);
            header("HTTP/1.1 {$code} $msg");
        }
        foreach (self::$headers as $k => $v) {
            header("$k: $v");
        }
        echo self::formatResponse();
        exit;
    }

    /**
     * Fake a response header code
     *
     * @param integer $code header code sent
     * @param mixed $data data
     * @param boolean|null $success success & error keys determinants
     * @param array $map response data keys map
     * @return string
     */
    public static function fake(int $code, array $data, ?bool $success = null, array $map = []): string
    {
        $faked = $code;
        $status_code = $data['code'] ?? self::$code;
        $success ??= ($status_code >= 200 && $status_code < 400);
        $message = $data['msg'] ?? self::text($status_code); // from $data (msg or code)

        // Define map to use ... 
        $map = func_num_args() > 3? $map: (self::$keyMap??[]);

        $response = self::template($status_code, $message, $success, $data['data']??[], $map);
        $response = self::formatResponse($response);
        
        // // Default content-type if not set
        $contentType = self::$headers['Content-Type'] ?? 'application/json';
        if(!in_array(self::$format,self::$skip_http_response_code))header("Content-Type: $contentType");
        header("HTTP/1.1 $faked $message");

        return $response;
    }

    /**
     * Builds a response from supplied data
     *
     * @param array $data
     * @param array $map
     * @return string
     */
    public static function from(array $data, array $map = []): string
    {
        $code = $data['code'] ?? self::$code;
        $success = ($code >= 200 && $code < 400);
        $message = $data['msg'] ?? self::text(self::$code); // from $data (msg or code)

        // Define map to use ... 
        $map = func_num_args() > 1? $map: self::$keyMap;

        $response = self::template($code, $message, $success, $data['data']??[], $map);
        $response = self::formatResponse($response);
        
        $contentType = self::$headers['Content-Type'] ?? 'application/json';
        if(!in_array(self::$format,self::$skip_http_response_code))header("Content-Type: $contentType");
        if($code)header("HTTP/1.1 $code $message");

        return $response;
    }

}