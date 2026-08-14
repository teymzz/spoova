<?php

namespace spoova\mi\core\classes;

/**
 * This class is for handling IPAddresses
 *
 * The client address is only ever taken from a proxy header when the request
 * actually arrived from a proxy that has been named as trusted. Any client can
 * put whatever it likes in X-Forwarded-For, so reading it unconditionally would
 * let a caller hand itself a new identity on every request — which is exactly
 * what defeats anything keyed on the address, rate limits included.
 */
class IPHandler
{
     public string $userIP;

     /**
      * Addresses of proxies whose forwarded-for header may be believed.
      *
      * Plain addresses and CIDR ranges are both accepted, e.g.
      * ```['10.0.0.0/8', '2001:db8::1']```. Anything set here takes precedence
      * over the configured value.
      *
      * @var array|null
      */
     public static ?array $trustedProxies = null;

     public function localIP(){
          return $this->get_local_ip();
     }

     /**
      * Get client ip
      *
      * @param string|null $type reserved
      * @return string the client address, or an empty string when none can be
      *   established — $userIP is typed, so the internal FALSE arrives here as ''.
      */
     public function clientIP(?string $type = null){
          //$type: will be added later
          $this->userIP = $this->get_client_ip();
          return $this->userIP;
     }

     /**
      * Proxies whose forwarded-for header may be believed.
      *
      * Read from the property when it is set, otherwise from the TRUSTED_PROXIES
      * init key as a comma separated list. The default is none: with no proxy
      * named, REMOTE_ADDR is the only address ever used, which is the setting a
      * project wants until it genuinely sits behind a load balancer.
      *
      * @return array
      */
     public static function trustedProxies() : array {

          if(is_array(self::$trustedProxies)) return self::$trustedProxies;

          /* Init reads the project's icore directory, so it can only be asked once the
             framework has been bootstrapped. Outside that — a unit test, a script — the
             answer is simply that no proxy is trusted. */
          $configured = (defined('_icore') && class_exists(Init::class))
               ? (string) (Init::key('TRUSTED_PROXIES') ?: '')
               : '';

          if(trim($configured) === '') return [];

          return array_values(array_filter(array_map('trim', explode(',', $configured)), 'strlen'));

     }

     /**
      * Whether an address belongs to one of the trusted proxies.
      *
      * @param string $address
      * @return bool
      */
     private function isTrustedProxy(string $address) : bool {

          foreach(self::trustedProxies() as $trusted){

               if(!str_contains($trusted, '/')){
                    if($address === $trusted) return true;
                    continue;
               }

               if(self::inRange($address, $trusted)) return true;

          }

          return false;

     }

     /**
      * Whether an address falls inside a CIDR range.
      *
      * Compared on the raw packed bytes so that one routine answers for both IPv4
      * and IPv6 rather than needing a separate path for each.
      *
      * @param string $address
      * @param string $range CIDR notation, e.g. 10.0.0.0/8
      * @return bool
      */
     private static function inRange(string $address, string $range) : bool {

          [$subnet, $bits] = array_pad(explode('/', $range, 2), 2, null);

          $ip     = @inet_pton($address);
          $net    = @inet_pton($subnet);
          $bits   = (int) $bits;

          // different families never match, and neither does anything unparseable
          if($ip === false || $net === false || strlen($ip) !== strlen($net)) return false;

          if($bits < 0 || $bits > (strlen($ip) * 8)) return false;

          $whole = intdiv($bits, 8);
          $rest  = $bits % 8;

          if($whole > 0 && strncmp($ip, $net, $whole) !== 0) return false;

          if($rest === 0) return true;

          $mask = chr((0xFF << (8 - $rest)) & 0xFF);

          return (($ip[$whole] & $mask) === ($net[$whole] & $mask));

     }

     private function get_local_ip(){
          
          if(function_exists("getHostName")){
               return gethostbyname(getHostName());
          }elseif (function_exists('php_uname')) {
               return gethostbyname(php_uname('n'));
          }else{
               return false;
          }
     }

     private function get_client_ip()
     {
          // Nothing to do without any reliable information
          if (!isset($_SERVER['REMOTE_ADDR'])) {
               return false;
          }
          
          // Header that is used by the trusted proxy to refer to the original IP
          $proxy_header = "HTTP_X_FORWARDED_FOR";

          /* The list used to be two hardcoded documentation addresses, which no real
             request ever arrives from — so the header was in practice never read, and
             a project genuinely behind a proxy had to edit this file to change that.
             It is configuration now: see IPHandler::trustedProxies(). */
          if ($this->isTrustedProxy($_SERVER['REMOTE_ADDR'])) {

               // Get IP of the client behind trusted proxy
               if (array_key_exists($proxy_header, $_SERVER)) {

                    // Header can contain multiple IP-s of proxies that are passed through.
                    // Only the IP added by the last proxy (last IP in the list) can be trusted.
                    $explode = explode(",", $_SERVER[$proxy_header]);
                    $client_ip = trim(end($explode));

                    // Validate just in case
                    if (filter_var($client_ip, FILTER_VALIDATE_IP)) {
                         return $client_ip;
                    } else {
                         // Validation failed - beat the guy who configured the proxy or
                         return false;
                    }
               }
          }

          // In all other cases, REMOTE_ADDR is the ONLY IP we can trust.
          return $_SERVER['REMOTE_ADDR'];
     }

}