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

namespace Wires\Routing;
use FileSystemIterator;
use Closure;
use \Wires\Configuration as Configuration;
use \Wires\Arr as Arr;

//If somebody is trying to directly access this file.
defined('COMPONENT') or die('Access Denied.');

class Router {
	private static $routes = array();

	private static $base = null;

	//Load all our routes.
	public static function load($paths = null, $deep = false){
		//Check to see if a path was even specified.
		if(is_null($paths)){
			return;
		}
		else{
			//If an array was not passed.
			if(!is_array($paths)){
				$uri = new URI($paths);
				$paths = array($uri->getArg(-1) => $paths);
			}
		}

		//Loop through all paths.
		foreach($paths as $dir => $syspath){
			//Make sure the directory exists.
			if(is_dir($syspath)){
				//Create a FileSystemIterator to easily loop through every file in each directory.
				$fsi = new FileSystemIterator($syspath, FileSystemIterator::SKIP_DOTS);

				//For each file in the directory.
				foreach($fsi as $file){
					if($file->isDir()){
						if($deep){
							//Recursively add any sub-directories.
							$path = $file->getPathName();

							$path = explode(DS, $path);
							$path = $dir . $path[count($path) - 1];

							static::load(array($path => $file->getPathName()));
						}
					}
					else{
						//Make sure the file is readable and is a PHP file.
						if($file->isReadable() && pathinfo($file->getPathname(), PATHINFO_EXTENSION) == 'php'){
							//Attempt to get the name of the current file. Exclude the extension.
							$path = $file->getPathName();
							$path = explode(DS, $path);

							$fname = Arr::lastElement($path);

							//Remove the file extension.
							$fname = preg_replace('/\.[a-z]{2,4}/', '', $fname);

							//Add a "/" if there's a parent directory.
							if($dir != ''){
								$dir .= '/';
							}

							//Create a new route object.
							$route = new Route($dir . $fname, $file->getPathName());

							//Add the route to our routes array.
							static::$routes[] = $route;
						}
					}
				}
			}
			else{
				$path = explode(DS, $syspath);
				$fname = Arr::lastElement($path);

				//Remove the file extension.
				$fname = preg_replace('/\.[a-z]{2,4}/', '', $fname);

				$route = new Route($fname, $syspath, false);
				static::$routes[] = $route;
			}
		}
	}

	//array_map() for our routes. The only difference is that this maps URIs.
	public static function mapRoutes($func){
		$func = Closure::bind($func, null, __CLASS__);

		foreach(static::$routes as $route){
			$newURI = $func($route->getURI());
			$route->setURI($newURI);
		}
	}

	//array_map() for our routes. This one works with paths.
	public static function mapPaths($func){
		$func = Closure::bind($func, null, __CLASS__);

		foreach(static::$routes as $route){
			$newPath = $func($route->getPath());
			$route->setPath($newPath);
		}
	}

	//Set the default directory for our routes.
	public static function setBase($base){
		static::$base = $base;

		static::mapRoutes(function($route){
			return preg_replace('/^\/?' . static::$base . '\/?/', '', $route);
		});
	}

	//Sets the resource path for the specified error type.
	public static function setError($type, $path){
		$error = null;

		foreach(static::$routes as $route){
			if($route->match($type)){
				$error = $route;
				break;
			}
		}

		if(is_null($error)){
			static::$routes[] = new Route($type, $path);
		}
		else{
			$error->setPath($path);
		}
	}

	//Gets the route object with the specified URI.
	public static function getRoute($uri){
		$r = null;

		foreach(static::$routes as $route){
			if($route->match($uri)){
				$r = $route;
				break;
			}
		}

		return $r;
	}

	//Gets the path with the specified route.
	public static function getPath($uri){
		$route = static::getRoute($uri);

		if(!is_null($route)){
			return $route->getPath();
		}
		else{
			return null;
		}
	}

	//Redirects the user to another page.
	public static function redirect($path){
		header('Location: ' . $path);
	}

	//Returns the resource to load based on the current URI.
	public static function getResource(){
		$uri = new URI();
		$path = $uri->getURI();

		if(!is_null(static::getPath($path))){
			return static::getPath($path);
		}
		else{
			if($path == ''){
				return static::getPath(Configuration::get('index'));
			}
			else if(is_null(static::getPath('404'))){
				return SYS . 'errors/404.php';
			}
			else{
				return static::getPath('404');
			}
		}
	}

	//Returns all routes loaded.
	public static function fetch(){
		return static::$routes;
	}

	//Sets the wildcard to true or false for the specified URI.
	public static function setWildCard($uri, $set){
		$route = static::getRoute($uri);

		if(!is_null($route)){
			$route->setWildCard($set);
		}
		else{
			//Log an error.
		}
	}

	//Returns the page response type.
	public static function isResponse($type){
		if($type == 'POST'){
			return (!empty($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST');
		}
	}
}
?>