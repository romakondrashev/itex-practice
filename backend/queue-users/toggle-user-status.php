<?php
require '../../connection.php';

$sqlSelect = $dbh->prepare("SELECT `is_active` FROM `queues` WHERE `ID` = ?");
$sqlSelect->execute(array($_POST['queue']));

$is_active_queue = $sqlSelect->fetch(PDO::FETCH_ASSOC)['is_active'];



$sqlSelect = $dbh->prepare("SELECT * FROM `queue_user` WHERE `FID_queue` = ? AND `FID_user` = ?");
$sqlSelect->execute(array($_POST['queue'],$current_user['ID']));

$user_exist = $sqlSelect->fetch(PDO::FETCH_ASSOC);



/*
	1. Если пользователя раннеe не было в очереди
	2. Если пользователь ранее отклонял очередь
	3. Если пользователь ранее состоял в очереди
*/
if (empty($user_exist) && $is_active_queue === '1') {
	$sqlSelect = $dbh->prepare("INSERT INTO `queue_user` (`FID_queue`,`FID_user`) VALUES (?,?)");
	$sqlSelect->execute(array($_POST['queue'],$current_user['ID']));
	echo 2;
} else if ($user_exist['queue_status'] === '0' && $is_active_queue === '1') {
	$sqlSelect = $dbh->prepare("UPDATE `queue_user` SET `queue_status` = 1 WHERE `FID_user` = ? AND `FID_queue` = ?");
	$sqlSelect->execute(array($current_user['ID'],$_POST['queue']));
	echo 1;
} else if ($user_exist['queue_status'] === '1' ) {
	$sqlSelect = $dbh->prepare("UPDATE `queue_user` SET `queue_status` = 0 WHERE `FID_user` = ? AND `FID_queue` = ?");
	$sqlSelect->execute(array($current_user['ID'],$_POST['queue']));
	echo 0;
}

