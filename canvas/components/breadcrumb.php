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
 * @link http://wildandrewlee.com
 */

use \Wires\Routing\URI as URI;
use \Wires\Configuration as Configuration;

class Bread {
	private static $map = array(
		'forum' => '*',
		'topic' => '*',
		'profile' => '*',
		'preferences' => 'Editing Preferences',
		'ntopic' => 'Posting New Topic',
		'npost' => 'Posting New Post',
		'nedit' => 'Editing Post'
	);

	private static $items = null;

	public static function build(){
		$nav = array();
		$uri = new URI();

		$nav[] = new Page(Configuration::get('name'), Canvas::getBase(), false);

		if($uri->getURI() == '' || $uri->getURI() == Configuration::get('index')){
			return array(new Page(Configuration::get('name'), Canvas::getBase(), true));
		}

		$view = $uri->getArg(0);

		if($view == 'post'){
			$view = 'n' . $uri->getArg(1);
		}

		if(array_key_exists($view, static::$map)){
			if(static::$map[$view] != '*'){
				$nav[] = new Page(static::$map[$view], $uri->getURI(), true);
			}
			else{
				if($view == 'forum'){
					$nav[] = new Page(Canvas::getForum()->getName(), Canvas::getForum()->getURL(), true);
				}
				else if($view == 'topic'){
					$parent = Canvas::getForum(Canvas::getTopic()->getParent());
					$nav[] = new Page($parent->getName(), $parent->getURL(), false);
					$nav[] = new Page(Canvas::getTopic()->getName(), Canvas::getTopic()->getURL(), true);
				}
				else if($view == 'profile'){
					$nav[] = new Page(Profile::getUser()->getUsername(), Profile::getUser()->getURL(), true);
				}
			}
		}

		return $nav;
	}

	public static function hasNext(){
		if(is_null(static::$items)){
			static::$items = static::build();
		}

		return count(static::$items);
	}

	public static function next(){
		return array_shift(static::$items);
	}
}
?>