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

			// Получение информации по следующим двум студентам в очереди

			$select_last_users = $dbh->prepare("SELECT `FID_user` FROM `queue_user` WHERE FID_queue = :queue AND queue_status = 1 LIMIT 3");
			$select_last_users->execute(array(
				'queue'       =>   clean($_POST['queue_id']),   
			));

			$latest_users = $select_last_users->fetchAll(PDO::FETCH_COLUMN);

			$output = array();
			if (in_array((string)clean($_POST['user_id']), $latest_users)) {
				$new_array = array_diff($latest_users,array((string)clean($_POST['user_id'])));
				$output['data'] = array_values($new_array);
			} else {
				$output['data'] = '';
			}

			// Обновление статуса студента в очереди
			if (clean($_POST['user_result']) == "dismiss") {
				$update_queue_user = $dbh->prepare("DELETE FROM `queue_user` WHERE FID_queue = :queue AND FID_user = :user");
				$update_queue_user->execute(array(
					'queue'       =>   clean($_POST['queue_id']),   
					'user'        =>   clean($_POST['user_id'])  
				));
			} elseif (clean($_POST['user_result']) == "accept") {
				$update_queue_user = $dbh->prepare("UPDATE `queue_user` SET `queue_status` = 2, `note` = :note WHERE FID_queue = :queue AND FID_user = :user");
				$update_queue_user->execute(array(
					'note'        =>   clean($_POST['description']),   
					'queue'       =>   clean($_POST['queue_id']),   
					'user'        =>   clean($_POST['user_id'])  
				));
			}

			echo json_encode($output);


		} else {
			$err = 1;
		}

	}

}
?>