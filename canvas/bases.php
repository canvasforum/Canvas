<?php
use \Wires\Configuration as Configuration;

return array(
	'root' => DS . Configuration::get('dir'),
	'canvas' => DS . Configuration::get('dir') . 'canvas' . DS,
	'theme' => DS . Configuration::get('dir') . 'themes' . DS . Configuration::get('theme') . DS
);
?>