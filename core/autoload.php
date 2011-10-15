<?php

function __autoload($classname) {
	//check each necessary folder for class files to be autoloaded
	$folders = array(
		'web/libs/',
		'web/models/',
		'core/libs/db/',
		'core/libs/',
		'core/'
	);
	
	foreach($folders as $folder) {
		if(file_exists(ROOT . $folder . $classname . ".php")) {
			require_once ROOT . $folder . $classname . ".php";
		}
	}
}
