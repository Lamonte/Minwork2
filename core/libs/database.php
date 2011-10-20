<?php 

/**
 * Database abstraction class
 * 
 * @package 	web
 * @copyright	2011-2012
 */
 
class database {
	public $dbclass = null;
	public static $instance = null;
	public $connected = false; //if we're connected we have to close our connection, just a reminder
	
	public function __construct() {
		global $config;
		$this->dbclass = isset($config[db_connection]['db']['type']) ? $config[db_connection]['db']['type'] . "_database" : null;
		if(!class_exists($this->dbclass)) {
			throw new Exception("Database class ({$this->dbclass}) couldn't be loaded");
		}
		$this->dbclass = new $this->dbclass();
	}
	
	public static function instance() {
		$class = __CLASS__;
		if(is_null(self::$instance)) {
			self::$instance = new $class();
		}
		return self::$instance;
	}
	
	public function connect(){
		global $config;
		$this->dbclass->connect($config[db_connection]['db']['host'],$config[db_connection]['db']['user'], 
			$config[db_connection]['db']['pass'], $config[db_connection]['db']['tble']);
		$this->connected = true;
	}
	
	public function close(){
		$this->dbclass->close();
		$this->connected = false;
	}
	
	public function query($sql_query){
		$this->dbclass->query($sql_query);
	}
	
	public function fetch($result_type = MYSQL_NUM){
		return $this->dbclass->fetch($result_type);
	}
	
	public function num_rows() {
		return $this->dbclass->num_rows();
	}
}
