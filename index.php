<?php
/*
 * Define some global constants.
 */

//Define a global constant to prevent direct access to PHP pages.
define('COMPONENT', true);

//Define a global constant for the directory separator. We don't want to type it out each time.forum
define('DS', DIRECTORY_SEPARATOR);

//Define a global constant for our application.
define('PATH', dirname(__FILE__) . DS);

//Define a global constant for our system directory.
define('SYS', PATH . 'wires' . DS);

//Define a global constant for our application files.
define('APP', PATH . 'canvas' . DS);

//Define a global constant for our themes directory.
define('THEMES', PATH . 'themes' . DS);

//Define a global constant for the current version of Canvas.
define('VERSION', '0.1');

//Bootstrap the application.
require SYS . 'boostrap.php';
?>