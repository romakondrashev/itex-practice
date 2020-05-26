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


// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
	// Google auth
	$is_auth_page = true;
	require_once 'backend/auth/google-auth/settings.php';
	$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
	$client->setAccessToken($token['access_token']);

  	// get profile info
	$google_oauth = new Google_Service_Oauth2($client);
	$google_account_info = $google_oauth->userinfo->get();

	$email =  $google_account_info->email;
	$name =  $google_account_info->name;
	$last_name =  $google_account_info->familyName;
	$first_name =  $google_account_info->givenName;

	require 'backend/auth/google-auth/auth-user.php';
	header("Location: $home_url/index.php");
	
} 

// Check if the user is loged in
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
