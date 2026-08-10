<?php

//current uri &  server name  & environment

use spoova\mi\core\classes\DomUrl;

$_ENV['SERVER_URI']    = $_SERVER['REQUEST_URI'] ?? '';
$_ENV['SERVER_NAME']   = $_SERVER['SERVER_NAME'] ?? '';
$_ENV['SERVER_HOST']   = $_SERVER['HTTP_HOST'] ?? '';
$_ENV['SERVER_DOMURL'] = $_ENV['SERVER_HOST'];
$_ENV['SERVER_PORT']   = $_SERVER['SERVER_PORT']?? '';
$_ENV['REMOTE_ADDR']   = $_SERVER['REMOTE_ADDR']?? '';
$_ENV['SERVER_SOFTWARE']   = $_SERVER['SERVER_SOFTWARE']?? '';


if( !defined('server') ) {

	//constants: current uri & server name & environment
	/** Relative Server Path */
	define('uri', $_ENV['SERVER_URI']); 
	define('server', $_ENV['SERVER_NAME']);

	/** Host name (e.g localhost) */
	define('host', $_ENV['SERVER_HOST']);

	/** remote address */
	define('remote', $_ENV['REMOTE_ADDR']);

	/** Route path (i.e uri without hostname) */
	define('urx', explode('/', ltrim(uri,' /'), 2)[1]?? '');
	define('fext', 
		( ( ( !isset($_SERVER['HTACCESS']) && !isset($_SERVER['REDIRECT_HTACCESS']) ) ? '.php' : '') )
	);
	define('isPHPServer', 
		( (strpos($_ENV['SERVER_SOFTWARE'], 'PHP') !== false) && (!isset($_SERVER['SERVER_ADMIN'])) && !online )
	);

	//set environment
	if(!defined('online')) define('online', !(in_array(remote,['127.0.0.1','::1','']) ||
		(empty($_SERVER['DOCUMENT_ROOT']))));

	//set environment
	if(!defined('offline')) define('offline', !online);

	$_ENV['online'] = online; //set online value

	//apply errors for environment
	ini_set('display_errors', offline);

	//check secure protocols
	function isSecure() {
		
		$_S = $_SERVER;
		return (! empty($_S['HTTPS']) && $_S['HTTPS'] !== 'off')
		|| ( ! empty($_S['HTTP_X_FORWARDED_PROTO']) && $_S['HTTP_X_FORWARDED_PROTO'] == 'https')
		|| ( ! empty($_S['HTTP_X_FORWARDED_SSL']) && $_S['HTTP_X_FORWARDED_SSL'] == 'on')
		|| (isset($_S['SERVER_PORT']) && $_S['SERVER_PORT'] == 443)
		|| (isset($_S['HTTP_X_FORWARDED_PORT']) && $_S['HTTP_X_FORWARDED_PORT'] == 443)
		|| (isset($_S['REQUEST_WIN_REX']) && $_S['REQUEST_WIN_REX'] == 'https'
		);

	}

	/**
	 * This function is used to map images, css and javascript absolute 
	 * urls to http protocol urls valid urls
	 *
	 * @param string $path
	 * @param boolean $modified when set as false, $path will not be saved
	 * @return string
	 */
	function  domUrl($path='', bool $modified = true){

		$path = ltrim($path?:'', '/ ');
		$http = isSecure()? 'https://' : 'http://';
		$server = (server == 'localhost')? server.FS.docBase.FS : server.FS;
		$host   = (server == 'localhost')? host.FS.docBase.FS : host.FS;

		//keep track of last value supplied
		if($modified) SET(DomUrl::Name(), $path, DomUrl::Hash()); 

		$host   = (
			array_key_exists('PATH_INFO', $_SERVER) ||
			isPHPServer
		)? $server : $host;
		$basedom = '';

		if(func_num_args() === 2 && online){
			
			if($_SERVER['DOCUMENT_ROOT'] != func_get_args()[1]){
				$basedom = str_replace($_SERVER['DOCUMENT_ROOT'],'',func_get_args()[1]).'/';
			}
			
		}
		
		if(online){

			if(defined('fol')){
				$realFol = explode('/',fol)[0];
				$xPath = $server.$realFol;
				if(strpos($server.$path, $xPath) !== false){
					if(!empty($basedom)){
						$path = $server.$path;
						return $http.$path;
					}else{
						$path = ltrim(str_replace($xPath,'',$server.$path),'/ ');
					}
				}
			}
		}
		
		if(isPHPServer) {
			$host = host.FS;
		}

		$httpraw =  str_replace('//','/',$host.$path);
		$httpuse =  $http.$httpraw;
		
		$url = (substr($path, 0,4) == 'http')? $path : $httpuse;
		
		//get hash
		$urlhash = explode('#',$url);
		$urlquery = explode('?',$urlhash[0]);
		$url = $urlquery[0];
		
		if(basename($url.fext) !== '.php'){
			// use for other web servers if necessary
			// $url = (pathinfo($url, PATHINFO_EXTENSION) == '')? $url.fext : $url;
		}

		if(isset($urlhash[1])) $url .= '#'.$urlhash[1];
		if(isset($urlquery[1])) $url .= '?'.$urlquery[1];
        $url = str_replace(['http:///', 'https:///'], ['http://', 'https://'], $url); 
		return $url;
	}

	/**
	 * Convert path supplied to project path
	 *
	 * @param string $path path to be converted
	 * @param string $type optional [url|root|app] 
	 *  - url returns http protocol 
	 *  - root returns absolute path 
	 *  - app returns project path.
	 * @return string
	 */
	function dompath($path, $type = 'url'): string {

		if($type === 'url' || $type === 'app') {

			$path = str_replace(['/','\\'], DS, $path);
			$domroot = str_replace(['/','\\'], DS, domroot());

			$paths = explode($domroot, $path, 2);
			if(count($paths) === 2){
				$path = str_replace(['/','\\'], FS, domurl($paths[1], false));
				return ($type === 'app')? preg_replace('#^https?://#i', '', $path) : $path;
			}
			
			return ($type === 'app')? preg_replace('#^https?://#i', '', $path) : $path;
		}else if($type === 'root'){

			$path = str_replace(['/','\\'], DS, $path);
			$domurl = str_replace(['/','\\'], DS, domurl(modified: false));
			$paths = explode($domurl, $path, 2);
			if(count($paths) === 2){
				return str_replace(['/','\\'], DS, domroot($paths[1], false));
			}
			return $path;
		}

		return '';

	 }

	function server() {
		return Server::run();
	}
	
}