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

class Form {
	private $fields = null;

	public function __construct($fields = array()){
		$this->fields = $fields;
	}

	//Builds the HTML for the specified input field.
	public function getField(){

	}

	//Build the HTML for the form and return it to the user.
	public function getHTML(){
		$html = '';

		foreach($fields as $field => $args){
			if(is_array($args)){
				$html = '<' . $field;

				foreach($args as $arg => $val){
					$html .= ' ' . $arg . '="' . $val . '"';
				}

				if($field == 'input'){
					$html .= ' />';
				}
				else if($field == 'textarea'){
					$html .= '></textarea>';
				}
			}
		}

		return $html;
	}

	//Returns whether or not an input field was posted.
	public static function used($field){
		return isset($_POST[$field]);
	}

	//Returns the value of a posted form element.
	public static function getInput($field){
		if(!empty($_POST[$field])){
			return $_POST[$field];
		}
		else{
			return false;
		}
	}
}
?>