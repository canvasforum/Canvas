<?php
namespace Canvas;

//If somebody is trying to directly access this file.
defined('COMPONENT') or die('Access Denied.');

class Error {
	private static $codes = array(
		1 => 'You are not connected to a MySQL database.'
	);

	private static $errors = array();

	public static function log($code){
		if(array_key_exists($code, $codes)){
			$errors[] = $codes[$code];
		}
	}

	//Registers a new error code and returns whether it was successful or not.
	public static function register($code, $message){
		if(array_key_exists($code, $codes)){
			return false;
		}
		else{
			$codes[$code] = $message;
			return true;
		}
	}
}
?>