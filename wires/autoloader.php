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
use FileSystemIterator;

//If somebody is trying to directly access this file.
defined('COMPONENT') or die('Access Denied.');

class Autoloader {
	private static $map = array();

	//Load the class with the specified fully qualified name.
	public static function load($classpath){		
		$args = explode('\\', $classpath);

		//Remove the global application namespace.
		unset($args[0]);

		//Recreate the fully qualified name.
		if(array_key_exists(Arr::lastElement($args), static::$map)){
			$key = Arr::lastElement($args);
			$path = static::$map[$key];

			$args[Arr::last($args)] = $path;
		}

		//Convert everything in our arguments to lowercase.
		$args = array_map(function($arg){
			return strtolower($arg);
		}, $args);

		$path = implode(DS, $args);

		$path = SYS . $path . '.php';

		require $path;
	}

	//Loads all classes in the given directory.
	public static function loadDir($path){
		$fsi = new FileSystemIterator($path, FileSystemIterator::SKIP_DOTS);

		foreach($fsi as $file){			
			if($file->isDir()){
				static::loadDir($file->getPathName());
			}
			else{
				require $file->getPathName();
			}
		}
	}

	//Load the alias map.
	public static function map(){
		static::$map = include 'alias.php';
	}
}
?>