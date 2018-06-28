<?php

namespace application\models;

use application\models\Admin;

class AdminMain extends Admin {

	public $TITLE = '';

	public function getHeaders($route){
		$return['TITLE'] = $this->TITLE;
		if($route['subtitle']){
			$return['SUBTITLE'] = $route['subtitle'];
		}
		return $return;
	}

	public function login(){
		if(isset($_POST)){
			if(isset($_POST['name']) && ($_POST['name']!='') && isset($_POST['pass']) && ($_POST['pass']!='')){
				$name = $this->clear($_POST['name']);
				$pass = $this->shaPSWD($this->clear($_POST['pass']));
				$ID = $this->verifyPSWD($name, $pass);
				if(!is_null($ID)){
					unset($_SESSION['err']);
					$_SESSION['username'] = 'headadmin';
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

	public function getContent($route, $flags = []){
		$return['NULL'] = [];
		return $return;
	}

	public function getTasks(){
		$return['TASKS'] = [];
		return $return;
	}

	public function getTags(){
		$return['TAGS'] = [];
		return $return;
	}

	public function getImages(){
		$return['IMAGES'] = [];
		return $return;
	}

	public function getUsers(){
		$return['USERS'] = [];
		return $return;
	}

}