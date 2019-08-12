<?php
	sleep(1);
	$db = new mysqli('127.0.0.1', 'root', '123456', 'EXPfinal');
 	if ($db->connect_errno)  die($db->connect_error);  
  	$db->query('SET NAMES "UTF8"');	
	$users = "select username from users";
	$result = $db->query($users);//返回true或false
	//$result = $result->etch_row();
	$users=array();
	$i = 0;
	while($line = $result->fetch_assoc()){
		$users[$i] = $line['username'];
		$i++;
	}
	$data = $_GET['user'];
	if($data == ""){
		echo 2;
	}else{
		if(in_array($data,$users)){
			echo 1;
		}else{
			echo 0;
		}
	}
?>