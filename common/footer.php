<!-- Добавление новой очереди -->
<?php require 'frontend/forms/add-queue-modal.php'; ?>
<!-- Проверка студента в очереди -->
<?php require 'frontend/forms/edit-user-modal.php'; ?>
<!-- Блок вывода чата -->
<div id="floating_chat_wrapper"></div>


<script src="<?php echo $home_url; ?>/assets/js/footer-scripts.js"></script>

<script>

	function open_form_edit (queue_id){
		$.ajax({
			type: 'POST',
			url: '<?php echo $home_url;?>/backend/edit-queue.php',
			data: {
				'queue_id' : queue_id
			},
			dataType: 'json',
			success: function(data){
				if (data.error === 0) {
					$('#add_queue_modal h2').text('Редактирование очереди');
					$('#add_queue_modal [type="submit"]').text('Отредактировать очередь');
					$('#add_queue_modal form #title').val(data.queue_info.title);
					$('#add_queue_modal form #discipline').val(data.queue_info.discipline);
					$('#add_queue_modal form #place').val(data.queue_info.place);
					$('#add_queue_modal form #date').val(data.queue_info.date);
					$('#add_queue_modal form #description').val(data.queue_info.description);

					$('#add_queue_modal form [name="queue_id"]').val(queue_id);


				} else {
					alert('Ошибка!');
				}

			}
		})
	}
	function restore_queue (queue_id){
		if (confirm('Вы действительно хотите очистить очередь?')) {
			$.ajax({
				type: 'POST',
				url: '<?php echo $home_url;?>/backend/reload-queue.php',
				data: {
					'queue_id' : queue_id
				},
				success: function(error){
					if (error !== '0') {
						alert('Ошибка!');
					} else {
						websocket_callback('restore_queue', $('body').data('queue-id'));
					}
				}
			})
		}
	}
	function toggle_activation_queue (queue_id){
		$.ajax({
			type: 'POST',
			url: '<?php echo $home_url;?>/backend/activation-queue.php',
			data: {
				'queue_id' : queue_id
			},
			success: function(error){
				if (error == '1') {
					alert('Ошибка!');
				} else {
					websocket_callback('toggle_activation_queue', $('body').data('queue-id'));
				}

			}
		})
	}
	function remove_queue (queue_id){
		if (confirm('Вы действительно хотите удалить очередь?')) {
			$.ajax({
				type: 'POST',
				url: '<?php echo $home_url;?>/backend/remove-queue.php',
				data: {
					'queue_id' : queue_id
				},
				success: function(error){
					if (error !== '0') {
						alert('Ошибка!');
					} else {
						websocket_callback('remove_queue', $('body').data('queue-id'));
					}
				}
			})
		}
	}



</script>


<footer class="py-4 bg-light mt-auto">
	<div class="container-fluid">
		<div class="d-flex align-items-center justify-content-between small">
			<div class="text-muted">Copyright &copy; Online-Queue 2020</div>
			<div>
				<a href="<?php echo $home_url; ?>/MediaWiki">Документация MediaWiki</a>
			</div>
		</div>
	</div>
</footer>
</div>
</div>



</body>
</html>
