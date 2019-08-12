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
	#info{
		text-align:center;
		font-size:18px;
		margin:10px;
	}
	#title{
		padding-left:10px;
		padding-right:10px;
		background-color:#FFF;
		width:auto !important; 
		height:40px;
		line-height:40px;
		text-align:center;
		width:auto; display:inline-block !important; display:inline;
		font-size:30px;
		background-color:#666;
		color:#0FF;
		font-weight:bold;
		margin:10px;
	}
	#reply{
		padding:10px;
		border:solid 1px;
		border-radius:10px;
		width:1800px;
		margin:0 auto;
		background-color:#69C;
	}
	.clearfix {*zoom:1;}
	.clearfix:after { 
          visibility: hidden; 
          display: block; 
          content: " "; 
          clear: both; 
          height: 0; 
		  
	}
	#floor{
		padding:10px;
		width:1800px; 
		margin:0px auto; 
		margin-bottom:20px; 
		border:solid 1px;
		border-radius:10px;
		background-color:#69C;
		text-align:center;
	}
	#text{
		margin:0px auto;
		margin-left:20px;
		border:solid 1px;
		text-align:left;
		background:#CCC; 
		padding:20px;
	}
	#replyinfloor{
		margin-left:150px;
		padding:10px;
	}
	#towhat{
		color:#666;
		font-size:small;
	}
	#rightside{
		float:right;
		color:#06C;
	}
	.clearfix:after {
	content: '\20';
	display: block;
	height: 0;
	clear: both;
	visibility: hidden;
	overflow: hidden;
}
	.clearfix span{
		cursor:pointer;
	}
	
	#info textarea{
		margin-top:20px;
		width:80%;
		height:50px;
	}
	#user{
		position:absolute;
		right:50px;
		bottom:5px;
	}
</style>
<script type="text/javascript" src="../jquery.js"></script>
<script type="text/javascript">
var logined = <?php
		if (!session_id()){
			session_start();
		}
		if (isset($_SESSION['log'])){
			echo 1;
		}else{
			echo 0;
		}
	?>;
$(document).ready(function(){ 
	var topicid=<?php echo $_GET['topicid']; ?>;
	$.ajax({
     	type: "get",
     	url: "text.php",
     	async : true,
    	dataType:"html",//返回整合HTML
     	data:{temp:topicid},
     	success: function (data) { 
        $("#insert").html(data);//刷新整个body页面的html
     	}
 	})
	
	if(logined){
		getUsername();
	}else{
		$('#user').html("<a href='login.php'>登录</a>　<a href='register.php'>注册</a>");
	}
})
function getUsername(){
		 $.ajax({type: "GET",
                url:"username.php",
                dataType: "json",
                jsonp: "callback",
                success: function(json){
					$('#user').html(json['username']+" 已登录 <a href='logout.php'>注销</a>");
                },
                error: function(){
                    alert("fail");
                }
          })
	 }
function textcheck(){
	var text = document.getElementById('text');
	var logined = <?php
		if (!session_id()){
			session_start();
		}
		if (isset($_SESSION['log'])){
			echo 1;
		}else{
			echo 0;
		}
	?>;
	if(logined){
		if(text.value=="<p><br></p>"){
				alert("内容不能为空");
				return false
		}else{
			return true;
		}
	}else{
		alert("请先登录！");
		return false;
	}
}
function comment(replyid, floornum){
	var logined = <?php
		if (!session_id()){
			session_start();
		}
		if (isset($_SESSION['log'])){
			echo 1;
		}else{
			echo 0;
		}
	?>;
	if(logined){
		var replydiv = "replydiv"+floornum;
		var replytextid = "replyid"+floornum;
		var replyfloorid = "replyfloornum"+floornum;
		var replydiv = document.getElementById(replydiv);
		replydiv.style.display = "block";
		var replytext = document.getElementById(replytextid);
		replytext.value = replyid;
		var replyfloor = document.getElementById(replyfloorid);
		replyfloor.value = floornum;
	}else{
		alert('请先登录');
	}
}
function replycheck(floornum){
	var replyareaid = "replyarea"+floornum;
	var replyarea = document.getElementById(replyareaid);
	if(replyarea.value==''){
		alert("内容不能为空");
		return false
	}else{
		return true;
	}
}
</script>
</head>

