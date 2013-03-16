<?php
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
	'dir' => 'canvasbb',

	//Application theme.
	'theme' => 'default'
)
?>