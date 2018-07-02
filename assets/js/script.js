


/********************* EVENTS *********************/
function delImage(THIS, ID){
  if (confirm("Действительно удалить эту картинку?")) {
    MAINTHIS = THIS;
    Ajax('/images/del', {'ID':ID}, 'delImageAfter');
  }
}
function delImageAfter(text, status){
  if(status){
    $(MAINTHIS).parent().remove();
    MAINTHIS = '';
    showMessage(text, typeMessage.good);
  }else{
    showMessage(text, typeMessage.bad);
  }
}

function deleteUser(THIS, ID){
  if (confirm("Действительно удалить этого пользователя?")) {
    let content = getContent('/users/del/'+ID);
    if(content != undefined){
      if(content.status){
        showMessage(content.message, typeMessage.good);
        $(THIS).parent().parent().remove();
      }else{
        showMessage(content.message, typeMessage.bad);
      }
    }else{
      showMessage('Server error', typeMessage.bad);
    }
  }
}

var tmpUSERFIELD = '';

function saveUser(){
  let F_NAME = $('#modal_user_form input[name=f_name]').val(),
      S_NAME = $('#modal_user_form input[name=s_name]').val(),
      NAME = $('#modal_user_form input[name=name]').val(),
      PASS = $('#modal_user_form input[name=pass]').val(),
      MAIL = $('#modal_user_form input[name=mail]').val(),
      PHONE = $('#modal_user_form input[name=phone]').val(),
      ID = $('#modal_user_form input[name=ID]').val();
  let passCheck = true;
  if(ID == -1){
    if(PASS == ''){
      passCheck = false;
    }
  }
  if((F_NAME != '') && (passCheck) && (NAME != '')){
    let obj = {
      'ID':ID,
      'F_NAME':F_NAME,
      'S_NAME':S_NAME,
      'NAME':NAME,
      'PASS':PASS,
      'MAIL':MAIL,
      'PHONE':PHONE,
    }
    tmpUSERFIELD = '<tr class="table_item"><td><span>NEW</span></td><td><span>'+NAME+'</span></td><td><span>'+F_NAME+'</span></td><td><span>0</span></td><td></td><td></td></tr>';
    $('.main_table tbody').append(tmpUSERFIELD);
    Ajax('/users/save', obj, 'saveUserAfter');
  }
}
function saveUserAfter(text, status){
  if(status){
    modalClose();
    showMessage(text, typeMessage.good);
  }else{
    showMessage(text, typeMessage.bad);
  }
}

function changeUser(ID = -1){
  let S_NAME, F_NAME, NAME, PASS, MAIN, PHONE;
  let fieldF_NAME = $('#modal_user_form input[name=f_name]'),
      fieldS_NAME = $('#modal_user_form input[name=s_name]'),
      fieldNAME = $('#modal_user_form input[name=name]'),
      fieldPASS = $('#modal_user_form input[name=pass]'),
      fieldMAIL = $('#modal_user_form input[name=mail]'),
      fieldPHONE = $('#modal_user_form input[name=phone]'),
      fieldTaskCount = $('.modal_user_info span'),
      fieldOnline = $('#on.modal_table tbody'),
      fieldOffline = $('#off.modal_table tbody'),
      fieldID = $('#modal_user_form input[name=ID]');
  if(ID == -1){
    $('#modal_user_form input[name=pass]').attr('required', '');
    $('.modal_user_info').attr('style', 'display:none;');
    S_NAME = '';
    F_NAME = '';
    NAME = '';
    PASS = '';
    MAIL = '';
    PHONE = '';
    COUNT = '';
    ONLINE = "";
    OFFLINE = "";
  }else{
    $('#modal_user_form input[name=pass]').removeAttr('required');
    $('.modal_user_info').removeAttr('style');
    let content = getContent('/users/'+ID);
    S_NAME = content.DATA.S_NAME;
    F_NAME = content.DATA.F_NAME;
    NAME = content.DATA.NAME;
    PASS = content.DATA.PASS;
    MAIL = content.DATA.MAIL;
    PHONE = content.DATA.PHONE;
    COUNT = content.DATA.COUNT_TASKS;
    ONLINE = "";
    content.ONLINE.forEach(function(field, key){
      ONLINE += "<tr><td>"+(key+1)+"</td><td>"+field.DEVICE+"</td><td>"+field.IP+"</td><td>"+field.BROWSER+"</td><td>"+field.DT_CREATE+"</td><td>"+15+"</td></tr>";
    });
    OFFLINE = "";
    content.OFFLINE.forEach(function(field, key){
      OFFLINE += "<tr><td>"+(key+1)+"</td><td>"+field.DEVICE+"</td><td>"+field.IP+"</td><td>"+field.BROWSER+"</td><td>"+field.DT_CREATE+"</td><td>"+15+"</td></tr>";
    });
  }
  fieldID.val(ID);
  fieldF_NAME.val(F_NAME);
  fieldS_NAME.val(S_NAME);
  fieldNAME.val(NAME);
  fieldPASS.val(PASS);
  fieldMAIL.val(MAIL);
  fieldPHONE.val(PHONE);
  fieldTaskCount.text(COUNT);
  fieldOnline.html(ONLINE);
  fieldOffline.html(OFFLINE);
  modalOpen();
}

