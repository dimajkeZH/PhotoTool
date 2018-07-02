/********************* EVENTS *********************/
/********************* EVENTS END *********************/

/********************* VARS *********************/
var keyCodeESC = 27;
/********************* VARS END *********************/

/********************* FUNCTIONS *********************/
//page ready
(function($){
    $(window).on("load",function(){
        $(".sidebar_wrapper").mCustomScrollbar();
        $(".user_task_info_tags").mCustomScrollbar();  
    });
})(jQuery);
function taskListOpen (){
  $(".task_list").toggleClass("active");
}
/********************* FUNCTIONS END *********************/

/********************* KEYDOWN *********************/
var lastTime = Date.now();
document.body.onkeydown = function(e) {
	if((e.keyCode === keyCodeESC) && ((Date.now() - lastTime) > 950)){
		lastTime = Date.now();
			
	    var text = lastTime + ' ' + e.type +
	    ' keyCode=' + e.keyCode +
	    ' which=' + e.which +
	    ' charCode=' + e.charCode +
	    ' char=' + String.fromCharCode(e.keyCode || e.charCode) +
	    (e.shiftKey ? ' +shift' : '') +
	    (e.ctrlKey ? ' +ctrl' : '') +
	    (e.altKey ? ' +alt' : '') +
	    (e.metaKey ? ' +meta' : '') + "\n";
		console.log(text);
		
		redirect('www.example.com/tasks');
	}
}

function redirect(url = ''){
	//window.location.href = url;
	window.location.replace(url);
}
function changeImg(img) {
  $(".info_photo_item img")[0].src=img;
}
/********************* KEYDOWN END *********************/