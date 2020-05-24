<?php

// Соединяемся с БД
require '../../connection.php';

function clean($value = "") {
	$value = trim($value);
	$value = stripslashes($value);
	$value = strip_tags($value);
	$value = htmlspecialchars($value);
	$value = preg_replace('/ {2,}/',' ',$value);

	return $value;
}



if(isset($_POST['submit']))
{
	$err = 0;


    // проверям данные
	if(
		empty($_POST['user_result'])      	||
		empty($_POST['description']) 		||
		empty($_POST['user_id'])      		||
		empty($_POST['queue_id'])      		||
		$_POST['user_id'] === '0'      		||
		$_POST['queue_id'] === '0'       
	)
	{
		$err = 1;
	}




    // Если нет ошибок, то меняем статус заявки
	if($err === 0)
	{

		$sqlSelect = $dbh->prepare("SELECT `author_FID` FROM `queues` WHERE `ID` = ?");
		$sqlSelect->execute(array(
			clean($_POST['queue_id'])
		));


            // Проверка на владельца очереди
		if ($sqlSelect->fetch(PDO::FETCH_ASSOC)['author_FID'] === $current_user['ID']) {
			$sqlSelect = $dbh->prepare("UPDATE `queue_user` SET `queue_status` = :status, `note` = :note WHERE FID_queue = :queue AND FID_user = :user");
			$status = '';
			if (clean($_POST['user_result']) == "dismiss") {
				$status = '0';
			} elseif (clean($_POST['user_result']) == "accept") {
				$status = '2';
			}
			$sqlSelect->execute(array(
				'status'      =>   $status,
				'note'        =>   clean($_POST['description']),   
				'queue'       =>   clean($_POST['queue_id']),   
				'user'        =>   clean($_POST['user_id'])  
			));
		} else {
			$err = 1;
		}


	}

	echo $err;
}
?>