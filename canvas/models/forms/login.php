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
 * @link http://wildandrewlee.com
 */

use \Wires\Database\DB as DB;
use \Wires\Routing\URI as URI;
use \Wires\Routing\Response as Response;

class Login {
	//Attempts to log the user in. Returns false if the log in failed.
	public static function attempt(){
		if(Response::isPost()){
			$uri = new URI();

			if(isset($_POST['handle'], $_POST['password'], $_POST['sub'])){
				$query = 'SELECT uid, email, password, salt FROM users WHERE username = :handle OR email = :handle LIMIT 1';

				$result = DB::queryObj($query, array(
					'handle' => $_POST['handle']
				))->fetch(PDO::FETCH_OBJ);

				if(!is_null($result) && $result){
					$attempt = Hasher::hashPass($_POST['password'], $result->salt);

					if($attempt == $result->password){
						$_SESSION['uid'] = $result->uid;
						$_SESSION['uas'] = $_SERVER['HTTP_USER_AGENT'];

						if(isset($_POST['remember']) && $_POST['remember'] == true){
							$key = md5($_SESSION['uas']) . md5(time()) . md5($result->salt);
							$key = str_shuffle($key);
							$key .= $result->uid;

							setcookie('rememberme', $key, time() + 2592000, '/');

							DB::query('INSERT INTO autologin (uid, userkey) VALUES (:uid, :key)', array(
								'uid' => $result->uid,
								'key' => $key
							));
						}

						new Message(Message::NOTICE, 'You are now logged in. Welcome back.', true);

						Canvas::redirect(Canvas::getBase());
					}
					else{
						new Message(Message::ERROR, 'An invalid password was specified.');

						return false;
					}
				}
				else{
					new Message(Message::ERROR, 'The specified user does not exist.');

					return false;
				}
			}
			else{
				new Message(Message::ERROR, 'Please specify a username or email and a password.');

				return false;
			}
		}
	}
}
?>