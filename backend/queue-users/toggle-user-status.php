<?php
require '../../connection.php';
function clean($value = "") {
	$value = trim($value);
	$value = stripslashes($value);
	$value = strip_tags($value);
	$value = htmlspecialchars($value);
	$value = preg_replace('/ {2,}/',' ',$value);

	return $value;
}


$sqlSelect = $dbh->prepare("SELECT `is_active` FROM `queues` WHERE `ID` = ?");
$sqlSelect->execute(array($_POST['queue']));

$is_active_queue = $sqlSelect->fetch(PDO::FETCH_ASSOC)['is_active'];



$sqlSelect = $dbh->prepare("SELECT * FROM `queue_user` WHERE `FID_queue` = ? AND `FID_user` = ?");
$sqlSelect->execute(array($_POST['queue'],$current_user['ID']));

$user_exist = $sqlSelect->fetch(PDO::FETCH_ASSOC);

// Получение информации по следующим двум студентам в очереди

$select_last_users = $dbh->prepare("SELECT `FID_user` FROM `queue_user` WHERE FID_queue = :queue AND queue_status = 1 LIMIT 3");
$select_last_users->execute(array(
	'queue'       =>   clean($_POST['queue']),   
));

$latest_users = $select_last_users->fetchAll(PDO::FETCH_COLUMN);

$output = array();

if (in_array($current_user['ID'], $latest_users)) {
	$new_array = array_diff($latest_users,array($current_user['ID']));
	$output['latest_users'] = array_values($new_array);
}

/*
	1. Если пользователя раннеe не было в очереди
	2. Если пользователь ранее состоял в очереди
*/
if (empty($user_exist) && $is_active_queue === '1') {
	$sqlSelect = $dbh->prepare("INSERT INTO `queue_user` (`FID_queue`,`FID_user`) VALUES (?,?)");
	$sqlSelect->execute(array($_POST['queue'],$current_user['ID']));

	$output['status'] = 2;
}  else if ($user_exist['queue_status'] === '1' ) {
	$sqlSelect = $dbh->prepare("DELETE FROM `queue_user`  WHERE `FID_user` = ? AND `FID_queue` = ?");
	$sqlSelect->execute(array($current_user['ID'],$_POST['queue']));
	$output['status'] = 0;
}


echo json_encode($output);