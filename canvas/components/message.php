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

 class Message {
 	const ERROR = 1;
 	const NOTICE = 2;

 	private $msg = '';
 	private $type = -1;
 	private $persist = false;
 	private $bind = null;

 	public function __construct($type, $msg, $persist = false, $bind = null){
 		$this->msg = $msg;
 		$this->persist = $persist;
 		$this->type = $type;
 		$this->bind = $bind;

 		if($type == self::ERROR){
 			if($persist){
 				$_SESSION['errors'][] = $this;
 			}
 			else{
 				Canvas::logError($this);
 			}
 		}
 		else if($type == self::NOTICE){
 			if($persist){
 				$_SESSION['notices'][] = $this;
 			}
 			else{
 				Canvas::logNotice($this);
 			}
 		}
 	}

 	public function getType(){
 		return $this->type;
 	}

 	public function getMessage(){
 		return $this->msg;
 	}

 	public function isBound(){
 		return !is_null($this->bind);
 	}

 	public function getBind(){
 		return $this->isBound() ? $this->bind : false;
 	}
 }
?>