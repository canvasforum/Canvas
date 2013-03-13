<?php
namespace Canvas\Routing;

//If somebody is trying to directly access this file.
defined('COMPONENT') or die('Access Denied.');

class Router {
	private static $routes = array();

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
			if(file_exists($syspath)){
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
			else{
				//Log an error here.
			}
		}
	}
}
?>