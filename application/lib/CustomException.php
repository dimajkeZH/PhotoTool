<?php

class CustomException{

	public static function Fatal(){
		$error = error_get_last();
    	if ($error['type'] === 1) { 
        	echo '<center>Страница 500.';
        	exit;    
    	}
	}

	public static function errorCode($code, $level = 0) {
		http_response_code($code);
		$path = 'application/views/errors/'.$code.'.php';
		if (file_exists($path)) {
			require $path;
		}
		exit;
	}
}