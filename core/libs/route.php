<?php

/**
 * Routes Class
 *
 * Used to reroute urls and url masks to certain controllers
 * allowing for cleaner urls.
 *
 * @package	core
 * @copyright	2009-2012
 */
 
class route {
	
	private static $mask = array(); //url masks, used to rewrite a custom url to a controller
	private static $instance = null;
	private static $regex = array(
		'(:num)'	=> '(\d+)',
		'(:any)'	=> '(.*?)'	
	);
	
	public static function instance() {
		$class = __CLASS__;
		if(is_null(self::$instance)) {
			self::$instance = new $class;
		}
		return self::$instance;
	}
	
	/**
	 * Basic Remapping
	 *
	 * Used to take the url and insert it into global variables,
	 * later used in our route class allowing us to reroute and mask
	 * urls to our likings.
	 *
	 * @return void
	 */
	public function basic_remapping() {
		$url_array = uri::instance()->split_segments($_SERVER['REQUEST_URI'], true);
		
		//return null results if array is empty, use default controller/action
		if(empty($url_array)) {
			$_GET['c'] = null;
			$_GET['a'] = null;
			$_GET['params'] = null;
		}
		
		//setup the controller and action global variables for later use
		$_GET['c'] = isset($url_array[0]) ? $url_array[0] : null;
		$_GET['a'] = isset($url_array[1]) ? $url_array[1] : null; 
		
		//remove the first two array values from the array and return the rest
		//of the array to setup the parameters assuming there are params
		unset($url_array[0]);
		unset($url_array[1]);
		
		//check if the array isn't empty then assign the rest of the 
		//variables to the params global variable.
		if(is_array($url_array) && !empty($url_array)) {
			$temp_url_array = array();
			foreach($url_array as $url_arr) {
				$temp_url_array[] = $url_arr;
			}
			$_GET['params'] = $temp_url_array;
		}
	}	
	
	/**
	 * Add Mask
	 *
	 * Add a custom url mask, that masks a custom url to a controller
	 * allow to create really clean looking urls.
	 * ex. Route::add_mask("pages/custom-(:num)-(:num).html", "controller/action/$1/$2");
	 *
	 * @param string $mask_name
	 * @param string $replacement
	 * @return void
	 */
	public static function add_mask($mask_name, $replacement) {
		self::$mask[] = array($mask_name, $replacement);
	}
	
	public function start_masking() {
	
		self::basic_remapping();
	
		//current url split into an array
		$url_array = uri::instance()->split_segments($_SERVER['REQUEST_URI'], true);
		
		//if url isn't complete, exit the function
		if(!is_array($url_array)) {
			return null;
		}
		
		//loop through every mask
		foreach(self::$mask as $mask) {
			
			//Prepare string to be parsed, so it doesn't break regular expressions
			$mask[0] = preg_quote($mask[0], "/");
			
			//replace any regular expression placers
			foreach(self::$regex as $regex => $val) {
				
				//Fix regular expression placers so they can get parsed correctly
				$temp_regex = preg_quote($regex, "/");
				$mask[0] = str_replace($temp_regex, $regex, $mask[0]);
				
				//Replace regular expression placers with actual regular expression syntax
				$mask[0] = str_replace($regex, $val, $mask[0]);
				
			}
			
			//check if the masked page is actually loaded
			$current_url = implode("/", $url_array);
			if(preg_match("/" . $mask[0] . "/i", $current_url, $matches)) {
				
				//replace temp variables inside the controller string
				for($x = 0; $x < count($matches); $x++) {
					$mask[1] = str_replace("\${$x}", $matches[$x], $mask[1]);
				}
				
				//setup global variables
				$masked_url = $mask[1];
				$masked_url = uri::instance()->split_segments($masked_url);
				
				//@todo Make this & the basic remapping into a function to minimize code
				//setup the controller and action global variables for later use
				$_GET['c'] = isset($masked_url[0]) ? $masked_url[0] : null;
				$_GET['a'] = isset($masked_url[1]) ? $masked_url[1] : null; 
				
				//remove the first two array values from the array and return the rest
				//of the array to setup the parameters assuming there are params
				unset($masked_url[0]);
				unset($masked_url[1]);
				
				//check if the array isn't empty then assign the rest of the 
				//variables to the params global variable.
				if(is_array($masked_url) && !empty($masked_url)) {
					$_GET['params'] = $masked_url;
				}
			}	
		}
		
	}
}