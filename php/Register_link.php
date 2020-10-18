<?php

	require_once("dbconnect.php");//首先连接数据库

	$connID=db_connect();
	$name=trim($_POST['username']);
	$email=trim($_POST['email']);
	$phonenumber=trim($_POST['phonenumber']);
	$hometown=trim($_POST['hometown']);
	$sex=trim($_POST['sex']);
	//trim函数，过滤空格，使用trim函数，我们可以把表单中空格给过滤掉
	$password=$_POST['password'];
    $range=$_POST['range'];

     $sql="select * from all_$range where username='$name'";//从数据库查找用户名数据
     $info = mysqli_query($connID,$sql);//函数执行一条 MySQL 查询（$sql）
     $res =  mysqli_num_rows($info);//返回一行的结果
     //$res = False;//上面那行有问题，直接结果//解决了 又OK了

	if(empty($name)){//empty() 函数用于检查一个变量是否为空。
		echo "<script>alert('用户名不能为空');location.href='registe.html';</script>";
	}else if(empty($password)){
		echo "<script>alert('密码不能为空');location.href='registe.html';</script>";
	}else{	
		if($res){
			echo "<script>alert('用户名已存在');location.href='registe.html';</script>";
		}else{
			$sql1 ="insert into all_$range(username,password,sex,hometown,email,phonenumber) values('$name','$password','$sex','$hometown','$email','$phonenumber')";//PHP MySQL 插入数据
			$result = mysqli_query($connID,$sql1);//判断插入数据是否成功
		if($range=='teacher')
		{
		    $sql="select id from all_teacher where username='$name'";
		    $result=mysqli_query($connID,$sql);
		    $row=mysqli_fetch_assoc($result);
			$rid=$row['id'];
			$roomname='r'.$rid;
			mysqli_query($connID,"UPDATE all_teacher SET roomname='$roomname' WHERE id='$rid'");
            $sql_create1="create table r$rid"."_roomstudents(studentname varchar(255),onplay int(1))";
            $result=mysqli_query($connID,$sql_create1);
            $sql_create2="create table r$rid"."_diary(username varchar(255),job varchar(255),do varchar(255),what varchar(255),whendate DATE,whentime TIME)";
            $result=mysqli_query($connID,$sql_create2);
            $sql_create3="create table r$rid"."_roomchat(id int(100) primary key not null auto_increment,studentname varchar(255),whendate DATE,whentime TIME,message varchar(255))";
			$result=mysqli_query($connID,$sql_create3);
			mysqli_query($connID,"insert into r$rid"."_roomchat(id,studentname,message) values(0,'$name','')");
			$sql ="insert into all_room(roomname,teachername,play,studentnum,roomhotdegree,roomtitle) values('$roomname','$name',0,0,0,'')";//PHP MySQL 插入数据
			$result = mysqli_query($connID,$sql);//判断插入数据是否成功
			$secrettext=md5($name);
			$sql="update all_teacher set secrettext='$secrettext' where username='$name'";
			$result = mysqli_query($connID,$sql);


		}
		else{
            $sql="select id from all_student where username='$name'";
            $result=mysqli_query($connID,$sql);
            $row=mysqli_fetch_assoc($result);
            $sid=$row['id'];
            $sql_create4="create table s$sid"."_diary(username varchar(255),job varchar(255),do varchar(255),what varchar(255),whendate DATE,whentime TIME)";
            $result=mysqli_query($connID,$sql_create4);
        }
			if($result){
		 	//		echo "<script>alert('注册成功')</script>";
			//		 header('Location:login.php');
				echo "<script>alert('注册成功！');location.href='../regist/login.html';</script>";
					
			}else{
		 			echo "<script>alert('注册失败')</script>";
			}
		}

}	//