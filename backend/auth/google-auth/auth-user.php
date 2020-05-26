<?php
// Функция для генерации случайной строки
function generateCode($length=6) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
	$code = "";
	$clen = strlen($chars) - 1;
	while (strlen($code) < $length) {
		$code .= $chars[mt_rand(0,$clen)];
	}
	return $code;
}
function clean($value = "") {
	$value = trim($value);
	$value = stripslashes($value);
	$value = strip_tags($value);
	$value = htmlspecialchars($value);
	
	return $value;
}






$google_name = '';
// проверям ФИО
if(!empty($last_name))
{
	$google_name .= $last_name;
	if (!empty($first_name)) {
		$google_name .= ' '.mb_substr($first_name,0,1,'UTF-8').'.';
	}
} else {
	$google_name = preg_replace('/ {2,}/',' ',$name);
}

$is_user_registering = true;
// проверям почту
if (!empty($email)) {

	// проверяем, не сущестует ли пользователя с такой почтой
	$sqlSelect = $dbh->prepare("SELECT COUNT(*) FROM `users` WHERE `email` = ?");
	$sqlSelect->execute(array($email));
	if($sqlSelect->fetch()['COUNT(*)'] > 0)
	{
		$is_user_registering = false;
	}
}









if ($is_user_registering) {
	$sqlSelect = $dbh->prepare("INSERT INTO `users` (`email`,`name`) VALUES (:email,:name)");
	$sqlSelect->execute(array(
		'email'     =>   clean($email),   
		'name'      =>   preg_replace('/ {2,}/',' ',$google_name),   
	));
} 



// Вытаскиваем из БД запись
$query = $dbh->prepare("SELECT ID, password FROM users WHERE email=? LIMIT 1");
$query->execute(array($email));
$data = $query->fetch(PDO::FETCH_ASSOC);


// Генерируем случайное число и шифруем его
$hash = sha1(generateCode(10));

$user_ip = $_SERVER['REMOTE_ADDR'];

// Записываем в БД новый хеш авторизации и IP
$query = $dbh->prepare("UPDATE users SET user_hash=:hash, user_ip=:ip WHERE ID=:ID");
$query->execute(array(
	'hash'  =>  $hash,
	'ip'  =>  $user_ip,
	'ID'  =>  $data['ID']
));

// Ставим куки на день
setcookie("id", $data['ID'], time()+60*60*24, "/");
setcookie("hash", $hash, time()+60*60*24, "/", null, null, true); // httponly !!!




?>