<?php 
// Предотвращение перебора паролей
sleep(3);
// Страница авторизации

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

$is_auth_page = true;
require '../../connection.php';



$output = array();
if(isset($_POST['submit']))
{
    // Вытаскиваем из БД запись
    $query = $dbh->prepare("SELECT ID, password FROM users WHERE login=:login OR email=:login LIMIT 1");
    $query->execute(array('login'=>$_POST['login']));
    $data = $query->fetch(PDO::FETCH_ASSOC);

    // Сравниваем пароли
    if(isset($data['password']) && $data['password'] === sha1($_POST['password']))
    {
        // Генерируем случайное число и шифруем его
        $hash = sha1(generateCode(10));

        if(!empty($_POST['remember_ip']))
        {
            // Если пользователя выбрал привязку к IP
            // Переводим IP в строку
            $user_ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $user_ip = '';
        }
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

        $output['redirect'] = $home_url;
    }
    else
    {
        $output['message'] = "Вы ввели неправильный логин/пароль";
    }
}
echo json_encode( $output);
?>