<?php
namespace Canvas;

/*
 * Define some global constants.
 */

//Define a global constant to prevent direct access to PHP pages.
define('COMPONENT', true);

//Define a global constant for our application.
define('PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);

//Define a global constant for our system directory.
define('SYS', 'sys' . DIRECTORY_SEPARATOR);

//Define a global constant for our themes directory.
define('THEMES', PATH . 'themes' . DIRECTORY_SEPARATOR);

//Define a global constant for our admin directory.
define('ADMIN', PATH . SYS . 'admin' . DIRECTORY_SEPARATOR);

//Define a global constant for the current version of Canvas.
define('VERSION', '0.1');

//Bootstrap the application.
require PATH . SYS . 'boostrap.php';
?>