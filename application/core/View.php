<?php

namespace application\core;

class View {

	public $path;
	public $route;
	public $layout = 'default';

	public function __construct($route) {
		$this->route = $route;
		$this->path = $route['controller'].'/'.$route['action'];
	}

	public function render($headers = [], $vars = []){
		$content = '';
		$path = 'application/views/'.$this->path.'.php';
		//debug([$headers, $this->route, $this->path, $path, file_exists($path), file_exists('application/views/layouts/'.$this->layout.'.php'), 'application/views/layouts/'.$this->layout.'.php']);
		if(file_exists($path)) {
			extract($vars);
			ob_start();
			require $path;
			$content = ob_get_clean();
		}
		extract($headers);
		require 'application/views/layouts/'.$this->layout.'.php';
	}

	public function redirect($url) {
		header('location: '.$url);
		exit;
	}

	public static function errorCode($code){
		http_response_code($code);
		$path = 'application/views/errors/'.$code.'.php';
		if (file_exists($path)) {
			ob_start();
			require $path;
			$content = ob_get_clean();
			$TITLE = 'Страница не существует.';
			require 'application/views/layouts/error.php';
		}
		exit;
	}
}	