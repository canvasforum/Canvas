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

class Topic {
	private $tid;
	private $fid;
	private $name;
	private $author;
	private $startDate;
	private $posts = array();

	public function __construct(){
		$this->author = Canvas::getUser($this->author);
	}

	//Returns the topic ID.
	public function getID(){
		return $this->tid;
	}

	//Returns the forum ID in which this topic can be found.
	public function getParent(){
		return $this->fid;
	}

	//Returns the name of the topic.
	public function getName(){
		return $this->name;
	}

	//Returns the topic starter as a User object.
	public function getAuthor(){
		return $this->author;
	}

	//Returns the date of the topics first post.
	public function getStartDate($format = '%B %d, %Y'){
		return strftime($format, $this->startDate);
	}

	//Returns an array containing all the topic's posts.
	public function getPosts(){
		return $this->posts;
	}
}
?>