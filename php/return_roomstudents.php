<?php

require_once('dbconnect.php');
$link = db_connect();
$url = $_SERVER["HTTP_REFERER"];
$arr = parse_url($url);
$arr_query = convertUrlQuery($arr['query']);
$roomname=$arr_query["roomname"]."_roomstudents";
// mysqli_query($link,"update r21_roomchat set message='$roomname' where id = 2");
$sql = "SELECT * FROM $roomname";
$result = mysqli_query($link, $sql) or die('Query failed: ' . mysqli_connect_error());
$array = array("result" => array());

while ($row = mysqli_fetch_array($result)) {
    array_push($array["result"], json_encode($row));
}

echo json_encode($array);

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
?>