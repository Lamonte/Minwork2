<?php
/**
 * Form Handler
 *
 * Form handler library to make handling forms easier
 *
 * @copyright	2011
 * @package	library 
 */
 
class FormHandler {

	public static $rules = array(); //user defined rules
	public static $callbacks = array(); //user defined callbacks
	
	public static $rules_function = array( //rule name => rule function name
		'empty'	=> 'rule_empty',
		'url'	=> 'rule_url',
	);
	
	public static $rules_message = array(
		'empty' => "Input field '$1' is empty!",
		'url'	=> "Input field '$1' not a valid url",
	);
	
	public static $callbacks_message = array();
	public static $error_array = array();
	
	/**
	 * Set Rules
	 *
	 * Allows you to setup form rules used to validate the inputs set
	 * 
	 * @param	string $input
	 * @param	array $rules
	 */
	//Biggest issue is if the user has an array as a $_POST value how
	//do I get around this.
	public function set_rules($input, $rules = array()) {
		self::$rules[$input] = $rules;
	}
	
	/**
	 * Set Callbacks
	 *
	 * Allows you to setup form callbacks (custom user functions) used to validate the inputs set
	 * 
	 * @param	string $input
	 * @param	array $rules
	 */
	
	public function set_callback($input, $callbacks = array()) {
		self::$callbacks[$input] = $callbacks;
	}
	
	/**
	 * Check rules
	 *
	 * This will loop through all rules, cross check if there was an error
	 *
	 * @return	bool
	 */
	public function check() {
	
		//loop through each user defined rule 
		foreach(self::$rules as $input => $rules_array) {
		
			//loop through each individual rule to access the function that applies to said rule
			foreach($rules_array as $rule) {
				
				//locate the function used to check said rule
				$function = self::$rules_function[$rule];
				
				//call the function, check the resturn value & set error message if the resturn value is true
				if(self::$function($input)) {
					self::set_error($input, $rule);
				}
			}
		}
		
		//loop through all callbacks and attempt to call them if methods exist
		foreach(self::$callbacks as $input => $callback) {
			
			//loop through all the callbacks
			foreach($callback as $cb) {
				
				//grabs the class/method from the array and creates a new array to check if its callable
				$class_method = array($cb[0], $cb[1]);
				
				//check if method is callable
				if(!is_callable($class_method, true, $callback_name)) {
					throw new Exception("Callback method couldn't be called: {$cb}");
				}
				
				//call user function. Note:: function needs to return true to trigger the error message
				$cb_result = call_user_func($class_method, $input);
				if($cb_result) {
					self::set_callback_error($cb[2]);
				}
			}
		}
		
		//Check if we have any errors
		return (count(self::$error_array) > 0 ? false : true);
	}
	
	/**
	 * Get Errors
	 *
	 * Allows me to access the error messages if there are any
	 *
	 * @return	string
	 */
	public function get_errors() {
		$error_string = "<ul><li>" . implode("</li> <li>", self::$error_array) . "</li></ul>";
		return $error_string;
	}
	
	/**
	 * Set Error
	 *
	 * Sets up an error message based on the rule
	 * 
	 * @return 	void
	 */
	public function set_error($input, $rule) {
		self::$error_array[] = str_replace('$1', $input, self::$rules_message[$rule]);
	}
	
	public function set_callback_error($error) {
		self::$error_array[] = $error;
	}
	
	/**
	 * ================================================= *
	 * ALL CUSTOM FORM HANDLER RULES WILL BE UNDER HERE  *
	 * ================================================= *
	 **/
	 
	//Field empty?
	private function rule_empty($input) {
		return (empty($_POST[$input]) ? true : false);
	}	
	
	//Url invalid?
	private function rule_url($input) {
		return (!preg_match("/((http|https|ftp):\/\/(\S*?\.\S*?))(\s|\;|\)|\]|\[|\{|\}|,|\"|'|:|\<|$|\.\s)/ie", $_POST[$input]) ? true : false);
	}
}

