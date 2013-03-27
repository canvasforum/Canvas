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

		if(strlen($this->editedBy) == 6){
			$this->editedBy = Canvas::getUser($this->editedBy);
		}
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
		$postDate = changeTimeZone(Canvas::getUser()->getTimeZone(), $this->postDate);

		return strftime($format, strtotime($postDate));
	}

	//Returns the date on which this post was edited.
	public function getEditDate($format = '%B %d, %Y'){
		$editDate = changeTimeZone(Canvas::getUser()->getTimeZone(), $this->editedOn);

		return strftime($format, strtotime($editDate));
	}

	//Returns the contents of the post.
	public function getContents(){
		return $this->contents;
	}

	//Returns whether or not the post was edited.
	public function isEdited(){
		return (strtotime($this->editedOn) != strtotime('0000-00-00 00:00:00'));
	}

	//Returns the post editor as an object.
	public function getEditedBy(){
		return $this->editedBy;
	}

	//Returns whether or not this post is the first post in a topic.
	public function isFirstPost(){
		$parent = Canvas::getTopic($this->tid);
		return ($parent->getFirstPost()->getID() == $this->pid);
	}

	//Returns whether or not this post can be edited by the current use.
	public function canEdit(){
		$isAuthor = ($this->author->getID() == Canvas::getUser()->getID());
		$canEditOwn = Canvas::getUser()->hasPermission(Permissions::EDIT_OWN_POSTS);
		$canEditOthers = Canvas::getUser()->hasPermission(Permissions::EDIT_OTHER_POSTS);

		return $isAuthor && $canEditOwn || !$isAuthor && $canEditOthers;
	}

	//Returns the URL at which this post can be edited.
	public function getEditURL(){
		return Canvas::getBase() . 'post/edit/' . $this->tid . '/' . $this->pid;
	}
}
?>