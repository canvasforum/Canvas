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
 * @link http://wildandrewlee.com
 */

use \Wires\Database\DB as DB;

class Garbage {
	public static function removeTopic($tid){
		$query = 'DELETE FROM topics WHERE tid = :tid';

		DB::query($query, array('tid' => $tid));

		$query = 'DELETE FROM posts WHERE tid = :tid';

		DB::query($query, array('tid' => $tid));
	}

	public static function removePost($pid){
		$post = Canvas::getPost($pid);
		$topic = Canvas::getTopic($post->getParent());

		$query = 'DELETE FROM posts WHERE pid = :pid';

		DB::query($query, array('pid' => $pid));

		if($post == $topic->getLastPost()){
			$query = 'UPDATE topics SET updateDate = :date WHERE tid = :tid';

			DB::query($query, array(
				'tid' => $topic->getID(),
				'date' => $topic->getPosts()[count($topic->getPosts()) - 2]->getPostDate()
			));
		}
	}
}
?>