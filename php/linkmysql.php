



<?php
header("Content-type: text/html; charset=utf-8");
$host = "47.93.8.184";
$userName = "weblive";
$password = "qweasdz";
$connID = mysqli_connect($host, $userName, $password) or die("数据库连接失败");//没问题
mysqli_select_db($connID,"web") or  die("指定的数据库不能打开");//没问题
mysqli_query($connID,"set names utf8");//没问题

?>
