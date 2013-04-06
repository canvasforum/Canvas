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

use \Wires\Database\DB as DB;
use \Wires\Arr as Arr;

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
			$result = Canvas::getTopics($this->fid);

			$this->topics = $result;

			return is_null($result) ? array() : $result;
		}
	}

	//Returns the last topic to be updated.
	public function getLastTopic(){
		if(is_null($this->topics)){
			$this->getTopics();
		}

		return $this->topics[0];
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

	//Returns if this forum has any topics or not.
	public function hasTopics(){
		return count($this->getTopics());
	}
}
?>