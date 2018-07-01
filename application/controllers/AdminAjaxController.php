<?php

namespace application\controllers;

use application\controllers\AdminController;

class AdminAjaxController extends AdminController {

	const MESSAGE__NO_VALUES = 'Нет параметров';
	const MESSAGE__BAD_VALUES = 'Не все параметры заполнены правильно';

	const MESSAGE__CHANGE_GOOD = 'Данные успешно изменены';
	const MESSAGE__CHANGE_BAD = 'Изменение данных не произошло';

	const MESSAGE__SAVE_GOOD = 'Данные успешно сохранены';
	const MESSAGE__SAVE_BAD = 'Сохранение данных не произошло';

	const MESSAGE__DELETE_GOOD = 'Данные успешно удалены';
	const MESSAGE__DELETE_BAD = 'Удаление данных не произошло';

	const MESSAGE__LOADFILE_GOOD = 'Файл успешно загружен<br>';
	const MESSAGE__LOADFILE_BAD = 'Загрузка файла прервалась<br>';

	private $post;
	private $file;



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


	public function delUserAction(){
		if($this->model->delUser($this->route)){
			$this->model->message(true, self::MESSAGE__DELETE_GOOD);
		}else{
			$this->model->message(false, self::MESSAGE__DELETE_BAD);
		}
	}
	public function saveUserAction(){
		$this->post = $_POST;
		if($this->model->saveUser($this->post)){
			$this->model->message(true, self::MESSAGE__SAVE_GOOD);
		}else{
			$this->model->message(false, self::MESSAGE__SAVE_BAD);
		}
	}

	public function delTagAction(){
		if($this->model->delTag($this->route)){
			$this->model->message(true, self::MESSAGE__DELETE_GOOD);
		}else{
			$this->model->message(false, self::MESSAGE__DELETE_BAD);
		}
	}
	public function saveTagsAction(){
		$this->post = $_POST;
		if($this->model->saveTags($this->post)){
			$this->model->message(true, self::MESSAGE__CHANGE_GOOD);
		}else{
			$this->model->message(false, self::MESSAGE__CHANGE_BAD);
		}
	}

	/* API */
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
	public function getTaskAction(){
		$content = $this->model->getTask($this->route);
		if($this->model->isAjax()){
			exit($content);
		}else{
			echo '<title>'.$this->model->TITLE.'</title><pre>';
			print_r(JSON_decode($content));
			echo '</pre>';
			exit();
		}
	}
	public function getTagTypesAction(){
		$content = $this->model->getTagTypes();
		if($this->model->isAjax()){
			exit($content);
		}else{
			echo '<title>'.$this->model->TITLE.'</title><pre>';
			print_r(JSON_decode($content));
			echo '</pre>';
			exit();
		}
	}
	/* API END */
}