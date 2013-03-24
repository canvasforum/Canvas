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

class Login {
	//Attempts to log the user in. Returns false if the log in failed.
	public static function attempt(){
		if(!empty($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST'){
			$uri = new URI();

			if($uri->getArg(0) == 'login' && isset($_POST['handle'], $_POST['password'], $_POST['sub'])){
				$query = 'SELECT uid, email, password, salt FROM users WHERE username = :handle OR email = :handle LIMIT 1';

				$result = DB::queryObj($query, array(
					'handle' => $_POST['handle']
				))->fetch(PDO::FETCH_OBJ);

				if(!is_null($result) && $result){
					$attempt = md5(md5($_POST['password']) . md5($result->salt));

					if($attempt == $result->password){
						$_SESSION['uid'] = $result->uid;
						$_SESSION['uas'] = $_SERVER['HTTP_USER_AGENT'];

						if(isset($_POST['remember']) && $_POST['remember'] == true){
							//Login key.
							$key = md5($_SESSION['uas']) . md5(time()) . md5($result->salt);

							//Randomize the key.
							$key = str_shuffle($key);
							$key .= $result->uid;

							//One month persistent login cookie.
							setcookie('rememberme', $key, time() + 2592000);

							DB::query('INSERT INTO autologin (uid, userkey) VALUES (:uid, :key)', array(
								'uid' => $result->uid,
								'key' => $key
							));
						}						

						Canvas::redirect(Canvas::getBase());
					}
					else{
						Canvas::logError('An invalid password was specified.');

						return false;
					}
				}
				else{
					Canvas::logError('The specified user does not exist.');

					return false;
				}
			}
			else{
				Canvas::logError('Please specify a username or email and a password.');

				return false;
			}
		}
	}
}
?>