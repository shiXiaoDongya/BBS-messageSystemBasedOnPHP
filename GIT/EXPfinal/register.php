<!doctype html>
<html>
<head>
<meta charset="utf-8">
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
	#userinfo{
		margin:0 auto;
		width:520px;
		border:solid 1px;
	}
	.tit{
		width:150px;
		display:inline-block;
		text-align:right;
		font-size:16px
	}
	.txt{
		line-height:25px;
		width:180px;
		height:25px;
		vertical-align:middle;
		border:1px solid #CCCCCC
		margin-right:10px;
		padding-left:5px;
		border-radius:3px;
		box-shadow:2px 2px 2px 0 #EAEAEA inset;
		margin-right:15px;
	}
</style>
<script src="../jquery.js"></script>
<script type="text/javascript">
	window.onload = function(){
		document.getElementById("reguser").onblur = usercheck;
		document.getElementById("regpsw").onblur = pswecheck;
		document.getElementById("phone").onblur = phonecheck;
		
		document.getElementById('reg').onclick = showreg;
		document.getElementById('log').onclick = showlog;
		
	}
	function usercheck(){
		document.getElementById('usershow').style.color = 'blue';
		document.getElementById('usershow').innerHTML = "检测中...";
	
		var user = document.getElementById("reguser").value;
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function(){receiveMsg(xhr);};
		xhr.open("GET","usercheck.php?user=" + user,true);
		xhr.send();
	}
	function receiveMsg(xhr){
		if(xhr.readyState == 4 && xhr.status == 200){
			if(xhr.responseText == 1){		//1表示姓名已存在
				document.getElementById('usershow').style.color = 'red';
				document.getElementById('usershow').innerHTML = "用户名已注册！";
			}else{			//0表示姓名不存在
				if(xhr.responseText == 2){
					document.getElementById('usershow').style.color = 'red';
					document.getElementById('usershow').innerHTML = "用户名不能为空！";
				}else{	
					document.getElementById('usershow').style.color = 'green';
					document.getElementById('usershow').innerHTML = "√";
				}
			}
		}
	}
	function pswecheck(){
		var psw = document.getElementById('regpsw');
		if(psw.value.length < 6){
			document.getElementById('pswshow').style.color = "red";
			document.getElementById('pswshow').innerHTML = "密码最短6位数！";
		}else{
			document.getElementById('pswshow').style.color = "green";
			document.getElementById('pswshow').innerHTML = "√";
		}
	}
	function phonecheck(){
		var phone = document.getElementById('phone')
		var str = phone.value;
		var head = str.substring(0,2);
			if(str.length == 11 && head == "13"){
				document.getElementById('phoneshow').style.color = 'green';
				document.getElementById('phoneshow').innerHTML = "√";
				
			}else{
				document.getElementById('phoneshow').style.color = 'red';
				document.getElementById('phoneshow').innerHTML = "请输入正确的手机号！";
			}
	}
	function showreg(){
		document.getElementById('registerform').style.display = "block";
		document.getElementById('loginform').style.display = "none";
		document.getElementById('loginform').reset();
		document.getElementById('reg').style.textDecoration = "underline";
		document.getElementById('log').style.textDecoration = "none";
	};
	function showlog(){
		document.getElementById('registerform').style.display = "none";
		document.getElementById('loginform').style.display = "block";
		document.getElementById('registerform').reset();
		document.getElementById('reg').style.textDecoration = "none";
		document.getElementById('log').style.textDecoration = "underline";
	};
	function submitcheck(){
		var usercheck = (document.getElementById('usershow').style.color == "green");
		var pswcheck = (document.getElementById('pswshow').style.color == "green");
		var phonecheck = (document.getElementById('phoneshow').style.color == "green");
		if(usercheck && pswcheck && phonecheck){
			return true
		}else{
			alert("请更正数据！");
			return false;
		}
	};
</script>
<title>无标题文档</title>
</head>

<body style="background-color:#CCC;">
	<div id="header">
    	<h1>XX论坛</h1>
	</div>
    <div id="content">
    <div id="userinfo">
    	<div style="text-align:center;">
        	<span style="font-size:22px; cursor:pointer; text-decoration:underline" id="reg">注册</span>
            <span>&nbsp;&nbsp;&nbsp;丨&nbsp;&nbsp;&nbsp;</span>
            <span style="font-size:22px; cursor:pointer" id="log">登录</span>
        </div>
    	<form action="useradd.php" method="post" id="registerform" style="display:block;" onSubmit="return submitcheck()">
    	<p><label for="reguser" class="tit"><span style="color:#F00">*</span>用户名：</label><input type="text" id="reguser" name="reguser" class="txt" /><span id="usershow"></span></p>
        <p><label for="regpsw" class="tit"><span style="color:#F00">*</span>密码：</label><input type="password" id="regpsw" name="regpsw" class="txt" /><span id="pswshow"></span></p>
        <p><label class="tit">性别：</label>
        <input type="radio" id="男" name = "gender" value="男" checked="checked"><label for="男">男</label>　
        <input type="radio" id="女" name = "gender" value="女"><label for="女">女</label>
        </p>
        <p><label for="phone" class="tit">手机号：</label><input type="text" id="phone" name="phone" class="txt"/><span id="phoneshow"></span></p>
        <p><label class="tit"></label><input type="submit" value="注册" style="width:80px; height:40px;"/></p>
        <input type="hidden" name="prevurl" value="<?php echo $_SERVER['HTTP_REFERER']?>">
        </form>
        <form action="logcheck.php" method="post" id="loginform" style="display:none;">
        	<p><label for="loguser" class="tit">用户名：</label><input type="text" id="loguser"  name="loguser"class="txt"/></p>
            <p><label for="logpsw" class="tit">密码：</label><input type="password" id="logpsw" name="logpsw" class="txt"/>
            <p><label class="tit"></label><input type="submit" value="登录" style="width:80px; height:40px;" /></p>
            <input type="hidden" name="prevurl" value="<?php echo $_SERVER['HTTP_REFERER']?>">
        </form>
    </div>
    </div>
</body>
</html>