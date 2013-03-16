<?php
namespace Canvas;

//If somebody is trying to directly access this file.
defined('COMPONENT') or die('Access Denied.');

//We need at least 5.3 for OOP
if(version_compare(PHP_VERSION, '5.3.0') < 0.0){
	die('Your version of PHP must be at least 5.3.0.');
}

//Turn off retarded PHP magic quotes.
if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()){
	ini_set('magic_quotes_gpc', false);
	ini_set('magic_quotes_runtime', false);
	ini_set('magic_quotes_sybase', false);
}

//Import the autoloader.
require SYS . 'autoloader.php';

//Load some handy tools.
require SYS . 'arr.php';

//Load class file aliases.
Autoloader::map();

//Set our autoloader.
spl_autoload_register(array('Canvas\\Autoloader', 'load'));

//Load the application configuration.
Configuration::load();

//Define an alias for the DB class.
use \Canvas\Database\DB as DB;

//Connect to the database.
DB::connect(Configuration::get('db'));

//Define an alias for the Router class.
use \Canvas\Routing\Router as Router;

//Load some paths.
Router::load();

$theme = THEMES . Configuration::get('theme') . DIRECTORY_SEPARATOR;

Router::load(array('' => $theme));
Router::setBase(Configuration::get('theme'));
?>