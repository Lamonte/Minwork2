<?php

class html {
	public function link($href, $rel = "stylesheet", $type = "text/css") {
		return '<link rel="' . $rel . '" type="' . $type . '" href="' . $href . '" />';
	}
	
	/* URL ANCHOR */
	public function anchor($url, $text, $title = "") {
		$url = (preg_match("/^http:\/\//i", $url) ? $url : uri::base($url));
		$anchor = '<a href="' . $url . '" title="' . $title . '">' . $text . '</a>';
		return $anchor;
	}
}