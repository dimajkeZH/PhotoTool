<?php

require 'application/lib/Dev.php';

use application\core\Router;

spl_autoload_register(function($class) {
    $path = str_replace('\\', '/', $class.'.php');
    if (file_exists($path)) {
        require $path;
    }
});

function shutdown()
{
	$error = error_get_last();
    if ($error['type'] === 1) { 
        echo '<center>Страница 500.';
        exit;    
    }
}
register_shutdown_function('shutdown');

session_start();

$router = new Router;
$router->run();