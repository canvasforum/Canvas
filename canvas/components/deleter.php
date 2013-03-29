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

class Deleter {
	const TOPIC = 1;
	const POST = 2;

	//Returns the post form type.
	public static function getType(){
		$uri = new URI();

		if(preg_match('#delete/((post|topic)/\d{6})#', $uri->getURI())){
			if($uri->getArg(1) == 'topic'){
				return Canvas::getTopic() ? static::TOPIC : -1;
			}
			else if($uri->getArg(1) == 'post'){
				return Canvas::getPost() ? static::POST : -1;
			}
		}
		
		return -1;
	}

	public static function getPost(){
		return Canvas::getPost();	
	}

	public static function getTopic(){
		return Canvas::getTopic();
	}

	public static function delete(){
		if(static::getType() == Deleter::TOPIC){
			$topic = static::getTopic();
			$post = $topic->getFirstPost();

			if($post->canDelete()){
				Garbage::removeTopic($post->getParent());

				Canvas::logNotice('Topic Successfully Deleted', true);
				header('Location: ' . Canvas::getBase() . 'forum/' . $topic->getParent());

				return true;
			}

			Canvas::logError('You do not have permission to delete this item.', true);
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
		else if(static::getType() == Deleter::POST){
			$post = static::getPost();

			if($post->canDelete()){
				Garbage::removePost($post->getID());

				Canvas::logNotice('Post Successfully Deleted', true);
				header('Location: ' . Canvas::getBase() . 'topic/' . $post->getParent());

				return true;
			}

			Canvas::logError('You do not have permission to delete this item.', true);
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
		
		Canvas::logError('Invalid command specified.', true);
		header('Location: ' . $_SERVER['HTTP_REFERER']);

		return false;
	}
}
?>