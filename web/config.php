<?php

/**
 * Configuration File
 *
 * This file is used to modify some of the global
 * settings that control the minwork2 framework.
 * Editing these settings will control how some things
 * work throughout the framework.
 * @todo setup log and show errors to work with global defined variables
 */

//uncomment to enable sessions
//session_start();

//global settings
define("SHOW_ERRORS", true);
define('LOG', true);
define('default_controller', 'welcome');
define('enable_database', true);
define('db_connection', 'default');

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