<?php 	 require 'connection.php'; 
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

// Проверка на наличие текущего пользователя в очереди
$sqlCount = $dbh->prepare("SELECT COUNT(*) FROM `queue_user` WHERE `FID_queue` = ? AND `FID_user` = ?");
$sqlCount->execute(array($_GET['queue'],$current_user['ID']));

$user_exist = $sqlCount->fetch()['COUNT(*)'];


?>
<main>
	<div class="container-fluid">
		<h1 class="mt-4">Очередь на приём работ по <?php echo $row['discipline']; ?></h1>
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
			<div class="col-md-12 d-flex justify-content-end">
				
				<?php if ($author["ID"] === $current_user["ID"]): ?>
					<div class="actions"  style="z-index: 2" >
						<button data-fancybox href="#" data-src="#add_queue_modal" title="Отредактировать очередь" class="btn btn-primary" onclick="open_form_edit('<?php echo $row['ID']; ?>');">
							<i class="fas fa-edit"></i>
						</button>
						<button href="#" title="Обновить список ожидающих" class="btn btn-warning" onclick="reload_queue('<?php echo $row['ID']; ?>');">
							<i class="fas fa-sync-alt"></i> 
						</button>
						<button href="#" title="Удалить очередь" class="btn btn-danger" onclick="remove_queue('<?php echo $row['ID']; ?>');">
							<i class="fas fa-trash-alt"></i>
						</button>
					</div>
				<?php endif ?>
			</div>
		</div>
		<div class="row">
			
			<div class="col-xl-4 col-md-6 mx-auto">
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
						<hr>
						<p><?php echo $row['description']; ?></p>
					</div>
					
				</div>
			</div>
			
		</div>
		<div class="row">
			<div class="col-xl-4 col-md-6 col-sm-12 mx-auto">
				<h2 class="text-center awaiting-users-title">Список ожидающих</h2>
				<button class="btn btn-primary" onclick="get_awaiting_users()"><i class="fas fa-sync-alt"></i></button>
				<div id="card-single-wrapper">
					
				</div>
				<?php if ($user_exist): ?>
					<button id="queue_button" type="button" class="btn  btn-block btn-outline-danger my-4" style="padding: 10px">Выйти из очереди</button>
					<?php else: ?>
						<button id="queue_button" type="button" class="btn  btn-block btn-outline-success my-4" style="padding: 10px">Встать в очередь</button>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</main>



	<script>


		function get_awaiting_users () {
			$.ajax({
				type: 'POST',
				dataType: 'json',
				data: {
					'queue' : '<?php echo $_GET['queue']; ?>'
				},
				url: 'backend/queue-awaiting-users.php',
				beforeSend: function(){
					$('#card-single-wrapper').html('<p class="text-center">Загрузка данных...</p>');
					$('#queue_button').hide();
				},
				success: function(data) {
					var output = '';
					for (var i = 0; i < data.length; i++) {
						output += '<div class="card bg-light text-dark my-4"><div class="card-body awaiting-user-info text-center">';

						if (data[i]['curse'] !== '0' && data[i]['curse'] !== '') {
							output += '<span>'+data[i]['curse']+' курс</span>';
						} else {
							output += '<span></span>';
						}
						output += '<span>'+data[i]['name']+'</span>';
						output += '<span>'+data[i]['from_group']+'</span>';

						output +='</div></div>';

						output += '<div class="text-center"><i class="fas fa-chevron-up"></i></div>';
					}


					$('#card-single-wrapper').html(output);
					$('#queue_button').show();
				}

			})
		}
		function toggle_queue_stand(){
			$.ajax({
				type: 'POST',
				data: {
					'queue' : '<?php echo $_GET['queue']; ?>',
					'user'	: '<?php echo $current_user['ID']; ?>'
				},
				url: 'backend/toggle-queue-user.php',
				success: function(data) {
					if (data === '1') {
						$('#queue_button').toggleClass('btn-outline-success').toggleClass('btn-outline-danger');
						$('#queue_button').text('Выйти из очереди');
					} else {
						$('#queue_button').toggleClass('btn-outline-success').toggleClass('btn-outline-danger');
						$('#queue_button').text('Встать в очередь');
					}
					get_awaiting_users();
				}

			})
		}
		window.onload = function() {
			get_awaiting_users();


			$('#queue_button').on('click', function(){
				if (confirm('Уверены?')) {
					toggle_queue_stand();
				}
			})
		};
	</script>

	<?php require 'common/footer.php'; ?>