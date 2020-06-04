<?php 	 
require 'connection.php'; 
function clean($value = "") {
	$value = trim($value);
	$value = stripslashes($value);
	$value = strip_tags($value);
	$value = htmlspecialchars($value);
	$value = preg_replace('/ {2,}/',' ',$value);
	
	return $value;
}
// Получение ID автора очереди
$sqlSelect = $dbh->query("SELECT * FROM `queues` WHERE `ID` = ".clean($_GET['queue']));
$row = $sqlSelect->fetch(PDO::FETCH_ASSOC);


if (empty($row)) {
	header("Location: $queue_list_url");
	exit;
}
require 'common/header.php'; 


$author_sql = $dbh->query("SELECT `ID`,`name` FROM `users` WHERE `ID` = ".$row['author_FID']);
$author = $author_sql->fetch(PDO::FETCH_ASSOC);


?>
<main>
	<div class="container-fluid">
		<h1 class="mt-5">Очередь на приём работ по <?php echo $row['discipline']; ?></h1>
		<ol class="breadcrumb mb-4">
			<li class="breadcrumb-item ">
				<a href="<?php echo $home_url; ?>">
					Главная
				</a>
			</li>
			<li class="breadcrumb-item">
				<a href="<?php echo $queue_list_url; ?>">
					Список всех очередей
				</a>
			</li>
			<li class="breadcrumb-item active">Очередь на приём работ по <?php echo $row['discipline']; ?></li>
		</ol>
		<div class="row">
			<div class="col-md-12 mb-3 d-flex justify-content-end">
				<div class="actions"  style="z-index: 2" >
					<button class="btn btn-info" onclick="get_queue_users()" title="Обновить"><i class="fas fa-sync-alt"></i></button>
					<?php if ($author["ID"] === $current_user["ID"]): ?>

						<button data-fancybox href="#" data-src="#add_queue_modal" title="Отредактировать очередь" class="btn btn-primary" onclick="open_form_edit('<?php echo $row['ID']; ?>');">
							<i class="fas fa-edit"></i>
						</button>
						<button href="#" title="Очистить список ожидающих" class="btn btn-warning" onclick="restore_queue('<?php echo $row['ID']; ?>');">
							<i class="fas fa-user-slash"></i>
						</button>
						<?php if ($row['is_active']==='1'): ?>
							<button href="#" title="Приостановить очередь" class="btn btn-danger" onclick="if(confirm('Вы, действительно, хотите отключить очередь?'))toggle_activation_queue('<?php echo $row['ID']; ?>');">
								<i class="fas fa-ban"></i>
							</button>
							<?php elseif($row['is_active']==='0'): ?>
								<button href="#" title="Возобновить очередь" class="btn btn-success" onclick="if(confirm('Вы, действительно, хотите Включить очередь?'))toggle_activation_queue('<?php echo $row['ID']; ?>');">
									<i class="fas fa-check"></i>
								</button>
							<?php endif ?>
							<button href="#" title="Удалить очередь" class="btn btn-danger" onclick="remove_queue('<?php echo $row['ID']; ?>');">
								<i class="fas fa-trash-alt"></i>
							</button>
						<?php endif ?>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xl-4 col-md-6 mx-auto order-md-last">
					<div class="card bg-light text-dark mb-4">
						<div class="card-body">
							<div class="card-body-item">
								<p>Название:</p>
								<p><?php echo $row['title']; ?></p>
							</div>

							<div class="card-body-item">
								<p>Дисциплина:</p>
								<p><?php echo $row['discipline']; ?></p>
							</div>
							<div class="card-body-item">
								<p>Преподаватель:</p>
								<p><?php echo $author['name']; ?></p>
							</div>
							<div class="card-body-item">
								<p>Дата:</p>
								<p><?php echo date( "d.m.Y", strtotime($row['date'])); ?></p>
							</div>
							<div class="card-body-item">
								<p>Место:</p>
								<p><?php echo $row['place']; ?></p>
							</div>
							<div class="card-body-item">
								<p>Статус очереди:</p>
								<?php echo $row['is_active'] === '1' ? '<p class="text-success">Активна</p>' : '<p class="text-danger">Не активна</p>' ?>
							</div>

							<hr class="mt-0">
							<p class="mb-0"><?php echo $row['description']; ?></p>
						</div>

					</div>
				</div>
				<div class="nav flex-column nav-pills col-xl-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
					<a class="nav-link active" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Текущие участники</a>
					<a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Прошли очередь</a>

				</div>
				<div class="tab-content col-xl-6 col-md-6 col-sm-12 mx-auto" id="v-pills-tabContent">
					<div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
						<h2 class="text-center awaiting-users-title">Список ожидающих</h2>


						<div id="awaiting-users-wrapp"><!-- Inserting queue students --></div>

						<div id="queue_button_wrapper" class="queue_button_wrapper text-center"><!-- Inserting toggle button --></div>
					</div>
					<div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
						<h2 class="text-center awaiting-users-title">Успешно прошли очередь</h2>
						<div id="success-users-wrapp"><!-- Inserting queue students --></div>
					</div>
				</div>
				

			</div>
		</div>
	</main>



	<script>
		window.onload = function() {
			get_queue_users();

		};
		function queue_button_handler(){
			if (confirm('Уверены?')) {
				toggle_queue_stand(this);
			}
		}


		function get_user_card (user_info, classes = '', arrow = 'up') {
			let current_user_text = '';
			let output = '';

			if (user_info['current_user'] === 1 ) {
				classes = 'border border-primary';
				current_user_text = '(я) ';
			} 

			<?php if ($author["ID"] === $current_user["ID"]): ?>
				output += '<a onclick="edit_user_click('+user_info['ID']+', \' '+user_info['name']+'\');" data-fancybox href="javascript:;" data-src="#edit_user_modal"  class="modalbox">';
			<?php endif; ?>

			output += '<div class="card bg-light text-dark '+classes+'"><div class="card-body awaiting-user-info text-center">';

			if (user_info['curse'] !== '0' && user_info['curse'] !== '') {
				output += '<span>'+user_info['curse']+' курс</span>';
			} else {
				output += '<span></span>';
			}
			output += '<span>'+current_user_text + user_info['name']+'</span>';
			output += '<span>'+user_info['from_group']+'</span>';

			output +='</div>';

			if (user_info['note'] !== '') 
				output += '<hr class="mt-0"><p class="col-md-12"><b>Комментарий преподавателя:</b> '+user_info['note']+'</p>';

			output += '</div>';

			<?php if ($author["ID"] === $current_user["ID"]): ?>
				output += '</a>';
			<?php endif; ?>

			output += '<div class="text-center my-2 "><i class="fas fa-chevron-'+arrow+'"></i></div>';

			return output;
		}

		function get_toggle_queue_button(is_standing = false) {
			let output = '';

			if (is_standing) {
				output += '<button id="queue_button" type="button" class="btn  btn-danger my-4 w-auto mx-auto " style="padding: 10px" onclick="queue_button_handler()">Покинуть очередь</button>';
			} else {
				output += '<button id="queue_button" type="button" class="btn  btn-success my-4 w-auto mx-auto " style="padding: 10px" onclick="queue_button_handler()">Встать в очередь</button>';
			}

			return output;
		}

		function get_queue_users () {
			$.ajax({
				type: 'POST',
				dataType: 'json',
				data: {
					'queue' : '<?php echo $_GET['queue']; ?>'
				},
				url: 'backend/queue-users/queue-users.php',
				beforeSend: function(){
					$('#awaiting-users-wrapp, #success-users-wrapp, #abort-users-wrapp').html('<p class="text-center">Загрузка данных...</p>');
					$('#queue_button').hide();
				},
				success: function(data) {

					let output = '',
					is_current_user_done = false,
					is_current_user_awaiting = false,
					is_author_of_queue = <?php echo $author["ID"] === $current_user["ID"] ? 'true' : 'false'; ?>,
					is_active_queue = <?php echo $row['is_active'] === '1' ? 'true' : 'false'; ?>;

					// awaiting users
					if (data['awaiting']) {
						for (var i = 0; i < data['awaiting'].length; i++) {
							output += get_user_card(data['awaiting'][i]);
							if (data['awaiting'][i].ID === '<?php echo $current_user['ID']; ?>') 
							is_current_user_awaiting = true;
						}
					} else {
						output = '<p class="text-center">Список пуст.</p>';
					}
					$('#awaiting-users-wrapp').html(output);
					


					output = '';

					// success users
					if (data['success']) {
						for (var i = data['success'].length-1; i >= 0; i--) {
							output += get_user_card(data['success'][i], 'border border-success', 'down');
							if (data['success'][i].ID === '<?php echo $current_user['ID']; ?>') 
							is_current_user_done = true;
						}
					} else {
						output = '<p class="text-center">Список пуст.</p>';
					}
					$('#success-users-wrapp').html(output);

					if (!is_author_of_queue) {
						// Пользователь ожидает в очереди
						if (!is_current_user_done && is_current_user_awaiting) 
							$('#queue_button_wrapper').html(get_toggle_queue_button(true));
						// Пользователя нет в очереди
						else if (!is_current_user_done && !is_current_user_awaiting && is_active_queue)
							$('#queue_button_wrapper').html(get_toggle_queue_button());
					}


				}
			})
		}
		function toggle_queue_stand(button){
			$.ajax({
				type: 'POST',
				data: {
					'queue' : '<?php echo $_GET['queue']; ?>'
				},
				dataType: 'json',
				url: 'backend/queue-users/toggle-user-status.php',
				success: function(data) {
					if(!!data.latest_users)
						websocket_callback('get_queue_users', $('body').data('queue-id'), data.latest_users.join(','));
					else
						websocket_callback('get_queue_users', $('body').data('queue-id'));
				}

			})
		}



	</script>

	<?php require 'common/footer.php'; ?>