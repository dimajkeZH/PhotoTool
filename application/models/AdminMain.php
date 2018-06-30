<?php

namespace application\models;

use application\models\Admin;

class AdminMain extends Admin {

	protected $TITLE = 'webPHOTO';

	public function login(){
		if(isset($_POST)){
			if(isset($_POST['name']) && ($_POST['name']!='') && isset($_POST['pass']) && ($_POST['pass']!='')){
				$name = $this->clear($_POST['name']);
				$pass = $this->shaPSWD($this->clear($_POST['pass']));
				$ID = $this->verifyPSWD($name, $pass);
				if(!is_null($ID)){
					unset($_SESSION['err']);
					$_SESSION['username'] = $this->db->column('SELECT NAME FROM ADMIN_ACCOUNTS WHERE ID = '.$ID);
					if($_POST['rem'] && ($_POST['rem'] == 'on')){
						$rem = true;
					}else{
						$rem = false;
					}
					$this->sessionCreate($ID, $rem);
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

	public function getContent($route, $flags = []){
		$return['NULL'] = [];
		return $return;
	}

	public function getTasks(){
		$q = 'SELECT * FROM TASK_LIST';
		$return['TASKS'] = $this->db->row($q);
		return $return;
	}

	public function getTags(){
		$q = 'SELECT ID, VALUE, VAL_TYPE FROM TAG_LIST';
		$return['TAGS'] = $this->db->row($q);
		$q = 'SELECT VALUE, NAME FROM TAG_TYPES';
		$return['TAG_TYPES'] = $this->db->row($q);
		return $return;
	}

	public function getImages(){
		$q = 'SELECT ID, `PATH`, NAME FROM IMAGE_LIST';
		$return['IMAGES'] = $this->db->row($q);
		return $return;
	}

	public function getUsers(){
		$q = 'SELECT UA.ID, UA.F_NAME, UA.NAME, (SELECT COUNT(TL.ID) FROM TASK_LIST AS TL WHERE TL.ID_USER = UA.ID) as TASK_COUNT FROM USER_ACCOUNTS as UA;';
		$return['USERS'] = $this->db->row($q);
		return $return;
	}

}