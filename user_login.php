<?php
/*
		USER Entry Check & Login
			23/09/18		
*/
 include ("login_auto.php"); 
	
	if(isset($_REQUEST['userid'])) 		$name 	= $_REQUEST['userid'];
	if(isset($_REQUEST['pass'])) 		$pass	= $_REQUEST['pass'];
	
	$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
		$db_server->set_charset("utf8");
		If (!$db_server) die("Can not connect to a database!!".mysqli_connect_error($db_server));
		mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));
		
		
			$check_user='SELECT id FROM users
						
						WHERE name = "'.$name.'" AND pass="'.$pass.'"';
			
			$answsql=mysqli_query($db_server,$check_user);
			if(!$answsql) die("SELECT TO users table UPDATE failed: ".mysqli_error($db_server));
			
		if($answsql->num_rows)
		{
			session_start();
			$row_u=$answsql->fetch_row();
			$user_id=$row_u[0];
			$_SESSION['username']=$name;
			$_SESSION['dude']=$user_id;
			$_SESSION['ip']=$_SERVER['REMOTE_ADDR'];
			$_SESSION['ua']=$_SERVER['HTTP_USER_AGENT'];
			echo '<script>window.location.replace("main.php?command=list&id='.$user_id.'");</script>';
		}
		else
		{
			echo "ERROR: WRONG INPUT DATA FROM THE FORM: name - $name | password - $pass";
			//echo '<script>history.go(-1);</script>';
		}
			
// reconstruct user screen	
// ? make redirect to main.php show
			
	
mysqli_free_result($answsql);
mysqli_close($db_server);

?>