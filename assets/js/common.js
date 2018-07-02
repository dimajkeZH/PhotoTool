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
/********************* VARS END *********************/

/********************* FUNCTIONS *********************/
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
function scrollDown() {
  let wrapper = $('.main_content_info');
  let scrollElement = $('#mCSB_1_container');
  let wrapperHeight = wrapper.height();
  let scrollElementHeight = scrollElement.height();
  if(scrollElementHeight > wrapperHeight){
    scrollElement.css('top', -(scrollElementHeight - wrapperHeight));
  }
}
/********************* FUNCTIONS END *********************/