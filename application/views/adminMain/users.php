		<div class="content_wrapper">
			<div class="main_content_head">
				<p class="main_content_head_title">Пользователи</p>
				<div class="main_content_head_settings">
					<button onclick="changeUser()" class="btn green">Добавить</button>
				</div>
			</div>
			<div class="main_content_info">
				<div class="table_wrapper">
					<table class="main_table">
						<thead>
							<tr class="table_head">
								<th style="width:100px;">#</th>
								<th>Логин</th>
								<th>Имя</th>
								<th style="width:250px;">Кол-во заданий</th>
								<th style="width:120px;">Изменить</th>
								<th style="width:120px;">Удалить</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($USERS as $key => $user): ?>
							<tr class="table_item">
								<td><span><?php echo $key+1; ?></span></td>
								<td><span><?php echo $user['NAME']; ?></span></td>
								<td><span><?php echo $user['F_NAME']; ?></span></td>
								<td><span><?php echo $user['TASK_COUNT']; ?></span></td>
								<td><button class="btn blue" onclick="changeUser(<?php echo $user['ID']; ?>)">C</button></td>
								<td><button class="btn red" onclick="deleteUser(this, <?php echo $user['ID']; ?>)">X</button></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="modal_wnd">
			<div class="modal_wnd_wrapper" id="wrap" onclick="modalClose()">
			</div>
			<div class="modal_wnd_inner" id="window">
					<div class="modal_wnd_head">
						<button onclick="modalClose()" class="btn red">Отмена</button>
						<button onclick="saveUser()" class="btn green">Сохранить</button>
					</div>
					<div class="modal_wnd_content">
						<form class="modal_user_form" id="modal_user_form">
							<input hidden type="text" name="ID" value="-1">
							<div class="forma_group">
								<label>
									<p>Фамилия </p>
									<input type="text" name="s_name">
								</label>
							</div>
							<div class="forma_group">
								<label>
									<p>Имя<span>*</span></p>
									<input required type="text" name="f_name">
								</label>
							</div>
							<div class="forma_group">
								<label>
									<p>Логин<span>*</span></p>
									<input required type="text" name="name">
								</label>
							</div>
							<div class="forma_group">
								<label>
									<p>Пароль<span>*</span></p>
									<input required type="password" name="pass">
								</label>
							</div>
							<div class="forma_group">
								<label>
									<p>Почта</p>
									<input type="email" name="mail">
								</label>
							</div>
							<div class="forma_group">
								<label>
									<p>Телефон</p>
									<input type="text" name="phone">
								</label>
							</div>
						</form>
						<div class="modal_user_info">
							<p class="modal_user_info_title">Количество заданий: <span>0</span></p>
							<p class="modal_user_info_title">Сейчас онлайн: </p>
							<div class="modal_table_wrapper">
								<table class="modal_table" id="on">
									<thead>
										<tr>
											<th>№</th>
											<th>Устройство</th>
											<th>IP</th>
											<th>Браузер</th>
											<th>Дата входа</th>
											<th>Время онлайн</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>1</td>
											<td>Телефон</td>
											<td>159.56.255.15</td>
											<td>Google Chrome</td>
											<td>28.06.2018 16:00</td>
											<td>00:50:51</td>
										</tr>
									</tbody>
								</table>
							</div>
							<p class="modal_user_info_subtitle">Активности: </p>
							<div class="modal_table_wrapper">
								<table class="modal_table" id="off">
									<thead>
										<tr>
											<th>№</th>
											<th>Устройство</th>
											<th>IP</th>
											<th>Браузер</th>
											<th>Дата входа</th>
											<th>Время онлайн</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>1</td>
											<td>Телефон</td>
											<td>159.56.255.15</td>
											<td>Google Chrome</td>
											<td>28.06.2018 16:00</td>
											<td>00:50:51</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
				</div>
			</div>
		</div>