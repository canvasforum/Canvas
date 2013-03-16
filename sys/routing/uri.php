<?php
namespace Canvas\Routing;
use \Canvas\Configuration as Configuration;

//If somebody is trying to directly access this file.
defined('COMPONENT') or die('Access Denied.');

class URI {
	//The requested URI as well as its arguements separated using '/' as the delimeter.
	private $uri = null;
	private $original = null;
	private $args = array();

	//A URI constructor.
	function __construct($uri = null){
		//Set the current URI.
		if(is_null($uri)){
			$this->uri = $this->original = $_SERVER['REQUEST_URI'];
		}
		else{
			$this->uri = $this->original = $uri;
		}

		//Remove the initial "/".
		$this->uri = substr($this->uri, 1);

		//Remove the installation directory from the path.
		$this->uri = preg_replace('#^' . Configuration::get('dir') . '#', '', $this->uri);

		//Split the URI into args based on "/".
		$this->args = explode('/', $this->uri);
	}

	public function getOriginal(){
		return $this->original;
	}

	//Returns the nubmer of arguements.
	public function length(){
		return count($this->args);
	}

	//Gets the argument at $index.
	public function getArg($index){
		if(abs($index) < $this->length()){
			//If the index is positive return the nth argument otherwise return the
			//element with the index $this->length() - abs($index) - 1.
			return $index > 0 ? $this->args[$index] : $this->args[$this->length() + $index - 1];
		}
		else{
			return null;
		}
	}

	//Returns the arguement list.
	public function getArgs(){
		return $this->args;
	}

	//Returns the requested resource path.
	public function getURI(){
		return implode('/', $this->getArgs());
	}
}
?>

