<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	# return all rows
	function dbGetRows($sql, $db=false) {
		$result = dbQuery($sql, $db);

		if (!$result)
			return false;
		
		if ($result->num_rows()) {
			return $result->result_array();
		}
		
		return false;
	}

	
	function dbRowsAffected($db=false) {
		$ci = &get_instance();
		if (!$db) {
			$db = $ci->db;
		}

		return (int) $db->affected_rows();
	}

	# return the first row
	function dbGetRow($sql, $db=false) {
		$result = dbQuery($sql, $db);

		if (!$result)
			return null;

		if ($result->num_rows()) {
			return $result->row_array();
		}
		return null;
	}
	
	# return the first column
	function dbGetOne($sql, $db=false) {
		$result = dbQuery($sql, $db);

		if (!$result)
			return null;

		if ($result->num_rows()) {
			$ret = $result->row_array();
			foreach ($ret as $val) {
				return $val;
			}
		}
		else
			return null;
	}
	
	# count
	function dbGetCount($sql, $db=false) {
		$ci = &get_instance();
		if (!$db) {
			$db = $ci->db;
		}
		
		$sql = "select count(*) from ($sql)";
		
		return dbGetOne($sql,$db);
	}
	
	# insert
	function dbInsertSQL($table, $fields, $db=false) {
		$ci = &get_instance();
		if (!$db) {
			$db = $ci->db;
		}
		
		$sql = "insert into $table (";
		$fieldnames = "";
		$fieldvals = "";
		
		$i = 0;
		
		reset($fields);
		while(list($f, $v) = each($fields)) {
			$fieldnames .= $f . ", ";
			
			if (preg_match_all("/{{(.*?)}}/", $v, $m)) {
				$val = strtolower($m[1][0]);
				$fieldvals .= $m[1][0] . ", ";
			}
			else {
				$fieldvals .= $db->escape($v) . ", ";
			}
		}
		$fieldnames = substr($fieldnames, 0, -2);
		$fieldvals = substr($fieldvals, 0, -2);

		$sql .= $fieldnames . ") values (" .$fieldvals . ")";
		
		return $sql;
	}
	
	function dbInsert($table, $fields, $db=false) {
		$ci = &get_instance();
		if (!$db) {
			$db = $ci->db;
		}
		
		$sql = dbInsertSQL($table, $fields, $db);
		$ret = dbQuery($sql, $db);
		return $ret;
	}
	
	# update
	function dbUpdateSQL($table, $fields, $where, $db=false) {
		$ci = &get_instance();
		if (!$db) {
			$db = $ci->db;
		}
		
		$sql = "update $table set ";
		$vars = "";
		
		$i = 0;
		
		reset($fields);
		while(list($f, $v) = each($fields)) {
			if (preg_match_all("/{{(.*?)}}/", $v, $m)) {
				$val = strtolower($m[1][0]);
				$vars .= "$f = " . $m[1][0] . ", ";
			}
			else  {
				$vars .= "$f = " . $db->escape($v) . ", ";
			}
		}
		$sql .= substr($vars, 0, -2);
		$sql .= " where $where";
		
		return $sql;
	}
	
	function dbUpdate($table, $fields, $where, $db=false) {		
		$ci = &get_instance();
		if (!$db) {
			$db = $ci->db;
		}
		
		$sql = dbUpdateSQL($table, $fields, $where, $db);
		$ret = dbQuery($sql, $db);
		
		return $ret;
	}
	
	
	# query
	function dbQuery($sql, $db=false) {
		$ci = &get_instance();
		if (!$db) {
			$db = $ci->db;
		}
		
		$ret = false;
		
		try {
			$ret = $db->query($sql);
		}
		catch (Exception $e) {
			$ci->list_sql[] = $sql;
			$ci->error_sql_str = $e->getMessage();
			$ci->error_sql[] = $ci->error_sql_str;
			
			//throw new Exception($e->getMessage(), 500);
			return false;
		}
		
		return $ret;
	}
	
	function dbErrorMessage() {
		$ci = &get_instance();

		return $ci->error_sql_str;
	}
	
	function dbBeginTrans($db=false) {
		$ci = &get_instance();
		if (!$db) {
			$db = $ci->db;
		}
		
		$ret = $db->trans_begin();
		
		// tidak bisa menggunakan dbQuery
		$sql = 'START TRANSACTION';
		
		$ci->last_sql = $sql;
		$ci->last_error_sql = ''; // $db->getErrorMessage();
		if ($ci->config->item('debug_sql')) {
			$ci->list_sql[] = $sql;
			$ci->error_sql[] = ''; // $db->getErrorMessage();
		}
		
		return $ret;
	}
	
	function dbEndTrans($ok=null,$db=false) {
		$ci = &get_instance();
		if (!$db) {
			$db = $ci->db;
		}
		
		if(!isset($ok)) {
			if ($db->trans_status() === false)
				$ok = false;
			else
				$ok = true;
		}
		
		if($ok) {
			$sql = 'COMMIT';
			$ret = $db->trans_commit();
		}
		else {
			$sql = 'ROLLBACK';
			$ret = $db->trans_rollback();
		}
		
		// tidak bisa menggunakan dbQuery
		$ci->last_sql = $sql;
		$ci->last_error_sql = ''; // $db->getErrorMessage();
		if ($ci->config->item('debug_sql')) {
			$ci->list_sql[] = $sql;
			$ci->error_sql[] = ''; // $db->getErrorMessage();
		}
		
		return $ret;
	}
	
	
?>