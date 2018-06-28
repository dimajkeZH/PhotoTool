<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

function debug($str){
	echo '<pre>';
	var_dump($str);
	echo '</pre>';
	exit;
}

function loger($file, $message = 'NULL'){
	$message = date('[Y-m-d H:i:s (T)] ').$message.PHP_EOL;
	$f = fopen($file, 'a');
	fwrite($f, $message);
	fclose($f);
}

function message($status, $message) {
	exit(json_encode(['status' => $status, 'message' => $message]));
}