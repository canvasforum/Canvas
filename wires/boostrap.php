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
 * @link http://wildandrewlee.com
 */

namespace wires;
use \Wires\Error as Error;
use \Wires\Routing\Router as Router;
use \Wires\Database\DB as DB;

//If somebody is trying to directly access this file.
defined('COMPONENT') or die('Access Denied.');

//We need at least 5.3 for OOP
if(version_compare(PHP_VERSION, '5.4.0') < 0.0){
	die('Your version of PHP must be at least 5.4.0.');
}

//GZIP cause we're cool.
if(!ob_start('ob_gzhandler')){
	ob_start();
}

//Turn off retarded PHP magic quotes.
if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()){
	ini_set('magic_quotes_gpc', false);
	ini_set('magic_quotes_runtime', false);
	ini_set('magic_quotes_sybase', false);
}

//Suppress all errors.
//ini_set('display_errors', 'off');

//Import the autoloader.
require SYS . 'autoloader.php';

//Load some handy tools.
require SYS . 'arr.php';

//Load class file aliases.
Autoloader::map();

//Set our autoloader.
spl_autoload_register(array('Wires\\Autoloader', 'load'));

/*
//Set exception handlers.
set_exception_handler(function($exception){
	Error::log($exception);
});

//Set error handlers.
set_error_handler(function($code, $error, $file, $line){
	Error::log($code, $error, $file, $line);
});
*/

//Load the application configuration.
Configuration::load();

//Set the default timezone.
date_default_timezone_set(Configuration::get('timezone'));

//Connect to the database.
DB::connect(Configuration::get('db'));

//Load application bootstrap.
require APP . 'bootstrap.php';
?>