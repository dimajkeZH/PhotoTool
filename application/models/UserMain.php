<?php

namespace application\models;

use application\models\User;

class UserMain extends User {

	public $TITLE = 'SITE';

	public function login(){
		if(isset($_POST)){
			if(isset($_POST['name']) && ($_POST['name']!='') && isset($_POST['pass']) && ($_POST['pass']!='')){
				$name = $this->clear($_POST['name']);
				$pass = $this->shaPSWD($this->clear($_POST['pass']));
				$ID = $this->verifyPSWD($name, $pass);
				if(!is_null($ID)){
					unset($_SESSION['err']);
					$_SESSION['username'] = 'user';
					$this->sessionCreate($ID);
					return true;
				}
				$_SESSION['err'] = 'name/pass not found';	
			}else{ $_SESSION['err'] = 'bad fields value'; }
			return false;
		}
		return false;
	}

	public function logout(){
		$this->sessionDestroy();
	}

	public function getTaskList(){
		$q = 'SELECT TL.ID FROM TASK_LIST as TL INNER JOIN USER_SESSIONS as US ON TL.ID_USER = US.ID_USER WHERE (US.HASH_S = :HASH_S) AND (US.HASH_C = :HASH_C)';
		$params = [
			'HASH_S' => $_SESSION['user_hash'],
			'HASH_C' => $_COOKIE['user_hash'],
		];
		$return['TASK_LIST'] = $this->db->row($q, $params);
		return $return;
	}

	public function getTask($route){
		$ID = $route['param'];
		$result['TASK_LIST'] = $this->getTaskList()['TASK_LIST'];

		$q = 'SELECT DT_END FROM TASK_LIST WHERE ID = :ID';
		$params = [
			'ID' => $ID
		];
		$result['TASK_DATA']['DT_END'] = $this->db->column($q, $params);
		$q = 'SELECT TIT.ID_TAG, TL.VALUE, TL.VAL_TYPE FROM TASK_INNER_TAGS as TIT INNER JOIN TAG_LIST as TL ON TL.ID = TIT.ID_TAG WHERE TIT.ID_TASK = :ID_TASK';
		$params = [
			'ID_TASK' => $ID
		];
		$result['TASK_DATA']['TASK_TAGS'] = $this->db->row($q, $params);

		$q = 'SELECT TII.ID, TII.ID_IMAGE, IL.NAME, IL.PATH FROM TASK_INNER_IMAGES as TII INNER JOIN IMAGE_LIST as IL ON IL.ID = TII.ID_IMAGE WHERE TII.ID_TASK = :ID_TASK';
		$params = [
			'ID_TASK' => $ID
		];
		$result['TASK_DATA']['TASK_IMAGES'] = $this->db->row($q, $params);

		$q = 'SELECT ID_TASK_TAG as ID FROM TASK_INNER_IMAGE_TAGS WHERE ID_TASK_IMAGE = :ID_IMAGE';
		foreach($result['TASK_DATA']['TASK_IMAGES'] as $key => $val){
			$params = [
				'ID_IMAGE' => $val['ID']
			];
			$result['TASK_DATA']['TASK_IMAGES'][$key]['TAGS'] = $this->db->row($q, $params);
		}

		//$result['TASK_DATA'] = json_encode($result['TASK_DATA']);
		//debug($result);
		$return = $result;
		return $return;
	}
}