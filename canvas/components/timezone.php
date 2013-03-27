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

class Timezone {
	public static function buildSelect($selected){
		$select = '<select name="timezone">';

		$utc = new DateTimeZone('UTC');
		$c = new DateTime('now', $utc);

		$zones = array();

		foreach(DateTimeZone::listIdentifiers() as $zone){
			$disp = preg_replace('#_#', ' ', $zone);
			$selects = $zone == $selected ? ' selected' : '';

			$select .= '<option value="' . $zone . '"' . $selects . '>' . $disp . '</option>';
		}

		$select .= '</select>';

		return $select;
	}
}
?>