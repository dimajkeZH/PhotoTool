<?php

namespace application\models;

use application\models\User;

class UserAjax extends User {

	public $TITLE = 'API';
	
	public function saveTask($post){
		$countNotEmptyTagList = 0;
		foreach($post['DATA'] as $postKey => $postVal){
			$params = [
				'ID' => $postVal['ID']
			];
			$q = 'DELETE FROM TASK_INNER_IMAGE_TAGS WHERE ID_TASK_IMAGE = :ID';
			$this->db->bool($q, $params);
			if(isset($postVal['TAGS']) && (count($postVal['TAGS'])>0)){
				$countNotEmptyTagList++;
				$q = 'INSERT INTO TASK_INNER_IMAGE_TAGS (ID_TASK_IMAGE, ID_TASK_TAG) VALUES (:ID, :ID_TAG)';
				foreach($postVal['TAGS'] as $tagKey => $tagVal){
					$params['ID_TAG'] = $tagVal['ID'];
					$this->db->bool($q, $params);
				}
			}
		}
		if($countNotEmptyTagList > 0){
			$newStatus = 3;
			if($countNotEmptyTagList == count($post['DATA'])){
				$newStatus = 4;
			}
			$q = 'SELECT VAL_STATUS FROM TASK_LIST WHERE ID = :ID';
			$params = [
				'ID' => $post['ID']
			];
			$oldstatus = $this->db->column($q, $params);
			if($newStatus != $oldstatus){
				$params['NEWVAL'] = $newStatus;
				$q = 'UPDATE TASK_LIST SET VAL_STATUS = :NEWVAL WHERE ID = :ID';
				$this->db->bool($q, $params);
			}
		}
		return true;
	}

	public function checkedTask($post){
		if(isset($post['ID'])){
			$ID = $post['ID'];
			$params = [
				'ID_TASK' => $ID
			];
			$q = 'SELECT VAL_STATUS FROM TASK_LIST WHERE ID = :ID_TASK';
			$oldstatus = $this->db->column($q, $params);
			if($oldstatus == 1){
				$q = 'UPDATE TASK_LIST SET VAL_STATUS = 2 WHERE ID = :ID_TASK';
				$this->db->bool($q, $params);
			}
		}
	}
}