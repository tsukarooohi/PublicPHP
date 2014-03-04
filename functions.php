<?php

function _h($string, $encode='utf-8', $type='') {

	if ($type) return htmlspecialchars_decode($string, ENT_QUOTES);

	return htmlspecialchars($string, ENT_QUOTES, $encode);
}

function _m($string) {
	
	return mysql_real_escape_string(trim($string));
}

function _u($string, $type='') {

	if ($type) {
		return urldecode($string);
	} else {
		return urlencode($string);
	}
}

// リダイレクト処理
function _redirect($url = null, $status = 302) {

	if ($status === 301) {

		header('HTTP/1.1 301 Moved Permanently', true, 301);
		header('Location: ' . $url);
		exit;

	} elseif ($status === 200) {

		header('HTTP/1.1 200', true, 200);
		header('Location: ' . $url);
		exit;
	}

	return false;
}

/*
 * ﾌｧｲﾙ書き込み自作関数
 * $f_dir: 書き込みﾌｧｲﾙﾊﾟｽ
 * $text: 書き込み内容
 * $type: 書き込みﾀｲﾌﾟ
 */
function _filePut($dir, $string, $type='') {

	$version = phpversion();
	if ((substr($version, 0, 1)) === 5) {

		if ($type === 'a') {
			
			file_put_contents($dir, $string, FILE_APPEND);
		} else {
			
			file_put_contents($dir, $string);
		}

	} else {

		$fp = fopen($dir, $type);
		fwrite($fp, $string);
		fclose($fp);
	}
	chmod($dir, 0777);
}

function _mb($string, $to, $from) {

	return mb_convert_encoding($string, $to, $from);
}

// クラスインスタンスの生成処理
function _instanceMake($class, $dir='/') {

	if (!class_exists($class)) {

		require(DIR . $dir . $class . '.php');
		return new $class;
	}
}

// 配列を指定数で分割した結果を返す
function _array_chunk($array, $limit, $key) {
	
	$chunk_array = array_chunk($array , $limit);

	return $chunk_array[$key];
}

//第○　○曜日かの振り分け
function _getWeek($y, $m, $d) {

	$_1day = (int)(date('w', strtotime($y . '-' . $m . '-01')));//この月の始めの曜日数値を取得
	$now = strtotime($y . '-' . $m . '-' . $d);
	$saturday = 6;
	$week_day = 7;
	$ww = $w = (int)(date('w', $now));
	$day = (int)(date('d', $now));
	if ($w != $saturday) {

		$w = ($saturday - $w) + $day;
	} else {

		$w = $day;// 土曜日の場合を修正
	}

	if ($_1day > $ww) {
		
		$return_day = ceil( $w/$week_day ) - 1;

	} else {

		$return_day = ceil( $w/$week_day );
	}

	return $return_day;
}

/*
 * 指定したキーが配列にあればその要素の値を返す
 * なければ false
 */
function _arrayKey($needle, $haystack) {
	
	if (array_key_exists($needle, $haystack)) {
		
		return $haystack[$needle];

	} else {
		
		return false;
	}
}