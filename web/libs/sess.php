<?php

class Sess {
	
	public static $instance = null;
	
	public static function instance() {
		if(is_null(self::$instance)) {
			self::$instance = new Sess();
		}
		return self::$instance;
	}
	
	//get session
	public function __get($key) {
		return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
	}
	
	//set session
	public function __set($key, $value) {
		$_SESSION[$key] = $value;
	}
	
	//close session
	public function close() {
		session_destroy();
	}
}