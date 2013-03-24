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
 * @package Wires
 * @author Andrew Lee
 * @link http://andrewleenj.com
 */

use \Wires\Database\DB as DB;
use \Wires\Routing\URI as URI;

class Register {
	//Attempts to log the user in. Returns false if the log in failed.
	public static function attempt(){
		if(!empty($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST'){
			$uri = new URI();

			$required = array(
				'email',
				'username',
				'password',
				'passwordVal',
				'captcha',
				'tos'
			);

			$check = all($required, function($item){
				return isset($_POST[$item]);
			});

			if($uri->getArg(0) == 'register' && $check){
				$result = Fetcher::getUserByHandle($_POST['email']);

				if($result){
					Canvas::logError('The email address specified is already in use.');
				}
				else if(!preg_match('#\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b#', $_POST['email'])){
					Canvas::logError('You must specify a valid email such as janedoe@email.com.');
				}

				$result = Fetcher::getUserByHandle($_POST['username']);

				if($result){
					Canvas::logError('The username specified is already in use.');
				}
				else if(!preg_match('#\b[a-zA-Z0-9]+\b#', $_POST['username'])){
					Canvas::logError('Your username may only contain letters and numbers');
				}

				if($_POST['password'] != $_POST['passwordVal']){
					Canvas::logError('Please make sure both passwords match.');
				}
				else if(!preg_match('#^[^\s]{5,}$#', $_POST['password'])){
					Canvas::logError('Your password must be at least 5 characters long and may not contain any spaces.');
				}

				if($_POST['captcha'] != $_SESSION['captcha']){
					Canvas::logError('Please make sure you enter the captcha correctly.');
				}

				if(!$_POST['tos']){
					Canvas::logError('Please agree to the terms and conditions.');
				}

				if(!Canvas::hasErrors()){
					$salt = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
					$salt = substr(str_shuffle($salt), 0, 32);

					$hash = md5(md5($_POST['password']) . md5($salt));

					$uid = rand(100000, 999999);

					while(Canvas::getUser($uid)){
						$uid = rand(100000, 999999);
					}

					$_SESSION['uid'] = $uid;
					$_SESSION['uas'] = $_SERVER['HTTP_USER_AGENT'];

					$query = 'INSERT INTO users (uid, email, username, password, salt, regDate, lastLoginDate, ip) VALUES (:uid, :email, :username, :password, :salt, :regDate, :lastLoginDate, :ip)';

					$ip = ip2long($_SERVER['REMOTE_ADDR']);
					
					$res = DB::query($query, array(
						'uid' => $uid,
						'email' => $_POST['email'],
						'username' => htmlspecialchars($_POST['username']),
						'password' => $hash,
						'salt' => $salt,
						'regDate' => date('Y-m-d'),
						'lastLoginDate' => date('Y-m-d H:i:s'),
						'ip' => $ip
					));

					Canvas::redirect(Canvas::getBase());	
				}
			}
			else{
				Canvas::logError('Please fill out all the fields.');

				return false;
			}
		}
		else{
			return false;
		}
	}
}
?>