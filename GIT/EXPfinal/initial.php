<!doctype html>
<html>
<head>
<meta charset="utf-8">
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
	#footer{
		padding:10px;
		border:solid 1px;
		border-radius:10px;
		height:50px;
		width:1800px;
		margin:0 auto;
		background-color:#69C;
	}
	#left{
		float:left;
		width:300px;
		height:1070px;
	}
	#block{
		width:300px;
		height:300px;
		border:solid 1px;
	}
	#user{
		position:absolute;
		right:50px;
		bottom:5px;
	}
	#hot{
		margin:0 43px 0 43px;
		width:1080px;
		height:350px;
		border:solid 1px;
		display:inline-block;
	}
	#right{
		float:right;
		margin-right:30px;
		width:300px;
		height:1070px;
		text-align:center;
	}
	#search{
		width:300px;
		height:200px;
		border:solid 1px;
		text-align:center;
	}
	#top{
		margin-top:20px;
		width:300px;
		height:850px;
		border:solid 1px;
	}
	#topic{
		margin-left:360px;
		width:1080px;
		height:700px;
		margin:20px 43px 0 43px;
		border:solid 1px;
		display:inline-block;
	}
	hr{
		width:90%;
		height:5px;
		background-color:#000;
	}
	#block p{
		margin-top:40px;
		text-align:center;
		color:#FF0;
		font-weight:bold;
	}
	#block span{
		cursor:pointer;
	}
	#block span:hover{
		color:#F00;
		text-decoration:underline;
	}
	table{
		border-collapse:collapse;
		font-size:16px;
		table-layout:fixed;
	}

	table th{
		border-bottom:#CCC solid 1px;
		border-right:solid 1px;
		border-left:solid 1px;
	}
	table td{
		border-bottom:#CCC dashed 1px;
		height:30px;
		line-height:30px;
		text-align:center;
		white-space:nowrap;
		overflow:hidden;
		text-overflow: ellipsis;
	}
	.hotrows{
		cursor:pointer;
	}
	.hotrows:hover{
		font-size:large;
		color:#0FF;
	}
	#left2{
		margin-top:20px;
		width:300px;
		height:750px;
		border:solid 1px;
	}
	.clearfix {*zoom:1;}
	.clearfix:after { 
          visibility: hidden; 
          display: block; 
          content: " "; 
          clear: both; 
          height: 0; 
		  
	}
	#page li{
		float:left;
		display:block;
		margin-right:15px;
		cursor:pointer;
		text-decoration:underline;
		color:#00F;
	}
	#text{
		margin-top:5px;
		font-size:12px;
		text-align:center;
		color:#FF9;
	}
