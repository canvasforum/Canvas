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
 * @package Wires
 * @author Andrew Lee
 * @link http://andrewleenj.com
 */

 use \Wires\Database\DB as DB;
 use \Wires\Routing\URI as URI;

class Preferences {
	const BASIC = 1;
	const PASSWORD = 2;
	const PROFILE = 3;

	public static function getType(){
		$uri = new URI();
		$uri = $uri->getURI();

		if(preg_match('#preferences/(index|basic)?$#', $uri)){
			return static::BASIC;
		}
		else if(preg_match('#preferences/password$#', $uri)){
			return static::PASSWORD;
		}
		else if(preg_match('#preferences/profile$#', $uri)){
			return static::PROFILE;
		}

		return -1;
	}

	public static function attempt(){
		if(!empty($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST'){
			if(static::getType() == static::BASIC){
				$result = Fetcher::getUserByHandle($_POST['email']);

				if($result && $result->getID() != Canvas::getUser()->getID()){
					Canvas::logError('The email address specified is already in use.');
				}
				else if(!preg_match('#\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b#', $_POST['email'])){
					Canvas::logError('You must specify a valid email such as janedoe@email.com.');
				}

				if(!Canvas::hasErrors()){
					$query = 'UPDATE users SET name = :name, email = :email, timezone = :timezone WHERE uid = :uid';

					DB::query($query, array(
						'name' => $_POST['name'],
						'email' => $_POST['email'],
						'timezone' => $_POST['timezone'],
						'uid' => Canvas::getUser()->getID()
					));

					Canvas::logNotice('Your preferences have been successfully updated.');

					return true;
				}
			}
			else if(static::getType() == static::PASSWORD){
				if(isset($_POST['cpassword'], $_POST['npassword'], $_POST['cnpassword'])){
					$query = 'SELECT password, salt FROM users WHERE uid = :uid';

					$result = DB::queryObj($query, array(
						'uid' => Canvas::getUser()->getID()
					))->fetch(PDO::FETCH_OBJ);

					$hash = md5(md5($_POST['cpassword']) . md5($result->salt));

					if($hash == $result->password){
						if($_POST['npassword'] != $_POST['cnpassword']){
							Canvas::logError('Please make sure both passwords match.');
						}
						else if(!preg_match('#^[^\s]{5,}$#', $_POST['npassword'])){
							Canvas::logError('Your password must be at least 5 characters long and may not contain any spaces.');
						}

						if(!Canvas::hasErrors()){
							$salt = Hasher::createSalt();

							$hash = md5(md5($_POST['npassword']) . md5($salt));

							$query = 'UPDATE users SET password = :password, salt = :salt WHERE uid = :uid';

							DB::query($query, array(
								'password' => $hash,
								'salt' => $salt,
								'uid' => Canvas::getUser()->getID()
							));

							$autologin = Fetcher::getAutoLoginKey(Canvas::getUser()->getID());

							if(!empty($autologin)){
								$key = md5($_SESSION['uas']) . md5(time()) . md5($salt);
								$key = str_shuffle($key);
								$key .= Canvas::getUser()->getID();

								setcookie('rememberme', $key, time() + 2592000);

								$query = 'UPDATE autologin SET userkey = :userkey WHERE uid = :uid';

								DB::query($query, array(
									'userkey' => $key,
									'uid' => Canvas::getUser()->getID()
								));

								Canvas::logNotice('Your password has been successfully updated.');

								return true;
							}
						}
					}
					else{
						Canvas::logError('Incorrect password specified. Please check your current password and try again.');
					}
				}
				else{
					Canvas::logError('You must fill in every field.');
				}
			}
			else if(static::getType() == static::PROFILE){

			}
		}

		return false;
	}

	public static function buildTimeSelect(){
		return Timezone::buildSelect(Canvas::getUser()->getTimezone());
	}
}
?>