function addTag() {
  let index = maxTagFormId();
  let options = '';
  let optionsData = getContent('/tagtypes');
  if(optionsData.STATUS){
    optionsData.DATA.forEach(function(value){
      options += '<option value="'+value.VALUE+'">'+value.NAME+'</option>';
    });
  }
  let tagItem = '<tr class="table_item"><form id="data" name="newform'+index+'"><td><span>NEW</span><input for="newform'+index+'" name="ID" type="text" value="-1" hidden></td><td><select name="TYPE" for="newform'+index+'"><option value="0">--- Выберите значение ---</option>'+options+'</select></td><td><input type="text" for="newform'+index+'" value="" name="VALUE" /></td><td><button class="btn red" onclick="deleteNewTag(this)">X</button></td></form></tr>';
  let parent = $('.main_table tbody');
  parent.append(tagItem);
  let wrapper = $('.main_content_info');
  let scrollElement = $('#mCSB_1_container');
  let wrapperHeight = wrapper.height();
  let scrollElementHeight = scrollElement.height();
  let tableItemHeight = $('.table_item').height();
  if(scrollElementHeight > wrapperHeight){
    scrollElement.css('top', scrollElement.css('top').replace(/[^-\d\.]/g, '') - tableItemHeight);
  }
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
function deleteTag(THIS, ID) {
  if (confirm("Действительно удалить этот тег?")) {
    let content = getContent('/tags/del/'+ID);
    if(content != undefined){
      if(content.status){
        $(THIS).parent().parent().remove();
        showMessage(content.message, typeMessage.good);
      }else{
        showMessage(content.message, typeMessage.bad);
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
  Ajax('/tags/save', data, 'saveTagsAfter');
}
function saveTagsAfter(text, status){
  if(status){
    showMessage(text, typeMessage.good);
  }else{
    showMessage(text, typeMessage.bad);
  }
}
/********************* EVENTS END *********************/





/********************* VARS *********************/
var typeMessage = Object.freeze({
      good : 1,
      common : 2,
      bad : 3,
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
var classContentBox = 'main_content',
    classSiteTree = 'main_nav',
    classLoaderPage = 'loader_box',
    loaderPageHide = 5; /* 3 - 12 */
var MAINTHIS;
/********************* VARS END *********************/





/********************* FUNCTIONS *********************/
//page ready
(function($){
    $(window).on("load",function(){
        $(".main_content_info").mCustomScrollbar();
        $(".modal_table_wrapper").mCustomScrollbar();
        $(".modal_tasks_form_tags").mCustomScrollbar();
        $(".modal_tasks_form_photo_wrapper").mCustomScrollbar();
        $(".gallery_wrapper").mCustomScrollbar();
        $(".sidebar_wrapper").mCustomScrollbar();
        $(".user_task_info_tags").mCustomScrollbar();
    });
})(jQuery);

function modalOpen (){
  $(".modal_wnd_inner").fadeIn(400);
  $(".modal_wnd_wrapper").fadeIn(400);
}
function modalClose (){
  $(".modal_wnd_inner").fadeOut(400);
  $(".modal_wnd_wrapper").fadeOut(400);
}
function taskListOpen (){
  $(".task_list").toggleClass("active");
}

function showMessage(message, status = typeMessage.common){
  var curClassMessage, type;
  switch(status){
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

function getContent(uri){
  let Data;
  $.ajax({
    url: uri,
    type: 'POST',
    async: false,
    success: function(data){
      console.log(data);
      try{
        Data = JSON.parse(data.trim());
      }catch{
        console.log('Error of script. Refresh page!');
      }finally{
        //HideLoader();
      }
    },
    error: function(){
      console.log('something was wrong. Refresh page!');
      //HideLoader();
    }
  });
  return Data;
}

function Ajax(uri, data = [], callback = ''){
  $.ajax({
    url: uri,
    type: 'POST',
    data: data,
    success: function(data){
      console.log(data);
      try{
        data = JSON.parse(data.trim());
        window[callback](data.message, data.status);
      }catch{
        console.log('Error of script. Refresh page!');
      }finally{
        //HideLoader();
      }
    },
    error: function(){
      console.log('something was wrong. Refresh page!');
      //HideLoader();
    }
  });
}

function modalPhotoOpen (img){
	$(".modal_wnd_photo_img img")[0].src=img;
	$(".modal_wnd_photo_inner").fadeIn(400);
	$(".modal_wnd_photo_wrapper").fadeIn(400);
}
function modalPhotoClose (){
	$(".modal_wnd_photo_inner").fadeOut(400);
	$(".modal_wnd_photo_wrapper").fadeOut(400);
}
/********************* FUNCTIONS END *********************/