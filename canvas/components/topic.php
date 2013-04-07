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

class Topic {
	private $tid;
	private $fid;
	private $name;
	private $author;
	private $startDate;
	private $posts = null;

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
		return htmlspecialchars($this->name);
	}

	//Returns the topic starter as a User object.
	public function getAuthor(){
		return $this->author;
	}

	//Returns the date of the topics first post.
	public function getStartDate($format = '%B %d, %Y'){
		if(Canvas::loggedIn()){
			$startDate = changeTimeZone(Canvas::getUser()->getTimeZone(), $this->startDate);
		}
		else{
			$startDate = changeTimeZone(Canvas::getTimeZone(), $this->startDate);
		}

		return strftime($format, strtotime($startDate));
	}

	//Returns an array containing all the topic's posts.
	public function getPosts(){
		if(!is_null($this->posts)){
			return $this->posts;
		}
		else{
			$query = 'SELECT tid, pid, author, contents, postDate, editedBy, editedOn FROM posts WHERE tid = :tid ORDER BY id ASC';

			$result = DB::queryObj($query, array('tid' => $this->tid));

			$result = $result->fetchAll(PDO::FETCH_CLASS, 'Post');

			$this->posts = $result;

			return is_null($result) ? array() : $result;
		}
	}

	//Returns the first post in the topic and removes it from the list.
	public function getFirstPost(){
		if(is_null($this->posts)){
			$this->getPosts();
		}
		
		$posts = $this->posts;
		$post = $posts[0];

		unset($this->posts[0]);

		return $post;
	}

	//Returns the last post in the topic.
	public function getLastPost(){
		if(is_null($this->posts)){
			$this->getPosts();
		}

		return Arr::lastElement($this->posts);
	}

	//Returns the URL at which this topic can be found.
	public function getURL(){
		return Canvas::getBase() . 'topic/' . $this->tid;
	}
}
?>