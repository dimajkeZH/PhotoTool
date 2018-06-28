<?php

namespace application\models;

use application\core\Model;

class UserAjax extends Model {

	public function delRow($post){
		$q = 'DELETE FROM '.$post['TABLE'].' WHERE ID = :ID';
		$params = [
			'ID' => $post['ID'],
		];
		return $this->db->bool($q, $params);
	}

	public function save($post){
		if(isset($post['TABLE']) && isset($post['DATA'])){
			$TABLE = $post['TABLE'];
			$DATA = $post['DATA'];
			$tran = [];
			foreach($DATA as $formKey => $form){
				switch($TABLE){
					//
					case 'FACULTIES':
						$params = [
							'NAME' => $form['NAME'],
							'HEAD_NAME' => $form['HEAD_NAME'],
						];
						if($form['ID'] == -1){
							$q = 'INSERT INTO FACULTIES (NAME, HEAD_NAME) VALUES (:NAME, :HEAD_NAME)';
						}else{
							$q = 'UPDATE FACULTIES SET NAME = :NAME, HEAD_NAME = :HEAD_NAME WHERE `ID` = :ID';
							$params['ID'] = $form['ID'];
						}
						break;
					//
					case 'DEPARTMENTS':
						$params = [
							'NAME' => $form['NAME'],
							'ID_FACULTY' => $form['ID_FACULTY'],
							'HEAD_NAME' => $form['HEAD_NAME'],
						];
						if($form['ID'] == -1){
							$q = 'INSERT INTO DEPARTMENTS (NAME, ID_FACULTY, HEAD_NAME) VALUES (:NAME, :ID_FACULTY, :HEAD_NAME)';
						}else{
							$q = 'UPDATE DEPARTMENTS SET NAME = :NAME, ID_FACULTY = :ID_FACULTY, HEAD_NAME = :HEAD_NAME WHERE `ID` = :ID';
							$params['ID'] = $form['ID'];
						}
						break;
					//
					case 'SPECIALTIES':
						$params = [
							'NAME' => $form['NAME'],
							'ID_DEPARTMENT' => $form['ID_DEPARTMENT'],
						];
						if($form['ID'] == -1){
							$q = 'INSERT INTO SPECIALTIES (NAME, ID_DEPARTMENT) VALUES (:NAME, :ID_DEPARTMENT)';
						}else{
							$q = 'UPDATE SPECIALTIES SET NAME = :NAME, ID_DEPARTMENT = :ID_DEPARTMENT WHERE `ID` = :ID';
							$params['ID'] = $form['ID'];
						}
						break;
					//
					case 'STUDENT_GROUPS':
						$params = [
							'NAME' => $form['NAME'],
							'ID_SPECIALTY' => $form['ID_SPECIALTY'],
							'ID_TYPE' => $form['ID_TYPE'],
							'FULL_NAME' => $form['FULL_NAME'],
							'BUDGET_PLACES_COUNT' => $form['BUDGET_PLACES_COUNT'],
							'YEAR_START' => $form['YEAR_START'],
							'YEAR_END' => $form['YEAR_END'],
						];
						if($form['ID'] == -1){
							$q = 'INSERT INTO STUDENT_GROUPS (NAME, ID_SPECIALTY, ID_TYPE, FULL_NAME, BUDGET_PLACES_COUNT, YEAR_START, YEAR_END) VALUES (:NAME, :ID_SPECIALTY, :ID_TYPE, :FULL_NAME, :BUDGET_PLACES_COUNT, :YEAR_START, :YEAR_END)';
						}else{
							$q = 'UPDATE STUDENT_GROUPS SET NAME = :NAME, ID_SPECIALTY = :ID_SPECIALTY, ID_TYPE = :ID_TYPE, FULL_NAME = :FULL_NAME, BUDGET_PLACES_COUNT = :BUDGET_PLACES_COUNT, YEAR_START = :YEAR_START, YEAR_END = :YEAR_END WHERE `ID` = :ID';
							$params['ID'] = $form['ID'];
						}
						break;
					//
					case 'TRAINING_TYPES':
						$params = [
							'NAME' => $form['NAME'],
							'PERIOD' => $form['PERIOD'],
						];
						if($form['ID'] == -1){
							$q = 'INSERT INTO TRAINING_TYPES (NAME, PERIOD) VALUES (:NAME, :PERIOD)';
						}else{
							$q = 'UPDATE TRAINING_TYPES SET NAME = :NAME, PERIOD = :PERIOD WHERE `ID` = :ID';
							$params['ID'] = $form['ID'];
						}
						break;
					//
					case 'TEACHERS':
						$params = [
							'ID_DEPARTMENT' => $form['ID_DEPARTMENT'],
							'ID_POSITION' => $form['ID_POSITION'],
							'FULL_NAME' => $form['FULL_NAME'],
							'PHONE' => $form['PHONE'],
							'EMAIL' => $form['EMAIL'],
							'DT_BIRTH' => $form['DT_BIRTH'],
						];
						if($form['ID'] == -1){
							$q = 'INSERT INTO TEACHERS (ID_DEPARTMENT, ID_POSITION, FULL_NAME, PHONE, EMAIL, DT_BIRTH) VALUES (:ID_DEPARTMENT, :ID_POSITION, :FULL_NAME, :PHONE, :EMAIL, :DT_BIRTH)';
						}else{
							$q = 'UPDATE TEACHERS SET ID_DEPARTMENT = :ID_DEPARTMENT, ID_POSITION = :ID_POSITION, FULL_NAME = :FULL_NAME, PHONE = :PHONE, EMAIL = :EMAIL, DT_BIRTH = :DT_BIRTH WHERE `ID` = :ID';
							$params['ID'] = $form['ID'];
						}
						break;
					//
					case 'TEACHING_POSITIONS':
						$params = [
							'NAME' => $form['NAME'],
						];
						if($form['ID'] == -1){
							$q = 'INSERT INTO TEACHING_POSITIONS (NAME) VALUES (:NAME)';
						}else{
							$q = 'UPDATE TEACHING_POSITIONS SET NAME = :NAME WHERE `ID` = :ID';
							$params['ID'] = $form['ID'];
						}
						break;
					//
					case 'STUDENTS':
						$params = [
							'ID_GROUP' => $form['ID_GROUP'],
							'ID_TYPE' => $form['ID_TYPE'],
							'FULL_NAME' => $form['FULL_NAME'],
							'PHONE' => $form['PHONE'],
							'EMAIL' => $form['EMAIL'],
							'DT_BIRTH' => $form['DT_BIRTH'],
						];
						if($form['ID'] == -1){
							$q = 'INSERT INTO STUDENTS (ID_GROUP, ID_TYPE, FULL_NAME, PHONE, EMAIL, DT_BIRTH) VALUES (:ID_GROUP, :ID_TYPE, :FULL_NAME, :PHONE, :EMAIL, :DT_BIRTH)';
						}else{
							$q = 'UPDATE STUDENTS SET ID_GROUP = :ID_GROUP, ID_TYPE = :ID_TYPE, FULL_NAME = :FULL_NAME, PHONE = :PHONE, EMAIL = :EMAIL, DT_BIRTH = :DT_BIRTH WHERE `ID` = :ID';
							$params['ID'] = $form['ID'];
						}
						break;
					//
					case 'STUDENTS_EDUCATION_TYPES':
						$params = [
							'NAME' => $form['NAME'],
						];
						if($form['ID'] == -1){
							$q = 'INSERT INTO STUDENTS_EDUCATION_TYPES (NAME) VALUES (:NAME)';
						}else{
							$q = 'UPDATE STUDENTS_EDUCATION_TYPES SET NAME = :NAME WHERE `ID` = :ID';
							$params['ID'] = $form['ID'];
						}
						break;
					//
					case 'ITEMS':
						$params = [
							'NAME' => $form['NAME'],
							'ID_SPECIALTY' => $form['ID_SPECIALTY'],
							'ID_SEMESTER' => $form['ID_SEMESTER'],
							'ID_TYPE' => $form['ID_TYPE'],
							'HOURS_L' => $form['HOURS_L'],
							'HOURS_P' => $form['HOURS_P'],
						];
						if($form['ID'] == -1){
							$q = 'INSERT INTO ITEMS (NAME, ID_SPECIALTY, ID_SEMESTER, ID_TYPE, HOURS_L, HOURS_P) VALUES (:NAME, :ID_SPECIALTY, :ID_SEMESTER, :ID_TYPE, :HOURS_L, :HOURS_P)';
						}else{
							$q = 'UPDATE ITEMS SET NAME = :NAME, ID_SPECIALTY = :ID_SPECIALTY, ID_SEMESTER = :ID_SEMESTER, ID_TYPE = :ID_TYPE, HOURS_L = :HOURS_L, HOURS_P = :HOURS_P WHERE `ID` = :ID';
							$params['ID'] = $form['ID'];
						}
						break;
					//
					case 'SEMESTERS':
						$params = [
							'NAME' => $form['NAME'],
							'VALUE' => $form['VALUE'],
						];
						if($form['ID'] == -1){
							$q = 'INSERT INTO SEMESTERS (NAME, VALUE) VALUES (:NAME, :VALUE)';
						}else{
							$q = 'UPDATE SEMESTERS SET NAME = :NAME, VALUE = :VALUE WHERE `ID` = :ID';
							$params['ID'] = $form['ID'];
						}
						break;
					//
					case 'CLASSES':
						$params = [
							'ID_ITEM' => $form['ID_ITEM'],
							'ID_GROUP' => $form['ID_GROUP'],
							'ID_TEACHER' => $form['ID_TEACHER'],
						];
						if($form['ID'] == -1){
							$q = 'INSERT INTO CLASSES (ID_ITEM, ID_GROUP, ID_TEACHER) VALUES (:ID_ITEM, :ID_GROUP, :ID_TEACHER)';
						}else{
							$q = 'UPDATE CLASSES SET ID_ITEM = :ID_ITEM, ID_GROUP = :ID_GROUP, ID_TEACHER = :ID_TEACHER WHERE `ID` = :ID';
							$params['ID'] = $form['ID'];
						}
						break;
					//
					case 'PAIRS':
						$params = [
							'ID_CLASS' => $form['ID_CLASS'],
							'ID_TYPE' => $form['ID_TYPE'],
							'ID_NUMBER' => $form['ID_NUMBER'],
							'DATE' => $form['DATE'],
						];
						if($form['ID'] == -1){
							$q = 'INSERT INTO PAIRS (ID_CLASS, ID_TYPE, ID_NUMBER, `DATE`) VALUES (:ID_CLASS, :ID_TYPE, :ID_NUMBER, :DATE)';
						}else{
							$q = 'UPDATE PAIRS SET ID_CLASS = :ID_CLASS, ID_TYPE = :ID_TYPE, ID_NUMBER = :ID_NUMBER, `DATE` = :DATE WHERE `ID` = :ID';
							$params['ID'] = $form['ID'];
						}
						break;
					//
					case 'PAIR_TYPES':
						$params = [
							'NAME' => $form['NAME'],
						];
						if($form['ID'] == -1){
							$q = 'INSERT INTO PAIR_TYPES (NAME) VALUES (:NAME)';
						}else{
							$q = 'UPDATE PAIR_TYPES SET NAME = :NAME WHERE `ID` = :ID';
							$params['ID'] = $form['ID'];
						}
						break;
					//
					case 'PAIR_NUMBER':
						$params = [
							'NAME' => $form['NAME'],
							'VALUE' => $form['VALUE'],
							'TIME_START' => $form['TIME_START'],
							'TIME_END' => $form['TIME_END'],
						];
						if($form['ID'] == -1){
							$q = 'INSERT INTO PAIR_NUMBER (NAME, VALUE, TIME_START, TIME_END) VALUES (:NAME, :VALUE, :TIME_START, :TIME_END)';
						}else{
							$q = 'UPDATE PAIR_NUMBER SET NAME = :NAME, VALUE = :VALUE, TIME_START = :TIME_START, TIME_END = :TIME_END WHERE `ID` = :ID';
							$params['ID'] = $form['ID'];
						}
						break;
					//
					case 'ESTIMATES':
						$params = [
							'ID_PAIR' => $form['ID_PAIR'],
							'ID_STUDENT' => $form['ID_STUDENT'],
							'VISITED' => $form['VISITED'],
							'RATING' => $form['RATING'],
						];
						if($form['ID'] == -1){
							$q = 'INSERT INTO ESTIMATES (ID_PAIR, ID_STUDENT, VISITED, RATING) VALUES (:ID_PAIR, :ID_STUDENT, :VISITED, :RATING)';
						}else{
							$q = 'UPDATE ESTIMATES SET ID_PAIR = :ID_PAIR, ID_STUDENT = :ID_STUDENT, VISITED = :VISITED, RATING = :RATING WHERE `ID` = :ID';
							$params['ID'] = $form['ID'];
						}
						break;
					//
					case 'FINAL_RATING':
						$params = [
							'ID_CLASS' => $form['ID_CLASS'],
							'ID_STUDENT' => $form['ID_STUDENT'],
							'VISITED' => $form['VISITED'],
							'RATING' => $form['RATING'],
						];
						if($form['ID'] == -1){
							$q = 'INSERT INTO FINAL_RATING (ID_CLASS, ID_STUDENT, VISITED, RATING) VALUES (:ID_CLASS, :ID_STUDENT, :VISITED, :RATING)';
						}else{
							$q = 'UPDATE FINAL_RATING SET ID_CLASS = :ID_CLASS, ID_STUDENT = :ID_STUDENT, VISITED = :VISITED, RATING = :RATING WHERE `ID` = :ID';
							$params['ID'] = $form['ID'];
						}
						break;
					//
					case 'FINAL_RATING_TYPES':
						$params = [
							'NAME' => $form['NAME'],
						];
						if($form['ID'] == -1){
							$q = 'INSERT INTO FINAL_RATING_TYPES (NAME) VALUES (:NAME)';
						}else{
							$q = 'UPDATE FINAL_RATING_TYPES SET NAME = :NAME WHERE `ID` = :ID';
							$params['ID'] = $form['ID'];
						}
						break;
				}
				$tran = array_merge($tran, [
					0 => [
						'sql' => $q,
						'params' => $params,
					]
				]);
			}
			//debug($tran);
			return $this->db->transaction($tran);
		}
		return false;
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
}