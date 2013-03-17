<?php
namespace Canvas;
use \Canvas\Routing\Router as Router;

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
?>