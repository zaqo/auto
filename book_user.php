﻿<?php
/*
		Updates data from the new car input form
			17/09/18		
*/
 include ("login_auto.php"); 
include ("header.php"); 
	if(isset($_REQUEST['username'])) 		$name 	= $_REQUEST['username'];
	if(isset($_REQUEST['pass'])) 		$pass 	= $_REQUEST['pass'];
	if(isset($_REQUEST['email'])) 		$email	= $_REQUEST['email'];
	if(isset($_REQUEST['user_loc'])) 	$loc_id	= $_REQUEST['user_loc'];

	
	
	$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
		$db_server->set_charset("utf8");
		If (!$db_server) die("Can not connect to a database!!".mysqli_connect_error($db_server));
		mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));
		
		if ($name)
		{
			$textsql_insert='INSERT INTO users
						(location_id,name,email,pass,isValid)
						VALUES( "'.$loc_id.'","'.$name.'","'.$email.'","'.$pass.'",1)';
			
			$answsql=mysqli_query($db_server,$textsql_insert);
			if(!$answsql) die("Users table UPDATE failed: ".mysqli_error($db_server));
		}
		else
		{
			die( "ERROR: WRONG INPUT DATA FROM THE FORM");
		}
		$new_id=mysqli_insert_id($db_server);
		

echo '<div class="alert alert-primary mt-5 ml-5 mr-5" role="alert">
										<h5>ВАША УЧЕТНАЯ ЗАПИСЬ ЗАРЕГИСТРИРОВАНА!</h5>
										<br/>Для продолжения работы войдите на <a href="login.php"> сайт</a><br/>
						</div>';
			
	
	
mysqli_close($db_server);

?>