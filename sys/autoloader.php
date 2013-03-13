<?php
namespace Canvas;

//If somebody is trying to directly access this file.
defined('COMPONENT') or die('Access Denied.');

class Autoloader {
	//Load the class with the specified fully qualified name.
	public static function load($classpath){
		$args = explode('\\', $classpath);

		//Remove the global "Canvas" path.
		unset($args[0]);

		//Convert everything in our arguments to lowercase.
		$args = array_map(function($arg){
			return strtolower($arg);
		}, $args);

		//Recreate the fully qualified name.
		$path = implode(DIRECTORY_SEPARATOR, $args);
		$path = PATH . SYS . $path . '.php';

		if(is_readable($path)){
			require $path;
		}
		else{
			//Throw an error here.
		}
	}
}
?>