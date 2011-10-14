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
		echo "test";
	}
}