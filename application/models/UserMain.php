<?php

namespace application\models;

use application\core\Model;

class UserMain extends Model {

	public $TITLE = 'Структура вуза';

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
		return $return;
	}

	public function isAuth(){
		if(isset($_SESSION['hash']) && isset($_COOKIE['hash'])){
			if(!empty($_SESSION['hash']) && !empty($_COOKIE['hash'])){
				$q = 'SELECT COUNT(*) FROM ADMIN_SESSIONS WHERE (HASH_S = :HASH_S) AND (HASH_C = :HASH_C) AND (DT_DESTROY > NOW())';
				$params = [
					'HASH_S' => $_SESSION['hash'],
					'HASH_C' => $_COOKIE['hash']
				];
				//debug([$_SESSION['hash'], $_COOKIE['hash']]);
				$result = $this->db->column($q, $params);
				if($result == 1){
					return true;
				}
			}
		}
		$this->sessionDestroy();
		return false;
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
		switch($route['action']){
			case 'faculties':
				$q = 'SELECT * FROM FACULTIES;';
				break;
			case 'departments':
				$q = 'SELECT * FROM DEPARTMENTS;';
				break;
			case 'specialties':
				$q = 'SELECT * FROM SPECIALTIES;';
				break;
			case 'groups':
				$q = 'SELECT * FROM STUDENT_GROUPS;';
				break;
			case 'training_types':
				$q = 'SELECT * FROM TRAINING_TYPES;';
				break;
			case 'teachers':
				$q = 'SELECT * FROM TEACHERS;';
				break;
			case 'teaching_positions':
				$q = 'SELECT * FROM TEACHING_POSITIONS;';
				break;
			case 'students':
				$q = 'SELECT * FROM STUDENTS;';
				break;
			case 'students_education_types':
				$q = 'SELECT * FROM STUDENTS_EDUCATION_TYPES;';
				break;
			case 'items':
				$q = 'SELECT * FROM ITEMS;';
				break;
			case 'semesters':
				$q = 'SELECT * FROM SEMESTERS;';
				break;
			case 'classes':
				$q = 'SELECT * FROM CLASSES;';
				break;
			case 'pairs':
				$q = 'SELECT * FROM PAIRS;';
				break;
			case 'pair_types':
				$q = 'SELECT * FROM PAIR_TYPES;';
				break;
			case 'pair_number':
				$q = 'SELECT * FROM PAIR_NUMBER;';
				break;
			case 'estimates':
				$q = 'SELECT * FROM ESTIMATES;';
				break;
			case 'final_rating':
				$q = 'SELECT * FROM FINAL_RATING;';
				break;
			case 'final_rating_types':
				$q = 'SELECT * FROM FINAL_RATING_TYPES;';
				break;
			default:
				$q = '';
				break;
		}
		$return['DATALIST'] = $this->db->row($q);
		foreach($flags as $flag){
			switch($flag){
				case self::$contentFACULTIES:
					$return['FACULTIES'] 					= $this->db->row('SELECT * FROM FACULTIES;');
					break;
				case self::$contentDEPARTMENTS:
					$return['DEPARTMENTS'] 					= $this->db->row('SELECT * FROM DEPARTMENTS;');
					break;
				case self::$contentSPECIALTIES:
					$return['SPECIALTIES'] 					= $this->db->row('SELECT * FROM SPECIALTIES;');
					break;
				case self::$contentTRAINING_TYPES:
					$return['TRAINING_TYPES'] 				= $this->db->row('SELECT * FROM TRAINING_TYPES;');
					break;
				case self::$contentSTUDENTS_EDUCATION_TYPES:
					$return['STUDENTS_EDUCATION_TYPES'] 	= $this->db->row('SELECT * FROM STUDENTS_EDUCATION_TYPES;');
					break;
				case self::$contentTEACHING_POSITIONS:
					$return['TEACHING_POSITIONS'] 			= $this->db->row('SELECT * FROM TEACHING_POSITIONS;');
					break;
				case self::$contentSEMESTERS:
					$return['SEMESTERS'] 					= $this->db->row('SELECT * FROM SEMESTERS;');
					break;
				case self::$contentFINAL_RATING_TYPES:
					$return['FINAL_RATING_TYPES'] 			= $this->db->row('SELECT * FROM FINAL_RATING_TYPES;');
					break;
				case self::$contentITEMS:
					$return['ITEMS'] 						= $this->db->row('SELECT * FROM ITEMS;');
					break;
				case self::$contentSTUDENT_GROUPS:
					$return['STUDENT_GROUPS'] 				= $this->db->row('SELECT * FROM STUDENT_GROUPS;');
					break;
				case self::$contentTEACHERS:
					$return['TEACHERS'] 					= $this->db->row('SELECT * FROM TEACHERS;');
					break;
				case self::$contentCLASSES:
					$return['CLASSES'] 						= $this->db->row('SELECT C.ID, CONCAT(SG.NAME, ": ", I.NAME) as NAME  FROM CLASSES as C INNER JOIN STUDENT_GROUPS as SG ON SG.ID = C.ID_GROUP INNER JOIN ITEMS as I ON I.ID = C.ID_ITEM;');
					break;
				case self::$contentPAIR_TYPES:
					$return['PAIR_TYPES'] 					= $this->db->row('SELECT * FROM PAIR_TYPES;');
					break;
				case self::$contentPAIR_NUMBER:
					$return['PAIR_NUMBER'] 					= $this->db->row('SELECT * FROM PAIR_NUMBER;');
					break;
				case self::$contentPAIRS:
					$return['PAIRS'] 						= $this->db->row('SELECT * FROM PAIRS;');
					break;
				case self::$contentSTUDENTS:
					$return['STUDENTS'] 					= $this->db->row('SELECT * FROM STUDENTS;');
					break;
			}
		}
		return $return;
	}





	//session destroy
	public function sessionDestroy(){
		if(isset($_SESSION['hash']) && isset($_COOKIE['hash'])){
			$q = 'UPDATE ADMIN_SESSIONS SET DT_DESTROY = NOW() WHERE (HASH_S = :HASH_S) AND (HASH_C = :HASH_C)';
			$params = [
				'HASH_S' => $_SESSION['hash'],
				'HASH_C' => $_COOKIE['hash']
			];
			$this->db->column($q, $params);
		}
		unset($_SESSION['hash']);
		session_destroy();
		setcookie('hash', "", time()-3600);
	}

	//create new record in the db
	public function sessionCreate($id_admin){
		if($this->dif_hash){
			$hash_s = $this->generateStr(128);
			$hash_c = $this->generateStr(128);
			$_SESSION['hash'] = $hash_s;
			setcookie('hash', $hash_c, time()+$this->lifetime_hash);
		}else{
			$hash_s = $hash_c = $this->generateStr(128);
			$_SESSION['hash'] = $hash_s;
			setcookie('hash', $hash_c, time()+$this->lifetime_hash);
		}
		$create =  $this->now();
		$destroy = $this->now($this->lifetime_hash);		
		$q = 'INSERT INTO ADMIN_SESSIONS (ID_ADMIN, HASH_S, HASH_C, IP, BROWSER, DT_CREATE, DT_DESTROY) VALUES (:ID_ADMIN, :HASH_S, :HASH_C, :IP, :BROWSER, :DT_CREATE, :DT_DESTROY)';
		$params = [
			'ID_ADMIN' => $id_admin,
			'HASH_S' => $hash_s,
			'HASH_C' => $hash_c,
			'IP' => $_SERVER['REMOTE_ADDR'],
			'BROWSER' => $_SERVER['HTTP_USER_AGENT'],
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
		$q = 'SELECT ID, PASS FROM ADMIN_ACCOUNTS WHERE (NAME = :NAME) ORDER BY ID LIMIT 1';
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