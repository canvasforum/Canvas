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
		if(Response::isPost()){			
			if(Form::used('name') && !Form::getInput('name')){
				Canvas::logError('You must specify a topic name');
			}

			if(!Canvas::getUser()->hasPermission(Permissions::BYPASS_MIN_CHAR)){
				if(!Form::getInput('contents') || strlen(trim(Form::getInput('contents'))) < Settings::getSetting('minPostLength')){
					Canvas::logError('Your post must contain at least ' . Settings::getSetting('minPostLength') . ' characters');
				}
			}

			if(!Canvas::hasErrors()){
				if(static::getType() == static::TOPIC){
					return Posting::newTopic();
				}
				else if(static::getType() == static::POST){
					return Posting::newPost(static::getTopic()->getID());
				}
				else if(static::getType() == static::EDIT){
					Canvas::logNotice('Post Successfully Edited', true);

					return Posting::editPost();
				}		
			}
		}

		return false;
	}
}
?>