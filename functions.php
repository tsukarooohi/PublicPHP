<?php

function h($string){

	return htmlspecialchars($string, ENT_QUOTES);
}

function m($string){
	return mysql_real_escape_string($string);
}
