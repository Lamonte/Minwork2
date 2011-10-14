<?php
/**
 * The Class that does the dirty work
 *
 * @package	core
 * @copyright	2009-2012
 */
class Minwork {

	/**
	 * Load Controllers
	 *
	 * This function first checks the url route to see if we are calling
	 * a function.  Then checks if the route exists, if all fails it 
	 * attempts to load the default controller from the config file.
	 * If it can't find the config file, it'll throw an error.
	 *
	 * @todo add template class rendering
	 * @return void
	 */
	public function load_controllers() {
		//grab default controller from url/setup default controller
		$controller = Request::instance()->get("c");
		$controller = empty($controller) ? default_controller : $controller;
		
		if(!is_null($controller)) {
			$controller_class_file = ROOT . "web/controllers/" . strtolower($controller) . ".php";
			
			//throw exception here if file doesn't exists
			if(!file_exists($controller_class_file)) {
				throw new Exception("Controller file ({$controller_class_file}) doesn't exist!");
			}
			
			//require class file
			require_once $controller_class_file;
			
			$controller_class = ucfirst($controller) . "_Controller";
			
			$action = Request::instance()->get("a");
			$action = empty($action) ? "index" : $action;
			
			$params = Request::instance()->get("params");
			$params = empty($params) ? array() : @explode(",", $params);
			
			//check if class exists
			if(!class_exists($controller_class)) {
				throw new Exception("Controller Class ({$controller_class}) doesn't exist!");
			}
			
			//create a new instance of the controller
			$controller = new $controller_class();
			
			//check if method exists
			if(!method_exists($controller_class, $action)) {
				throw new Exception("Controller Method ({$action}) doesn't exist!");
			}
			
			//load the action and send the parameters to the method
			call_user_func(array($controller, $action), $params);
		}
	}
}