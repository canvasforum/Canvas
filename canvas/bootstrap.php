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

use \Wires\Routing\Router as Router;
use \Wires\Configuration as Configuration;
use \Wires\Error as Error;
use \Wires\Routing\URI as URI;
use \Wires\Autoloader as Autoloader;

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

//Set wildcards.
$wildcards = require APP . 'wildcards.php';

foreach($wildcards as $wildcard){
	Router::setWildCard($wildcard, true);
}

Autoloader::loadDir(APP . 'models/');
Autoloader::loadDir(APP . 'components/');
Autoloader::loadDir(APP . 'forms/');
AutoLoader::loadDir(APP . 'lib/');

//Sessions are VERY important.
session_start();

//Load our page.
include Router::getResource();
?>