<?php

return [

	/* USER */
	'' => [
		'controller' => 'UserMain',
		'action' => 'tasks',
		'subtitle' => 'Задания',
	],

	'tasks' => [
		'controller' => 'UserMain',
		'action' => 'tasks',
		'subtitle' => 'Задания',
	],

	'task/[0-9]{1,}' => [
		'controller' => 'UserMain',
		'action' => 'task',
		'subtitle' => 'Задание',
	],

	'auth' => [
		'controller' => 'UserMain',
		'action' => 'auth',
		'subtitle' => 'Вход',
	],

	'login' => [
		'controller' => 'UserMain',
		'action' => 'login',
		'subtitle' => '',
	],

	'logout' => [
		'controller' => 'UserMain',
		'action' => 'logout',
		'subtitle' => '',
	],
	/* USER END */
	/* USER AJAX */
	'task/save' => [
		'controller' => 'UserAjax',
		'action' => 'saveTask',
		'subtitle' => '',
	],
	'task/status' => [
		'controller' => 'UserAjax',
		'action' => 'statusTask',
		'subtitle' => '',
	],
	/* USER AJAX END */

	/* ADMIN */
	'admin' => [
		'controller' => 'AdminMain',
		'action' => 'tasks',
		'subtitle' => 'Задания',
	],

	'admin/tasks' => [
		'controller' => 'AdminMain',
		'action' => 'tasks',
		'subtitle' => 'Задания',
	],

	'admin/tags' => [
		'controller' => 'AdminMain',
		'action' => 'tags',
		'subtitle' => 'Теги',
	],

	'admin/images' => [
		'controller' => 'AdminMain',
		'action' => 'images',
		'subtitle' => 'Картинки',
	],

	'admin/users' => [
		'controller' => 'AdminMain',
		'action' => 'users',
		'subtitle' => 'Пользователи',
	],

	'admin/auth' => [
		'controller' => 'AdminMain',
		'action' => 'auth',
		'subtitle' => 'Вход',
	],

	'admin/login' => [
		'controller' => 'AdminMain',
		'action' => 'login',
		'subtitle' => '',
	],

	'admin/logout' => [
		'controller' => 'AdminMain',
		'action' => 'logout',
		'subtitle' => '',
	],
	/* ADMIN END */

	/* ADMIN AJAX */
	'images/upload' => [
		'controller' => 'AdminAjax',
		'action' => 'uploadImage',
	],
	'images/del' => [
		'controller' => 'AdminAjax',
		'action' => 'delImage',
	],

	
	'users/del/[0-9]{1,}' => [
		'controller' => 'AdminAjax',
		'action' => 'delUser',
		'subtitle' => 'API',
	],
	'users/save' => [
		'controller' => 'AdminAjax',
		'action' => 'saveUser',
		'subtitle' => 'API',
	],

	
	'tasks/save' => [
		'controller' => 'AdminAjax',
		'action' => 'saveTask',
		'subtitle' => 'API',
	],

	'tags/del/[0-9]{1,}' => [
		'controller' => 'AdminAjax',
		'action' => 'delTag',
		'subtitle' => 'API',
	],
	'tags/save' => [
		'controller' => 'AdminAjax',
		'action' => 'saveTags',
		'subtitle' => 'API',
	],
	/* ADMIN AJAX END */

	/* ADMIN API GET_DATA */
	'users/[0-9]{1,}' => [
		'controller' => 'AdminAjax',
		'action' => 'getUser',
		'subtitle' => 'API',
	],
	'tasks/[0-9]{1,}' => [
		'controller' => 'AdminAjax',
		'action' => 'getTask',
		'subtitle' => 'API',
	],
	'tagtypes' => [
		'controller' => 'AdminAjax',
		'action' => 'getTagTypes',
		'subtitle' => 'API',
	],
	/* ADMIN API GET_DATA END */
];