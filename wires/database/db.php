<?php

/**
 * Wires
 *
 * A super simple, super flexible framework built for lightning fast development.
 * 
 * Released under the WTFPL.
 * http://www.wtfpl.net/
 * 
 * @package Wires
 * @author Andrew Lee
 * @link http://wildandrewlee.com
 */

namespace Wires\Database;
use PDO;
use Exception;
use \Wires\Error as Error;

//If somebody is trying to directly access this file.
defined('COMPONENT') or die('Access Denied.');

class DB {
	private static $config = array();
	private static $connection = null;

	//Attempt to connect to the database.
	public static function connect($config){
		try{
			$base = 'mysql:host=' . $config['host'] . ';port=' . $config['port'] . ';dbname=' . $config['name'];

			static::$config = $config;
			static::$connection = new PDO($base, $config['user'], $config['pass']);
		}
		catch(Exception $exception){
			Error::log($exception);
		}
	}

	//Performs database queries but returns the PDO object.
	public static function queryObj($query, $param){
		if(static::isConnected()){
			$derp = $query;
			//Prepare the query.
			$query = static::$connection->prepare($query);

			//Bind data.
			if(!is_null($param) && is_array($param)){
				foreach($param as $key => $value){
					$query->bindValue($key, $value);
				}
			}

			//Execute the query.
			$query->execute();

			return $query;
		}
		else{
			return null;
		}
	}

	//Perform database queries and returns the result. Null if empty.
	public static function query($query, $param = array(), $type = PDO::FETCH_ASSOC){		
		$query = static::queryObj($query, $param);

		//Return the results.
		if(!is_null($query)){
			return $query->fetchAll($type);
		}
		else{
			return null;
		}
	}

	//Returns a single specified value. Null if empty.
	public static function single($query, $param, $col){
		$result = static::query($query, $param, PDO::FETCH_ASSOC);

		return !empty($result) && is_array($result) ? $result[0][$col] : null;
	}

	//Returns true if the connection is valid otherwise false.
	public static function isConnected(){
		return static::$connection !== null;
	}

	//Returns the currently connected version of database.
	public static function getVersion(){
		return explode('-', static::$connection->getAttribute(PDO::ATTR_SERVER_VERSION))[0];
	}

	//Returns the current database type.
	public static function getType(){
		return static::$connection->getAttribute(PDO::ATTR_DRIVER_NAME);
	}
}
?>