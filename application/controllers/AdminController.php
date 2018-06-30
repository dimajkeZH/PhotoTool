<?php

namespace application\controllers;

use application\core\Controller;

class AdminController extends Controller {

	public function render($content = [], $layout = 'admin'){
		$this->view->layout = $layout;
		$this->view->render($this->model->getHeaders($this->route), $content);
	}

}