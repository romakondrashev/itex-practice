<?php 

// Выбор всех очередей по ID, в которых присутствует текущий пользователь
if (isset($limit)) {
    $post_count = $limit;
    $sqlSelect = $dbh->prepare("SELECT queues.ID,`title`,`description`,`author_FID`,`discipline`,`place`,`date` FROM `queues`,`queue_user` WHERE queues.ID = queue_user.FID_queue and queue_user.FID_user = :myID LIMIT ".$limit);
} else {
    $post_count = -1;
     $sqlSelect = $dbh->prepare("SELECT queues.ID,`title`,`description`,`author_FID`,`discipline`,`place`,`date` FROM `queues`,`queue_user` WHERE queues.ID = queue_user.FID_queue and queue_user.FID_user = :myID ");
}


$sqlSelect->execute(array('myID' => $current_user['ID']));
$queues_info = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);

if (!empty($queues_info)) :
// Цикл по всем очередям, в которых есть текущий юзер
foreach ($queues_info as $index => $queue_info) :
$index++;


$author_sql = $dbh->query("SELECT `name` FROM `users` WHERE `ID` = ".$queue_info['author_FID']);

?>
<div class="col-xl-4 col-md-6">
    <div class="card bg-light text-dark mb-4">
        <div class="card-body">
            <div class="card-body-item">
                <p>Название:</p>
                <p><?php echo $queue_info['title']; ?></p>
            </div>

            <div class="card-body-item">
                <p>Дисциплина:</p>
                <p><?php echo $queue_info['discipline']; ?></p>
            </div>
            <div class="card-body-item">
                <p>Преподаватель:</p>
                <p><?php echo $author_sql->fetch(PDO::FETCH_ASSOC)['name']; ?></p>
            </div>
            <div class="card-body-item">
                <p>Дата:</p>
                <p><?php echo date( "d.m.Y", strtotime($queue_info['date'])); ?></p>
            </div>
            <div class="card-body-item">
                <p>Место:</p>
                <p><?php echo $queue_info['place']; ?></p>
            </div>
            <hr>
            <p><?php echo $queue_info['description']; ?></p>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <a class="small text-dark stretched-link" href="<?php echo $queue_single_url.'?queue='.$queue_info['ID']; ?>">Подробнее</a>
            <div class="small text-dark"><i class="fas fa-angle-right"></i></div>
        </div>
    </div>
</div>
<?php if ($index === $post_count): ?>
    <div class="col-md-12 text-center">
        <a href="#" class="btn btn-primary small">Показать все</a>
    </div>
<?php endif ?>
<?php endforeach; ?>

<?php else: ?>
    
    <div class="col-xl-4 col-md-6 mx-auto text-center">
        <p>Похоже, что Вы не состоите в очередях.</p>
        <a href="<?php echo $home_url; ?>/queue-list.php" class="btn btn-primary small">Показать все</a>
    </div>  

<?php endif; ?>