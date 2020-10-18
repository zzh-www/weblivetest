<?php
session_start();
    if($_SESSION['username']=='unset'){
			echo '不能登陆';
		    exit();
		}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>登录成功</title>
    <link rel="stylesheet" type="text/css" media="screen" href="welcome.css">
</head>
<body>
    <div id="Landingsuccessfully">
    <h1>Landingsuccessfully</h1>
    <a class="qqx" href="end.php">Please cancel</a><!-- 请取消 -->
</body>
</html>
