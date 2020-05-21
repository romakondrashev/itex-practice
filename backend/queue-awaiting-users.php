<?php
require '../connection.php';


$sqlSelect = $dbh->prepare("SELECT * FROM `queue_user` WHERE `FID_queue` = ?");
$sqlSelect->execute(array($_POST['queue']));

$awaiting_users = array();

while ($row = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
	$sqlSelect_user = $dbh->query("SELECT * FROM `users` WHERE `ID` = ".$row['FID_user']);
	$awaiting_users[] = $sqlSelect_user->fetch(PDO::FETCH_ASSOC);
}

echo json_encode($awaiting_users);

