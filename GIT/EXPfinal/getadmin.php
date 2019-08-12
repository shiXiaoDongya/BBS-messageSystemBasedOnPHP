<?php 
	if(isset($_SESSION['authority'])){
		if($_SESSION['authority']==1){
			$json['authority']=1;
		}else{
			$json['authority']=0;
		}
	}
	$json = json_encode($json);
	echo $json;
?>