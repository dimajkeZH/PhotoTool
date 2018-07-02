<?php

namespace application\controllers;

use application\core\Controller;

class UserController extends Controller {

	public function render($content = [], $layout = 'user'){
		$this->view->layout = $layout;
		$this->view->render($this->model->getHeaders($this->route), $content);
	}
	
}