<?php
	$topicname = $_POST['topic'];
	$block = $_POST['block'];
	$description = $_POST['description'];
	$now = date("Y-m-d H:i:s");
	$user = $_SESSION['userid'];
	
	

	
	$db = new mysqli('127.0.0.1', 'root', '123456', 'EXPfinal');
 	if ($db->connect_errno)  die($db->connect_error);  
  	$db->query('SET NAMES "UTF8"');	
	$inserttopic = "insert into topic(topicname,description,userid,time,blockid) values('$topicname','$description','$user','$now','$block')";
	$result = $db->query($inserttopic);//返回true或false
   if (!$result){
       echo '插入失败';
   }else{
		$topicidsql = "select max(topicid) from topic";
		$result2 = $db->query($topicidsql);//返回true或false
		while($row2 = $result2->fetch_row()){
			$topicid = $row2[0];
		}
   		header('location:topic.php?topicid='.$topicid);
   }
	
   $db->close();
?>