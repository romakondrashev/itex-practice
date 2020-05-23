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
	$queue_info['error'] = 0;


	$sqlSelect = $dbh->prepare("SELECT `author_FID` FROM `queues` WHERE `ID` = ?");
    $sqlSelect->execute(array(
        clean($_POST['queue_id'])
    ));


    // Проверка на владельца очереди
    if ($sqlSelect->fetch(PDO::FETCH_ASSOC)['author_FID'] === $current_user['ID']) {

        // Удаление очереди
    	$sqlSelect = $dbh->prepare("SELECT * FROM `queues` WHERE `ID` = ?");
	    $sqlSelect->execute(array(
	        clean($_POST['queue_id'])
	    ));

        $queue_info['queue_info'] = $sqlSelect->fetch(PDO::FETCH_ASSOC);
        $queue_info['queue_info']['date'] = date('Y-m-d',strtotime($queue_info['queue_info']['date']));
    	
    } else {
    	$queue_info['error'] = 1;
    }


    echo json_encode($queue_info);
}