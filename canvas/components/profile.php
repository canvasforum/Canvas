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

class Profile {
	private $fields = array();
	private static $user = null;
	private static $pfields = null;

	public function __construct($uid){
		$this->fields = Canvas::getProfile($uid);
	}

	public function getField($name){
		if(!is_null($this->fields) && array_key_exists($name, $this->fields)){
			return $this->fields[$name]->value;
		}

		return null;
	}

	public static function getFields(){
		if(is_null(static::$pfields)){
			static::$pfields = Fetcher::getProfileFields();
		}

		return static::$pfields;
	}

	public static function getUser(){
		if(is_null(static::$user)){
			static::$user = Canvas::getUser(Canvas::getID());
		}
		
		return static::$user;
	}
}
?>