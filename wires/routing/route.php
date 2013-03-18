<?php

/**
 * Wires
 *
 * A super simple, super flexible framework built for lightning fast development.
 * 
 * Released under the WTFPL.
 * http://www.wtfpl.net/
 * 
 * @package Wires
 * @author Andrew Lee
 * @link http://andrewleenj.com
 */

 namespace Wires\Routing;

//If somebody is trying to directly access this file.
defined('COMPONENT') or die('Access Denied.');

class Route {
	private $uri = null;
	private $path = null;
	private $wildcard = false;

	public function __construct($uri, $path, $wildcard = false){
		$this->uri = $uri;
		$this->path = $path;
		$this->wildcard = $wildcard;
	}

	//Checks to see if the URI provided matches this route's URI.
	public function match($uri){
		if($this->wildcard){
			$regex = $this->uri;
			$regex = preg_replace('/\*/', '.+?', $regex);
			$regex .= '/.*';
			$regex = '#' . $regex . '#';

			return preg_match($regex, $uri);
		}
		else{
			return $this->uri == $uri;
		}
	}

	//Sets the route's URI.
	public function setURI($uri){
		$this->uri = $uri;
	}

	//Sets the route's resource path.
	public function setPath($path){
		$this->path = $path;
	}

	//Returns the route's resource path.
	public function getPath(){
		return $this->path;
	}

	//Returns the route's URI.
	public function getURI(){
		return $this->uri;
	}

	//Returns whether this route uses a wildcard or not.
	public function wildCard(){
		return $this->wildcard;
	}

	//Sets this route to use or not use a wildcard. Default FALSE.
	public function setWildCard($set = false){
		$this->wildcard = $set;
	}
}
?>