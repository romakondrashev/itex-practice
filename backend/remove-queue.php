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


	$sqlSelect = $dbh->prepare("SELECT `author_FID` FROM `queues` WHERE `ID` = ?");
    $sqlSelect->execute(array(
        clean($_POST['queue_id'])
    ));

    // Проверка на владельца очереди
    if ($sqlSelect->fetch(PDO::FETCH_ASSOC)['author_FID'] === $current_user['ID']) {

        // Удаление очереди
    	$sqlSelect = $dbh->prepare("DELETE FROM `queues` WHERE `ID` = ?");
	    $sqlSelect->execute(array(
	        clean($_POST['queue_id'])
	    ));

        // Удаление связей между ожидающими очереди и самой очередью
        $sqlSelect = $dbh->prepare("DELETE FROM `queue_user` WHERE `FID_queue` = ?");
        $sqlSelect->execute(array(
            clean($_POST['queue_id'])
        ));
    	
    } else {
    	$err = 1;
    }


    echo $err;
}