
<?php
	
	$topicid = $_GET['temp'];
   
   
	$db = new mysqli('127.0.0.1', 'root', '123456', 'EXPfinal');
 	if ($db->connect_errno)  die($db->connect_error);  
  	$db->query('SET NAMES "UTF8"');
	$selectfloor = "select * from floor where topicid=$topicid and replytoreplyid is null";
	$result = $db->query($selectfloor);//返回true或false	
	$num_rows = mysqli_num_rows($result);
   	while($row = $result->fetch_assoc()){
		$user = "select username from users where userid={$row['userid']}";
	   	$result2 = $db->query($user);
	   	while($row2 = $result2->fetch_assoc()){
			$username = $row2['username'];
	   	}
	   	$replyid = $row['replyid'];
	   	$time =  $row['time'] ;
		$content = $row['content'] ;
		$floornum = $row['floornum'] ;
		$voteup =  $row['voteup'] ;
		$replytoreplyid = $row['replytoreplyid'];
		
		echo "
	<div id='floor' >
		作者:{$username}　　　　时间:$time
		<div id='text'>
			<div class='clearfix'>
			$content<br />
			<div id='rightside'><span id='floornum'>{$floornum}楼</span>　<span id='vote'>点赞($voteup)</span>　<span onClick='comment($replyid,$floornum)'>评论</span></div>
			</div>
			<hr />
			";	
		
		$replyinfloor = "select * from floor where topicid=$topicid and floornum = $floornum and replyid <> $replyid";
		$result3 = $db->query($replyinfloor);
		$num_rows2 = mysqli_num_rows($result3);
		if($num_rows2 != 0){
			while($row3 = $result3->fetch_assoc()){
				$commentuser = "select username from users where userid={$row3['userid']}";
				$result5 = $db->query($commentuser);
				while($row5 = $result5->fetch_assoc()){
					$commenter = $row5['username'];
				}
				$toreply = "select * from floor where replyid = {$row3['replytoreplyid']}";
				$result4 = $db->query($toreply);					
				while($row4 = $result4->fetch_assoc()){
					$towhomsql = "select username from users where userid ={$row4['userid']}";
					$result6 = $db->query($towhomsql);	
					while($row6=$result6->fetch_assoc()){
						$towhom = $row6['username'];
					}
					$content = $row4['content'];
					$cont = substr($content,0,10);
					echo"
			<div id='replyinfloor' class='clearfix'>
				<div class='clearfix'>
				<span id='towhat'>评论者:{$commenter}　　@{$towhom}　　时间:{$row3['time']}
				<div class='clearfix'>
				<span style='float:left; margin-left:50px; width:300px;'>$cont</span> </div></span><br />
				　　	　　{$row3['content']}<br />
				<div id='rightside' class='clearfix'><span id='vote'>点赞</span>　<span id='comment' onClick='comment({$row3['replyid']},$floornum)'>评论</span></div>
				</div>
				<hr />
			</div>";
				}
			}
		}
		
		echo "		
			<div id='info'>
			<div id='replydiv{$floornum}' style='display:none'>
				<form id='replyform$floornum' action='replyinflooradd.php' method='post' onsubmit='return replycheck($floornum)'>
					<textarea id='replyarea{$floornum}' name='content'/>
					<input type='text' id='replyfloornum$floornum' name='floornum' hidden='hidden'/>
					<input type='text' id='topicid$floornum' name='topicid' hidden='hidden' value='$topicid'/>
					<input type='text' id='replyid$floornum' name='replyid' hidden='hidden'/>
					<div class='clearfix'>
						<input type='submit' value='发表' style='float:right; margin-right:180px; margin-top:15px;'/>
					</div>
				</form>
			</div>
			</div>
		</div>
	</div>";
   }
?>