</style>
<script src="../jquery.js"></script>
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
	var page = 1;
	var blockpage = 1;
	var totalPage;
	var blockid;
	$(document).ready(function(){	
		if(logined){
			getUsername();
			getadmin();
		}else{
			$('#user').html("<a href='login.php'>登录</a>　<a href='register.php'>注册</a>");
		}
		
		getData(page);
		
		$.ajax({type: "GET",
                url:"top7.php",
                dataType: "json",
                jsonp: "callback",
                success: function(json){
					var top7table = document.getElementById('top7table');
					for(var i = 0; i<json['username'].length;i++){
						var id =json['topicid'][i];
							var tr = $("<tr class='hotrows' id='"+id+"' onClick='turn(this.id)'></tr>").appendTo(top7table);
							$("<td></td>").appendTo(tr).html(json['username'][i]);
							$("<td></td>").appendTo(tr).html(json['topicname'][i]);
							$("<td></td>").appendTo(tr).html("0");
							$("<td></td>").appendTo(tr).html(json['time'][i]);
							$("<td></td>").appendTo(tr).html(json['block'][i]);
					}
                },
                error: function(){
                    alert("fail");
                }
          })
     })
	 function getadmin(){
		 $.ajax({type: "GET",
                url:"getadmin.php",
                dataType: "json",
                jsonp: "callback",
                success: function(json){
					if(json['authority'] == 1){
						$('#admin').html("<a href='admin.php'>管理员界面</a>");
					}
                },
                error: function(){
                    alert("fail");
                }
          })
	 }
	 
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
	 
	 function getData(page){
		 $.ajax({type: "GET",
                url:"selecttopic.php",
                dataType: "json",
                jsonp: "callback",
				data:{'page':page},
                success: function(json){
					var count = json['username'].length;
					totalPage = Math.ceil(count / 16);
					var text = "共"+count+"条帖子　　共"+totalPage+"页　　当前第"+page+"页";
					var last = count % 16;
					$("#topictable tr:not(:first)").html('');
					if(page!=totalPage){
						for(var j = 0;j<16;j++){
							var id =json['topicid'][16*(page-1)+j];
							var tr = $("<tr class='hotrows' id='"+id+"' onClick='turn(this.id)'></tr>").appendTo(topictable);
							$("<td></td>").appendTo(tr).html(json['username'][16*(page-1)+j]);
							$("<td></td>").appendTo(tr).html(json['topic'][16*(page-1)+j]);
							$("<td></td>").appendTo(tr).html("0");
							$("<td></td>").appendTo(tr).html(json['time'][16*(page-1)+j]);
							$("<td></td>").appendTo(tr).html(json['block'][16*(page-1)+j]);
						}
					}else{
						for(var j = 0;j<last;j++){
							var id =json['topicid'][16*(page-1)+j];
							var tr = $("<tr class='hotrows' id='"+id+"' onClick='turn(this.id)'></tr>").appendTo(topictable);
							$("<td></td>").appendTo(tr).html(json['username'][16*(page-1)+j]);
							$("<td></td>").appendTo(tr).html(json['topic'][16*(page-1)+j]);
							$("<td></td>").appendTo(tr).html("0");
							$("<td></td>").appendTo(tr).html(json['time'][16*(page-1)+j]);
							$("<td></td>").appendTo(tr).html(json['block'][16*(page-1)+j]);
						}
					}
					$('#text').html(text);
					var option=""; 
					for(var i=1;i<=totalPage;i++){  
        				option+='<option value='+i+'>'+i+'</option>'; 
   			 		}  
   			 		$(".jump").html(option);
					
					if(page<1){
						page=1;
					}
					if(page>totalPage+1){
						page=totalPage;
					}
					
                },
                error: function(){
                    alert("fail");
                }
          })
	 }
	 
	function firstPage(){
		getData(1);
		page = 1;
	}
	function prePage(){
		page--;
		if(page<1){
			page=1;
			getData(page);
		}else{
			getData(page);
		}
	}
	function nextPage(){
		page++;
		if(page>totalPage){
			page=totalPage;
			getData(page);
		}else{
			getData(page);
		}
	}
	function lastPage(){
		getData(totalPage);
		page = totalPage;
	}
	function jumpPage(){
		var s=parseInt($(".jump").val());  
        getData(s); 
	}
	
	function turn(i){
		window.open("topic.php?topicid="+i);
	}
	function publishcheck(){
		if(logined){
			window.location.href="publish.php";
		}else{
			alert('请先登录!');
		}
	}
	function change(i){
		document.getElementById('changepage').style.display = "none";
		document.getElementById('changeblockpage').style.display = "block"
		blockid = i;
		getBlockData(blockid,blockpage);
		var spans = document.getElementById('block').getElementsByTagName('span');
		for(var temp=0;temp<spans.length;temp++){
			spans[temp].style.color = "#FF0";
		}
		spans[i-1].style.color="red";
		
		
	}
	function getBlockData(blockid,blockpage){
		$.ajax({type: "GET",
                url:"changeblock.php",
                dataType: "json",
                jsonp: "callback",
				data:{'data':blockid},
                success: function(json){
					var count = json['username'].length;
					totalPage = Math.ceil(count / 16);
					var text = "共"+count+"条帖子　　共"+totalPage+"页　　当前第"+blockpage+"页";
					var last = count % 16;
					$("#topictable tr:not(:first)").html("");
					var topictable = document.getElementById('topictable')
					if(blockpage!=totalPage){
						for(var j = 0;j<16;j++){
							var id =json['topicid'][16*(blockpage-1)+j];
							var tr = $("<tr class='hotrows' id='"+id+"' onClick='turn(this.id)'></tr>").appendTo(topictable);
							$("<td></td>").appendTo(tr).html(json['username'][16*(blockpage-1)+j]);
							$("<td></td>").appendTo(tr).html(json['topic'][16*(blockpage-1)+j]);
							$("<td></td>").appendTo(tr).html("0");
							$("<td></td>").appendTo(tr).html(json['time'][16*(blockpage-1)+j]);
							$("<td></td>").appendTo(tr).html(json['block'][16*(blockpage-1)+j]);
						}
					}else{
						for(var j = 0;j<last;j++){
							var id =json['topicid'][16*(blockpage-1)+j];
							var tr = $("<tr class='hotrows' id='"+id+"' onClick='turn(this.id)'></tr>").appendTo(topictable);
							$("<td></td>").appendTo(tr).html(json['username'][16*(blockpage-1)+j]);
							$("<td></td>").appendTo(tr).html(json['topic'][16*(blockpage-1)+j]);
							$("<td></td>").appendTo(tr).html("0");
							$("<td></td>").appendTo(tr).html(json['time'][16*(blockpage-1)+j]);
							$("<td></td>").appendTo(tr).html(json['block'][16*(blockpage-1)+j]);
						}
					}
					$('#text').html(text);
					var option=""; 
					for(var i=1;i<=totalPage;i++){  
        				option+='<option value='+i+'>'+i+'</option>'; 
   			 		}  
   			 		$(".Blockjump").html(option);
					
					if(blockpage<1){
						blockpag=1
					};
					if(blockpage>totalPage+1){
						blockpage=totalPage;
					}
                },
                error: function(){
                    alert("fail");
                }
          });
	}
	
	function firstBlockPage(){
			getBlockData(blockid,1);
			blockpage=1;
	}
	function preBlockPage(){
		blockpage--;
		if(blockpage<1){
			blockpage=1;
			getBlockData(blockid,blockpage);
		}else{
			getBlockData(blockid,blockpage);
		}
	}
	function nextBlockPage(){
		blockpage++;
		if(blockpage>totalPage){
			blockpage=totalPage;
			getBlockData(blockid,blockpage);
		}else{
			getBlockData(blockid,blockpage);
		}
	}
	function lastBlockPage(){
		getBlockData(blockid,totalPage);
		blockpage = totalPage;
		
	}
	function jumpBlockPage(){
		var s=parseInt($(".Blockjump").val());  
        getBlockData(blockid,s); 
	}
	function searchcheck(){
		var txt = document.getElementById('searchtxt').value;
		var txt_1 = txt.replace(/^\s*|\s*$/g,"");	//取除字符串左右两端空格
		if(txt_1 == ''){
			alert('请输入关键字');
			return false;
		}else{
			return true;
		}
		
	}
