
<?php
ini_set("error_reporting","E_ALL & ~E_NOTICE"); 
header('Content-type:text/html;charset=utf-8');
if ($_SESSION['username']!='unset') {
	unset($_SESSION['username']);
	session_destroy();
	echo "<script type='text/javascript'>alert('注销成功！');location.href='../homepage_1.html';</script>";

}

?>
