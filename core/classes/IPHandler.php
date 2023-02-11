<?php

namespace core\classes;

/**
 * This class is for handling IPAddresses
 * 
 */
class IPHandler
{
     public string $userIP;

     public function localIP(){
          return $this->get_local_ip();
     }

     /**
      * Get client ip
      *
      * @param string $type
      * @return void
      */
     public function clientIP($type=null){
          //$type: will be added later
          $this->userIP = $this->get_client_ip();
          return $this->userIP;
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

     // /**
     //  * Returns the information of an ip using geoplugin.net
     //  *
     //  * @param string $customIP
     //  * @return mixed
     //  */
     // public function geoInfo($customIP = null){
          
     //      $user_ip = !is_empty($customIP)? $customIP : $this->clientIP();
     //      if(!filter_var($user_ip,FILTER_VALIDATE_IP)){ return false; }
          
     //      try{
     //           $geo = unserialize(@file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
     //           return $geo;
     //      }catch(\Exception $e){
     //           return false;
     //      }
     // }

     private function get_client_ip()
     {
          // Nothing to do without any reliable information
          if (!isset($_SERVER['REMOTE_ADDR'])) {
               return false;
          }
          
          // Header that is used by the trusted proxy to refer to the original IP
          $proxy_header = "HTTP_X_FORWARDED_FOR";

          // List of all the proxies that are known to handle 'proxy_header' in known, safe manner
          $trusted_proxies = array("2001:db8::1", "192.168.50.1");

          if (in_array($_SERVER['REMOTE_ADDR'], $trusted_proxies)) {
               
               // Get IP of the client behind trusted proxy
               if (array_key_exists($proxy_header, $_SERVER)) {

                    // Header can contain multiple IP-s of proxies that are passed through.
                    // Only the IP added by the last proxy (last IP in the list) can be trusted.
                    $client_ip = trim(end(explode(",", $_SERVER[$proxy_header])));

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