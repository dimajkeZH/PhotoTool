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
		<script type="text/javascript">
			function addTag() {
				let index = maxTagFormId();
				let tagItem = '<tr class="table_item"><form id="data" name="newform'+index+'"><td><span>NEW</span><input for="newform'+index+'" name="ID" type="text" value="-1" hidden></td><td><select name="TYPE" for="newform'+index+'"><option value="0">--- Выберите значение ---</option></select></td><td><input type="text" for="newform'+index+'" value="" name="VALUE" /></td><td><button class="btn red" onclick="deleteNewTag(this)">X</button></td></form></tr>';
				let parent = $('.main_table tbody');
				parent.append(tagItem);
			}
			function deleteNewTag(THIS) {
				$(THIS).parent().parent().remove();
			}
			function maxTagFormId() {
				let ID;
				let max = 0;
				let newMax;
				let formList = $("form#data[name^=newform]");
				if(formList.length > 0){
					formList.each(function(index, curForm){
						newMax = curForm.name.split('newform')[1];
						if (newMax > max) {
							max = newMax;
						}
					});
					ID = max*1 + 1;
				}
				else{
					ID = 0;
				}
				console.log(ID)
				return ID;
			}
			function deleteTag(ID) {
				if (confirm("Действительно удалить этот тег?")) {
			    let content = getContent('/tags/del/'+ID);
			    console.log(content);
			    if(content != undefined){
			      if(content.status){
			        showMessage(text, typeMessage.good);
			      }else{
			        showMessage(text, typeMessage.bad);
			      }
			    }else{
			      showMessage('Server error', typeMessage.bad);
			    }
			  }
			}
			function saveTags() {
				let formList = $("form#data");
				let obj, data = {};
				formList.each(function(index, form) {
					obj = {
						'ID': $("input[for="+form.name+"][name=ID]").val(),
						'TYPE': $("select[for="+form.name+"][name=TYPE]").val(),
						'VALUE': $("input[for="+form.name+"][name=VALUE]").val(),
					}
					data[index] = obj;
				});
				console.log(data);
			}
		</script>