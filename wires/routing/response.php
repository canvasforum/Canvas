<?php


/**
 * Wires
 *
 * A super simple, super flexible framework built for lightning fast development.
 * 
 * Released under the WTFPL.
 * http://www.wtfpl.net/
 * 
 * @package Wires
 * @author Andrew Lee
 * @link http://andrewleenj.com
 */

namespace Wires\Routing;

//If somebody is trying to directly access this file.
defined('COMPONENT') or die('Access Denied.');

class Response {
	//Returns whether or not a form post was made.
	public static function isPost(){
		return !empty($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST';
	}
}
?>