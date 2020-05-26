// возвращает куки с указанным name,
// или undefined, если ничего не найдено
function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}


var element = $('.floating-chat');
var myStorage = localStorage;

if (!myStorage.getItem('chatID')) {
    myStorage.setItem('chatID', createUUID());
}

setTimeout(function() {
    element.addClass('enter');
}, 1000);

element.click(openElement);

function openElement() {
    var messages = element.find('.messages');
    var textInput = element.find('.text-box');
    element.find('>i').hide();
    element.addClass('expand');
    element.find('.chat').addClass('enter');
    var strLength = textInput.val().length * 2;
    textInput.keydown(onMetaAndEnter).html('').prop("disabled", false).focus();
    element.off('click', openElement);
    element.find('.header button').click(closeElement);
    element.find('#sendMessage').click(function(){
        websocket_callback('new_message', '', '', $('.text-box').html(),getCookie('id'));
        // clean out old message
        $('.text-box').html('');
        // focus on input
        $('.text-box').focus();
    });
    messages.scrollTop(messages.prop("scrollHeight"));
}

function closeElement() {
    element.find('.chat').removeClass('enter').hide();
    element.find('>i').show();
    element.removeClass('expand');
    element.find('.header button').off('click', closeElement);
    element.find('#sendMessage').off('click', sendNewMessage);
    element.find('.text-box').off('keydown', onMetaAndEnter).prop("disabled", true).blur();
    setTimeout(function() {
        element.find('.chat').removeClass('enter').show()
        element.click(openElement);
    }, 500);
}

function createUUID() {
    // http://www.ietf.org/rfc/rfc4122.txt
    var s = [];
    var hexDigits = "0123456789abcdef";
    for (var i = 0; i < 36; i++) {
        s[i] = hexDigits.substr(Math.floor(Math.random() * 0x10), 1);
    }
    s[14] = "4"; // bits 12-15 of the time_hi_and_version field to 0010
    s[19] = hexDigits.substr((s[19] & 0x3) | 0x8, 1); // bits 6-7 of the clock_seq_hi_and_reserved to 01
    s[8] = s[13] = s[18] = s[23] = "-";

    var uuid = s.join("");
    return uuid;
}

function sendNewMessage(message='', classes = '', from = '', time = '') {
    var newMessage = message.replace(/\<div\>|\<br.*?\>/ig, '').replace(/\<\/div\>/g, '').trim().replace(/\n/g, '');

    if (!newMessage) return;

    var messagesContainer = $('.messages');
    var currDate = new Date();
    var hours = currDate.getHours();
    var minutes = currDate.getMinutes();


    if (from !== '') {
        messagesContainer.append([
            '<li class="'+classes+'">',
            '<p class="user-name mb-1">'+from+'</p>',
            '<p class="message mb-0">'+newMessage+'</p>',
            '<p class="message-time mb-0">'+hours + ':' + minutes + '</p>',
            '</li>'
            ].join(''));
    } else {
        messagesContainer.append([
            '<li class="'+classes+'">',
            '<p class="message mb-0">'+newMessage+'</p>',
            '<p class="message-time mb-0">'+hours + ':' + minutes + '</p>',
            '</li>'
            ].join(''));
    }

    

    messagesContainer.finish().animate({
        scrollTop: messagesContainer.prop("scrollHeight")
    }, 250);
}

function onMetaAndEnter(event) {
    if (event.keyCode == 13) {
        websocket_callback('new_message', '', '', $('.text-box').html(),getCookie('id'));
        // clean out old message
        $('.text-box').html('');
        // focus on input
        $('.text-box').focus();
    }
}