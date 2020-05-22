<?php 
$sqlSelect = $dbh->prepare("SELECT `FID_queue` FROM `queue_user` WHERE `FID_user` = :myID  LIMIT 6 ");
$sqlSelect->execute(array('myID' => $current_user['ID']));

foreach ($sqlSelect->fetchAll(PDO::FETCH_ASSOC) as $queue_id) :
$sqlSelect = $dbh->prepare("SELECT * FROM `queues` WHERE `ID` = :myID LIMIT 6");
$sqlSelect->execute(array('myID' => $queue_id['FID_queue']));
while ($row = $sqlSelect->fetch(PDO::FETCH_ASSOC)) : 
$author_sql = $dbh->query("SELECT `name` FROM `users` WHERE `ID` = ".$row['author_FID']);
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
                <p><?php echo $author_sql->fetch(PDO::FETCH_ASSOC)['name']; ?></p>
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
        </div>
    </div>
</div>
<?php endwhile; ?>
<?php endforeach; ?>