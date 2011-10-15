<?php 

/**
 * Welcome Controller
 * 
 * @package 	web
 * @copyright	2011-2012
 */
 
class Welcome_Controller extends Template_Controller {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$this->template->content = "Hello world";
		$this->load_model("items");
		$this->template->content .= ":::" . $this->model->items->total_items();
	}
}