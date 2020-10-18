<?php
session_start();
require_once("dbconnect.php");
$link=db_connect();
$name=$_SESSION['username'];
$sql="select * from all_teacher where username='$name'";
$result=mysqli_query($link,$sql);
$row=mysqli_fetch_array($result);
$roomname=$row['roomname'];
$sql="select COUNT(studentname) as num from $roomname"."_roomstudents";
$result=mysqli_query($link,$sql);
$row=mysqli_fetch_array($result);
$sql="select * from all_room where roomname='$roomname'";
$result=mysqli_query($link,$sql);
$room_array=mysqli_fetch_array($result);
$viewnow=$room_array['studentnum'];
$total_st=$row['num'];
$absent=$total_st-$viewnow;
echo $total_st.'|'.$viewnow.'|'.$viewnow.'|'.$absent;
?>
