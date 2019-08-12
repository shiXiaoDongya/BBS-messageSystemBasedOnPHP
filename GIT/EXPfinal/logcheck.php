<?php  
	$username = $_POST['loguser'];
	$psw = $_POST['logpsw'];
	
	try {
      $db = new mysqli('localhost', 'root', '123456', 'EXPfinal');
      $db->query('SET NAMES "utf8"');
      $check = 'Select * From users Where username=? And password=?';
      $stmt = $db->prepare($check);
      $stmt->bind_param("ss", $username, $psw);   
	  $username = $_POST['loguser'];
	  $psw = $_POST['logpsw'];
      $stmt->execute();
      $result = $stmt->get_result();  
	  
	  $num_rows = mysqli_num_rows($result);
	  
	  if($num_rows == 0){
		  echo "账号或密码错误";
		  
	  }else{
		  while($row = $result->fetch_assoc()){
			  $userid = $row['userid'];
			  $authority = $row['authority'];
		  }
		   if (!session_id()){
			session_start();
			}
		   $_SESSION['log'] = 1;
		   $_SESSION['username']=$username;
		   $_SESSION['userid']=$userid;
		   $_SESSION['authority']=$authority;
    	   header('location:'.$_POST['prevurl']);
	  }
	  
    } catch (Exception $e) {
      die($e->getMessage());
    }

	
?>
