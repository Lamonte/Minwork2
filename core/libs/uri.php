<?php
/**
 * @author	MinWork Developers
 * @copyright	2009-2010
 * @package	Core
 */
 
class uri
{
	private static $_Instance = null;
	private function __construct(){}
	
	public static function instance()
	{
		$class = __CLASS__;
		if(is_null(self::$_Instance)) {
			self::$_Instance = new $class();
		}
		return self::$_Instance;
	}	
	
	/*
	 * Redirect Url
	 *
	 * Redirect user directly to the url provided or to a controller provided
	 */
	public function redirect($redirect_url) {
		
		if(is_array($redirect_url)) {
			$redirect_url = self::base() . implode("/", $redirect_url);	
		}
		
		header("Location: " . $redirect_url); exit();
	}
	
	/**
	 * Checks if request uri has any controller/action/params segments
	 *
	 * @return	bool
	 */
	public function has_segments()
	{
		if(uri::count_segments() == 0) {
			return false;
		}
		return true;
	}
	
	/**
	 * Grabs uri segment, it not defined returns
	 * an array of the request uri segment controller/action/params
	 *
	 * @return	mixed
	 */
	public function segments($segment = null) // 0 = first segment
	{
		$uri = $_SERVER['REQUEST_URI'];
		
		$uri = $this->split_segments($uri, true);
		
		//I don't use empty() because I want to check
		//if were actually returning the whole array
		if(is_null($segment)) {
			return $uri;
		}
		
		if(isset($uri[$segment])) {
			return $uri[$segment];
		}
		
		return array();
	}

	/**
	 * Strip string into an array of segments
	 *
	 * @param	string
	 * @param	bool	default - false
	 * @return	array
	 */
	public function split_segments($url, $global_url = false) {
		//search for the index.php and anything before it and remove it
		$url = preg_replace("/.*?\/index\.php/i", "", $url);
		
		//replace any get variables starting after the question mark ex. index.php?
		$url = preg_replace("/\?.*/i", "", $url);
		
		//remove the last forward slash if one
		$url = preg_replace("/\/$/i", "", $url);
		
		//remove first forward slash 
		$url = preg_replace("/^\//i", "", $url);
		
		//remove any unnecessary whitespace from the beginning and end of the string
		$url = trim($url);
		
		//make sure we're getting everything that isn't the directory
		$url = empty($url) ? array() : @explode("/", $url);
		
		if(empty($url)) {
			return $url;	
		}
		
		if($global_url == true) {
			if(count($url) > 0) {
				unset($url[0]);
			}
			
			//fix array
			$temp_url = array();
			foreach($url as $u) {
				$temp_url[] = $u;
			}
			$url = $temp_url;
		}
		
		return $url;
	}
	
	/**
	 * Count's total segments in a url
	 * Ex. controller/action/param1/param2 the output would be
	 * 4 after splitting the "/" from the segments
	 *
	 * @return	integer
	 */
	public function count_segments()
	{
		return count(uri::segments());
	}
	
	/** [REWRITE THIS]
	 * Returns the base url set in the config
	 *
	 * @return	string
	 */
	public function base()
	{
		global $config;
		return (isset($config[db_connection]['uri']) && isset($config[db_connection]['uri']) ? $config[db_connection]['uri']['base'] : null);
	}
}