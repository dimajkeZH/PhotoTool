<?php

namespace application\controllers;

use application\controllers\UserController;

class UserAjaxController extends UserController {

	const MESSAGE__NO_VALUES = 'Нет параметров';
	const MESSAGE__BAD_VALUES = 'Не все параметры заполнены правильно';

	const MESSAGE__CHANGE_GOOD = 'Данные успешно изменены';
	const MESSAGE__CHANGE_BAD = 'Изменение данных не произошло';

	const MESSAGE__SAVE_GOOD = 'Данные успешно сохранены';
	const MESSAGE__SAVE_BAD = 'Сохранение данных не произошло';

	const MESSAGE__DELETE_GOOD = 'Данные успешно удалены';
	const MESSAGE__DELETE_BAD = 'Удаление данных не произошло';

	private $post;

	public function saveTaskAction(){
		$this->post = $_POST;
		if($this->model->saveTask($this->post)){
			$this->model->message(true, self::MESSAGE__SAVE_GOOD);
		}else{
			$this->model->message(false, self::MESSAGE__SAVE_BAD);
		}
	}

	public function statusTaskAction(){
		$this->model->checkedTask($_POST);
	}
}