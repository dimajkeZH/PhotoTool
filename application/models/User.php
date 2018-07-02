<?php

namespace application\models;

use application\core\Model;

class User extends Model {

	protected $lifetime_hash = 1800;

	protected $pswd_cost = 10;
	protected $sha = 'sha512';
	protected $sha_key = 'supersecretkey';

	protected $dif_hash = true;

	public function getHeaders($route){
		$return['TITLE'] = $this->TITLE;
		if($route['subtitle']){
			$return['SUBTITLE'] = $route['subtitle'];
		}
		if($route['param']){
			$return['TASK_NUMBER'] = $route['param'];
		}
		return $return;
	}

	public function isAuth(){
		if(isset($_SESSION['user_hash']) && isset($_COOKIE['user_hash'])){
			if(!empty($_SESSION['user_hash']) && !empty($_COOKIE['user_hash'])){
				$q = 'SELECT COUNT(*) FROM USER_SESSIONS WHERE (HASH_S = :HASH_S) AND (HASH_C = :HASH_C) AND (DT_DESTROY > NOW())';
				$params = [
					'HASH_S' => $_SESSION['user_hash'],
					'HASH_C' => $_COOKIE['user_hash']
				];
				//debug([$_SESSION['user_hash'], $_COOKIE['user_hash']]);
				$result = $this->db->column($q, $params);
				if($result == 1){
					return true;
				}
			}
		}
		$this->sessionDestroy();
		return false;
	}

	//session destroy
	public function sessionDestroy(){
		if(isset($_SESSION['user_hash']) && isset($_COOKIE['user_hash'])){
			$q = 'UPDATE USER_SESSIONS SET DT_DESTROY = NOW() WHERE (HASH_S = :HASH_S) AND (HASH_C = :HASH_C)';
			$params = [
				'HASH_S' => $_SESSION['user_hash'],
				'HASH_C' => $_COOKIE['user_hash']
			];
			$this->db->column($q, $params);
		}
		unset($_SESSION['user_hash']);
		session_destroy();
		setcookie('user_hash', "", time()-3600);
	}

	//create new record in the db
	public function sessionCreate($id_user){
		if($this->dif_hash){
			$hash_s = $this->generateStr(128);
			$hash_c = $this->generateStr(128);
			$_SESSION['user_hash'] = $hash_s;
			setcookie('user_hash', $hash_c, time()+$this->lifetime_hash);
		}else{
			$hash_s = $hash_c = $this->generateStr(128);
			$_SESSION['user_hash'] = $hash_s;
			setcookie('user_hash', $hash_c, time()+$this->lifetime_hash);
		}
		$create =  $this->now();
		$destroy = $this->now($this->lifetime_hash);		
		$q = 'INSERT INTO USER_SESSIONS (ID_USER, HASH_S, HASH_C, IP, BROWSER, DEVICE, DT_CREATE, DT_DESTROY) VALUES (:ID_USER, :HASH_S, :HASH_C, :IP, :BROWSER, :DEVICE, :DT_CREATE, :DT_DESTROY)';
		$params = [
			'ID_USER' => $id_user,
			'HASH_S' => $hash_s,
			'HASH_C' => $hash_c,
			'IP' => $_SERVER['REMOTE_ADDR'],
			'BROWSER' => $_SERVER['HTTP_USER_AGENT'],
			'DEVICE' => 'Компьютер',
			'DT_CREATE' => $create,
			'DT_DESTROY' => $destroy
		];
		$this->db->column($q, $params);
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

	//get CURRENT TIME with shift on some seconds
	public function now($sec = 0){
		return date_modify(date_create(), "+$sec sec")->format('Y-m-d H:i:s');
	}

	//string generation the specified length
	private function generateStr($length){
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $str = '';
	    for ($i = 0; $i < $length; $i++) {
	        $str .= $characters[rand(0, strlen($characters)-1)];
	    }
	    return $str;
	}

	//hashPSWD to bcrypt
	private function hashPSWD($str){
		return password_hash(
			$this->shaPSWD($str),
			PASSWORD_BCRYPT, 
			["cost" => $this->pswd_cost]
		);
	}

	//verify PASS, get ID
	public function verifyPSWD($name, $pass){
		$db = $this->matchLogin($name);
		if(is_null($db)){
			return NULL;
		}
		if(password_verify($pass, $db['PASS'])){
			return $db['ID'];
		}
	}

	//get ID, PASS
	private function matchLogin($name){
		$q = 'SELECT ID, PASS FROM USER_ACCOUNTS WHERE (NAME = :NAME) ORDER BY ID LIMIT 1';
		$params = [
			'NAME' => $name
		];
		$result = $this->db->row($q, $params);
		if(count($result) == 1){
			return $result[0];
		}
		return NULL;
	}

	//sha PSWD for BCRYPT
	public function shaPSWD($str){
		return base64_encode(hash_hmac($this->sha, $str, $this->sha_key, true));
	}

}