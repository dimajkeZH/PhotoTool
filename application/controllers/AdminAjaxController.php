<?php

namespace application\controllers;

use application\controllers\AdminController;

class AdminAjaxController extends AdminController {

	const MESSAGE__NO_VALUES = 'Нет параметров';
	const MESSAGE__BAD_VALUES = 'Не все параметры заполнены правильно';

	const MESSAGE__CHANGE_GOOD = 'Данные успешно изменены';
	const MESSAGE__CHANGE_BAD = 'Изменение данных не произошло';

	const MESSAGE__DELETE_GOOD = 'Данные успешно удалены';
	const MESSAGE__DELETE_BAD = 'Удаление данных не произошло';

	const MESSAGE__LOADFILE_GOOD = 'Файл успешно загружен<br>';
	const MESSAGE__LOADFILE_BAD = 'Загрузка файла прервалась<br>';

	private $post;
	private $file;

	/*
	public function taskAction() {
		$this->post = $_POST;
		if($this->model->delRow($this->post)){
			//$this->model->message(true, self::MESSAGE__DELETE_GOOD);
		}else{
			//$this->model->message(false, self::MESSAGE__DELETE_BAD);
		}
	}

	public function tagAction() {
		$this->post = $_POST;
		if($this->model->delRow($this->post)){
			//$this->model->message(true, self::MESSAGE__DELETE_GOOD);
		}else{
			//$this->model->message(false, self::MESSAGE__DELETE_BAD);
		}
	}

	public function imageAction() {
		$this->post = $_POST;
		if($this->model->delRow($this->post)){
			//$this->model->message(true, self::MESSAGE__DELETE_GOOD);
		}else{
			//$this->model->message(false, self::MESSAGE__DELETE_BAD);
		}
	}

	public function userAction() {
		$this->post = $_POST;
		if($this->model->delRow($this->post)){
			//$this->model->message(true, self::MESSAGE__DELETE_GOOD);
		}else{
			//$this->model->message(false, self::MESSAGE__DELETE_BAD);
		}
	}

	*/

	public function uploadImageAction(){
		$this->post = $_POST;
		$this->file = $_FILES['file'];
		if($this->model->loadImage($this->file)){
			$this->model->message(true, self::MESSAGE__LOADFILE_GOOD.$this->file['name'], $this->post['ID']);
		}else{
			$this->model->message(false, self::MESSAGE__LOADFILE_BAD.$this->file['name'], $this->post['ID']);
		}
	}

	public function delImageAction(){
		$this->post = $_POST;
		if($this->model->delImage($this->post)){
			$this->model->message(true, self::MESSAGE__DELETE_GOOD);
		}else{
			$this->model->message(false, self::MESSAGE__DELETE_BAD);
		}
	}

	/* API GET */
	public function getUserAction(){
		$content = $this->model->getUser($this->route);
		if($this->model->isAjax()){
			exit($content);
		}else{
			echo '<title>'.$this->model->TITLE.'</title><pre>';
			print_r(JSON_decode($content));
			echo '</pre>';
			exit();
		}
	}
	/* API GET END*/

}