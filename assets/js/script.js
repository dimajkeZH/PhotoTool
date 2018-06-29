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
	$(".slidebar_wrapper").mCustomScrollbar();
}
function custormScrollUserTaskTags(){
	$(".user_task_info_tags").mCustomScrollbar();
}

(function($){
    $(window).on("load",function(){
       	custormScrollContent();
    });
})(jQuery);
(function($){
    $(window).on("load",function(){
       	custormScrollModalForm();
    });
})(jQuery);
(function($){
    $(window).on("load",function(){
       	custormScrollModalFormTasks();
    });
})(jQuery);
(function($){
    $(window).on("load",function(){
       	custormScrollModalFormTasksPhoto();
    });
})(jQuery);
(function($){
    $(window).on("load",function(){
       	custormScrollModalFormDrugAndDrop();
    });
})(jQuery);
(function($){
    $(window).on("load",function(){
       	custormScrollSlidebar();
    });
})(jQuery);
(function($){
    $(window).on("load",function(){
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