</script>
</head>
<body style="background-color:#CCC;">
<div>
  <div id="header">
    	<h1>XX论坛</h1>
        <div id="admin">
        </div>
        <p>
        	<span id="user"></span>
        </p>
	</div>

	<div id="content">
		<div id="left" class="clearfix">
        <div id="block">
        	<h3 style="text-align:center;">所有版块</h3>
            <hr />
            <p><span id="1" onClick="change(this.id)">经济论坛</span>　<span id="2" onClick="change(this.id)">以案说法</span>　<span id="3" onClick="change(this.id)">娱乐八卦</a></span>
            <p><span id="4" onClick="change(this.id)">旅游分享</span>　<span id="5" onClick="change(this.id)">影视交谈</span>　<span id="6" onClick="change(this.id)">情感交谈</span></p>
            <p><span  id="7" onClick="change(this.id)">音乐发烧</span>　<span  id="8" onClick="change(this.id)">灌水专区</span>　<span  id="9" onClick="change(this.id)">其他版块</span></p>
        </div>
        
        <div id = "left2">
        </div>
        </div>
        
        <div id="hot">
        	<h3 style="text-align:center;">热门帖子　　点击量TOP7</h3>
            <hr/>
            <table align="center" width="1000px" id="top7table">
            <tr>
              <th width="150px;">发帖人</th>
              <th width="550px">主题</th>
              <th width="50px">状态</th>
              <th width="180px">时间</th>
              <th width="100px">板块</th>
            </tr>
            </table>
      </div>
        
        <div id="right">
        	<div id="search">
            <form action="search.php" method="get" onSubmit="return searchcheck();">
        	<p><input type="text" id="searchtxt" name="searchtxt"/>　<input type="submit" value="搜索"/></p>
            <p>输入关键词搜索帖子</p>
            <p>（多关键词请用一个空格分开）</p>
            </form>
            </div>
            <div id="top">
            </div>
    	</div>
        
        
        <div id="topic">
       		<input type="button" value="我要发帖" id="publish" onClick="publishcheck()" style="float:right; margin:10px 60px 5px 0; width:100px; height:40px; border-radius:10px; background-color:#FF0; border-color:black;">
            <hr/>  
            <table align="center" width="1000px" id="topictable">
            <tr>
              <th width="150px;">发帖人</th>
              <th width="550px">主题</th>
              <th width="50px">状态</th>
              <th width="180px">时间</th>
              <th width="100px">板块</th>
            </tr>
            
            </table>
            <div id="text">
            </div>
            <div id="changepage">
            <div style="width:600px;margin-left:250px;" class="clearfix">
            	<ul id='page'>
		<li onClick="firstPage()">首页</li>
		<li onClick="prePage()">上一页</li>
		<li onClick="nextPage()">下一页</li>
		<li onClick="lastPage()">尾页</li>
		<li><select class="jump" style="width:60px; margin-left:20px;"></select></li> 
		<li onClick="jumpPage()">跳转</li>
            </div>
            </div> 
            
            <div id="changeblockpage" style="display:none">
            <div style="width:600px;margin-left:250px;" class="clearfix">
            	<ul id='page'>
		<li onClick="firstBlockPage()">首页</li>
		<li onClick="preBlockPage()">上一页</li>
		<li onClick="nextBlockPage()">下一页</li>
		<li onClick="lastBlockPage()">尾页</li>
		<li><select class="Blockjump" style="width:60px; margin-left:20px;"></select></li> 
		<li onClick="jumpBlockPage()">跳转</li>
            </div>
            </div> 
        </div>
	</div>

	<div id="footer">
	</div>
</div>
</body>
</html>