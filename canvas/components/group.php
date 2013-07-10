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
 * @link http://wildandrewlee.com
 */

class Group {
	private $name;
	private $permissions;

	public function __construct(){
		$this->perm = new Permissions($this->permissions);
	}

	public function hasPermission($action){
		return $this->perm->hasPermission($action);
	}

	public function getName(){
		return $this->name;
	}
}
?>