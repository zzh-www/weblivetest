<?php

require_once('dbconnect.php');
$link = db_connect();

$sql = "SELECT * FROM all_room ORDER BY ID DESC";
$result = mysqli_query($link, $sql) or die('Query failed: ' . mysqli_connect_error());
$array = array("result" => array());

while ($row = mysqli_fetch_array($result)) {
    if($row["play"]==="200")  array_push($array["result"], json_encode($row));
}
 echo json_encode($array);
