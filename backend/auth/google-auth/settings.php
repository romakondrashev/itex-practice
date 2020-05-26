<?php
require_once './vendor/autoload.php';
 
// init configuration
$clientID = '274220663243-vck8qp4r8lurranhim45i0648qovas0n.apps.googleusercontent.com';
$clientSecret = 'HrSdyw0NJlXBjsjmAJ8h04Uz';
$redirectUri = 'http://localhost/online-queue/index.php';
 
// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");