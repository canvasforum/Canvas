<?php

/**
 * Wires
 *
 * A super simple, super flexible framework built for lightning fast development.
 * 
 * Released under the WTFPL.
 * http://www.wtfpl.net/
 * 
 * @package Wires
 * @author Andrew Lee
 * @link http://andrewleenj.com
 */
 
namespace Wires;

//If somebody is trying to directly access this file.
defined('COMPONENT') or die('Access Denied.');

class Configuration {
	private static $config = array();

	//Attempt to load the current configuration.
	public static function load(){
		//Check to see if the config file is readable.
		if(is_readable(APP . 'config.php')){
			static::$config = include APP . 'config.php';
		}
		else{
			//Throw an error. File isn't readable or doesn't exist.
		}
	}

	//Returns the setting with the key specified.
	public static function get($key){
		//Check if a setting with the key $key exists.
		if(array_key_exists($key, static::$config)){
			return static::$config[$key];
		}
		else{
			//Throw an error.
		}
	}

	//Defines the key specified to be the value specified.
	public static function set($key, $val){
		//If it doesn't exist create it. If it does then override it.
		static::$config[$key] = $val;
	}
}
?>