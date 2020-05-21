<?php
$dsn = "mysql:host=localhost; dbname=online_queue";
$user = "root";
$pass = "";
try {
    $dbh = new PDO($dsn, $user, $pass);
    $dbh->exec('SET NAMES utf8');
} catch (PDOException $e) {
    echo "ERROR!! "."$e->getMessage()";
}