<body style="background-color:#CCC;">
	<div id="header">
    	<a href="initial.php">首页</a>
        <p>
        	<span id="user"></span>
        </p>
    </div>
    <div id="content">
    	<div style="text-align:center">
    	<div id="title">
        	 <?php
			$topicid =  $_GET['topicid'];
			$db = new mysqli('127.0.0.1', 'root', '123456', 'EXPfinal');
 			if ($db->connect_errno)  die($db->connect_error);  
  			$db->query('SET NAMES "UTF8"');	
			$topic = "select * from topic where topicid=$topicid";
			$result = $db->query($topic);//返回true或false
   			while($row = $result->fetch_assoc()){
				echo $row['topicname'];
				$hits = $row['hits'];
			}
			$hitsadd = "update topic set hits= $hits+1 where topicid=$topicid";
			$result = $db->query($hitsadd);//返回true或false
			?>
        </div>
        </div>
        <div id="info">
        <?php
			$topicid =  $_GET['topicid'];
			$db = new mysqli('127.0.0.1', 'root', '123456', 'EXPfinal');
 			if ($db->connect_errno)  die($db->connect_error);  
  			$db->query('SET NAMES "UTF8"');	
			$topic = "select * from topic where topicid=$topicid";
			$result = $db->query($topic);//返回true或false
   			while($row1 = $result->fetch_assoc()){
				$user = "select username from users where userid = {$row1['userid']}";
				$result = $db->query($user);//返回true或false
				while($row2 = $result->fetch_assoc()){
					echo "楼主:".$row2['username']."&nbsp;&nbsp;&nbsp;&nbsp;";
				}
				echo "时间:".$row1['time']."&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "点击率:".$row1['hits'];
			}
		
   		$db->close();
?>
        </div>
        
        
    	<div style= "background:#CCC; padding:20px; overflow:auto; margin-top:20px;" >
        <?php
			$topicid =  $_GET['topicid'];
			$db = new mysqli('127.0.0.1', 'root', '123456', 'EXPfinal');
 			if ($db->connect_errno)  die($db->connect_error);  
  			$db->query('SET NAMES "UTF8"');	
			$topic = "select description from topic where topicid=$topicid";
			$result = $db->query($topic);//返回true或false
   			if (!$result){
       			echo '插入失败';
   			}
   		while($row = $result->fetch_row()){
	   		echo $row[0];
		}
   		$db->close();
?>
        </div>
    </div>
    
    <div id="insert">
    </div>
   	
    <div id="reply">
    <?php
	if (!session_id()){
		session_start();
	}
	
	if (isset($_SESSION['log'])){
		echo $_SESSION['username']." 已登录 ";
		echo "<a href='test.php'>注销</a>";
	}else{
		echo "<span><a href='login.php'>登录</a>　<a href='register.php'>注册</a></span>";
	}
?>
   		<form action="replyadd.php" method="post" onsubmit="return textcheck()">
        <div style="width:60%; margin:0px auto; margin-top:15px;" >
        <div id="div1" style="background-color:#FFF;"></div>
    	<textarea id="text"  name="text" hidden="hidden"></textarea>
        <div class="clearfix">
   		<input type="submit" value="发表" style="float:right; margin-right:45px; width:80px; height: 30px; background-color:#FF0;" />
        </div>
        <input type="text" name="topicid" hidden="hidden" value="<?php echo $_GET['topicid'];?>"/>
        </div>
        
        </form>
   </div>
   
   <script src="../jquery.js"></script>
    <script type="text/javascript" src="wangEditor-3.1.1/release/wangEditor.min.js"></script>
    <script type="text/javascript">
        var E = window.wangEditor;
        var editor = new E('#div1');
		var $text = $('#text')
        editor.customConfig.onchange = function (html) {
            // 监控变化，同步更新到 textarea
            $text.val(html)
        }
     	editor.customConfig.uploadImgShowBase64 = true;
            editor.customConfig.uploadImgMaxSize = 3 * 1024 * 1024;
            editor.customConfig.uploadImgMaxLength = 5;
            editor.create();
			$text.val(editor.txt.html())
    </script>
   
</body>
</html>
