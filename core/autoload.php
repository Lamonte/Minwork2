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
		$filename = strtolower(ROOT . $folder . $classname . ".php");
		if(file_exists($filename)) {
			require_once $filename;
		}
	}
}
