<?php
/**
 * @author	MinWork Developers
 * @copyright	2009-2010
 * @package	Core
 */
 
class View
{
	public  $_data        = array();
	private $_view        = null;
	private $_render_data = null;
	private $_throw_excep = true;
	/**
	 * Setup some class defaults
	 */
	public function __construct($view = 'template', $throw_exception = true)
	{
		$this->_view = $view;
		$this->_throw_excep = $throw_exception; //do you want to hard check if the file exists
							//main use is for using this class in none controllers/views
	}

	/**
	 * Newly created data added to class array so we
	 * know which data to extract when rendering the view as
	 * well as not overwrite existing class variables.
	 *
	 * @return	void
	 */
	public function __set($key, $val) 
	{
		$this->_data[$key] = $val;
	}

	/**
	 * This is required so when say you want to reassign data or add new data to an
	 * already created variable, this is required to get access to that data from outside
	 * access.
	 */
	public function __get($key)
	{
		return $this->_data[$key];
	}

	/**
	 * Renders view file if printed to the screen
	 *
	 * @return	void
	 */
	public function __toString()
	{
		return $this->render(TRUE);
	}

	/**
	 * Load and render template file
	 *
	 * @return	void
	 */
	public function render($return = false)
	{
		//Try loading the view file then outputting it to the screen
		if(!file_exists(ROOT . "web/views/" . $this->_view . ".php")) {
			if($this->_throw_excep == false) {
				return false;
			}
			throw new Exception("Couldn't load view file: '{$this->_view}'");
		}

		//Save the html in a variable
		ob_start();

			extract($this->_data);
			include_once ROOT . "web/views/" . $this->_view . ".php";
			$this->_render_data = ob_get_contents();

		ob_end_clean();

		//do we want to return the data ?
		if($return == false) {
			echo $this->_render_data;
			$this->_render_data = null;
		} else {
			$_tmp_render_data = $this->_render_data;
			$this->_render_data = null;
			return $_tmp_render_data;
		}
	}
}