<?php
session_start();
require_once('dbconnect.php');
$link = db_connect();
$range=$_SESSION['job'];
$name=$_SESSION['username'];
$sql = "SELECT * FROM all_$range where username='$name'";
$result = mysqli_query($link, $sql) or die('Query failed: ' . mysqli_connect_error());
$array = array("result" => array());

$row = mysqli_fetch_array($result);
array_push($array["result"], json_encode($row));

 echo json_encode($array);
 ?>