<script>

// возвращает куки с указанным name,
// или undefined, если ничего не найдено
function getCookie(name) {
	let matches = document.cookie.match(new RegExp(
		"(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
		));
	return matches ? decodeURIComponent(matches[1]) : undefined;
}
// Websocket

const websocket_server = new WebSocket("ws://localhost:8080/");
websocket_server.onopen = function(e) {


};
websocket_server.onerror = function(e) {
	// Errorhandling
}

websocket_server.onmessage = function(e)
{
	let data = PHPUnserialize.unserialize(e.data);

	switch (data.action) {
		case 'get_queue_users' :
			if (data.notify !== '') {
				$current_user_id = getCookie('id');

				let notify_users = data.notify.split(',');
				let notify_messages = [
					'Ваша очередь уже подошла!',
					'Приготовьтесь, Вы следующий на очереди.',
				];

				for (var i = 0; i < notify_users.length; i++) {
					if (notify_users[i] === $current_user_id) {
						sendNotification('Электронная очередь ХНУРЭ', {
							body: notify_messages[i],
							icon: 'assets/img/queue.png',
							dir: 'auto'
						});
					}
				}

			}
			if ($('body').hasClass('queue-single') && $('body').data('queue-id') ===  parseInt(data.queue)) {
				get_queue_users();
			}
		break;
		case 'remove_queue' :
		case 'toggle_activation_queue' :
		case 'restore_queue' :
		case 'add_queue' :
			if ($('body').hasClass('queues-list')  ||
				$('body').hasClass('queue-single') && $('body').data('queue-id') ===  parseInt(data.queue)
				) {
				location.reload();
			}
			break;
		case 'new_message':
			if ($('#floating_chat_wrapper').html() !== '') {
				if (data.user_id === '<?php echo $current_user['ID']; ?>') {
					$('.text-box').html('');
					sendNewMessage(data.message,'self', '', data.time);
				} else {
					sendNewMessage(data.message,'other', data.user_name);
				}
			}

			
			break;
		default:
			break;
	}
}

function websocket_callback(action = '', queue = '', notify = '', message = '', user_id  = '', user_name = '<?php echo $current_user['name']; ?>'){
	// Chat settings
	$.ajax('./backend/chat/show-condition.php').done(function(data){
		let chat = $('#floating_chat_wrapper');

		if (parseInt(data) === 1 && chat.html() === '' ) {
			chat.load('./frontend/chat.php');
		} else if (parseInt(data) === 0 && chat.html() !== '' ) {
			chat.html('');
		}
	});


	websocket_server.send(JSON.stringify({
		action: action,
		queue: queue,
		notify: notify,
		message: message,
		user_id: user_id,
		user_name : user_name
	}));	

}


</script>