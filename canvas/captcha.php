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
 
session_start();

header('Content-type: image/png');

$captcha = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
$captcha = substr(str_shuffle($captcha), 0, 4);
$_SESSION['captcha'] = $captcha;

$image = imagecreatetruecolor(100, 50);
$white = imagecolorallocate($image, 255, 255, 255);
$black = imagecolorallocate($image, 83, 83, 83);

imagefill($image, 0, 0, $white);
imagettftext($image, 30, 0, 0, 40, $black, 'fonts/calibri.ttf', $_SESSION['captcha']);

imagepng($image);
?>