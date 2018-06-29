<?php

namespace application\models;

use application\models\Admin;

class AdminAjax extends Admin {

	public function loadImage($file){
		return true;


	}

	//send finally message to user
	public function message($status, $message){
		exit(json_encode(['status' => $status, 'message' => $message]));
	}

	//full clear data
	public function clear($str) {
	    $str = trim($str);
	    $str = strip_tags($str);
	    return $str;
	}

	//clear data and save tags
	public function clearHTML($str) {
	    $str = trim($str);
	    $str = stripslashes($str);
	    $str = htmlspecialchars($str);
	    return $str;
	}
}