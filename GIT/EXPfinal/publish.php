<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" Content="text/html; charset=utf-8" />
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
	textarea{
		width:800px;
		font-size:16px;
	}
	#info{
		margin:0 auto;
		width:900px;
	}
	hr{
		width:90%;
		height:5px;
		background-color:#000;
	}
	#topic{
		width:650px;
		height:20px;
		line-height:20px;
	}
	.clearfix {*zoom:1;}
	.clearfix:after { 
          visibility: hidden; 
          display: block; 
          content: " "; 
          clear: both; 
          height: 0; 
		  
	}
</style>
<script type="text/javascript" src="../jquery.js"></script>
<script type="text/javascript">
	window.onload = function(){
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
		if(!logined){
			window.location.href = "login.php";
		}
	}
	function publishcheck(){
		var topic = document.getElementById('topic');
		var block = document.getElementById('block');
		var description = document.getElementById('description');
		if(topic.value == ""){
			alert("标题不能为空！");
			return false;
		}else{
			if(topic.value.length > 40){
				alert("标题请不要超过40个字");
				return false;
			}else{	
				if(block.value == 0){
					alert("请选择版块");
					return false;
				}else{
					if(description.value=="<p><br></p>"){
						alert("内容不能为空");
						return false
					}
					return true;
				}
			}
		}
	}
</script>
<link rel="stylesheet" type="text/css" href="wangEditor-3.1.1/release/wangEditor.min.css">
</head>

<body bgcolor="#CCCCCC">
<div id="header">
</div>
<div id="content">
<h3 style="text-align:center;">发帖</h3>
    <hr />
	<div id="info">
	<form action="topicadd.php" method="post" id="publishform" onsubmit="return publishcheck()">
    <p style="height:25px; line-height:25px"><label for="topic">标题：</label><input type="text" id="topic" name="topic"/>
    <select id="block" name="block" style="width:150px; height:25px; line-height:25px;">
    	<option value="0">请选择版块</option>
        <option value="1">经济论坛</option>
        <option value="2">以案说法</option>
        <option value="3">娱乐八卦</option>
        <option value="4">旅游分享</option>
        <option value="5">影视交谈</option>
        <option value="6">情感交谈</option>
        <option value="7">音乐发烧</option>
        <option value="8">灌水专区</option>
        <option value="9">其他版块</option>
    </select>
    </p>
    <label >内容：</label>
	<div id="div1" style="background-color:#FFF; margin-left:50px;">
    </div>
    <textarea id="description"  name="description" hidden="hidden"></textarea>
   <div class="clearfix"><input type="submit" value="发表" style="float:right; margin-right:45px; width:80px; height: 30px; background-color:#FF0;" /></div>
    </form>
    </div>
</div>

  <script src="../jquery.js"></script>
    <script type="text/javascript" src="wangEditor-3.1.1/release/wangEditor.min.js"></script>
    <script type="text/javascript">
        var E = window.wangEditor;
        var editor = new E('#div1');
		var $description = $('#description')
        editor.customConfig.onchange = function (html) {
            // 监控变化，同步更新到 textarea
            $description.val(html)
        }
     	editor.customConfig.uploadImgShowBase64 = true;
            editor.customConfig.uploadImgMaxSize = 3 * 1024 * 1024;
            editor.customConfig.uploadImgMaxLength = 5;
            editor.create();
			$description.val(editor.txt.html())
    </script>
</body>
</html>
