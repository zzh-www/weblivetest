<?php
session_start();
require_once('dbconnect.php');
$link = db_connect();
date_default_timezone_set('PRC');
$title = $_GET["titlemsg"];
$class = $_GET["classmsg"];
$text = $_GET["textmsg"];
echo $text;
$user = $_SESSION["username"];
$url = $_SERVER["HTTP_REFERER"];
$arr = parse_url($url);
$arr_query = convertUrlQuery($arr['query']);
$roomname = $arr_query["roomname"];
if ($title != null) {
    # code...

    $sql = "update all_room set roomtitle='$title' where roomname='$roomname'";
    $result = mysqli_query($link, $sql);
}
if ($class != null) {
    # code...
    $sql = "update all_teacher set class='$class' where roomname='$roomname'";
    $result = mysqli_query($link, $sql);
}
if ($text != null) {
    $sql = "update all_teacher set secrettext='$text' where roomname='$roomname'";
    $result = mysqli_query($link, $sql);
}

if (!$result) {
    exit;
}
echo "1";
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
