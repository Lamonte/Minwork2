<?php

/**
 * Configuration File
 *
 * This file is used to modify some of the global
 * settings that control the minwork2 framework.
 * Editing these settings will control how some things
 * work throughout the framework.
 */
 
//uncomment to enable sessions
//session_start(); 
 
//Unused needs to be enabled in the code soon
define("SHOW_ERRORS", true);
define('LOG', true);

//Default controller class
define('default_controller', 'images');

//Enable database class
define('enable_database', false);

//Which database connect do we use
define('db_connection', 'default');

//Enable 404 template
define('enable_404', true);

//The first parameter determines which connection you are on
//make a clone of this array if you have seperate servers
//for live and dev usages.
$config['default'] = array(
	'db' => array(
		'user' => 'root',
		'pass' => '',
		'host' => 'localhost',
		'tble' => 'items',
		'type' => 'Mysql',
	),
	'uri' => array(
		'base' => 'http://localhost/minwork2/' 
	)
);