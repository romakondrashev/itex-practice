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


if(isset($_POST['submit']))
{
    $err = 0;

    
    // проверям данные
    if(
        empty($_POST['title'])      ||
        empty($_POST['discipline']) ||
        empty($_POST['place'])      ||
        empty($_POST['date'])       ||
        empty($_POST['description'])
    )
    {
        $err = 1;
    }




    if($err === 0)
    {

        if ($_POST['queue_id'] !== '0') {
            $sqlSelect = $dbh->prepare("SELECT `author_FID` FROM `queues` WHERE `ID` = ?");
            $sqlSelect->execute(array(
                clean($_POST['queue_id'])
            ));


            // Проверка на владельца очереди
            if ($sqlSelect->fetch(PDO::FETCH_ASSOC)['author_FID'] === $current_user['ID']) {
                $sqlSelect = $dbh->prepare("UPDATE `queues` SET `title` = :title, `description` = :description, `discipline` = :discipline, `place` = :place,`date`=:date WHERE ID = :id");
                $sqlSelect->execute(array(
                    'id'                =>   clean($_POST['queue_id']),
                    'title'             =>   clean($_POST['title']),   
                    'description'       =>   clean($_POST['description']),   
                    'discipline'        =>   clean($_POST['discipline']),   
                    'place'             =>   clean($_POST['place']),   
                    'date'              =>   clean($_POST['date'])
                ));
            } else {
                $err = 1;
            }
        } else {

            $sqlSelect = $dbh->prepare("INSERT INTO `queues` (`author_FID`,`title`,`description`,`discipline`,`place`,`date`) VALUES (:author,:title,:description,:discipline,:place,:date)");
            $sqlSelect->execute(array(
                'author'            =>   clean($current_user['ID']),   
                'title'             =>   clean($_POST['title']),   
                'description'       =>   clean($_POST['description']),   
                'discipline'        =>   clean($_POST['discipline']),   
                'place'             =>   clean($_POST['place']),   
                'date'              =>   clean($_POST['date'])
            ));
        }


    }

    echo $err;
}
?>