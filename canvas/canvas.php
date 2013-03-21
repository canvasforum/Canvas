<?php

/**
 * Canvas
 *
 * A super simple, super flexible forum.
 * 
 * Released under the WTFPL.
 * http://www.wtfpl.net/
 * 
 * Uses Wires as a framework.
 * Wires is also released under the WTFPL.
 * 
 * @package Wires
 * @author Andrew Lee
 * @link http://andrewleenj.com
 */

use \Wires\Routing\URI as URI;
use \Wires\Configuration as Configuration;

class Canvas {
	private static $errors = array();
	private static $bases = null;

	//Returns all forum categories as an array.
	public static function getCategories(){
		return Fetcher::getCategories();
	}

	//Returns the user with the given ID.
	public static function getUser($id = -1){
		return Fetcher::getUser($id);
	}

	//Returns the forum object for the forum currently being viewed.
	public static function getForum($fid = -1){
		return Fetcher::getForum($fid);
	}

	//Returns the topic object for the topic currently being viewed.
	public static function getTopic($tid = -1){
		return Fetcher::getTopic($tid);
	}

	//Returns the post object for the post currently being viewed.
	public static function getPost($pid = -1){
		return Fetcher::getPost($pid);
	}

	//Returns the base URL for various directories.
	public static function getBase($type = 'root'){
		if(is_null(static::$bases)){
			static::$bases = require APP . 'bases.php';
		}

		return static::$bases[$type];
	}

	//Returns the name of the theme.
	public static function getTheme(){
		return Configuration::get('theme');
	}

	//Returns the current URL.
	public static function getURL(){
		$uri = new URI();
		return $uri->getOriginal();
	}

	//Returns the current view ID.
	public static function getID(){
		$uri = new URI();

		for($n = 0; $n < $uri->length(); $n++){
			if(preg_match('#^\d{6}$#', $uri->getArg($n))){
				return $uri->getArg($n);
			}
		}

		return -1;
	}

	//Logs an error in the system.
	public static function logError($error){
		if(is_string($error)){
			static::$errors[] = $error;
		}
	}

	//Returns an array containing all errors if any.
	public static function getErrors(){
		return static::$errors;
	}

	//Redirects the user to the specified URL.
	public static function redirect($url){
		header('Location: ' . $url);
	}

	//Checks to see if the user has a persistent login cookie.
	public static function checkUser(){
		if(isset($_COOKIE['rememberme'])){
			$key = $_COOKIE['rememberme'];
			$results = Fetcher::getAutoLogin($key);

			if(!is_null($results)){
				$results = Fetcher::getUser($results);

				if(!is_null($results)){
					return $results;
				}
			}
		}
		else if(isset($_SESSION['uid'], $_SESSION['uas'])){
			return Fetcher::getUser($_SESSION['uid']);
		}

		return null;
	}

	//Checks to see if the user is logged in.
	public static function loggedIn(){
		if(isset($_SESSION['uid'], $_SESSION['uas']) || !is_null(static::checkUser())){
			return true;
		}

		return false;
	}

	//Logs the user out.
	public static function logout(){
		unset($_SESSION['uid']);
		unset($_SESSION['uas']);
		
		setcookie('rememberme', '', time() - 24 * 365 * 60);

		session_destroy();

		static::redirect(static::getBase());
	}
}
?>