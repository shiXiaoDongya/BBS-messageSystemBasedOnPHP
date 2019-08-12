<?php
	$db = new mysqli('127.0.0.1', 'root', '123456', 'EXPfinal');
 	if ($db->connect_errno)  die($db->connect_error);  
  	$db->query('SET NAMES "UTF8"');
	$top6 = "select * from topic ORDER BY (log10(hits)*4/power(UNIX_TIMESTAMP(now()) - UNIX_TIMESTAMP(time)+1,1.5)) DESC LIMIT 0, 7";
	$result = $db->query($top6);
	$i=0;
	while($row = $result->fetch_assoc()){
		$name = "select username from users where userid = {$row['userid']}";
		$result2 = $db->query($name);
		while($row2 = $result2->fetch_assoc()){
			$username[$i] = $row2['username'];
		}
		$topicid[$i] = $row['topicid'];
		$topicname[$i] = $row['topicname'];
		$time[$i] = $row['time'];
		$blocknamesql = "select blockname from topicblock where blockid = {$row['blockid']};";
		$result3 = $db->query($blocknamesql);
		while($row3 = $result3->fetch_assoc()){
			$block[$i] = $row3['blockname'];
		}
		$i++;
	}
	
	$json['username'] = $username;
	$json['topicid']=$topicid;
	$json['topicname'] = $topicname;
	$json['time'] = $time;
	$json['block'] = $block;
	
	$json = json_encode($json);
	echo $json;
?>