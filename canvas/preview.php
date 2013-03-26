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
 * @link http://andrewleenj.com
 */
 
require 'lib/markdown.php';

if(isset($_POST['contents'])){
	echo Markdown(htmlspecialchars($_POST['contents']));
}
else{
	echo 'lel what are you doing here?';
}
?>