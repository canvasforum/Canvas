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

class Post {
	private $tid;
	private $pid;
	private $author;
	private $contents;
	private $postDate;
	private $editedBy;
	private $editedOn;

	public function __construct(){
		$this->author = Canvas::getUser($this->author);
		$this->editedby = Canvas::getUser($this->editedBy);
	}

	//Returns the topic ID in which this post can be found.
	public function getParent(){
		return $this->tid;
	}

	//Returns the post ID.
	public function getID(){
		return $this->pid;
	}

	//Returns the topic starter as a User object.
	public function getAuthor(){
		return $this->author;
	}

	//Returns the date of the topics first post.
	public function getPostDate($format = '%B %d, %Y'){
		return strftime($format, $this->postDate);
	}

	//Returns the date on which this post was edited.
	public function getEditDate($format = '%B %d, %Y'){
		return strftime($format, $this->editedBy);
	}

	//Returns the contents of the post.
	public function getContents(){
		return $this->contents;
	}
}
?>