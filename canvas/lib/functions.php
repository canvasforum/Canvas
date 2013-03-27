<?php
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
?>