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
 * @link http://wildandrewlee.com
 */

namespace Wires;

//If somebody is trying to directly access this file.
defined('COMPONENT') or die('Access Denied.');

class Arr {
	//Returns the key of the last element in the array.
	public static function last($arr){
		end($arr);
		$key = key($arr);
		reset($arr);

		return $key;
	}

	//Returns the value of the last element in the array.
	public static function lastElement($arr){
		return $arr[static::last($arr)];
	}
}
?>