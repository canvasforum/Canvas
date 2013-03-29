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
 * @package Wires
 * @author Andrew Lee
 * @link http://andrewleenj.com
 */

use \Wires\Database\DB as DB;
use \Wires\Routing\URI as URI;
use \Wires\Routing\Response as Response;

class Posting {
	//Creates a new topic.
	public static function newTopic(){
		$tid = rand(100000, 999999);

		while(Canvas::getTopic($tid)){
			$tid = rand(100000, 999999);
		}

		$query = 'INSERT INTO topics (tid, fid, name, author, startDate) VALUE (:tid, :fid, :name, :author, :startDate)';

		DB::query($query, array(
			'tid' => $tid,
			'fid' => Canvas::getID(),
			'name' => htmlspecialchars(Form::getInput('name')),
			'author' => Canvas::getUser()->getID(),
			'startDate' => date('Y-m-d H:i:s')
		));

		static::newPost($tid);

		return $tid;
	}

	//Creates a new post.
	public static function newPost($tid){
		if(!Canvas::hasErrors()){
			$pid = rand(100000, 999999);

			while(Canvas::getPost($pid)){
				$pid = rand(100000, 999999);
			}

			$query = 'INSERT INTO posts (tid, pid, author, contents, postDate) VALUE (:tid, :pid, :author, :contents, :postDate)';

			DB::query($query, array(
				'tid' => $tid,
				'pid' => $pid,
				'author' => Canvas::getUser()->getID(),
				'contents' => htmlspecialchars(Form::getInput('contents')),
				'postDate' => date('Y-m-d H:i:s')
			));

			$query = 'UPDATE topics SET updateDate = :updateDate WHERE tid = :tid';

			DB::query($query, array(
				'updateDate' => date('Y-m-d H:i:s'),
				'tid' => $tid
			));

			return $pid;
		}

		return false;
	}

	public static function editPost(){
		$uri = new URI();
		$tid = $uri->getArg(2);
		$pid = $uri->getArg(3);

		if(!Canvas::hasErrors()){
			$query = 'UPDATE topics SET name = :name WHERE tid = :tid';

			DB::query($query, array(
				'name' => htmlspecialchars(Form::getInput('name')),
				'tid' => $tid
			));

			$query = 'UPDATE posts SET contents = :contents, editedBy = :editedBy, editedOn = :editedOn WHERE pid = :pid';

			DB::query($query, array(
				'contents' => htmlspecialchars(Form::getInput('contents')),
				'editedBy' => Canvas::getUser()->getID(),
				'editedOn' => date('Y-m-d H:i:s'),
				'pid' => $pid
			));

			return $tid;
		}

		return false;
	}
}
?>