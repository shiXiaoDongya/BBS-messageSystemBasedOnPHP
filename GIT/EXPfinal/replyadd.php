<?php
	$content = $_POST['text'];
	$topicid = $_POST['topicid'];
	$userid = $_SESSION['userid'];
	$now = date("Y-m-d H:i:s");
	
	
	
	$db = new mysqli('127.0.0.1', 'root', '123456', 'EXPfinal');
 	if ($db->connect_errno)  die($db->connect_error);  
  	$db->query('SET NAMES "UTF8"');
	$allfloor = "select allfloor from topic where topicid=$topicid";
	$result = $db->query($allfloor);//返回true或false	
   while($row = $result->fetch_row()){
	   $floornum = $row[0]+1;
   }
   
   	echo $topicid;
	echo $userid;
	echo $floornum;
   	echo $content;
	echo $now;
   
   $insertfloor = "insert into floor(topicid,userid,floornum,content,time) values('$topicid','$userid','$floornum','$content','$now')";
   $result2 = $db->query($insertfloor);
   if (!$result2){
       echo '插入失败';
   }
   
   $updateallfloor="update topic set allfloor=$floornum where topicid=$topicid";
   $result3 = $db->query($updateallfloor);
   
   header('location:topic.php?topicid='.$topicid);
   
   $db->close();
?>