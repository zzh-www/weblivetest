<?php
session_start();
require_once('dbconnect.php');
$link = db_connect();
date_default_timezone_set('PRC');
$msg = $_GET["msg"];
$dt = date("Y-m-d H:i:s");
$user = $_SESSION["username"];
echo ($dt);
$url = $_SERVER["HTTP_REFERER"];
$arr = parse_url($url);
$arr_query = convertUrlQuery($arr['query']);
$roomname=$arr_query["roomname"];
$sql = "insert into $roomname"."_roomchat(studentname,whendate,whentime,message) values('{$user}','{$dt}','{$dt}','{$msg}')";
$result = mysqli_query($link, $sql);
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
