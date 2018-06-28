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

function modalOpen (){
	$(".modal_wnd_inner").fadeIn(400);
	$(".modal_wnd_wrapper").fadeIn(400);
}
function modalClose (){
	$(".modal_wnd_inner").fadeOut(400);
	$(".modal_wnd_wrapper").fadeOut(400);
}