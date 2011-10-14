<?php
/**
 * The Class that does the dirty work
 *
 * @package	core
 * @copyright	2009-2012
 */
 
class Template_Controller {

	public $template = 'template'; //default template file
	public $auto_render = true;    //check: __render() function
	//public $db = null;             //database variable to use globally in all extended controllers

	/**
	 * Load default template
	 */
	public function __construct()
	{
		//global $db;

		$this->template = new View($this->template);
		//$this->db = $db;
	}

	/**
	 * Auto rendering if auto render is off the html will not
	 * display unless echoing the template variable or calling 
	 * the render function from controller: $this->template->render();
	 *
	 * @return	void
	 */
	public function __render()
	{
		if($this->auto_render == true) {
			$this->template->render();
		}
	}
}