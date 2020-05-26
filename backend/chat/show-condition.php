<?php
require '../../connection.php';
// Author queues
$author_queues_count = $dbh->prepare('SELECT COUNT(*) FROM `queues` WHERE `author_FID` = ? and `is_active` = 1');
$author_queues_count->execute(array($current_user['ID']));
$author_queues_count = $author_queues_count->fetch()['COUNT(*)'];

// Awaiting queues
$my_awaiting_queues_count = $dbh->prepare('SELECT COUNT(*) FROM `queue_user`, `queues` WHERE queue_user.FID_user = ? and queue_user.FID_queue = queues.ID and queues.is_active = 1 and queue_user.queue_status = 1 ');
$my_awaiting_queues_count->execute(array($current_user['ID']));
$my_awaiting_queues_count = $my_awaiting_queues_count->fetch()['COUNT(*)'];


if ((int)$author_queues_count === 0 && (int)$my_awaiting_queues_count > 0){
	echo 1;
} else {
	echo 0;
}