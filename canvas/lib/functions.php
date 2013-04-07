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
	if(is_numeric($time)){
		$time = date('Y-m-d H:i:s', $time);
	}

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

//Returns relative time.
function relativeTime($time){
	$intervals = array('minute', 'hour');
	$times = array(60, 3600);

	$now = time();

	if(Canvas::loggedIn()){
		$now = changeTimeZone(Canvas::getUser()->getTimeZone(), $now);
		$now = strtotime($now);
	}

	$ttime = strtotime($time);

	$dif = $now - $ttime;

	if($dif < 60){
		return 'just now';
	}
	else{
		if($dif >= (3600)){
			return strftime('%B %d, %Y at %#I:%M %p', $ttime);
		}

		$text = '';

		for($n = count($intervals) - 1; $n >= 0; $n--){
			if($times[$n] <= $dif){
				$amount = (int) ($dif / $times[$n]);

				if(strlen($text) != 0){
					$text .= 'and ';
				}

				$text .= $amount . ' ' . $intervals[$n] . ($amount > 1 ? 's ' : ' ');

				$dif %= $times[$n];
			}
		}

		return $text . 'ago';
	}
}
?>