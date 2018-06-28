<div class="content_wrapper">
			<div class="main_content_head">
				<p class="main_content_head_title">Список Тэгов</p>
				<div class="main_content_head_settings">
					<button class="btn blue" onclick="tagAdd()">Добавить</button>
					<button class="btn green" onclick="tagsSave()">Сохранить</button>
				</div>
			</div>
			<div class="main_content_info">
				<div class="table_wrapper">
					<table class="main_table">
						<thead>
							<tr class="table_head">
								<th style="width:100px;">#</th>
								<th>Тип</th>
								<th>Значение</th>
								<th style="width:120px;">Удалить</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($TAGS as $key => $tag): ?>
							<tr class="table_item">
								<form id="" name="">
								<td><span>1</span></td>
								<td>
									<select for="" name="" id="">
										<option value="1">Значение 1</option>
										<option value="2">Значение 2</option>
										<option value="3">Значение 3</option>
									</select>
								</td>
								<td><input for="" name="" id="" type="text"></td>
								<td><button class="btn red">X</button></td>
								</form>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>