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

		$utc = new DateTimeZone('UTC');
		$c = new DateTime('now', $utc);
		$selected = new DateTimeZone($selected);

		$neg = array();
		$pos = array();

		foreach(DateTimeZone::listIdentifiers() as $zone){
			$cz = new DateTimeZone($zone);
			$offset =  static::getOffset($c, $cz);

			if(!in_array($offset, $neg) && !in_array($offset, $pos)){
				if($offset[0] == '-'){
					$neg[$offset] = $zone;
				}
				else{
					$pos[$offset] = $zone;
				}
			}
		}

		krsort($neg);
		ksort($pos);

		foreach($neg as $offset => $zone){
			$selects = $offset == static::getOffset($c, $selected) ? ' selected' : '';

			$select .= '<option value="' . $zone . '"' . $selects . '>GMT ' . $offset . ' Hours</option>';
		}

		foreach($pos as $offset => $zone){
			$selects = $offset == static::getOffset($c, $selected) ? ' selected' : '';

			$select .= '<option value="' . $zone . '"' . $selects . '>GMT ' . $offset . ' Hours</option>';
		}

		$select .= '</select>';

		return $select;
	}
}
?>