<?php

namespace application\models;

use application\models\Admin;

class AdminAjax extends Admin {

	public function loadImage($file){
		$oldName = pathinfo($file['name'])['filename'];
		$tmpPath = $file['tmp_name'];
		$newName = $this->generateStr(64);
		$newPath = $_SERVER['DOCUMENT_ROOT'].'/'.$this->file_path.'/'.$newName.'.'.$this->file_format;
		if(move_uploaded_file($tmpPath, $newPath)) {
    		$q = 'INSERT INTO IMAGE_LIST (`PATH`, `NAME`) VALUES (:PATH, :NAME)';
    		$params = [
    			'PATH' => $newName,
    			'NAME' => $oldName,
    		];
    		return $this->db->bool($q, $params);
		}
		return false;
	}

	//send finally message to user
	public function message($status, $message, $id = -1){
		exit(json_encode(['status' => $status, 'message' => $message, 'id' => $id]));
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