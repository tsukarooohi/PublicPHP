<?php

class ClassDB{

	public $link;
	public $total;

	public function __construct(){

		$db_host = '';
		$db_user = '';
		$db_pass = '';
		$db_name = '';
		
		$this->link = mysql_connect($db_host, $db_user, $db_pass)  or die('Could not connect: ' . mysql_error());
		mysql_select_db($db_name) or die('Could not select database');
		mysql_query('SET NAMES utf8');
	}

	//Select処理
	protected function Select($sql, $sql_rows=''){

		$resource = mysql_query($sql);

		if(!mysql_errno() && mysql_num_rows($resource)){

			if($sql_rows){
				$this->FoundRows();
			}

			while($a = mysql_fetch_assoc($resource)) $datas[] = $a;

			return $datas;
		}
	}

	//Insert処理
	protected function Insert($table, $values){

		foreach($values as $k => $v){
			$values[$k] = "'" . $this->m($v) . "'";
		}
		
		$column = array_keys($values);
		$sql = "insert into " . $table . "
					(" . implode(' , ', $column) . ")
					values
					(" . implode(' , ', $values) . ")
			   ";
		
		mysql_query($sql);
		
	}
	
	//UpDate処理
	protected function UpDate($table, $values, $where){

		foreach($values as $k => $v)
			$in_set .= ',' . $k . " = '" . $this->m($v) . "'";
		
		$sql = "update " . $table . " set
					" . ltrim($in_set, ',') . "
				where " . $where . "
			   ";

		mysql_query($sql);
		
	}
	
	//InsertUpdate処理
	protected function InsertUp($table, $values){

		foreach($values as $k => $v){
			$in_set .= ',' . $k . " = '" . $this->m($v) . "'";
		}

		array_shift($values);
		foreach($values as $k => $v)
			$up_set .= ',' . $k . " = '" . $this->m($v) . "'";

		$sql = "insert into " . $table . " set
					 " . ltrim($in_set, ',') . "
				ON DUPLICATE KEY UPDATE
					" . ltrim($up_set, ',') . "
			   ";

		mysql_query($sql);
	}
	
	protected function m($string){
		
		return mysql_real_escape_string($string);
	}
	
	//総数の取得処理
	protected function FoundRows(){
		
		$resource = mysql_query('select found_rows() as all_max');
		$this->total = mysql_result($resource, 0);
	}
	
	public function DB_close(){

		mysql_close($this->link);
	}

}