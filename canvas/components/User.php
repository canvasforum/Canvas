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

class User {
	private $id;
	private $uid;
	private $name;
	private $email;
	private $username;
	private $regDate;
	private $lastLoginDate;
	private $ip;
	private $groupId;
	private $group;
	private $timezone;
	private $profile;
	private $posts;

	public function __construct(){
		$this->ip = long2ip($this->ip);
		$this->group = Canvas::getGroup($this->groupId);

		if(empty($this->timezone)){
			$this->timezone = Canvas::getTimeZone();
		}
	}

	//Returns the user's member number.
	public function getNumber(){
		return $this->id;
	}

	//Returns the user's ID.
	public function getID(){
		return $this->uid;
	}

	//Returns the user's name.
	public function getName(){
		return $this->name;
	}

	//Returns the user's email address.
	public function getEmail(){
		return $this->email;
	}

	//Returns the user's username.
	public function getUsername(){
		return $this->username;
	}

	//Returns the user's registration date/time
	public function getRegistration(){
		return $this->regDate;
	}

	//Returns the user's last login date/time.
	public function getLastLogin(){
		return $this->lastLoginDate;
	}

	//Returns the user's registration IP.
	public function getIP(){
		return $this->ip;
	}

	//Returns the user's group as an object.
	public function getGroup(){
		return $this->group;
	}

	//Returns whether or not this user has permission to do something.
	public function hasPermission($action){
		return $this->group->hasPermission($action);
	}
	
	//Returns the gravatar URL for the user.
	public function getGravatar($size = 100){
		return 'http://www.gravatar.com/avatar/' . md5(strtolower($this->email)) . '?d=identicon&s=' . $size;
	}

	//Returns the user's designated timezone.
	public function getTImezone(){
		return $this->timezone;
	}

	//Returns the user's profile.
	public function getProfile(){
		if(is_null($this->profile)){
			$this->profile = new Profile($this->uid);
		}

		return $this->profile;
	}

	//Returns the profile URL for this user.
	public function getProfileURL(){
		return Canvas::getBase() . 'profile/' . $this->uid;
	}

	//Returns all posts made by this user. Sorted in reverse chronological order.
	public function getPosts($limit = -1){
		if(is_null($this->posts)){
			$this->posts = Fetcher::getPostsByAuthor($this->uid);
		}

		if($limit != -1){
			return array_splice($this->posts, 0, $limit);
		}

		return $this->posts;
	}
}
?>