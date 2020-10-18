<?php
$time = 60 * 60;
date_default_timezone_set('PRC');
$dt = date("Y-m-d H:i:s");
session_set_cookie_params($time);
session_start();
//第一次登陆的时候，通过用户输入的信息来确认用户
header('Content-type: text/html;charset=utf-8');
//设置编码，防止乱码
$verifyData = file_get_contents("php://input");
//$verifyData = "{\"action\":\"on_play\",\"client_id\":105,\"ip\":\"139.71.22.215\",\"vhost\":\"__defaultVhost__\",\"app\":\"live\",\"tcUrl\":\"rtmp://ip:1935/live?user=player&pwd=123\",\"pageUrl\":\"\"}";
$obj = json_decode($verifyData);
require_once('dbconnect.php');
$link = db_connect();
$connID = $link;
$arr = parse_url($obj->tcUrl);
$arr_query = convertUrlQuery($arr['query']);
$sql = "SELECT * FROM all_teacher ORDER BY ID DESC";
$result = mysqli_query($link, $sql) or die('Query failed: ' . mysqli_connect_error());
$array = array("result" => array());
$flag = false;


if ($obj->action == "on_connect") {
    echo "0";
} else if ($obj->action == "on_close") {
    echo "0";
} else if ($obj->action == "on_publish") {
    while ($row = mysqli_fetch_array($result)) {
        if ($row["username"] == $arr_query["user"] && $row["password"] == $arr_query["pwd"]) {
            $username = $row["username"];
            $rowid = $row["id"];
            $roomname = 'r' . $rowid;
            $table = 'r' . $rowid . "_diary";
            $job = "teacher";
            $do = "on_public";
            $what = $roomname;
            $sql = "INSERT INTO $table (username,job,do,what,whendate,whentime) values ('{$username}','{$job}','{$do}','{$what}','{$dt}','{$dt}');";
            $result = mysqli_query($connID, $sql);
            mysqli_query($link, "UPDATE all_room SET play=200 WHERE teachername='$username' AND roomname='$roomname'");

            $flag = true;
            break;
        }
    }
    if ($flag == true) echo "0";
    else echo "1";
} else if ($obj->action == "on_unpublish") {
    while ($row = mysqli_fetch_array($result)) {
        # code...
        if ($row["roomname"] == $obj->stream) {
            $roomname = $row["roomname"];
            $username = $row["username"];
            $table = $roomname . "_diary";
            $job = "teacher";
            $do = "on_unpublic";
            $what = $roomname;
            $sql = "INSERT INTO $table (username,job,do,what,whendate,whentime) values ('{$username}','{$job}','{$do}','{$what}','{$dt}','{$dt}');";
            $result = mysqli_query($connID, $sql);
            mysqli_query($link, "UPDATE all_room SET play=0 WHERE roomname='$roomname'");
            break;
        }
    }
    echo "0";
} else if ($obj->action == "on_play") {

    $user = "rtmp://ip:1935/live" . $obj->param;
    $arr = parse_url($user);
    $arr_query = convertUrlQuery($arr['query']);
    $sql = "SELECT * FROM all_teacher ORDER BY ID DESC";
    $result = mysqli_query($link, $sql) or die('Query failed: ' . mysqli_connect_error());
    $array = array("result" => array());
    $job = "";
    $flag = false;
    while ($row = mysqli_fetch_array($result)) {
        if ($row["username"] == $arr_query["user"]) {
            $flag = true;
            $job = "teacher";
            $roomname = $obj->stream;
            $username = $row["username"];
            $table = $row["roomname"] . "_diary";
            $do = "on_play";
            $what = $roomname;
            $sql = "INSERT INTO $table (username,job,do,what,whendate,whentime) values ('{$username}','{$job}','{$do}','{$what}','{$dt}','{$dt}');";
            $result = mysqli_query($connID, $sql);
            mysqli_query($link, "UPDATE all_room SET studentnum=studentnum+1 WHERE roomname='$roomname'");
            // echo "0";
            break;
        }
    }
    $sql = "SELECT * FROM all_student ORDER BY ID DESC";
    $result = mysqli_query($link, $sql) or die('Query failed: ' . mysqli_connect_error());
    $array = array("result" => array());
    while ($row = mysqli_fetch_array($result)) {
        if ($row["username"] == $arr_query["user"]) {
            $flag = true;
            $job = "student";
            $username = $row["username"];
            $roomname = $obj->stream;
            $what = $roomname;
            $rstable = $roomname . "_roomstudents";
            $do = "on_play";
            $sid = 's' . $row["id"];
            $table = $sid . "_diary";
            $sql = "INSERT INTO $table (username,job,do,what,whendate,whentime) values ('{$username}','{$job}','{$do}','{$what}','{$dt}','{$dt}');";
            $result = mysqli_query($connID, $sql);
            $studentname = $row["username"];
            mysqli_query($link, "UPDATE $rstable SET onplay=200 WHERE studentname='$studentname' ");
            mysqli_query($link, "UPDATE all_room SET studentnum=studentnum+1 WHERE roomname='$roomname'");
            // echo "0";
            break;
        }
    }
    if ($flag == true) echo "0";
    else echo "1";
} else if ($obj->action == "on_stop") {
    $user = "rtmp://ip:1935/live" . $obj->param;
    $arr = parse_url($user);
    $arr_query = convertUrlQuery($arr['query']);
    $sql = "SELECT * FROM all_student ORDER BY ID DESC";
    $result = mysqli_query($link, $sql) or die('Query failed: ' . mysqli_connect_error());
    $array = array("result" => array());
    while ($row = mysqli_fetch_array($result)) {
        if ($row["username"] == $arr_query["user"]) {
            $flag = true;
            $job = "student";
            $username = $row["username"];
            $roomname = $obj->stream;
            $what = $roomname;
            $rstable = $roomname . "_roomstudents";
            $do = "on_unplay";
            $sid = 's' . $row["id"];
            $table = $sid . "_diary";
            $sql = "INSERT INTO $table (username,job,do,what,whendate,whentime) values ('{$username}','{$job}','{$do}','{$what}','{$dt}','{$dt}');";
            $result = mysqli_query($connID, $sql);
            $studentname = $row["username"];
            break;
        }
    }
    $studentname = $arr_query["user"];
    $roomname = $obj->stream;
    $rstable = $roomname . "_roomstudents";
    $results = mysqli_query($link, "UPDATE $rstable SET onplay=0 WHERE studentname='$studentname' and onplay=200 ");

    mysqli_query($link, "UPDATE all_room SET studentnum=studentnum-1 WHERE roomname='$roomname' ");

    echo "0";
} else if ($obj->action == "on_dvr") {
    echo "0";
} else {
    echo "1";
}

function convertUrlQuery($query)
{
    $queryParts = explode('&', $query);
    $params = array();
    foreach ($queryParts as $param) {
        $item = explode('=', $param);
        $params[$item[0]] = $item[1];
    }
    return $params;
}

function getUrlQuery($array_query)
{
    $tmp = array();
    foreach ($array_query as $k => $param) {
        $tmp[] = $k . '=' . $param;
    }
    $params = implode('&', $tmp);
    return $params;
}
