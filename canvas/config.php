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

//If somebody is trying to directly access this file.
defined('COMPONENT') or die('Access Denied.');

return array(
	//Database information.
	'db' => array(
		'user' => 'root',
		'pass' => '',
		'name' => 'canvasbb',
		'host' => 'localhost',
		'port' => '3306'
	),

	//Installation directory. Leave off the beginning "/".
	'dir' => 'canvasbb/',

	//Canvas theme.
	'theme' => 'default',

	//Index page.
	'index' => 'index',

	//Forum Name.
	'name' => 'Canvas Forums',

	//Timezone.
	'timezone' => 'America/New_York'
)
?>