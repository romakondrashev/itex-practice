<?php
// Страница регистрации нового пользователя
sleep(3);
// Соединямся с БД
$is_auth_page = true;
require '../../connection.php';

function clean($value = "") {
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
    
    return $value;
}



if(isset($_POST['submit']))
{
    $err = [];

    
    // проверям ФИО
    if(!preg_match("/^\D+ [А-ЯA-Z].[А-ЯA-Z].$/u",$_POST['surname']))
    {
        $err[] = "ФИО не соответствует шаблону - Кондрашёв Р.А.";
    }


    // проверям логин
    if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
    {
        $err[] = "Логин может состоять только из букв английского алфавита и цифр";
    }

    if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
    {
        $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
    }

    // проверяем, не сущестует ли пользователя с таким именем
    $sqlSelect = $dbh->prepare("SELECT COUNT(*) FROM `users` WHERE `login` = ?");
    $sqlSelect->execute(array($_POST['login']));
    if($sqlSelect->fetch()['COUNT(*)'] > 0)
    {
        $err[] = "Пользователь с таким логином уже существует в базе данных";
    }


    if (!empty($_POST['email'])) {
        // проверям почту
        if(!preg_match("/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/",$_POST['email']))
        {
            $err[] = "Неправильный ввод почты";
        }

        if(strlen($_POST['email']) < 5 or strlen($_POST['email']) > 30)
        {
            $err[] = "Почта должна быть не меньше 3-х символов и не больше 30";
        }

        // проверяем, не сущестует ли пользователя с такой почтой
        $sqlSelect = $dbh->prepare("SELECT COUNT(*) FROM `users` WHERE `email` = ?");
        $sqlSelect->execute(array($_POST['email']));
        if($sqlSelect->fetch()['COUNT(*)'] > 0)
        {
            $err[] = "Пользователь с такой почтой уже существует в базе данных";
        }
    }




    // проверяем пароль
    if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['password']))
    {
        $err[] = "Пароль может состоять только из букв английского алфавита и цифр";
    }

    if(strlen($_POST['password']) < 6 or strlen($_POST['password']) > 30)
    {
        $err[] = "Пароль должен быть не меньше 6-ти символов и не больше 15";
    }

    if ($_POST['password'] !== $_POST['confirm-password']) {
        $err[] = "Пароли не совпадают";
    }


    if (!empty($_POST['curse'])) {
        // проверяем курс
        if(!preg_match("/^[1-6]$/",$_POST['curse']))
        {
            $err[] = "Ошибка ввода курса";
        }
    }

   






    // Если нет ошибок, то добавляем в БД нового пользователя
    if(count($err) == 0)
    {


        // Убераем лишние пробелы и делаем двойное хеширование
        $password = sha1(trim($_POST['password']));


        $sqlSelect = $dbh->prepare("INSERT INTO `users` (`login`,`password`,`email`,`name`,`curse`,`from_group`) VALUES (:login,:pass,:email,:name,:curse,:group)");
        $sqlSelect->execute(array(
            'login'     =>   clean($_POST['login']),   
            'pass'      =>   clean($password),   
            'email'     =>   clean($_POST['email']),   
            'name'      =>   preg_replace('/ {2,}/',' ',$_POST['surname']),   
            'curse'     =>   $_POST['curse'],   
            'group'     =>   clean($_POST['group']),   
        ));

        header("Location: login.php?message=register-success"); exit();
    }
    else
    {
        echo json_encode($err);
    }
}
?>