<?php

class Model {
	public $db = null;
	
	public function __construct () {
		$this->db = Database::instance();
		
		//Are we allowed to connect?
		if(enable_database == true) {
			$this->db->connect();
		}
	}
}