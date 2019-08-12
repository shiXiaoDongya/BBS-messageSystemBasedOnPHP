<?php
 	$topicid = $_POST['topicid'];
	$userid = $_SESSION['userid'];
	$floornum = $_POST['floornum'];
	$content = $_POST['content'];
	$time = date("Y-m-d H:i:s");
	$replytoreplyid = $_POST['replyid'];
	
	echo $topicid;
	echo $userid;
	echo $floornum;
	echo $content;
	echo $time;
	echo $replytoreplyid;
	
	$db = new mysqli('127.0.0.1', 'root', '123456', 'EXPfinal');
 	if ($db->connect_errno)  die($db->connect_error);  
  	$db->query('SET NAMES "UTF8"');	
	$insertreply = "insert into floor(topicid,userid,floornum,content,time,replytoreplyid) values('$topicid','$userid','$floornum','$content','$time','$replytoreplyid')";
	$result = $db->query($insertreply);//返回true或false
   if (!$result){
       echo '插入失败';
   }else{
	   header('location:topic.php?topicid='.$topicid);
   }
 ?>