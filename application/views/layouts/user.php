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
	<div class="main_wrapper">
		<div class="header">
			<div class="header_logo">
				<img src="/assets/img/sambo_logo.png" alt="">
			</div>
			<div class="header_settings">
				<div class="header_settings_username">
					<p>Панель Пользователя: <span><?php echo $_SESSION['username']; ?></span></p>
				</div>
				<a href="/logout" class="btn">
					<p>Выход</p>
				</a>
			</div>
		</div>
		<div class="content_wrapper">
			<div class="main_content_head">
				<p class="main_content_head_title"><?php echo ((isset($TASK_NUMBER))?'Задание номер: <span>'.$TASK_NUMBER.'</span>':'Задание не выбрано'); ?></p>
				<p class="main_content_head_timer"><span id="timer_hour">00</span>:<span id="timer_min">00</span>:<span id="timer_sec">00</span></p>
				<div class="main_content_head_settings">
					<button onclick="taskListOpen()" class="btn green">Список заданий</button>
				</div>
			</div>
			<div class="user_main_content_info">
				<div class="user_task">
					<div class="task_list">	
						<div class="task_list_head">
							<p class="task_list_title"><?php echo ((isset($TASK_LIST)) && (count($TASK_LIST) > 0))?'Список заданий':'У вас пока нет заданий'; ?></p>
							<button onclick="taskListOpen()" class="task_list_close btn red"><p>X</p></button>
						</div>
						<?php if((isset($TASK_LIST)) && (count($TASK_LIST) > 0)): ?>
						<div class="task_list_content">
							<ul>
								<?php foreach($TASK_LIST as $key => $val): ?>
								<li class="task_list_content_item"><a href="/task/<?php echo $val['ID']?>">Задание <?php echo $val['ID']?></a></li>
								<?php endforeach; ?>
							</ul>
						</div>
						<?php endif; ?>
					</div>
					<?php echo $content; ?>
				</div>
			</div>
		</div>
		<div class="footer"></div>
	</div>
	<script src="/assets/js/jquery-3.3.1.min.js"></script>
	<script src="/assets/js/slick/slick.min.js"></script>
	<script src="/assets/js/malihu-custom-scrollbar-plugin-master/jquery.mCustomScrollbar.js"></script>
	<script src="/assets/js/common.js"></script>
	<script src="/assets/js/user.js"></script>
</body>
</html>