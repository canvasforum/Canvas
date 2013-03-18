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
use Exception;
use ErrorException;

//If somebody is trying to directly access this file.
defined('COMPONENT') or die('Access Denied.');

class Error {
	private static $errors = array();

	//Log method that all exceptions and errors must go through.
	public static function log($code, $error = null, $file = null, $line = 0){	
		if($code instanceof Exception){
			static::ln($code);
		}
		else{
			$exception = new ErrorException($error, $code, 0, $file, $line);
			static::ln($exception);
		}
	}

	//For anybody who gets why the function name is ln. Logs exceptions.
	public static function ln($exception){
		static::$errors[] = 'Message: ' . $exception->getMessage() . '<br />Location: ' . $exception->getFile() . ' on line ' . $exception->getLine() . '.<br />';
	}

	//Returns all errors if any.
	public static function getErrors(){
		return static::$errors;
	}
}
?>