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

class Fetcher {
	private static $categories = null;
	private static $user = null;

	//Returns all forum categories as an array.
	public static function getCategories(){
		if(!is_null(static::$categories)){
			return static::$categories;
		}
		else{
			$query = 'SELECT id, name FROM categories ORDER BY id ASC';
			$result = DB::queryObj($query, null);

			$result = $result->fetchAll(PDO::FETCH_CLASS, 'Category');

			static::$categories = $result;

			return is_null($result) ? array() : $result;
		}
	}

	//Returns the user with the given UID.
	public static function getUser($id = -1){
		if($id != -1){
			$query = 'SELECT id, uid, email, username, regDate, lastLoginDate, groupId FROM users WHERE uid = :uid LIMIT 1';
			$result = DB::queryObj($query, array('uid' => $id));

			$result->setFetchMode(PDO::FETCH_CLASS, 'User');

			return $result->fetch();
		}
		else{
			static::$user = Canvas::checkUser();
			return static::$user;
		}
	}

	//Returns the user with the given username or email.
	public static function getUserByHandle($handle){
		$query = 'SELECT uid, email, password, salt FROM users WHERE username = :handle OR email = :handle LIMIT 1';
		$result = DB::queryObj($query, array('handle' => $handle));

		$result->setFetchMode(PDO::FETCH_CLASS, 'User');

		return $result->fetch();
	}

	//Returns the forum object for the forum currently being viewed.
	public static function getForum($fid = -1){
		$fid = $fid == -1 ? Canvas::getID() : $fid;

		$query = 'SELECT fid, name, description FROM forums WHERE fid = :fid LIMIT 1';

		$result = DB::queryObj($query, array('fid' => $fid));
		$result->setFetchMode(PDO::FETCH_CLASS, 'Forum');

		return $result->fetch();
	}

	//Returns the topic object for the topic currently being viewed.
	public static function getTopic($tid = -1){
		$tid = $tid == -1 ? Canvas::getID() : $tid;
		
		$query = 'SELECT tid, fid, name, author, startDate FROM topics WHERE tid = :tid LIMIT 1';

		$result = DB::queryObj($query, array('tid' => $tid));
		$result->setFetchMode(PDO::FETCH_CLASS, 'Topic');

		return $result->fetch();
	}

	//Returns the post object for the post currently being viewed.
	public static function getPost($pid = -1){
		$pid = $pid == -1 ? Canvas::getID() : $pid;

		$query = 'SELECT tid, pid, author, contents, postDate, editedBy, editedOn FROM posts WHERE pid = :pid LIMIT 1';

		$result = DB::queryObj($query, array('pid' => $pid));
		$result->setFetchMode(PDO::FETCH_CLASS, 'Post');

		return $result->fetch();
	}

	//Returns the UID of the user whose auto login key matches the one specified.
	public static function getAutoLogin($key){
		$query = 'SELECT uid FROM autologin WHERE userkey = :key';
		$result = DB::single($query, array('key' => $key), 'uid');

		return $result;
	}

	//Returns the specified group as an object.
	public static function getGroup($id){
		$query = 'SELECT name, permissions FROM groups WHERE id = :id LIMIT 1';

		$result = DB::queryObj($query, array('id' => $id));
		$result->setFetchMode(PDO::FETCH_CLASS, 'Group');

		return $result->fetch();
	}
}
?>