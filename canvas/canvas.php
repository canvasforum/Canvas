<?php
use \Wires\Database\DB as DB;

function canvas($mode, $type, $args = array()){
	if($mode == 'fetch'){
		switch($type){
			case 'categories':
				$result = DB::query('SELECT id, name FROM categories ORDER BY id ASC', null, PDO::FETCH_OBJ);
				
				if(is_null($result)){
					return array();
				}
				else{
					return $result;
				}

			case 'forums':
				$result = DB::query('SELECT fid, name, description FROM forums WHERE cid = :cid', $args, PDO::FETCH_OBJ);

				if(is_null($result)){
					return array();
				}
				else{
					return $result;
				}
		}
	}

	return null;
}
?>