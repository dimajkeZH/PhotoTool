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

	public function delUser($route){
		$ID = $route['param'];
		$tran = [
			0 => [
				'sql' => 'DELETE FROM USER_ACCOUNTS WHERE ID = :ID',
				'params' => [
					'ID' => $ID
				],
			],
			1 => [
				'sql' => 'DELETE FROM USER_SESSIONS WHERE ID_USER = :ID',
				'params' => [
					'ID' => $ID
				],
			],
		];
		return $this->db->transaction($tran);
	}
	public function saveUser($post){
		$ID = $post['ID'];
		$F_NAME = $post['F_NAME'];
		$S_NAME = $post['S_NAME'];
		$NAME = $post['NAME'];
		$PASS = $post['PASS'];
		$changePass = ($PASS != '')?'true':'false';
		$PASS = $this->hashPSWD($post['PASS']);
		$MAIL = $post['MAIL'];
		$PHONE = $post['PHONE'];
		$params = [
			'F_NAME' => $F_NAME,
			'S_NAME' => $S_NAME,
			'NAME' => $NAME,
			'MAIL' => $MAIL,
			'PHONE' => $PHONE,
		];
		if($ID == -1){
			$q = 'INSERT INTO USER_ACCOUNTS (F_NAME, S_NAME, NAME, MAIL, PHONE, PASS) VALUES (:F_NAME, :S_NAME, :NAME, :MAIL, :PHONE, :PASS)';
			$params['PASS'] = $PASS;
		}else{
			if($changePass){
				$params['PASS'] = $PASS;
				$tmpSQL = ', PASS = :PASS';
			}
			$q = 'UPDATE USER_ACCOUNTS SET F_NAME = :F_NAME, S_NAME = :S_NAME, NAME = :NAME, MAIL = :MAIL, PHONE = :PHONE'.$tmpSQL.' WHERE ID = :ID';
			$params['ID'] = $ID;
		}
		//debug($params);
		return $this->db->bool($q, $params);
	}

	public function delTag($route){
		$ID = $route['param'];
		$q = 'DELETE FROM TAG_LIST WHERE ID = :ID';
		$params = [
			'ID' => $ID
		];
		return $this->db->bool($q, $params);
	}
	public function saveTags($post){
		$tran = [];
		foreach($post as $key => $val){
			if($val['ID'] == -1){
				$sql = 'INSERT INTO TAG_LIST (VALUE, VAL_TYPE) VALUES (:VALUE, :VAL_TYPE)';
				$params = [
					'VALUE' => $val['VALUE'],
					'VAL_TYPE' => $val['TYPE'],
				];
			}else{
				$sql = 'UPDATE TAG_LIST SET VALUE = :VALUE, VAL_TYPE = :VAL_TYPE WHERE ID = :ID';
				$params = [
					'VALUE' => $val['VALUE'],
					'VAL_TYPE' => $val['TYPE'],
					'ID' => $val['ID'],
				];
			}
			$tran[$key] = [
				'sql' => $sql,
				'params' => $params
			];
		}
		return $this->db->transaction($tran);
	}


	/* API */
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
		return json_encode(['STATUS'=> true, 'DATA' => $return['DATA'], 'ONLINE' => $return['ONLINE'], 'OFFLINE' => $return['OFFLINE']]);
	}
	public function getTask($route){
		$ID = $route['param'];
		$q = '';
		//$q = 'SELECT UA.F_NAME, UA.S_NAME, UA.NAME, UA.MAIL, UA.PHONE, (SELECT COUNT(TL.ID) FROM TASK_LIST as TL WHERE TL.ID_USER = UA.ID) as COUNT_TASKS FROM USER_ACCOUNTS as UA WHERE UA.ID = :ID';
		$params = [
			'ID' => $ID,
		];
		$return['DATA'] = $this->db->row($q, $params)[0];
		//$q = 'SELECT * FROM USER_SESSIONS WHERE (ID_USER = :ID) AND (DT_DESTROY < NOW())';
		$return['ONLINE'] = $this->db->row($q, $params);
		//$q = 'SELECT * FROM USER_SESSIONS WHERE (ID_USER = :ID) AND (DT_DESTROY >= NOW())';
		$return['OFFLINE'] = $this->db->row($q, $params);
		return json_encode(['STATUS'=> true, 'DATA' => $return['DATA'], 'ONLINE' => $return['ONLINE'], 'OFFLINE' => $return['OFFLINE']]);
	}
	public function getTagTypes(){
		$q = 'SELECT NAME, VALUE FROM TAG_TYPES';
		$return['TAG_LIST'] = $this->db->row($q);
		return json_encode(['STATUS'=> true, 'DATA' => $return['TAG_LIST']]);
	}
	/* API END*/
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