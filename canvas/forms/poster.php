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

class Poster {
	//Returns the post form type.
	public static function getType(){
		$uri = new URI();

		if($uri->getArg(0) == 'post'){
			if(!is_null($uri->getArg(1)) && !is_null($uri->getArg(2))){
				if($uri->getArg(1) == 'topic'){
					return 'topic';
				}
				else if($uri->getArg(1) == 'post'){
					return 'post';
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}

	public static function post(){
		if(!empty($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST'){
			if(static::getType() == 'topic'){
				$tid = rand(100000, 999999);

				while(Canvas::getTopic($tid)){
					$tid = rand(100000, 999999);
				}

				$query = 'INSERT INTO topics (tid, fid, name, author, startDate) VALUE (:tid, :fid, :name, :author, :startDate)';

				DB::query($query, array(
					'tid' => $tid,
					'fid' => Canvas::getID(),
					'name' => Form::getInput('name'),
					'author' => Canvas::getUser()->getID(),
					'startDate' => date('Y-m-d h:i:s')
				));

				return static::newPost($tid);
			}
			else if(static::getType() == 'post'){
				return static::newPost(Canvas::getID());
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}

	//Creates a new post.
	public static function newPost($tid){
		$pid = rand(100000, 999999);

		while(Canvas::getPost($pid)){
			$pid = rand(100000, 999999);
		}

		$query = 'INSERT INTO posts (tid, pid, author, contents, postDate) VALUE (:tid, :pid, :author, :contents, :postDate)';

		DB::query($query, array(
			'tid' => $tid,
			'pid' => $pid,
			'author' => Canvas::getUser()->getID(),
			'contents' => Form::getInput('contents'),
			'postDate' => date('Y-m-d h:i:s')
		));

		return $tid;
	}
}
?>