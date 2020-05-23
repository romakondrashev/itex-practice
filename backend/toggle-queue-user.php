<?php
require '../connection.php';


$sqlSelect = $dbh->prepare("SELECT COUNT(*) FROM `queue_user` WHERE `FID_queue` = ? AND `FID_user` = ?");
$sqlSelect->execute(array($_POST['queue'],$_POST['user']));

$user_exist = $sqlSelect->fetch()['COUNT(*)'];

if ($user_exist === '0') {
	$sqlSelect = $dbh->prepare("INSERT INTO `queue_user` (`FID_queue`,`FID_user`) VALUES (?,?)");
	$sqlSelect->execute(array($_POST['queue'],$_POST['user']));
	echo 1;
} else {
	$sqlSelect = $dbh->prepare("DELETE FROM `queue_user` WHERE `FID_user` = ? AND `FID_queue` = ?");
	$sqlSelect->execute(array($_POST['user'],$_POST['queue']));
	echo -1;
}

