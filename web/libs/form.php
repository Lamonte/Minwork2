<?php
/* Form Helper */
class Form {

	public function open($action) {
		$action = (preg_match("/http:\/\//i", $action) ? $action : uri::base($action));
		$form = '<form method="post" action="' . $action . '">';
		return $form;
	}
	
	public function close() {
		return "</form>";
	}
	
	public function input($name, $type = "text", $value = "", $attributes = array()) {
		$input = '<input type="' . $type . '" name="' . $name . '" value="' . $value . '"';
		
		//setup attributes
		foreach($attributes as $attr => $value) {
			$input .= ' ' . $attr . '="' . $value . '"';
		}
		
		$input .= " />";
		return $input;
	}
}