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
		$return['TASK_LIST'] = $this->getTaskList()['TASK_LIST'];

		$q = 'SELECT TIT.ID_TAG FROM TASK_INNER_TAGS as TIT WHERE TIT.ID_TASK = :ID_TASK';
		$params = [
			'ID_TASK' => $route['param']
		];
		$return['TASK_DATA']['TASK_TAGS'] = $this->db->row($q, $params);

		$q = 'SELECT TTI.ID_IMAGE FROM TASK_INNER_IMAGES as TII WHERE TII.ID_TASK = :ID_TASK';
		$params = [
			'ID_TASK' => $route['param']
		];
		$return['TASK_DATA']['TASK_IMAGES'] = $this->db->row($q, $params);

		/*
		$q = 'SELECT * FROM TASK_INNER_IMAGE_TAGS ';
		$params = [
			'ID_TASK' => $route['param']
		];
		$return['TASK_DATA']['TASK_IMAGES']['TAGS'] = $this->db->row($q, $params);
		*/
	
		debug($return);
		return $return;
	}
}