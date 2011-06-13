<?php

function h($string, $encode='utf-8'){

	return htmlspecialchars($string, ENT_QUOTES, $encode);
}

function m($string){
	return mysql_real_escape_string($string);
}

function Location($url){

	header("location: ".$url);
	exit;
}

/*
 * ﾌｧｲﾙ書き込み自作関数
 * $f_dir: 書き込みﾌｧｲﾙﾊﾟｽ
 * $text: 書き込み内容
 * $type: 書き込みﾀｲﾌﾟ
 */
function file_put($dir, $string, $type=''){

	$version = phpversion();
	if((substr($version, 0, 1)) == '5'){

		if($type == 'a') file_put_contents($dir, $string, FILE_APPEND);
		else file_put_contents($dir, $string);

	}else{

		$fp = fopen($dir, $type);
		fwrite($fp, $string);
		fclose($fp);
	}
	chmod($dir, 0777);
}

function mb($str, $to, $from){

	return mb_convert_encoding($str, $to, $from);
}