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
	const TOPIC = 1;
	const POST = 2;
	const EDIT = 3;

	//Returns the post form type.
	public static function getType(){
		$uri = new URI();

		if(preg_match('#post/(((post|topic)/\d{6})|(edit(/\d{6}){2}))#', $uri->getURI())){
			if($uri->getArg(1) == 'topic'){
				return Canvas::getForum() ? static::TOPIC : -1;
			}
			else if($uri->getArg(1) == 'post'){
				return Canvas::getTopic() ? static::POST : -1;
			}
			else if($uri->getArg(1) == 'edit'){
				return Canvas::getTopic($uri->getArg(2)) && Canvas::getPost($uri->getArg(3)) ? static::EDIT : -1;
			}
		}
		
		return -1;
	}

	public static function getPost(){
		if(static::getType() == static::EDIT){
			$uri = new URI();
			return Canvas::getPost($uri->getArg(3));
		}
		else{
			return Canvas::getPost();
		}		
	}

	public static function getTopic(){
		if(static::getType() == static::EDIT){
			$uri = new URI();
			return Canvas::getTopic($uri->getArg(2));
		}
		else{
			return Canvas::getTopic();
		}
	}

	public static function post(){
		if(!empty($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST'){
			if(static::getType() == static::TOPIC){
				if(empty($_POST['name'])){
					Canvas::logError('You must specify a topic name');
				}

				if(empty($_POST['contents']) || strlen(trim($_POST['contents'])) < Settings::getSetting('minPostLength')){
					Canvas::logError('You post must contain at least ' . Settings::getSetting('minPostLength') . ' characters');
				}

				if(!Canvas::hasErrors()){
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
			else if(static::getType() == static::POST){
				return static::newPost(Canvas::getID());
			}
			else if(static::getType() == static::EDIT){
				$uri = new URI();

				return static::editPost($uri->getArg(2), $uri->getArg(3));
			}
		}

		return false;
	}

	//Creates a new post.
	public static function newPost($tid){
		if(empty($_POST['contents']) || strlen(trim($_POST['contents'])) < Settings::getSetting('minPostLength')){
			Canvas::logError('Your post must contain at least ' . Settings::getSetting('minPostLength') . ' characters');
		}

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

			return $tid;
		}

		return false;
	}

	public static function editPost($tid, $pid){
		if(empty($_POST['contents']) || strlen(trim($_POST['contents'])) < Settings::getSetting('minPostLength')){
			Canvas::logError('You post must contain at least ' . Settings::getSetting('minPostLength') . ' characters');
		}

		if(isset($_POST['name']) && empty($_POST['name'])){
			Canvas::logError('You must specify a topic name');
		}

		if(!Canvas::hasErrors()){
			if(isset($_POST['name'])){
				$query = 'UPDATE topics SET name = :name WHERE tid = :tid';

				DB::query($query, array(
					'name' => htmlspecialchars(Form::getInput('name')),
					'tid' => $tid
				));
			}	

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