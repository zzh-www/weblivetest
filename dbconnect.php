<?php
function db_connect()
{
  date_default_timezone_set("Asia/Calcutta");

  $link = @mysqli_connect("gwsjwm.top", "weblive", "qweasdz")
            or die('Could not connect: ' . mysqli_connect_error());
  mysqli_query($link,"set names utf8");
  mysqli_select_db($link,"web");
  return $link;
}

?>
