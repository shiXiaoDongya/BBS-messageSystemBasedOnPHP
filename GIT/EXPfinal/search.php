<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<style>
	#header{
		padding:10px;
		border:solid 1px;
		border-radius:10px;
		height:150px;
		width:1800px;
		background-image:url(header.jpg);
		margin:0px auto;
		margin-bottom:20px;
		position:relative;
	}
	#content{
		padding:10px;
		width:1800px; 
		margin:0px auto; 
		margin-bottom:20px; 
		border:solid 1px;
		border-radius:10px;
		background-color:#69C;
	}
	p{
		cursor:pointer;
	}
	p:hover{
		font-size:large;
		color:#0FF;
	}
</style>
<script type="text/javascript" src="../jquery.js"></script>
<script type="text/javascript">

function turn(i){
		window.open("topic.php?topicid="+i);
	}
</script>
</head>

<body>
<div id="header">
    	<h1>XX论坛</h1>
        <p>
        	<span id="user"></span>
        </p>
</div>
<div id="content">
<?php
	$txt = $_GET['searchtxt'];
	$txt = trim($txt);
	$strings = explode(' ',$txt);
	for($i = 0; $i< count($strings);$i++){
		$db = new mysqli('127.0.0.1', 'root', '123456', 'EXPfinal');
 		if ($db->connect_errno)  die($db->connect_error);  
  		$db->query('SET NAMES "UTF8"');
		$topic = "select * from topic where topicname like '%$strings[$i]%'";
		$result = $db->query($topic);//返回true或false
		$num_rows = mysqli_num_rows($result);
		if($num_rows == 0){
			echo "没有关于\"".$strings[$i]."\"的结果";
		}else{
			while($row=$result->fetch_assoc()){
				echo "<p id='{$row['topicid']}' onclick='turn(this.id)'>";
				echo $row['topicname'];
				echo "</p>";
			}
		}
	}
?>
</div>
</body>
</html>
