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
?>