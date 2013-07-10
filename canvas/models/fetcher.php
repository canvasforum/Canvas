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

use \Wires\Database\DB as DB;
use \Wires\Configuration as Configuration;
use \Wires\Routing\URI as URI;

class Fetcher {
	private static $categories = null;
	private static $user = null;
	private static $forum = null;
	private static $topic = null;

	//Returns all forum categories as an array.
	public static function getCategories(){
		if(!is_null(static::$categories)){
			return static::$categories;
		}
		else{
			$query = 'SELECT id, name FROM categories ORDER BY ordering ASC';
			$result = DB::queryObj($query, null);

			$result = $result->fetchAll(PDO::FETCH_CLASS, 'Category');

			static::$categories = $result;

			return is_null($result) ? array() : $result;
		}
	}

	//Returns the user with the given UID.
	public static function getUser($id = -1){
		if($id != -1){
			$query = 'SELECT id, name, uid, email, username, regDate, lastLoginDate, groupId, timezone FROM users WHERE uid = :uid LIMIT 1';
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
		return static::getUserByEmail($handle) || static::getUserByUsername($handle) || false;
	}

	//Returns the user with the given email.
	public static function getUserByEmail($handle){
		$query = 'SELECT uid, email, password, salt FROM users WHERE email = :handle LIMIT 1';
		$result = DB::queryObj($query, array('handle' => $handle));

		$result->setFetchMode(PDO::FETCH_CLASS, 'User');

		return $result->fetch();
	}

	//Returns the user with the given username.
	public static function getUserByUsername($handle){
		$query = 'SELECT uid, email, password, salt FROM users WHERE username = :handle LIMIT 1';
		$result = DB::queryObj($query, array('handle' => $handle));

		$result->setFetchMode(PDO::FETCH_CLASS, 'User');

		return $result->fetch();
	}

	//Returns the forum object for the forum currently being viewed.
	public static function getForum($fid = -1){
		if($fid == -1){
			if(is_null(static::$forum)){
				static::$forum = static::getForum(Canvas::getID());
			}

			return static::$forum;
		}

		$query = 'SELECT fid, name, description FROM forums WHERE fid = :fid LIMIT 1';

		$result = DB::queryObj($query, array('fid' => $fid));
		$result->setFetchMode(PDO::FETCH_CLASS, 'Forum');

		return $result->fetch();
	}

	//Returns the topic object for the topic currently being viewed.
	public static function getTopic($tid = -1){
		if($tid == -1){
			if(is_null(static::$topic)){
				static::$topic = static::getTopic(Canvas::getID());
			}

			return static::$topic;
		}

		$query = 'SELECT tid, fid, name, author, startDate FROM topics WHERE tid = :tid LIMIT 1';

		$result = DB::queryObj($query, array('tid' => $tid));
		$result->setFetchMode(PDO::FETCH_CLASS, 'Topic');

		return $result->fetch();
	}

	//Returns all the topics in the forum specified.
	public static function getTopics($fid){
		$result = DB::queryObj('SELECT tid, fid, name, author, startDate FROM topics WHERE fid = :fid ORDER BY updateDate DESC', array('fid' => $fid));
		$result = $result->fetchAll(PDO::FETCH_CLASS, 'Topic');

		return $result;
	}

	//Returns the post object for the post currently being viewed.
	public static function getPost($pid = -1){
		$pid = $pid == -1 ? Canvas::getID() : $pid;

		$query = 'SELECT tid, pid, author, contents, postDate, editedBy, editedOn FROM posts WHERE pid = :pid LIMIT 1';

		$result = DB::queryObj($query, array('pid' => $pid));
		$result->setFetchMode(PDO::FETCH_CLASS, 'Post');

		return $result->fetch();
	}

	//Returns all posts made by the user specified.
	public static function getPostsByAuthor($uid){
		$query = 'SELECT tid, pid, author, contents, postDate, editedBy, editedOn FROM posts WHERE author = :uid ORDER BY id DESC';

		$results = DB::queryObj($query, array('uid' => $uid));

		return $results->fetchAll(PDO::FETCH_CLASS, 'Post');
	}

	//Returns the specified group as an object.
	public static function getGroup($id){
		$query = 'SELECT name, permissions FROM groups WHERE id = :id LIMIT 1';

		$result = DB::queryObj($query, array('id' => $id));
		$result->setFetchMode(PDO::FETCH_CLASS, 'Group');

		return $result->fetch();
	}

	//Returns a user's profile.
	public static function getProfile($id){
		$query = 'SELECT * FROM profiles WHERE uid = :uid';

		$result = DB::query($query, array('uid' => $id), PDO::FETCH_OBJ);

		foreach($result as $key => $val){
			$result[$val->name] = $val;
			unset($result[$key]);
		}

		return $result;
	}

	//Returns all profile fields available.
	public static function getProfileFields(){
		$query = 'SELECT name, label, type FROM profilefields ORDER BY id ASC';

		$results = DB::query($query, null, PDO::FETCH_OBJ);

		return $results;
	}

	//Returns the total rows of a table.
	public static function getTotal($type){
		//Total posts.
		if($type == 1){
			$query = 'SELECT id FROM posts';
			return count(DB::query($query));
		}
		//Total members.
		else if($type == 2){
			$query = 'SELECT id FROM users';
			return count(DB::query($query));
		}
	}

	//Returns the newest row in a table.
	public static function getNewest($type){
		//Newest member.
		if($type == 1){
			$query = 'SELECT id, name, uid, email, username, regDate, lastLoginDate, groupId, timezone FROM users ORDER BY regDate DESC LIMIT 1';
			$result = DB::queryObj($query, null);
			$result->setFetchMode(PDO::FETCH_CLASS, 'User');

			return $result->fetch();
		}
	}
}
?>