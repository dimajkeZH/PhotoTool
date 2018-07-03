/********************* EVENTS *********************/
(function($){
    $(window).on("load",function(){
        if(typeof IDtask != undefined){
			Ajax('/task/status/', {'ID':IDtask}); 
        	//console.log(IDtask);
        }
    });
})(jQuery);
/********************* EVENTS END *********************/

/********************* VARS *********************/
var keyCodeESC = 27;
var CurMinIMG = $('.sidebar_item button')[0];
var boxHour = $('#timer_hour'),
	boxMin = $('#timer_min'),
	boxSec = $('#timer_sec');
let sec = Math.floor(((new Date(endDateTime).getTime()) - Date.now()) / 1000);
let arr = ((sec / 60) + '').split(".");
arr[1] = (arr[1] == undefined)?0:arr[1];
var newSec = twoSymbols(Math.floor(('0.'+arr[1]) * 60) + '');
arr = ((arr[0] / 60) + '').split(".");
arr[1] = (arr[1] == undefined)?0:arr[1];
var newHours = twoSymbols(arr[0] * 1 + '');
var newMin = twoSymbols(Math.floor(('0.'+arr[1]) * 60) + '');
//console.log(newHours + ' ' + newMin + ' ' + newSec);
boxHour.text(newHours);
boxMin.text(newMin);
boxSec.text(newSec);
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
		
		//redirect('www.example.com/tasks');
	}
}

function redirect(url = ''){
	window.location.replace(url);
}

function changeImg(THIS, img, ID) {
	CurMinIMG = $(THIS).parent().find('button')[0];
	console.log(CurMinIMG);
  	$(".info_photo_item img")[0].src=img;
  	CurImageID = ID;
  	let selectionTags = [];
  	data_tasklist.forEach(function(valueData, indexData){
  		if(valueData.ID == CurImageID){
			data_tasklist[indexData].TAGS.forEach(function(valueTag, indexTag){
				selectionTags.push(valueTag.ID);
			});
  		}
  	});
  	let cbList = $('.tag_checkbox input[name^=TAG]');
  	cbList.each(function(indexCb, valueCb){
  		if($.inArray(valueCb.value, selectionTags) > -1){
  			valueCb.checked = true;
  		}else{
  			valueCb.checked = false;
  		}
  	});
}
function saveTask(ID){
	console.clear();
	console.log(data_tasklist);
	Ajax('/task/save', {'DATA':data_tasklist, 'ID':IDtask}, 'saveTaskAfter');
}
function saveTaskAfter(text, status){
	if(status){
		showMessage(text, typeMessage.good);
	}else{
		showMessage(text, typeMessage.bad);
	}
}
function selectTag(THIS, ID){
	if(CurImageID != undefined){
		let status = $(THIS).prop('checked');
		let tag = $(THIS).val();
		data_tasklist.forEach(function(valueData, indexData){
			if(valueData.ID == CurImageID){
				if(status){
					data_tasklist[indexData].TAGS.push({'ID':tag});
				}else{
					data_tasklist[indexData].TAGS.forEach(function(valueTag, indexTag){
						if(valueTag.ID == tag){
							//delete data_tasklist[indexData].TAGS[indexTag];
							data_tasklist[indexData].TAGS.splice(indexTag, 1);
						}
					});
				}
				if(data_tasklist[indexData].TAGS.length > 0){
					CurMinIMG.classList.add('active');
				}else{
					CurMinIMG.classList.remove('active');
				}
			}
		});
	}
}

function twoSymbols(str){
	if(str.length == 1){
		return '0'+ str;
	}
	return str;
}

function timerTick(){
	let hour = boxHour.text() * 1,
		min = boxMin.text() * 1,
		sec = boxSec.text() * 1;
	//console.log(hour + ' ' + min + ' ' + sec);
	if(sec > 0){
		sec--;
	}else{
		sec = 59;
		if(min > 0){
			min--;
		}else{
			min = 59;
			if(hour > 0){
				hour--;
			}
		}
	}
	if((hour <= 0) && (min <= 0) && (sec <= 0)){
		clearInterval(timerID);
	}
	boxHour.text(twoSymbols(hour+''));
	boxMin.text(twoSymbols(min+''));
	boxSec.text(twoSymbols(sec+''));
}

var timerID = setInterval(timerTick, 1000);
/********************* KEYDOWN END *********************/