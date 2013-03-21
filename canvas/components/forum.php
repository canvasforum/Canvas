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

class Forum {
	private $name;
	private $fid;
	private $cid;
	private $description;
	private $topics = array();

	//Returns all topics associated with this forum.
	public function getTopics(){
		if(!is_null($this->topics) && count($this->topics)){
			return $this->topics;
		}
		else{
			$result = DB::queryObj('SELECT tid, fid, name, author, startDate FROM topics WHERE fid = :fid ORDER BY id DESC', array('fid' => $this->fid));
			$result = $result->fetchAll(PDO::FETCH_CLASS, 'Topic');

			$this->topics = $result;

			return is_null($result) ? array() : $result;
		}
	}

	//Returns the name of the forum.
	public function getName(){
		return $this->name;
	}

	//Returns the ID of the forum.
	public function getID(){
		return $this->fid;
	}

	//Returns the description of the forum.
	public function getDescription(){
		return $this->description;
	}
}
?>