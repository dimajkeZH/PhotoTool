<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $TITLE.': '.$SUBTITLE; ?></title>
	<link rel="stylesheet" type="text/css" href="/assets/css/slick.css"/>
	<link rel="stylesheet" type="text/css" href="/assets/css/slick-theme.css"/>
	<link rel="stylesheet" type="text/css" href="/assets/css/style.css">
	<link rel="stylesheet" href="/assets/js/malihu-custom-scrollbar-plugin-master/jquery.mCustomScrollbar.css" />
</head>
<body>
	<div class="popup__message"></div>
	<div class="main_wrapper">
		<div class="header">
			<div class="header_nav">
				<a href="/admin/tasks" class="header_nav_item">
					<p>Список заданий</p>
				</a>
				<a href="/admin/users" class="header_nav_item">
					<p>Пользователи</p>
				</a>
				<a href="/admin/tags" class="header_nav_item">
					<p>Тэги</p>
				</a>
				<a href="/admin/images" class="header_nav_item">
					<p>Фотографии</p>
				</a>
			</div>
			<div class="header_logo">
				<img src="img/sambo_logo.png" alt="">
			</div>
			<div class="header_settings">
				<div class="header_settings_username">
					<p>Панель Администратора: <span>Евгений</span></p>
				</div>
				<a href="/admin/logout" class="btn">
					<p>Выход</p>
				</a>
			</div>
		</div>
		<?php echo $content; ?>
	</div>
	<script src="/assets/js/jquery-3.3.1.min.js"></script>
	<script src="/assets/js/slick/slick.min.js"></script>
	<script src="/assets/js/malihu-custom-scrollbar-plugin-master/jquery.mCustomScrollbar.js"></script>
	<script src="/assets/js/script.js"></script>
</body>
</html>