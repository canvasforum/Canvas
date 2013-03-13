<?php
namespace Canvas\Routing;

//If somebody is trying to directly access this file.
defined('COMPONENT') or die('Access Denied.');

class Router {
	private static $paths = array(
		'admin' => ADMIN . 'views' . DIRECTORY_SEPARATOR
	);

	private static $routes = array();

	//Load all our routes.
	public static function load(){
		//Loop through all paths.
		foreach($paths as $dir => $syspath){
			//Create a FileSystemIterator to easily loop through every file in each directory.
			$fsi = new FileSystemIterator($syspath, FileSystemIterator::SKIP_DOTS);

			//For each file in the directory.
			foreach($fsi as $file){
				//Make sure the file is readable and is a PHP file.
				if($file->isReadable() && pathinfo($file->getPathname(), PATHINFO_EXTENSION) == 'php'){
					//Attempt to get the name of the current file. Exclude the extension.
					$path = $file->getPathName();
					$path = explode(DIRECTORY_SEPARATOR, $path);
					$fname = $path[count($path) - 2];

					//Add the current file path to our routes array and give it a key
					//representing the request URI to be used by it.
					$routes[$dir . $fname] = $file->getPathName();
				}
			}
		}
	}
}
?>