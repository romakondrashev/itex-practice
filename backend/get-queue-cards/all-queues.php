<?php 
$sqlSelect = $dbh->query("SELECT * FROM `queues` ORDER BY ID DESC");

$counter = 1;
while ($row = $sqlSelect->fetch(PDO::FETCH_ASSOC)) :
$author_sql = $dbh->query("SELECT `ID`, `name` FROM `users` WHERE `ID` = ".$row['author_FID']);
$author 	= $author_sql->fetch(PDO::FETCH_ASSOC);
?>
<div class="col-xl-4 col-md-6">
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
		<div class="card-footer d-flex align-items-center justify-content-between">
			<a class="small text-dark stretched-link" href="<?php echo $queue_single_url.'?queue='.$row['ID']; ?>">Подробнее</a>
			<div class="small text-dark"><i class="fas fa-angle-right"></i></div>
			<?php if ($author["ID"] === $current_user["ID"]): ?>
				<div class="actions"  style="z-index: 2">
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
</div>
<?php $counter++;endwhile; ?>


<?php if ($counter === 1): ?>
    <div class="col-xl-4 col-md-6 mx-auto text-center">
        <p>Похоже, что в системе нет созданных очередей.</p>
        <a href="<?php echo $home_url; ?>/queue-list.php" class="btn btn-primary small">Создать</a>
    </div>  
<?php endif ?>