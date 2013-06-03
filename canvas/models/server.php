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

class Server {
	//Returns the currently connected version of database.
	public static function getVersion(){
		return DB::getVersion();
	}

	//Returns the current database type.
	public static function getType(){
		return DB::getType();
	}
}
?>