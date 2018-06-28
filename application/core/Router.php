<?php

namespace application\core;

use application\core\View;

class Router {

    protected $routes = [];
    protected $params = [];

    protected $url;

    public function __construct() {
        $arr = require 'application/config/routes.php';
        foreach ($arr as $key => $val) {
            $this->add($key, $val);
        }
    }

    public function add($route, $params) {
        $route = '#^'.$route.'$#';
        $this->routes[$route] = $params;
    }

    public function match() {
        $this->preprocessingURL();
        foreach ($this->routes as $route => $params) {
            //echo preg_match($route, $this->url, $matches).' '.$route.' '.$this->url.'<br>';
            if (preg_match($route, $this->url, $matches)) {
                $this->params = $params;
                $this->params['param'] = $this->selectNumber($this->url);
                return true;
            }
        }
        return false;
    }

    public function selectNumber($url){
        $number = substr($url,strripos($url,'/')+1);
        if(is_numeric($number)){
            return $number;
        }else{
            return '0';
        }
    }

    public function run(){
        if ($this->match()) {
            $path = 'application\controllers\\'.ucfirst($this->params['controller']).'Controller';
            //echo class_exists($path).' '.$path;
            if (class_exists($path)) {
                $action = $this->params['action'].'Action';
                //echo method_exists($path, $action).' '.$path.' '.$action;
                if (method_exists($path, $action)){
                    $controller = new $path($this->params);
                    $controller->$action();
                } else {
                    View::errorCode(404);
                }
            } else {
                View::errorCode(404);
            }
        } else {
            View::errorCode(404);
        }
    }


    private function preprocessingURL(){
        //debug($_GET);
        $url = trim($_SERVER['REQUEST_URI'], '/');
        if(!strpos($url, '?')){
            $this->url = $url;
            return;
        }
        list($this->url, $GET) = explode('?', $url);
        /*
        if(strpos($url, '&')){
            $GET = explode('&', $GET);
        }
        
        foreach($GET as $GETkey => $GETval){
            list($key, $val) = explode('=',$GETval);
            $preGET[$key] = $val;
        }
        $_GET = $preGET;
        */
    }
}