<?php
namespace Canvas;
use \Canvas\Routing\Router as Router;

//Load all our ACP pages.
$acp = APP . 'views' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR;
$paths = array('admin' => $acp);

Router::load($paths);

//Load some paths.
$theme = THEMES . Configuration::get('theme') . DIRECTORY_SEPARATOR;

Router::load(array('' => $theme));
Router::setBase(Configuration::get('theme'));
?>