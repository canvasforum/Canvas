<?php
namespace Canvas\Routing;
use FileSystemIterator;

//If somebody is trying to directly access this file.
defined('COMPONENT') or die('Access Denied.');

class Router {
	private static $routes = array();
	private static $base = null;

	private static $errors = array(
		'404' => '',
		'500' => ''
	);

	//Load all our routes.
	public static function load($paths = null){
		//Check to see if a path was even specified.
		if(is_null($paths)){
			//Just load all our ACP pages.
			$acp = ADMIN . 'views' . DIRECTORY_SEPARATOR;
			$paths = array('admin' => $acp);
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
					if(is_dir($file)){
						//Recursively add any sub-directories.
						$path = $file->getPathName();

						$path = explode(DIRECTORY_SEPARATOR, $path);
						$path = $path[count($path) - 2];

						static::load(array($path => $file->getPathName()));
					}
					else{
						//Make sure the file is readable and is a PHP file.
						if($file->isReadable() && pathinfo($file->getPathname(), PATHINFO_EXTENSION) == 'php'){
							//Attempt to get the name of the current file. Exclude the extension.
							$path = $file->getPathName();
							$path = explode(DIRECTORY_SEPARATOR, $path);

							$fname = $path[count($path) - 2];

							//Add the current file path to our routes array and give it a key
							//representing the request URI to be used by it.
							static::$routes[$dir . '/' . $fname] = $file->getPathName();
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
			return preg_replace('/^' . static::$base . '\/?/', '', $index);
		});
	}

	//Sets the resource path for the specified error type.
	public static function setError($type, $path){
		if(array_key_exists($type, static::$errors)){
			if(array_key_exists($path, static::$routes)){
				static::$errors[$type] = $path;
			}
			else{
				//Log an error here.
			}
		}
		else{
			//Log an error here.
		}		
	}

	//Returns the resource to load based on the current URI.
	public static function getResource(){
		$uri = new URI();

		/*
		 * Fetch the requested URI
		 * See if it matches any keys
		 * If a match is found return the resource pointed to by the key
		 * If not then return the resource pointed to by $errors['404']
		 * If a 404 page is not specified:

			header('HTTP/1.0 404 Not Found');
			echo '<h1>404 Error</h1>';
			echo '<p>The page you were looking for was not found.</p>';
		 */
	}
}
?>