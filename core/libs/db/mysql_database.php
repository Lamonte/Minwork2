<?php

class mysql_database {

	public $connect 	= null;
	public $result 		= null;	 
	public $table		= null;
	
	public function connect($host, $user, $password, $table) {
		$this->connect = mysql_connect($host, $user, $password);
		if(!$this->connect) {
			throw new Exception("Could not connect to database: " . mysql_error());
		}
		
		$this->table = mysql_select_db($table, $this->connect);
		if(!$this->table) {
			throw new Exception("Could not use table ({$table})");
		}
	}
	
	public function query($sql_query) { 
		$this->result = mysql_query($sql_query);
		if(!$this->result) {
			throw new Exception("Could not parse query: " . mysql_error());
		}
	}
	
	public function fetch($result_type = MYSQL_NUM) {
		return mysql_fetch_array($this->result, $result_type);
	}
	
	public function close() {
		mysql_close($this->connect);
	}
	
	public function num_rows() {
		return mysql_num_rows($this->result);
	}
}	
