<?php

class ClassDB{

	private $db_host, $db_user, $db_pass, $db_name, $link;
	public $total;

	public function __construct(){

		$this->db_host = '';
		$this->db_user = '';
		$this->db_pass = '';
		$this->db_name = '';

		$this->link = mysql_connect($this->db_host,$this->db_user,$this->db_pass)  or die('Could not connect: ' . mysql_error());
		mysql_select_db($this->db_name) or die('Could not select database');
		mysql_query("SET NAMES utf8");
	}

	protected function DB_connect(){

		$this->link = mysql_connect($this->db_host,$this->db_user,$this->db_pass)  or die('Could not connect: ' . mysql_error());
		mysql_select_db($this->db_name) or die('Could not select database');
		mysql_query("SET NAMES utf8");

	}

	//select処理
	protected function Select($sql, $sql_rows=''){

		$resource = mysql_query($sql);
		if(!mysql_errno() && mysql_num_rows($resource)){

			if($sql_rows){

				$total_result = mysql_query("select found_rows() total");
				$this->total = mysql_result($total_result, 0);
			}

			while($a = mysql_fetch_assoc($resource)) $datas[] = $a;

			return $datas;
		}

		return false;
	}


	protected function DB_close(){

		mysql_close($this->link);
	}

}

