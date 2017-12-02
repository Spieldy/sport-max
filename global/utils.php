<?php

if(!function_exists('user_connected')) {
	function user_connected() {
		return isset($_SESSION['user']);
	}
}


if(!function_exists('show_message')) {
	function show_message($type,$text) {
		$_SESSION['message']['type'] = strval($type);
		$_SESSION['message']['text'] = strval($text);
	}
}
