<?php



$time=60 * 60;
session_set_cookie_params($time);
session_start();
//第一次登陆的时候，通过用户输入的信息来确认用户
header('Content-type: text/html;charset=utf-8');
//设置编码，防止乱码
require_once("dbconnect.php");
$connID=db_connect();
$_SESSION['username']='unset';
$range=$_POST['range'];
$_SESSION['job']=$range;
if($_SESSION['username']==$_POST['username']){
	header('Location:../../../homepage_2.html');
}
else
if ( ( $_POST['username'] != null ) && ( $_POST['password'] != null ) ) {//判断输入是否为空
    $userName = $_POST['username'];//post方式接收传来的参数，用定义的$userName和$password接收
    $password = $_POST['password'];
    //从数据库获取用户信息
	
	$sql = "select * from all_$range where username = '$userName'";//从数据库表中获取数据
	$res = mysqli_query($connID,$sql);
	$row = mysqli_fetch_array($res);
	if	($row['username']!=$userName) {
		echo "<script>alert('登录失败');history.back();</script>";
		//header('Location:../../../regist/login.html');
	}
	else if($row['username']==$userName&&$row['password']!=$password)
	{
		echo "<script>alert('登录失败');history.back();</script>";
		//header('Location:../../../regist/login.html');
	}
	else if($row['username']!=$userName&&$row['password']!=$password) {
		echo "<script>alert('登录失败');history.back();</script>";
		//print_r($row);
		//header('Location:../../../regist/login.html');
	}
    else if($row['username']==$userName&&$row['password'] ==$password) {

        $_SESSION['username']=$userName;
		header('Location:../../../homepage_2.html');
    }
}
else {
	echo "<script>alert('登录失败');history.back();</script>";
	//header('Location:../../../regist/login.html');//跳转到失败页面
}
?>