		<div class="content_wrapper">
			<div class="main_content_head">
				<p class="main_content_head_title">Список заданий</p>
				<div class="main_content_head_settings">
					<button onclick="changeTask()" class="btn green">Добавить</button>
				</div>
			</div>
			<div class="main_content_info">
				<div class="table_wrapper">
					<table class="main_table">
						<thead>
							<tr class="table_head">
								<th style="width:100px;">#</th>
								<th>Логин</th>
								<th>Дата начала</th>
								<th>Дата конца</th>
								<th>Времени осталось</th>
								<th>Статус</th>
								<th style="width:120px;">Изменить</th>
								<th style="width:120px;">Удалить</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($TASKS as $key => $val): ?>
							<tr class="table_item">
								<td><span><?php echo $key + 1; ?></span></td>
								<td><span><?php echo $val['NAME']; ?></span></td>
								<td><span><?php echo $val['DT_START']; ?></span></td>
								<td><span><?php echo $val['DT_END']; ?></span></td>
								<td><span><?php echo $val['REM']; ?></span></td>
								<td><span><?php echo $val['STATUS']; ?></span></td>
								<td><button class="btn blue" onclick="changeTask(<?php echo $val['ID']; ?>)">C</button></td>
								<td><button class="btn red" onclick="deleteTask(this, <?php echo $val['ID']; ?>)">X</button></td>
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
					<div>
						<button id="btn_close" class="btn blue" onclick="closeTask()">Закончить</button>
						<button form="modal_tasks_form" class="btn green">Сохранить</button>
					</div>
				</div>
				<div class="modal_wnd_content">
					<div class="modal_tasks">
						<form id="modal_tasks_form" class="modal_tasks_form" action="">
							<input hidden type="text" name="ID" value="-1">
							<div class="modal_tasks_form_head">
								<div class="forma_group">
									<label>
										<p>Пользователь:</p>
										<select required name="" id="">
											<option value="Пользователь 1">Пользователь 1</option>
											<option value="Пользователь 2">Пользователь 2</option>
											<option value="Пользователь 3">Пользователь 3</option>
										</select>
									</label>
								</div>
								<div class="forma_group date">
									<label>
										<p>Начало</p>
										<input required type="date">
										<input type="time">
									</label>
								</div>
								<div class="forma_group date">
									<label>
										<p>Конец</p>
										<input required type="date">
										<input type="time">
									</label>
								</div>
							</div>
							<div class="modal_tasks_form_content">
								<div class="modal_tasks_form_tags">
									<div class="tag_checkbox">
										<label>
											<span class="tag_type location">Геолокация</span>
											<input value="" id="" name="" type="checkbox">
											<p class="checkbox_custom">&#10004;</p>
										</label>
									</div>
								</div>
								<div class="modal_tasks_form_photo_wrapper">
									<div class="modal_tasks_form_photo">
										<div class="photo_checkbox">
											<label>
												<img src="/assets/img/de.png" alt="">
												<input value="" id="" name="" type="checkbox">
												<span class="checkbox_custom"></span>
											</label>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>