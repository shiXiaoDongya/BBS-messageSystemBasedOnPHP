<?php
	$username = $_POST['reguser'];
	$password = $_POST['regpsw'];
	$gender = $_POST['gender'];
	$phone = $_POST['phone'];
	
	echo $username;
	echo $password;
	echo $gender;
	echo $phone;
	
	$db = new mysqli('127.0.0.1', 'root', '123456', 'EXPfinal');
 	if ($db->connect_errno)  die($db->connect_error);  
  	$db->query('SET NAMES "UTF8"');	
	$insertuser = "insert into users(username,password,gender,phone) values('$username','$password','$gender','$phone')";
	$result = $db->query($insertuser);//返回true或false
   if (!$result){
       echo '插入失败';
   }
   
   $userid = "select max(userid) from users";
	$result2 = $db->query($userid);//返回true或false
	while($row2 = $result2->fetch_row()){
		$userid = $row2[0];
	}
   if (!$result){
       echo '插入失败';
   }
   
   $db->close();
   if (!session_id()){
			session_start();
	}
   $_SESSION['log'] = 1;
   $_SESSION['username']= $username;
   $_SESSION['userid']=$userid;
   $_SESSION['authority']=0;
   header('location:'.$_POST['prevurl']);
?>