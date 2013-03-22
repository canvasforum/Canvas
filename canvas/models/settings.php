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

 class Settings {
 	public static function getSetting($name, $type = 'string'){
 		$query = 'SELECT value FROM settings WHERE setting = :setting LIMIT 1';

 		$result = DB::single($query, array(
 			'setting' => $name
 		), 'value');

 		switch($type){
 			case 'string':
 				return $result;

 			case 'int':
 				return intval($result);

 			case 'bool':
 				return bool($result);
 		}
 	}
 }
?>