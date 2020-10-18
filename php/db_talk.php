<?php
require_once('linkmysql.php');
$name=$_POST['txtname'];
$msg=$_POST['msg'];
$roomid=$_GET['roomid'];

$sql="select * from '$roomid'";
$result=mysqli_query($connID,$sql);
if(!$result)
    die('WDNMD!');
$sql="insert into '$roomid' (name,message) values ('$name','$msg')";
$result=mysqli_query($connID,$sql);
if(!$result)
    die('WDNMD!');


 ?>