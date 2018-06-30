		<div class="content_wrapper">
			<div class="main_content_head">
				<p class="main_content_head_title">Список Тэгов</p>
				<div class="main_content_head_settings">
					<button class="btn blue" onclick="addTag()">Добавить</button>
					<button class="btn green" onclick="saveTags()">Сохранить</button>
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
								<form id="data" name="form<?php echo $key+1; ?>">
								<td><span><?php echo $key+1; ?></span><input for="form<?php echo $key+1; ?>" name="ID" type="text" value="<?php echo $tag['ID']; ?>" hidden></td>
								<td>
									<select for="form<?php echo $key+1; ?>" name="TYPE">
										<option value="0">--- Выберите значение ---</option>
									<?php foreach($TAG_TYPES as $typekey => $type): ?>
										<option value="<?php echo $type['VALUE']; ?>"<?php echo ($type['VALUE'] == $tag['VAL_TYPE'])?' selected':''?>><?php echo $type['NAME']; ?></option>
									<?php endforeach; ?>
									</select>
								</td>
								<td><input for="form<?php echo $key+1; ?>" name="VALUE" type="text" value="<?php echo $tag['VALUE']; ?>"></td>
								<td><button class="btn red" onclick="deleteTag(<?php echo $tag['ID']; ?>); return false;">X</button></td>
								</form>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>