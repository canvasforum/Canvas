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

class Hasher {
	public static function hashPass($pass, $salt){
		return md5(md5($pass) . md5($salt));
	}

	//Generates a random salt.
	public static function createSalt(){
		$salt = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		$salt = md5(substr(str_shuffle($salt), 0, 32));

		return $salt;
	}
}
?>