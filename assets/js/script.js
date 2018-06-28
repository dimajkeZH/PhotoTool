/* ScrollBars */
function custormScrollContent(){
	$(".main_content_info").mCustomScrollbar();
}
function custormScrollTree(){
	$(".main_nav").mCustomScrollbar();
}
function custormScrollForm(){
	//$(".main_content_info_table").mCustomScrollbar({axis: "x"});
}

(function($){
    $(window).on("load",function(){
       	custormScrollContent();
       	custormScrollTree();
       	custormScrollForm();
    });
})(jQuery);
/* ScrollBars END */

/* VARS */
var row;
var typeMessage = Object.freeze({
	good : 		1,
	common : 	2,
	bad : 		3,
});
var classMessageBox = 'popup__message',
	classMessage = 'message',
	classMessageGood = 'good',
	classMessageBad = 'bad',
	classMessageCommon = 'common',
	messageGoodTimeout = 2800,
	messageBadTimeout = 3500,
	messageCommonTimeout = 3100;
	messageHide = 600;
var classLoaderPage = 'loader_box',
	loaderPageHide = 5; /* 3 - 12 */
/*
var table = Object.freeze({
	FACULTIES : 				1,
	DEPARTMENTS : 				2,
	SPECIALTIES : 				3,
	STUDENT_GROUPS : 			4,
	TRAINING_TYPES : 			5,
	TEACHERS : 					6,
	TEACHING_POSITIONS : 		7,
	STUDENTS : 					8,
	STUDENTS_EDUCATION_TYPES : 	9,
	ITEMS :						10,
	SEMESTERS : 				11,
	CLASSES : 					12,
	PAIRS : 					13,
	PAIR_TYPES : 				14,
	PAIR_NUMBER : 				15,
	ESTIMATES : 				16,
	FINAL_RATING : 				17,
	FINAL_RATING_TYPES : 		18,
});
*/
/* VARS END */

/* FUNCTIONS */

function AjaxContent(uri, data, callback){
	$.ajax({
		url: uri,
		type: 'POST',
		data: data,
		success: function(data){
			try{
				window[callback](data);
			}catch{
				console.log('Error of AjaxContent callback. Refresh page!');
				HideLoader();
			}
		},
		error: function(){
			console.log('something was wrong in AjaxContent. Refresh page!');
		}
	});
}

function Ajax(uri, data = {}, callback = ''){
	$.ajax({
		url: uri,
		type: 'POST',
		data: data,
		//dataType: 'json',
		//contentType: 'json',
		success: function(data){
			console.log(data);
			try{
				//data = JSON.parse(data.trim());
				window[callback](data.message, data.status);
			}catch{
				console.log('Error of Ajax callback. Refresh page!');
				HideLoader();
			}
		},
		error: function(){
			console.log('something was wrong. Refresh page!');
			HideLoader();
		}
	});
}

function showMessage(message, status = null){
	var curClassMessage, type;
	if(status){
		type = typeMessage.good;
	}else if(!status){
		type = typeMessage.bad;
	}else if(status == null){
		type = typeMessage.common;
	}
	switch(type){
		case typeMessage.good:
			curClassMessage = classMessageGood;
			curTimeout = messageGoodTimeout;
			break;
		case typeMessage.bad:
			curClassMessage = classMessageBad;
			curTimeout = messageBadTimeout;
			break;
		case typeMessage.common:
			curClassMessage = classMessageCommon;
			curTimeout = messageCommonTimeout;
			break;
	}
	var MessageBox = document.createElement("div");
	MessageBox.classList.add(classMessage);
	MessageBox.classList.add(curClassMessage);
	MessageBox.innerHTML = '<span>'+message+'</span>';
	$('.'+classMessageBox).prepend(MessageBox);
	removeMessage(MessageBox, curTimeout);
}

function removeMessage(msgBox, timeout){
	setTimeout(function(){
		$('.'+classMessageBox+'>div').filter(function(){
			return $(this).css("opacity") == 1;
		}).last().hide(messageHide, function(){
			msgBox.remove();
		});
	}, timeout);
}

function delRow(This, id){
	ShowLoader();
	let ID = id;
	row = $(This).parent().parent();
	//work
	/*
	let formDel = row.children('form')[0];
	let inputs = row.children('td').children('input[for="'+formDel.name+'"]');
	for(let input of inputs){
		if(input.name == 'ID'){
			ID = input.value;
			break;
		}
	}
	*/
	//not work
	/*
		for (let pair of new FormData(formDel).entries()) {
			if(pair[0] == 'ID'){
				ID = pair[1];
				//break;
			}
			console.log(pair[0]+' '+pair[1]);
		}
	*/
	if(window.confirm('Действительно хотите удалить эту запись?')){
		if(ID != '-1'){
			AjaxContent('/delRow', {'ID':ID, 'TABLE':table}, 'afterDelRow');
		}else{
			afterDelRow('{\"status\":true, \"message\":\"\"}');
		}
	}else{
		HideLoader();
	}
}

function afterDelRow(data){
	data = JSON.parse(data);
	HideLoader();
	if(data.status){
		row.remove();
		showMessage(data.message, typeMessage.good);
	}else{
		showMessage(data.message, typeMessage.bad);
	}
}

function addRow(){
	let dataForms = $('form#data');
	let name, 
		newname,
		arrName = [];
	dataForms.each(function(key, form){
		name = form.name;
		newname = name.replace('form', '');
		arrName.push(newname);
	});
	arrName = arrName.map(Number);
	if(arrName.length > 0){
		let newformIndex = Math.max.apply(null, arrName)+1;
		$('.main_content_info_table table tbody tr:last').after(template(newformIndex));
	}else{
		$('.main_content_info_table table tbody').html(template(0));
	}
	
}

function save(){
	let inputs,
		tempObj = {},
		dataObj = {};
	console.clear();
	let dataForms = $('form#data');
	$.each(dataForms, function(key, form){
		tempObj = {};
		inputs = $('.main_content_info_table table tbody tr td').children('input[for="'+form.name+'"]');
		$.each(inputs, function(key, input){
			tempObj[input.name] = input.value;
			if(input.type == 'checkbox'){
				if(input.checked){
					tempObj[input.name] = 1;
				}else{
					tempObj[input.name] = 0;
				}
			}
		});
		inputs = $('.main_content_info_table table tbody tr td').children('select[for="'+form.name+'"]');
		$.each(inputs, function(key, input){
			tempObj[input.name] = input.value;
		});
		dataObj[form.name] = tempObj;
	});
	data = {
		'TABLE' : table,
		'DATA' : dataObj,
	}
	//data = JSON.stringify(data);
	Ajax('/save', data, 'showMessage');
}

function ShowLoader(){
	var loader = $('.'+classLoaderPage)[0];
	loader.style.opacity = 1;
	loader.classList.remove('hide');
}
function HideLoader(){
	var loader = $('.'+classLoaderPage)[0];
	setTimeout(function tickHideLoader(){
		loader.style.opacity -= 0.01;
		if(loader.style.opacity == 0){
			loader.classList.add('hide');
		}else{
			setTimeout(tickHideLoader,loaderPageHide);
		}
	}, loaderPageHide);
}
/* FUNCTIONS END */

/* EVENTS */
/* EVENTS END */

/* SIMPLE CODE */
/* SIMPLE CODE END */
