<?php

class Controller {
	public $db = null;
	public $model = null;
	public function __construct() {
		$this->db = Database::instance();
		
		//Are we allowed to connect?
		if(enable_database == true) {
			$this->db->connect();
		}
	}
	
	public function load_model($model_name) {
		$model = $model_name . "_Model";
		
		if(!class_exists($model)) {
			throw new Exception("Model ($model) couldn't be loaded and doesn't exist");
		}
		
		$this->model->{$model_name} = new $model;
	}
}