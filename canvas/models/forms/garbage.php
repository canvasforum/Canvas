<?php

/*
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
use \Wires\Routing\URI as URI;
use \Wires\Routing\Response as Response;

class Garbage {
	public static function removeTopic($tid){
		$query = 'DELETE FROM topics WHERE tid = :tid';

		DB::query($query, array('tid' => $tid));

		$query = 'DELETE FROM posts WHERE tid = :tid';

		DB::query($query, array('tid' => $tid));
	}

	public static function removePost($pid){
		$query = 'DELETE FROM posts WHERE pid = :pid';

		DB::query($query, array('pid' => $pid));
	}
}
?>