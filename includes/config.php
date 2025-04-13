<?php
$host = 'localhost';
$dbname = 'theatre';
$user = 'root';
$password = '';

$conn = mysqli_connect($host, $user, $password, $dbname);
if (!$conn) {
    die("Ошибка подключения: " . mysqli_connect_error());
}
?>