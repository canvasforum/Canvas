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

use \Wires\Configuration as Configuration;

return array(
	'root' => DS . Configuration::get('dir'),
	'canvas' => DS . Configuration::get('dir') . 'canvas' . DS,
	'theme' => DS . Configuration::get('dir') . 'themes' . DS . Configuration::get('theme') . DS,
	'admin' => DS . Configuration::get('dir') . 'admin' . DS,
	'admindep' => DS . Configuration::get('dir') . 'canvas' . DS . 'views' . DS . 'admin' . DS
);
?>