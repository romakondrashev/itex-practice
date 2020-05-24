<?php
// Соединяемся с БД
require '../connection.php';

function clean($value = "") {
	$value = trim($value);
	$value = stripslashes($value);
	$value = strip_tags($value);
	$value = htmlspecialchars($value);
	$value = preg_replace('/ {2,}/',' ',$value);
	
	return $value;
}

if (isset($_POST['queue_id'])) {
	$err = 0;


	$sqlSelect = $dbh->prepare("SELECT * FROM `queues` WHERE `ID` = ?");
	$sqlSelect->execute(array(
		clean($_POST['queue_id'])
	));

	$target_queue = $sqlSelect->fetch(PDO::FETCH_ASSOC);

	if ( $target_queue['author_FID'] === $current_user['ID']) {

		if ($target_queue['is_active'] === '1') { 
			$sqlSelect = $dbh->prepare("UPDATE `queues` SET `is_active` = 0 WHERE `ID` = ?");
		} elseif ($target_queue['is_active'] === '0') { 
			$sqlSelect = $dbh->prepare("UPDATE `queues` SET `is_active` = 1 WHERE `ID` = ?");
		}
		$sqlSelect->execute(array(
			clean($_POST['queue_id'])
		));

	} else {
		$err = 1;
	}


	echo $err;
}