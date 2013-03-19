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

use \Wires\Database\DB as DB;
use \Wires\Configuration as Configuration;
use \Wires\Routing\URI as URI;

class Canvas {
	private static $categories = array();

	//Returns the base URL for various directories.
	public static function getBase($type = 'canvas'){
		if($type == 'canvas'){
			return DS . Configuration::get('dir');
		}
		else if($type == 'theme'){
			return DS . Configuration::get('dir') . 'themes' . DS . Configuration::get('theme') . DS;
		}
	}

	//Returns all forum categories as an array.
	public static function getCategories(){
		//Check to see if we've already fetched our categories before.
		if(!is_null(static::$categories) && count(static::$categories)){
			return static::$categories;
		}
		else{
			$result = DB::queryObj('SELECT id, name FROM categories ORDER BY id ASC', null);
			$result = $result->fetchAll(PDO::FETCH_CLASS, 'Category');

			//Cache categories.
			static::$categories = $result;

			return is_null($result) ? array() : $result;
		}
	}

	//Returns the user with the given ID.
	public static function getUser($id){
		$result = DB::queryObj('SELECT id, uid, email, username, regDate, lastLoginDate, groupId FROM users WHERE uid = :uid LIMIT 1', array('uid' => $id));
		$result->setFetchMode(PDO::FETCH_CLASS, 'User');

		return $result->fetch();
	}

	//Returns the current view ID.
	public static function getID(){
		$uri = new URI();
		$id = $uri->getArg(1);

		return $id;
	}

	//Returns the forum object for the forum currently being viewed.
	public static function getForum(){
		$result = DB::queryObj('SELECT fid, name, description FROM forums WHERE fid = :fid LIMIT 1', array('fid' => static::getID()));
		$result->setFetchMode(PDO::FETCH_CLASS, 'Forum');

		return $result->fetch();
	}
}
?>