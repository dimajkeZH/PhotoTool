	/* массив файлов */
	var FILES = [];
	// ************************ Drag and drop ***************** //
	let dropArea = document.getElementById("drop-area")

	// Prevent default drag behaviors
	;['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
	  dropArea.addEventListener(eventName, preventDefaults, false)   
	  document.body.addEventListener(eventName, preventDefaults, false)
	})

	// Highlight drop area when item is dragged over it
	;['dragenter', 'dragover'].forEach(eventName => {
	  dropArea.addEventListener(eventName, highlight, false)
	})

	;['dragleave', 'drop'].forEach(eventName => {
	  dropArea.addEventListener(eventName, unhighlight, false)
	})

	// Handle dropped files
	dropArea.addEventListener('drop', handleDrop, false)

	function preventDefaults (e) {
	  e.preventDefault()
	  e.stopPropagation()
	}

	function highlight(e) {
	  dropArea.classList.add('highlight')
	}

	function unhighlight(e) {
	  dropArea.classList.remove('active')
	}

	function handleDrop(e) {
	  var dt = e.dataTransfer
	  var files = dt.files

	  handleFiles(files)
	}

	/* переменные для прогресс-бара */
	let uploadProgress = []
	let progressBar = document.getElementById('progress-bar')

	/* инициализация прогресс-бара */
	function initializeProgress(numFiles) {
	  progressBar.value = 0
	  uploadProgress = []

	  for(let i = numFiles; i > 0; i--) {
	    uploadProgress.push(0)
	  }
	}

	/* обновление прогресс-бара */
	function updateProgress(fileNumber, percent) {
	  uploadProgress[fileNumber] = percent
	  let total = uploadProgress.reduce((tot, curr) => tot + curr, 0) / uploadProgress.length
	  //console.debug('update', fileNumber, percent, total)
	  progressBar.value = total
	}

	/* Загрузка файлов в массив */
	function handleFiles(files) {
	  	files = [...files];
	  	files.forEach(function(file){
	  		if(FILES.length < 1){
				file.id = 0;
	  		}else{
	  			let max = 0;
	  			FILES.forEach(function(val){
	  				if(val.id > max){
	  					max = val.id;
	  				}
	  			});
	  			file.id = max+1;
	  		}
	  		FILES.push(file);

	  	});
	  	files.forEach(previewFile);
	}

	/* Добавить файл в превью */
	function previewFile(file) {
	  let reader = new FileReader()
	  reader.readAsDataURL(file)
	  reader.onloadend = function() {
	    let img = document.createElement('img')
	    img.src = reader.result
	    let box = document.createElement('div');
	    box.classList.add('img_box');
	    box.id = file.id;
	    box.appendChild(img);
	    let btn = document.createElement('button');
	    btn.classList.add('btn');
	    btn.classList.add('red');
	    btn.innerHTML = '<p>X</p>';
	    btn.setAttribute('onclick', 'deleteElement(this, "'+file.name+'", "'+file.id+'")');
	    //btn.onclick=function(){deleteElement(this, file.name, file.id)};
	    box.appendChild(btn);
	    document.getElementById('gallery').appendChild(box);
	  }
	}

	/* загрузка файла на сервер */
	function uploadFile(file, i) {
	  var url = '/images/upload'
	  var xhr = new XMLHttpRequest()
	  var formData = new FormData()
	  xhr.open('POST', url, true)
	  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
	  xhr.upload.addEventListener("progress", function(e) {
	    updateProgress(i, (e.loaded * 100.0 / e.total) || 100)
	  })
	  xhr.addEventListener('readystatechange', function(e) {
	    if (xhr.readyState == 4 && xhr.status == 200) {
	      	updateProgress(i, 100);
	      	let data = xhr.responseText;
	    	data = JSON.parse(data);
	    	if(data.status == true){
	    		let parent = $('#'+data.id+'.img_box')[0];
	    		let src = parent.getElementsByTagName('img')[0].src;
	    		let el = document.createElement("div");
	    		el.classList.add('photo_list_item');
	    		el.innerHTML = '<img  onclick="modalPhotoOpen(this.src)" src="'+src+'" alt="">';
	    		$('.photo_list').append(el);
	    		parent.remove();
	    		FILES.forEach(function(val, key){
					if(val.id == data.id){
						FILES.splice(key, 1);
						return;
					}
				});
				if(FILES.length == 0){
					cancelUpload();
					scrollDown();
				}
	    		showMessage(data.message, typeMessage.good);
	    	}else{
	    		showMessage(data.message, typeMessage.bad);
	    	}
	    }
	    else if (xhr.readyState == 4 && xhr.status != 200) {
	     	console.log('error '+i);
	    }
	  })
	  formData.append('ID', file.id);
	  formData.append('file', file);
	  xhr.send(formData);
	}

	/* кнопка загрузить */
	function goUpload(){
		//console.log(FILES);
		if(FILES != undefined){
			initializeProgress(FILES.length);
			FILES.forEach(uploadFile);

		}	
	}

	/* кнопка удаления элемента из массива */
	function deleteElement(THIS, NAME, ID){
		FILES.forEach(function(val, key){
			if((val.name === NAME) && (val.id == ID)){
				FILES.splice(key, 1);
				return;
			}
		});
		THIS.parentNode.remove();
	}

	/* кнопка отмены */
	function cancelUpload(){
		FILES = [];
		document.getElementById('gallery').innerHTML = '';
		modalClose();
	}