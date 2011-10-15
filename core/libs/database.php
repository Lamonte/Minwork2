<?php 

/**
 * Database abstraction class
 * 
 * @package 	web
 * @copyright	2011-2012
 */
 
class Database {
	public $dbclass = null;
	public function __construct() {
		global $config;
		$this->dbclass = $config[db_connection]['db']['type'] . "_database";
		$this->dbclass = new $this->dbclass();
	}
	
	public function connect(){
		global $config;
		$this->dbclass->connect($config[db_connection]['db']['host'],$config[db_connection]['db']['user'], 
			$config[db_connection]['db']['pass'], $config[db_connection]['db']['tble']);
	}
	
	public function close(){
		$this->dbclass->close();
	}
	
	public function query($sql_query){
		$this->dbclass->query($sql_query);
	}
	
	public function fetch($result_type = MYSQL_NUM){
		return $this->dbclass->fetch($result_type);
	}
}

abstract class Database_abstract {
	abstract public function connect($host, $user, $password, $table);
	abstract public function query($sql_query);
	abstract public function fetch($result_type);
	abstract public function close();
}