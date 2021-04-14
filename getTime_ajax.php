<?php
$ht = "localhost";
$un = "ubuntu";
$pw = "bell5works";
$db = "testdb";
$pt = "3306";

$connect = mysqli_connect($ht, $un, $pw, $db, $pt) or die("실패2");

mysqli_select_db($connect, $db) or die("실패");

$sql = "SELECT time FROM save_progress WHERE idx = (SELECT max(idx) FROM save_progress)";
$result = $connect->query($sql);
$res = $result->fetch_assoc();

echo $res['time'];

mysqli_close($connect);
