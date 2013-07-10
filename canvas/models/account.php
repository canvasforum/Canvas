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
 * @link http://wildandrewlee.com
 */

use \Wires\Database\DB as DB;

class Account {
	//Returns the UID of the user whose auto login key matches the one specified.
	public static function getAutoLogin($key){
		$query = 'SELECT uid FROM autologin WHERE userkey = :key';
		$result = DB::single($query, array('key' => $key), 'uid');

		return $result;
	}

	//Returns the auto login key that matches the UID specified.
	public static function getAutoLoginKey($uid){
		$query = 'SELECT userkey FROM autologin WHERE uid = :uid';
		$result = DB::single($query, array('uid' => $uid), 'userkey');

		return $result;
	}

	//Returns the UID corresponding to the current auto login key.
	public static function getCurrentKey(){
		$key = $_COOKIE['rememberme'];
		$result = static::getAutoLogin($key);

		return $result;
	}

	//Deletes the currently logged in user's auto login key.
	public static function logout(){
		$result = static::getCurrentKey();

		if(!is_null($result)){
			DB::query('DELETE FROM autologin WHERE uid = :uid', array(
				'uid' => $result
			));
		}
	}
}
?>