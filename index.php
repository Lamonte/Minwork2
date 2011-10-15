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

//Start url masking
Route::instance()->start_masking();

try {
	$Minwork = new Minwork();
	$Minwork->load_controllers();
} catch(Exception $e) {
	echo "Caught Exception: " . $e->getMessage();
}

$db = new Database();
$db->connect();

$query = $db->query("SELECT * FROM `items`");
while($row = $db->fetch()) {
	print_r($row);
}

$db->close();