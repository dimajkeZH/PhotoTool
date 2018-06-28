function custormScrollContent(){
	$(".main_content_info").mCustomScrollbar();
}
function custormScrollModalForm(){
	$(".modal_table_wrapper").mCustomScrollbar();
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

// function modalOpen (){
// 	$(".modal_wnd").toggleClass("open");
// }