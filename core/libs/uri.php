<?php
/**
 * @author	MinWork Developers
 * @copyright	2009-2010
 * @package	Core
 */
 
class Uri
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
	
	/**
	 * Checks if request uri has any controller/action/params segments
	 *
	 * @return	bool
	 */
	public function has_segments()
	{
		if(Uri::count_segments() == 0) {
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
	public function split_segments($uri, $check_index = false)
	{
		$save_uri = $uri;
		
		$uri = preg_replace("/.*?\/index\.php/i", "", $uri);
		$uri = preg_replace("/\?.*/i", "", $uri);
		$uri = preg_replace("/\/$/i", "", $uri);
		$uri = preg_replace("/^\//i", "", $uri);
		$uri = trim($uri);
		
		//split segments into an array
		$uri = empty($uri) ? array() : @explode("/", $uri);
		
		//[FIGURE OUT WHAT I WAS THINKING HERE THEN EDIT/ADD COMMENT]
		if(!preg_match("/.*?\/index\.php/i", $save_uri) && $check_index == true) {
			if(is_array($uri) && count($uri) > 0) {
				unset($uri[0]);
			}
			$new_uri = array();
			foreach($uri as $u) {
				$new_uri[] = $u;
			}
			$uri = $new_uri;
		}
		
		return $uri;
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
		return count(Uri::segments());
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