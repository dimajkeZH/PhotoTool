<?php

namespace application\lib;

use PDO;

class Db {

	protected $db;
	
	public function __construct() {
		$config = require $_SERVER['DOCUMENT_ROOT'].'/application/config/db.php';
		$this->db = new PDO('mysql:host='.$config['host'].';dbname='.$config['name'].';charset=utf8;', $config['user'], $config['password']);
	}

	public function query($sql, $params = []) {
		$stmt = $this->db->prepare($sql);
		if (!empty($params)) {
			foreach ($params as $key => $val) {
				$stmt->bindValue(':'.$key, $val);
			}
		}
		$stmt->execute(); 
		return $stmt;
	}

	public function transaction($transaction = []){
		$this->db->beginTransaction();
		try{
			foreach($transaction as $key => $tran){
			    $stmt = $this->db->prepare($tran['sql']);
				if (!empty($tran['params'])) {
					foreach ($tran['params'] as $paramkey => $paramval) {
						$stmt->bindValue(':'.$paramkey, $paramval);
					}
				}
				if(!$stmt->execute()){
					return false;
				}
			}
		    $this->db->commit();
		    return true;
		}
		catch(Exception $e){
			return false;
		}
	}

	public function row($sql, $params = []) {
		$result = $this->query($sql, $params);
		return $result->fetchAll(PDO::FETCH_ASSOC);
	}

	public function column($sql, $params = []) {
		$result = $this->query($sql, $params);
		return $result->fetchColumn();
	}

	public function bool($sql, $params = []){
		$result = $this->query($sql, $params);
		if($result->errorCode() == 0){
			return true;
		}
		return false;
	}


}