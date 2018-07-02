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

}