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

class Page {
	private $name;
	private $uri;
	private $active;

	function __construct($name, $uri, $active){
		$this->name = $name;
		$this->uri = $uri;
		$this->active = $active;
	}

	public function getName(){
		return $this->name;
	}

	public function getURI(){
		return $this->uri;
	}

	public function isActive(){
		return $this->active;
	}
}
?>