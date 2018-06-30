function custormScrollContent(){
	$(".main_content_info").mCustomScrollbar();
}
function custormScrollModalForm(){
	$(".modal_table_wrapper").mCustomScrollbar();
}
function custormScrollModalFormTasks(){
	$(".modal_tasks_form_tags").mCustomScrollbar();
}
function custormScrollModalFormTasksPhoto(){
	$(".modal_tasks_form_photo_wrapper").mCustomScrollbar();
}
function custormScrollModalFormDrugAndDrop(){
	$(".gallery_wrapper").mCustomScrollbar();
}
function custormScrollSlidebar(){
	$(".sidebar_wrapper").mCustomScrollbar();
}
function custormScrollUserTaskTags(){
	$(".user_task_info_tags").mCustomScrollbar();
}

(function($){
    $(window).on("load",function(){
       	custormScrollContent();
       	custormScrollModalForm();
       	custormScrollModalFormTasks();
       	custormScrollModalFormTasksPhoto();
       	custormScrollModalFormDrugAndDrop();
       	custormScrollSlidebar();
       	custormScrollUserTaskTags();
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

/* VARS */
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
/* VARS END */

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

var MAINTHIS;

/* FUNCTIONS */
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
  }else{
    messageShow(text, typeMessage.bad);
  }
}

function delUser(THIS, ID){

}
function delUserAfter(){

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
      fieldOffline = $('#off.modal_table tbody');
  if(ID == -1){
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
    let content = getContent('/users/'+ID);
    console.log(content);
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
    console.log(ONLINE);
    OFFLINE = "";
    content.OFFLINE.forEach(function(field, key){
      OFFLINE += "<tr><td>"+(key+1)+"</td><td>"+field.DEVICE+"</td><td>"+field.IP+"</td><td>"+field.BROWSER+"</td><td>"+field.DT_CREATE+"</td><td>"+15+"</td></tr>";
    });
  }
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
function changeUserAfter(){

}
/* FUNCTION END */