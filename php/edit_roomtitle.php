<?php
session_start();
require_once("dbconnect.php");
$link=db_connect();
$url=$_SERVER['HTTP_REFERER'];
$name=$_SESSION['username'];
$newtitle=$_POST['title'];
$info=$_POST['info'];
$sql="update all_room set roomtitle='$newtitle' where teachername='$name'";
$result=mysqli_query($link,$sql);
$sql="update all_room set info='$info' where teachername='$name'";
$result=mysqli_query($link,$sql);
header("LOCATION:$url");



?>