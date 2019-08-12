<?php
	$blockid = $_GET['data'];
	
	$db = new mysqli('127.0.0.1', 'root', '123456', 'EXPfinal');
 	if ($db->connect_errno)  die($db->connect_error);  
  	$db->query('SET NAMES "UTF8"');	
	$showtopic = "select * from topic where blockid=$blockid order by time DESC";
	$result = $db->query($showtopic);//返回true或false
   if (!$result){
       echo '插入失败';
   }
   $i=0;
   while($row = $result->fetch_assoc()){
	   $user = "select username from users where userid={$row['userid']}";
		$result2 = $db->query($user);//返回true或false
		while($row2 = $result2->fetch_row()){
			$username[$i] = $row2[0];
		}
		$topicid[$i] = $row['topicid'];
		$topic[$i] = $row['topicname'];
		$time[$i] = $row['time'];
		$block = "select blockname from topicblock where blockid = {$row['blockid']};";
		$result3 = $db->query($block);//返回true或false
		while($row3 = $result3->fetch_row()){
			$blockname[$i] = $row3[0];
		}
		$i++;
   }
   $db->close();
   
   $json['username'] = $username;
   $json['topicid'] = $topicid;
   $json['topic']=$topic;
   $json['time']=$time;
   $json['block']=$blockname;
   
	$json = json_encode($json);
	echo $json;
return;
?>