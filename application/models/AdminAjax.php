<?php

namespace application\models;

use application\models\Admin;

class AdminAjax extends Admin {

	public $TITLE = 'API';

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

	public function delImage($post){
		$ID = $post['ID'];
		$q = 'SELECT `PATH` FROM IMAGE_LIST WHERE ID = :ID';
		$params = [
			'ID' => $ID,
		];
		$FILENAME = $this->db->column($q, $params);
		$FILENAME = $_SERVER['DOCUMENT_ROOT'].'/'.$this->file_path.'/'.$FILENAME.'.'.$this->file_format;
		unlink($FILENAME);
		$q = 'DELETE FROM IMAGE_LIST WHERE ID = :ID';
		$params = [
			'ID' => $ID,
		];
		return $this->db->bool($q, $params);
	}

	public function getUser($route){
		$ID = $route['param'];
		$q = 'SELECT UA.F_NAME, UA.S_NAME, UA.NAME, UA.MAIL, UA.PHONE, (SELECT COUNT(TL.ID) FROM TASK_LIST as TL WHERE TL.ID_USER = UA.ID) as COUNT_TASKS FROM USER_ACCOUNTS as UA WHERE UA.ID = :ID';
		$params = [
			'ID' => $ID,
		];
		$return['DATA'] = $this->db->row($q, $params)[0];
		$q = 'SELECT * FROM USER_SESSIONS WHERE (ID_USER = :ID) AND (DT_DESTROY < NOW())';
		$return['ONLINE'] = $this->db->row($q, $params);
		$q = 'SELECT * FROM USER_SESSIONS WHERE (ID_USER = :ID) AND (DT_DESTROY >= NOW())';
		$return['OFFLINE'] = $this->db->row($q, $params);
		return (json_encode(['STATUS'=> true, 'DATA' => $return['DATA'], 'ONLINE' => $return['ONLINE'], 'OFFLINE' => $return['OFFLINE']]));
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