		<div class="content_wrapper">
			<div class="main_content_head">
				<p class="main_content_head_title">Фото</p>
				<div class="main_content_head_settings">
					<form>
						<input type="text" placeholder="Значение тэга">
						<input type="text" placeholder="Название тэга">
						<input type="reset" class="btn red"	>
					</form>
					<button onclick="modalOpen()" class="btn green">Добавить</button>
				</div>
			</div>
			<div class="main_content_info">
				<div class="photo_list">
					<?php foreach($IMAGES as $key => $image): ?>
					<div class="photo_list_item">
						<img onclick="modalPhotoOpen(this.src)" src="/assets/img/catalog/<?php echo $image['PATH']; ?>.png" alt="<?php echo $image['NAME']; ?>">
						<button class="btn red" onclick="delImage(this, <?php echo $image['ID']; ?>)"><span>X</span></button>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<div class="modal_wnd">
			<div class="modal_wnd_wrapper" id="wrap" onclick="cancelUpload()">
			</div>
			<div class="modal_wnd_inner" id="window">
				<div class="modal_wnd_head">
					<button onclick="cancelUpload()" class="btn red">Отмена</button>
					<button onclick="goUpload()"" class="btn green">Загрузить</button>
				</div>
				<div class="modal_wnd_content">
					<div class="modal_drug_and_drop">
						<div id="drop-area">
	  						<form class="my-form">
	   					 		<p>Перетащи фото сюда</p>
	   					 		<input type="file" id="fileElem" multiple accept="image/*" onchange="handleFiles(this.files)">
	   					 		<label class="button" for="fileElem">Выбирите несколько файлов</label>
	  						</form>
	  						<progress id="progress-bar" max=100 value=0></progress>
	  						<div class="gallery_wrapper">
		  						<div id="gallery">
	  							</div>
	  						</div>
						</div>
					</div>
				</div>
			</div>
			<script src="/assets/js/drop.js"></script>
		</div>
		<div class="modal_wnd_photo">	
			<div class="modal_wnd_photo_wrapper" id="photo_wrap" onclick="modalPhotoClose()">
			</div>
			<div class="modal_wnd_photo_inner" id="photo_window">
				<div class="modal_wnd_photo_img">
					<img src="" alt="">
					<button onclick="modalPhotoClose()" class="btn red">
						<p>X</p>
					</button>
				</div>
			</div>
		</div>