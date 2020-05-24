<div id="edit_user_modal">
	<h2></h2>
	<form id="edit_user_form" name="contact" method="post">
		<div id="messages"></div>
		
		<div class="form-row " data-toggle="buttons">
			<div class="form-group col-md-6 col-sm-12 btn-group-toggle" >
				<label class="btn btn-outline-danger w-100 ">
					<input type="radio" name="user_result" value="dismiss" autocomplete="off" ><i class="fas fa-ban"></i> Отклонить
				</label>
			</div>
			<div class="form-group col-md-6 col-sm-12 btn-group-toggle" >
				<label class="btn btn-outline-success w-100 active">
					<input type="radio" name="user_result" value="accept" autocomplete="off" checked><i class="fas fa-check"></i> Принять
				</label>
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
			<input type="hidden" name="user_id" value="0">
			<input type="hidden" name="queue_id" value="<?php echo isset($_GET['queue']) ? $_GET['queue'] : 0 ?>">
		</div>
	</form>
</div>