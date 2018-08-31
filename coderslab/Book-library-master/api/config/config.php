<?php

include_once  ('../src/Book.php');

$host = "";
$username = "";
$password = "";
$db = "books";
$conn = new mysqli($host, $username, $password, $db);
if ($conn->connect_error) {
    echo "Connection failed. Error: " . $conn->connect_error;
    die;
}
$setEncodingSql = "SET CHARSET utf8";
$conn->query($setEncodingSql);
Book::$conn = $conn;
