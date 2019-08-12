<?php
	$json['username'] = $_SESSION['username'];
	$json = json_encode($json);
	echo $json;
?>