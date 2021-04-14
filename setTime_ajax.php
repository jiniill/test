<?php
$ht = "localhost";
$un = "ubuntu";
$pw = "bell5works";
$db = "testdb";
$pt = "3306";

$connect = mysqli_connect($ht, $un, $pw, $db, $pt) or die("실패2");

mysqli_select_db($connect, $db) or die("실패");

$sql = "INSERT INTO save_progress (type, time) VALUES ('{$_GET['type']}', '{$_GET['time']}')";

$connect->query($sql);

mysqli_close($connect);
