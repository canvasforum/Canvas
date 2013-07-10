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

if(isset($_POST['contents'])){
	if(empty($_POST['contents'])){
		echo '<span>Nothing to preview.</span>';
	}

	echo Markdown(htmlspecialchars($_POST['contents']));
}
else{
	echo 'lel what are you doing here?';
}
?>