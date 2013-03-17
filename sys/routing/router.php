<?php
namespace Canvas\Routing;
use FileSystemIterator;
use \Canvas\Configuration as Configuration;
use \Canvas\Arr as Arr;

//If somebody is trying to directly access this file.
defined('COMPONENT') or die('Access Denied.');

class Router {
	private static $routes = array(
		'404' => null
	);

	private static $base = null;

	//Load all our routes.
	public static function load($paths = null){
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
						//Recursively add any sub-directories.
						$path = $file->getPathName();

						$path = explode(DS, $path);
						$path = $dir . $path[count($path) - 1];

						static::load(array($path => $file->getPathName()));
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

							//Add the current file path to our routes array and give it a key
							//representing the request URI to be used by it.
							static::$routes[$dir . $fname] = $file->getPathName();
						}
					}
				}
			}
			else{
				//Log an error here.
			}
		}
	}

	//array_map() for our routes. The only difference is that this maps indices.
	public static function mapRoutes($func){
		foreach(static::$routes as $route => $path){
			unset(static::$routes[$route]);

			static::$routes[$func($route)] = $path;
		}
	}

	//array_map() for our routes. This one works with direction paths.
	public static function mapPaths($func){
		array_map($func, static::$routes);
	}

	//Set the default directory for our routes.
	public static function setBase($base){
		static::$base = $base;

		static::mapRoutes(function($index){
			return preg_replace('/^\/?' . static::$base . '\/?/', '', $index);
		});
	}

	//Sets the resource path for the specified error type.
	public static function setError($type, $path){
		if(array_key_exists($path, static::$routes)){
			static::$errors[$type] = $path;
		}
		else{
			//Log an error here.
		}
	}

	//Gets the path with the specified route.
	public static function getPath($route){
		if(array_key_exists($route, static::$routes)){
			return static::$routes[$route];
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
}
?>