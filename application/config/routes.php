<?php

return [

	/* USER */
	'' => [
		'controller' => 'UserMain',
		'action' => 'tasks',
		'subtitle' => '',
	],

	'tasks' => [
		'controller' => 'UserMain',
		'action' => 'tasks',
		'subtitle' => 'Задания',
	],

	'tasks/[0-9]{1,}' => [
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

	/* ADMIN */
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

	/* AJAX */
	'images/upload' => [
		'controller' => 'AdminAjax',
		'action' => 'uploadImage',
	],
	'images/del' => [
		'controller' => 'AdminAjax',
		'action' => 'delImage',
	],
	'users/[0-9]{1,}' => [
		'controller' => 'AdminAjax',
		'action' => 'getUser',
	],
	/* AJAX END */
];