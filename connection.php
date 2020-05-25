<?php
// Connection to database
$dsn = "mysql:host=localhost; dbname=online_queue";
$user = "root";
$pass = "";
try {
    $dbh = new PDO($dsn, $user, $pass);
    $dbh->exec('SET NAMES utf8');
} catch (PDOException $e) {
    echo "ERROR!! "."$e->getMessage()";
}

// Main url`s
$home_url           = '/online-queue';
$queue_list_url     =  $home_url . '/queue-list.php';
$queue_single_url   =  $home_url . '/queue-single.php';


// Check if the iser is loged in
$current_user = array();

if (!isset($is_auth_page)) {
	if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
	{
	    $query = $dbh->prepare("SELECT * FROM users WHERE ID = :id LIMIT 1");
	    $query->execute(array('id'=>$_COOKIE['id']));
	    $userdata = $query->fetch(PDO::FETCH_ASSOC);

	    if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['ID'] !== $_COOKIE['id'])
	 		or (($userdata['user_ip'] !== $_SERVER['REMOTE_ADDR'])  and ($userdata['user_ip'] !== "")))
	    {
	        setcookie("id", "", time() - 3600*24*30*12, "/");
	        setcookie("hash", "", time() - 3600*24*30*12, "/", null, null, true); // httponly !!!

	        
	        header("Location: $home_url/login.php?message=need-auth");
	    }
	    else
	    {
	    	$current_user = $userdata;
	    }
	}
	else
	{
	    header("Location: $home_url/login.php?message=need-auth");
	}
}



?>
