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