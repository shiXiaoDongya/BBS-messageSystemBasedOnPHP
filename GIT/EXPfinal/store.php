while($row3 = $result3->fetch_assoc()){
					$toreply = "select * from floor where replyid = {$row3['replytoreplyid']}";
					$result4 = $db->query($toreply);					
					while($row4 = $result4->fetch_assoc()){
						$towhom = $row4['userid'];
						$content = $row4['content'];
						$cont = substr($content,0,10);
					}
				echo"
			<div id='replyinfloor' class='clearfix'>
				<div class='clearfix'>
				<span id='towhat'>@作者:$towhom 
				<div class='clearfix'>
				<span style='float:left; margin-left:50px; width:300px;'>$cont</span> </div></span><br />
				　　	　　回复:{$row3['content']}<br />
				<div id='rightside' class='clearfix'><span id='vote'>点赞</span>　<span id='comment' onClick='comment({$row3['replyid']},$floornum)'>评论</span></div>
				</div>
				<hr />
			</div>";
				}