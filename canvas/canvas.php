<?php
use \Canvas\Database\DB as DB;

function canvas($mode, $type, $args = array()){
	if($mode == 'fetch'){
		switch($type){
			case 'categories':
				return DB::query('SELECT cid, name FROM categories ORDER BY id ASC', null, PDO::FETCH_OBJ);
		}
	}
	
	return null;
}
?>