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
 * @package Canvas
 * @author Andrew Lee
 * @link http://andrewleenj.com
 */

use \Wires\Database\DB as DB;
use \Wires\Routing\URI as URI;
use \Wires\Routing\Response as Response;

class Register {
	//Attempts to log the user in. Returns false if the log in failed.
	public static function attempt(){
		if(Response::isPost()){
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
					new Message(Message::ERROR, 'The email address specified is already in use.');
				}
				else if(!preg_match('#\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b#', $_POST['email'])){
					new Message(Message::ERROR, 'You must specify a valid email such as janedoe@email.com.');
				}

				$result = Fetcher::getUserByHandle($_POST['username']);

				if($result){
					new Message(Message::ERROR, 'The username specified is already in use.');
				}
				else if(!preg_match('#\b[a-zA-Z0-9]+\b#', $_POST['username'])){
					new Message(Message::ERROR, 'Your username may only contain letters and numbers');
				}

				if($_POST['password'] != $_POST['passwordVal']){
					new Message(Message::ERROR, 'Please make sure both passwords match.');
				}
				else if(!preg_match('#^[^\s]{5,}$#', $_POST['password'])){
					new Message(Message::ERROR, 'Your password must be at least 5 characters long and may not contain any spaces.');
				}

				if($_POST['captcha'] != $_SESSION['captcha']){
					new Message(Message::ERROR, 'Please make sure you enter the captcha correctly.');
				}

				if(!$_POST['tos']){
					new Message(Message::ERROR, 'Please agree to the terms and conditions.');
				}

				if(!Canvas::hasErrors()){
					$salt = Hasher::createSalt();
					$hash = Hasher::hashPass($_POST['password'], $salt);

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

					new Message(Message::NOTICE, 'Thanks. You are now registered and logged in.', true);

					Canvas::redirect(Canvas::getBase());	
				}
			}
			else{
				new Message(Message::ERROR, 'Please fill out all the fields.');

				return false;
			}
		}
		else{
			return false;
		}
	}
}
?>