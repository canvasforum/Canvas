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

class Permissions {
	const USE_AVATAR = 1;
	const USE_SIGNATURE = 2;
	const POST_REPLIES = 4;
	const POST_TOPICS = 8;
	const EDIT_OWN_POSTS = 16;
	const SEND_PM = 32;
	const USE_LIKE_SYSTEM = 64;
	const BYPASS_MIN_CHAR = 128;
	const CLOSE_TOPIC = 256;
	const DELETE_OWN_POSTS = 512;
	const EDIT_OTHER_POSTS = 1024;
	const DELETE_OTHER_POSTS = 2048;
	const MOVE_TOPICS = 4096;
	const MERGE_TOPICS = 8192;
	const WARN_USERS = 16384;
	const BAN_USERS = 32768;
	const ADMIN_PANEL = 65536;

	private $permissions;

	public function __construct($permissions){
		$this->permissions = intval($permissions);
	}

	public function hasPermission($action){
		//Boolean algebra. Go look it up if you don't know what it is.
		return ($this->permissions & $action) === $action;
	}
}
?>