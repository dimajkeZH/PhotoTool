		<div class="content_wrapper">
			<div class="main_content_head">
				<p class="main_content_head_title">Список заданий</p>
				<div class="main_content_head_settings">
					<button onclick="modalOpen()" class="btn green">Добавить</button>
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
								<th>Процент</th>
								<th style="width:120px;">Изменить</th>
								<th style="width:120px;">Удалить</th>
							</tr>
						</thead>
						<tbody>
							<tr class="table_item">
								<td><span>1</span></td>
								<td><span>zh</span></td>
								<td><span>28.07.18 20:54</span></td>
								<td><span>29.07.18 20:54</span></td>
								<td><span>20:05:54</span></td>
								<td><span>Выполнено</span></td>
								<td><span>66%</span></td>
								<td><button class="btn blue">C</button></td>
								<td><button class="btn red">X</button></td>
							</tr>
							<tr class="table_item">
								<td><span>1</span></td>
								<td><span>zh</span></td>
								<td><span>28.07.18 20:54</span></td>
								<td><span>29.07.18 20:54</span></td>
								<td><span>20:05:54</span></td>
								<td><span>Выполнено</span></td>
								<td><span>66%</span></td>
								<td><button class="btn blue">C</button></td>
								<td><button class="btn red">X</button></td>
							</tr>
							<tr class="table_item">
								<td><span>1</span></td>
								<td><span>zh</span></td>
								<td><span>28.07.18 20:54</span></td>
								<td><span>29.07.18 20:54</span></td>
								<td><span>20:05:54</span></td>
								<td><span>Выполнено</span></td>
								<td><span>66%</span></td>
								<td><button class="btn blue">C</button></td>
								<td><button class="btn red">X</button></td>
							</tr>
							<tr class="table_item">
								<td><span>1</span></td>
								<td><span>zh</span></td>
								<td><span>28.07.18 20:54</span></td>
								<td><span>29.07.18 20:54</span></td>
								<td><span>20:05:54</span></td>
								<td><span>Выполнено</span></td>
								<td><span>66%</span></td>
								<td><button class="btn blue">C</button></td>
								<td><button class="btn red">X</button></td>
							</tr>
							<tr class="table_item">
								<td><span>1</span></td>
								<td><span>zh</span></td>
								<td><span>28.07.18 20:54</span></td>
								<td><span>29.07.18 20:54</span></td>
								<td><span>20:05:54</span></td>
								<td><span>Выполнено</span></td>
								<td><span>66%</span></td>
								<td><button class="btn blue">C</button></td>
								<td><button class="btn red">X</button></td>
							</tr>
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
					<button form="" class="btn green">Сохранить</button>
				</div>
				<div class="modal_wnd_content">
					<div class="modal_tasks">
						<form class="modal_tasks_form" action="">
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
								<div class="forma_group">
									<label>
										<p>Начало</p>
										<input required type="datetime-local">
									</label>
								</div>
								<div class="forma_group">
									<label>
										<p>Конец</p>
										<input required type="datetime-local">
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