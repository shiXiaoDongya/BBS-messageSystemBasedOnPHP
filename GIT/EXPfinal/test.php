<?php
	unset($_SESSION['user']);
 	session_destroy();
	header('location:'.$_SERVER['HTTP_REFERER'])
?>
