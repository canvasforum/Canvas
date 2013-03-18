<?php
use \Wires\Routing\Router as Router;
use \Wires\Configuration as Configuration;
use \Wires\Error as Error;

//Load all our ACP pages.
$acp = APP . 'views' . DS . 'admin' . DS;
$paths = array('admin' => $acp);

Router::load($paths);

//Load some paths.
$theme = THEMES . Configuration::get('theme') . DS;

Router::load(array('' => $theme));
Router::setBase(Configuration::get('theme'));

//Load all templating functions.
require APP . 'canvas.php';

//Load our page.
include Router::getResource();

foreach(Error::getErrors() as $error){
	echo $error;
}
?>