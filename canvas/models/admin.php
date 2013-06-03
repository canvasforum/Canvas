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
use \Wires\Routing\Response as Response;

class Admin {
	public static function updateSetting($setting, $value){
		DB::query('UPDATE settings SET value = :value WHERE setting = :setting', array('setting' => $setting, 'value' => $value));

		return true;
	}

	public static function updateNotepad(){
		if(Response::isPost()){
			return static::updateSetting('adminNotepad', $_POST['adminNotepad']);
		}

		return false;
	}
}
?>