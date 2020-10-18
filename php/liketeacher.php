<?php
session_start();
require_once('dbconnect.php');
$link = db_connect();
$user = $_SESSION["username"];
$range = $_SESSION['job'];
$text = $_GET["teachertext"];
$sql = "SELECT * FROM all_teacher where secrettext='$text'";
$result = mysqli_query($link, $sql) or die('Query failed: ' . mysqli_connect_error());;
$row = mysqli_fetch_array($result);
$teachername = $row["username"];
$roomname = $row["roomname"];
// $teacherarry = explode("&", "syp&syp&");
// echo $teacherarry[1];
$sql = "SELECT * FROM all_student where username='$user'";
$result = mysqli_query($link, $sql) or die('Query failed: ' . mysqli_connect_error());;
$row = mysqli_fetch_array($result);
$teachers = $row["teachers"];
$teacherarry = explode("&", $teachers);
$flag = true;
for ($i = 0; $i < sizeof($teacherarry); $i++) {
    # code...
    if ($teacherarry[$i] == $teachername) {
        # code...
        $flag = false;
    }
}


if ($flag == true) {
    $sql = "update all_$range set teachers=CONCAT(teachers,'$teachername','&') where username='$user'";
    $result = mysqli_query($link, $sql);
    mysqli_query($link, "insert into $roomname" . "_roomstudents(studentname,onplay) values('$user',0)");
}
