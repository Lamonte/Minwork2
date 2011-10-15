<?php

class Items_Model extends Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function total_items() {
		$this->db->query("SELECT * FROM `items`");
		$items = $this->db->num_rows();
		return $items;
	}
}