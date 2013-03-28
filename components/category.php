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

class Category {
	private $name;
	private $id;
	private $forums = array();

	//Returns all forums associated with this category.
	public function getForums(){
		if(!is_null($this->forums) && count($this->forums)){
			return $this->forums;
		}
		else{
			$result = DB::queryObj('SELECT fid, name, description FROM forums WHERE cid = :cid', array('cid' => $this->id));
			$result = $result->fetchAll(PDO::FETCH_CLASS, 'Forum');

			$this->forums = $result;

			return is_null($result) ? array() : $result;
		}
	}

	//Returns the name of the category.
	public function getName(){
		return $this->name;
	}

	//Returns the ID of the category.
	public function getID(){
		return $this->id;
	}
}
?>