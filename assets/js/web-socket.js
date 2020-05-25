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
	let arrayOfData = e.data.split(' ');

	switch (arrayOfData[0]) {
		case 'get_queue_users' :
			if (arrayOfData[2] !== '') {
				$current_user_id = getCookie('id');

				let notify_users = arrayOfData[2].split(',');
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
			if ($('body').hasClass('queue-single') && $('body').data('queue-id') ===  parseInt(arrayOfData[1])) {
				get_queue_users();
			}
		break;
		case 'remove_queue' :
		case 'toggle_activation_queue' :
		case 'restore_queue' :
		case 'add_queue' :
		if ($('body').hasClass('queues-list')  ||
			$('body').hasClass('queue-single') && $('body').data('queue-id') ===  parseInt(arrayOfData[1])
			) {
			location.reload();
	}
	break;
	default:
	break;
}
}

function websocket_callback(action = '', queue = '', notify = ''){

	
	websocket_server.send(action+' '+queue+' '+notify);	
}