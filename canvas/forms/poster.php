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
				if($uri->getArg(1) == 'post' && !is_null(Canvas::getTopic(Canvas::getID()))){
					return 'post';
				}
				else if($uri->getArg(1) == 'topic' && !is_null(Canvas::getForum(Canvas::getID()))){
					return 'topic';
				}
				else if($uri->getArg(1) == 'edit'){
					if(!is_null(Canvas::getTopic($uri->getArg(2)))){
						if(!is_null($uri->getArg(3))){
							if(!is_null(Canvas::getPost($uri->getArg(3)))){
								return 'edit';
							}
						}
					}
				}
			}
		}
		else if($uri->getArg(0) == 'topic'){
			return 'post';
		}
		
		return false;
	}

	public static function getContents(){
		$uri = new URI();

		return Canvas::getPost($uri->getArg(3))->getContents();
	}

	public static function post(){
		if(!empty($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST'){
			if(static::getType() == 'topic'){
				if(empty($_POST['name'])){
					Canvas::logError('You must specify a topic name');
				}

				if(empty($_POST['contents']) || strlen(trim($_POST['contents'])) < Settings::getSetting('minPostLength')){
					Canvas::logError('You post must contain at least ' . Settings::getSetting('minPostLength') . ' characters');
				}

				if(!count(Canvas::getErrors())){
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

					return static::newPost($tid);
				}
			}
			else if(static::getType() == 'post'){
				return static::newPost(Canvas::getID());
			}
			else if(static::getType() == 'edit'){
				$uri = new URI();

				return static::editPost($uri->getArg(2), $uri->getArg(3));
			}
		}

		return false;
	}

	//Creates a new post.
	public static function newPost($tid){
		if(empty($_POST['contents']) || strlen(trim($_POST['contents'])) < Settings::getSetting('minPostLength')){
			Canvas::logError('You post must contain at least ' . Settings::getSetting('minPostLength') . ' characters');
		}

		if(!count(Canvas::getErrors())){
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

			return $tid;
		}

		return false;
	}

	public static function editPost($tid, $pid){
		if(empty($_POST['contents']) || strlen(trim($_POST['contents'])) < Settings::getSetting('minPostLength')){
			Canvas::logError('You post must contain at least ' . Settings::getSetting('minPostLength') . ' characters');
		}

		if(!count(Canvas::getErrors())){
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