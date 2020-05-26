<?php
require '../../connection.php';


sleep(1);

$sqlSelect = $dbh->prepare("SELECT * FROM `queue_user` WHERE `FID_queue` = ? ");
$sqlSelect->execute(array($_POST['queue']));

$queue_users = array();

// Цикл по пользователям текущей очереди
while ($row = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
	$user_type = '';
	if ($row['queue_status'] === '1') {
		$user_type = 'awaiting';
	} elseif($row['queue_status'] === '2') {
		$user_type = 'success';
	} 
	$sqlSelect_user = $dbh->query("SELECT `ID`,`curse`,`from_group`,`name` FROM `users` WHERE `ID` = ".$row['FID_user']);
	$queue_users[$user_type][] = $sqlSelect_user->fetch(PDO::FETCH_ASSOC);

	$last_key = array_key_last ( $queue_users[$user_type] );
	$queue_users[$user_type][$last_key]['current_user'] = $current_user['ID'] === $queue_users[$user_type][$last_key]['ID'] ? 1 : 0;
	$queue_users[$user_type][$last_key]['note']			= $row['note'];

	
}
echo json_encode($queue_users);

