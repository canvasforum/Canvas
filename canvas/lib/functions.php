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
 * @link http://andrewleenj.com
 */
 
//The PHP equivalent of Python's all() function.
function all($arr, $func){
	foreach($arr as $key => $val){
		if(!$func($val)){
			return false;
		}
	}

	return true;
}

//Converts a time from one timezone to another.
function changeTimeZone($new, $time){
	$dt = new DateTime($time);
	$new = new DateTimeZone($new);
	$dt->setTimeZone($new);
	return $dt->format('Y-m-d H:i:s');
}

//Truncates a string adding on an ellipsis to the end.
function truncate($str, $len){
	if(strlen($str) <= $len){
		return $str;
	}
	
	return substr($str, 0, $len) . '...';
}
?>