<?php

namespace application\controllers;

use application\controllers\UserController;

class UserMainController extends UserController {

	static private $default_area = '/tasks';
	static private $auth_area = '/auth';

	public function authAction() {
		if(!$this->model->isAuth()){
			$this->render([], 'auth');
		}else{
			$this->view->redirect(self::$default_area);
		}
	}

	public function loginAction() {
		if($this->model->login()){
			$this->view->redirect(self::$default_area);
		}else{
			$this->view->redirect(self::$auth_area);
		}
	}

	public function logoutAction() {
		$this->logout();
	}


	public function tasksAction() {
		if($this->model->isAuth()){
			$this->render($this->model->getTaskList());
		}else{
			$this->logout();
		}
	}

	public function taskAction() {
		if($this->model->isAuth()){
			$this->render($this->model->getTask($this->route));
		}else{
			$this->logout();
		}
	}


	private function logout(){
		$this->model->logout();
		$this->view->redirect(self::$auth_area);
	}

}