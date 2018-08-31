<?php

$host = '';
$username = '';
$password = '';
$db = 'tillter';

$conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $username, $password);
if($conn->errorCode()!= null){
    die("Połączenie nieudane. Blad: " . $conn->errorInfo()[2]);
}
