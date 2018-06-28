<?php

namespace application\controllers;

use application\controllers\AdminController;

class AdminMainController extends AdminController {

	static private $default_area = '/admin/tasks';
	static private $auth_area = '/admin/auth';

	private function render($content = [], $layout = 'admin'){
		$this->view->layout = $layout;
		$this->view->render($this->model->getHeaders($this->route), $content);
	}

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
			$this->render($this->model->getTasks());
		}else{
			$this->logout();
		}
	}

	public function tagsAction() {
		if($this->model->isAuth()){
			$this->render($this->model->getTags());
		}else{
			$this->logout();
		}
	}

	public function imagesAction() {
		if($this->model->isAuth()){
			$this->render($this->model->getImages());
		}else{
			$this->logout();
		}
	}

	public function usersAction() {
		if($this->model->isAuth()){
			$this->render($this->model->getUsers());
		}else{
			$this->logout();
		}
	}


	private function logout(){
		$this->model->logout();
		$this->view->redirect(self::$auth_area);
	}

}