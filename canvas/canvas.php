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
 * @package Canvas
 * @author Andrew Lee
 * @link http://andrewleenj.com
 */

use \Wires\Routing\URI as URI;
use \Wires\Configuration as Configuration;
use \Wires\Database\DB as DB;

class Canvas {
	private static $errors = array();
	private static $notices = array();
	private static $bases = null;

	//Returns the group specified by the given ID.
	public static function getGroup($id){
		return Fetcher::getGroup($id);
	}

	//Returns all forum categories as an array.
	public static function getCategories(){
		return Fetcher::getCategories();
	}

	//Returns the user with the given ID.
	public static function getUser($id = -1){
		return Fetcher::getUser($id);
	}

	//Returns a user's profile.
	public static function getProfile($id){
		return Fetcher::getProfile($id);
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

	//Returns the default time zone.
	public static function getTimeZone(){
		return Configuration::get('timezone');
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
		if($error instanceof Message){
			static::$errors[] = $error;
		}
	}

	//Returns whether or not there are any errors.
	public static function hasErrors($bind = Binds::UNBOUND){
		$dupe = static::$errors;

		if(!empty($_SESSION['errors'])){
			$dupe = array_merge(static::$errors, $_SESSION['errors']);
		}

		$_SESSION['bind'] = $bind;

		$dupe = array_filter($dupe, function($msg){
			return $msg->getBind() == $_SESSION['bind'];
		});

		unset($_SESSION['bind']);

		return count($dupe);
	}

	//Returns an array containing all errors if any.
	public static function getErrors($bind = Binds::UNBOUND){
		if(static::hasErrors($bind)){
			$_SESSION['bind'] = $bind;

			if(!empty($_SESSION['errors'])){
				static::$errors = array_merge(static::$errors, $_SESSION['errors']);
				unset($_SESSION['errors']);
			}

			static::$errors = array_filter(static::$errors, function($msg){
				return $msg->getBind() == $_SESSION['bind'];
			});

			unset($_SESSION['bind']);

			return static::$errors;
		}

		return false;
	}

	//Returns whether or not there are any notices.
	public static function hasNotices($bind = Binds::UNBOUND){
		$dupe = static::$notices;

		if(!empty($_SESSION['notices'])){
			$dupe = array_merge(static::$notices, $_SESSION['notices']);
		}

		$_SESSION['bind'] = $bind;

		$dupe = array_filter($dupe, function($msg){
			return $msg->getBind() == $_SESSION['bind'];
		});

		unset($_SESSION['bind']);

		return count($dupe);
	}

	//Returns an array containing all notices if any.
	public static function getNotices($bind = Binds::UNBOUND){
		if(static::hasNotices($bind)){
			$_SESSION['bind'] = $bind;

			if(!empty($_SESSION['notices'])){
				static::$notices = array_merge(static::$notices, $_SESSION['notices']);
				unset($_SESSION['notices']);
			}

			static::$notices = array_filter(static::$notices, function($msg){
				return $msg->getBind() == $_SESSION['bind'];
			});

			unset($_SESSION['bind']);

			return static::$notices;
		}

		return false;
	}

	//Logs a notice in the system.
	public static function logNotice($notice){
		if($notice instanceof Message){
			static::$notices[] = $notice;
		}
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
		if(Canvas::loggedIn()){
			DB::query('DELETE FROM autologin WHERE uid = :uid', array(
				'uid' => static::getUser()->getID()
			));

			unset($_SESSION['uid']);
			unset($_SESSION['uas']);
			
			setcookie('rememberme', '', time() - 24 * 365 * 60);

			session_destroy();
		}

		static::redirect(static::getBase());
	}
}
?>