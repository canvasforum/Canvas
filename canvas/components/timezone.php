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

class Timezone {
	public static function getOffset($first, $second){
		$offset =  $second->getOffset($first);

		$hours = (int) $offset / 3600;
		$minutes = floor(abs($offset % 3600 / 3600));
		$sign = $hours >= 0 ? '+' : '-';
		$hours = floor(abs($hours));

		$offset = $sign . str_pad($hours, 2, '0', STR_PAD_LEFT) . ':' . str_pad($minutes, 2, '0', STR_PAD_LEFT);

		return $offset;
	}

	public static function buildSelect($selected){
		$select = '<select name="timezone">';
		$zones = array();

		foreach(DateTimeZone::listIdentifiers() as $zone){
			$disp = preg_replace('#_#', ' ', $zone);

			$zones[$disp] = $zone;
		}

		ksort($zones);

		foreach($zones as $disp => $zone){
			$selects = $zone == $selected ? ' selected' : '';

			$select .= '<option value="' . $zone . '"' . $selects . '>' . $disp . '</option>';
		}

		$select .= '</select>';

		return $select;
	}
}
?>