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
		$query = 'UPDATE settings SET value = :value WHERE setting = :setting';

		DB::query($query, array('setting' => $setting, 'value' => $value));

		return true;
	}

	public static function updateNotepad(){
		if(Response::isPost()){
			return static::updateSetting('adminNotepad', $_POST['adminNotepad']);
		}

		return false;
	}

	public static function updateForumOrder(){
		if(Response::isPost()){
			$order = json_decode($_POST['list'], true);

			foreach($order as $category => $items){
				$category = explode('-', $category)[1];
				$query = 'UPDATE categories SET ordering = :ordering WHERE id = :id';

				DB::query($query, array('ordering' => $items[0], 'id' => $category));

				for($n = 0; $n < count($items[1]); $n++){
					$query = 'UPDATE forums SET ordering = :ordering, cid = :cid WHERE fid = :fid';

					DB::query($query, array('ordering' => $n + 1, 'fid' => $items[1][$n], 'cid' => $category));
				}
			}

			return true;
		}

		return false;
	}
}
?>