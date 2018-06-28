<?php

namespace application\controllers;

use application\controllers\UserController;

class UserMainController extends UserController {

	private $default_area = 'pairs';

	private function render($content = []){
		$this->view->render($this->model->getHeaders($this->route), $content);
	}

	public function authAction() {
		$this->view->layout = 'auth';
		$this->render();
	}

	public function loginAction() {
		if($this->model->login()){
			$this->view->redirect("/$default_area");
		}else{
			$this->view->redirect('/auth');
		}
	}

	public function logoutAction() {
		$this->logout();
	}


	public function tasksAction() {
		if($this->model->isAuth()){
			//$this->render($this->model->getContent($this->route));
		}else{
			$this->logout();
		}
	}

	public function taskAction() {
		if($this->model->isAuth()){
			//$this->render($this->model->getContent($this->route));
		}else{
			$this->logout();
		}
	}


	private function logout(){
		$this->model->logout();
		$this->view->redirect('/auth');
	}

}