
<style type="text/css">
	#add_queue_modal {display:none;}
</style>

<div id="add_queue_modal">
	<h2>Добавление очереди</h2>
	<form id="add_queue_form" name="contact" method="post">
		<div id="messages"></div>
		<div class="form-group">
			<label for="title">Название *</label>
			<input required="required" type="text" id="title" name="title" class="form-control">
			<small id="emailHelp" class="form-text text-muted">Например, "Лабораторная работа"</small>
		</div>
		<div class="form-row">
			<div class="form-group col-md-4 col-sm-12">
				<label for="discipline">Дисциплина *</label>
				<input required="required" type="text" id="discipline" name="discipline" class="form-control">
			</div>
			<div class="form-group col-md-4 col-sm-12">
				<label for="place">Место проведения *</label>
				<input required="required" type="text" id="place" name="place" class="form-control" >
			</div>
			<div class="form-group col-md-4 col-sm-12">
				<label for="date">Дата *</label>
				<input required="required" type="date" id="date" name="date" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label for="description">Описание *</label>
			<textarea required="required" id="description" name="description" class="form-control"></textarea>
		</div>

		<div class="form-group d-flex justify-content-end">
			<button type="reset" class="btn btn-secondary mr-2">Очистить форму</button>
			<button id="submit" class="btn btn-primary">Сохранить</button>
			<input type="hidden" name="submit">
			<input type="hidden" name="queue_id" value="0">
		</div>
	</form>
</div>


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
	function reload_queue (queue_id){
		if (confirm('Вы действительно хотите очистить очередь?')) {
			$.ajax({
				type: 'POST',
				url: '<?php echo $home_url;?>/backend/reload-queue.php',
				data: {
					'queue_id' : queue_id
				},
				success: function(error){
					if (error == '0') {
						alert('Очередь успешно очищена');
					} else {
						alert('Ошибка!');
					}
					location.reload();
				}
			})
		}
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
					if (error == '0') {
						alert('Очередь успешно удалена');
					} else {
						alert('Ошибка!');
					}
					location.reload();
				}
			})
		}
	}



</script>


<footer class="py-4 bg-light mt-auto">
	<div class="container-fluid">
		<div class="d-flex align-items-center justify-content-between small">
			<div class="text-muted">Copyright &copy; online-queue</div>
			<div>
				<a href="#">Privacy Policy</a>
				&middot;
				<a href="#">Terms &amp; Conditions</a>
			</div>
		</div>
	</div>
</footer>
</div>
</div>

</body>
</html>
