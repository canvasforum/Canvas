<?php
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