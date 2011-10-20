<?php
/**
 * Index.php
 *
 * @package	core
 * @copyright	2009-2012
 */
 
//ROOT Directory definition
define('ROOT', str_replace("\\", "/", dirname(__FILE__)) . "/");

//Load configuration file
require_once ROOT . "web/config.php";

//Autoload which autoloads all our classes when called 
require_once ROOT . "core/autoload.php";

//Require the bootstrap
require_once ROOT . "web/bootstrap.php";

//Start url masking
$route = new route();
$route->start_masking();

try {
	$Minwork = new Minwork();
	$Minwork->load_controllers();
} catch(Exception $e) {
	echo "Caught Exception: " . $e->getMessage();
}

//Disconnect database if we're connected
if(enable_database && Database::instance()->connected) {
	Database::instance()->close();
}