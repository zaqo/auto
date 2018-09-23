<?php
/*
		Updates data from the new car input form
			17/09/18		
*/
 include ("login_auto.php"); 
	
	if(isset($_REQUEST['vin'])) 		$vin 	= $_REQUEST['vin'];
	if(isset($_REQUEST['userid'])) 		$id 	= $_REQUEST['userid'];
	if(isset($_REQUEST['nick'])) 		$nick	= $_REQUEST['nick'];
	if(isset($_REQUEST['model_id'])) 	$model	= $_REQUEST['model_id'];
	if(isset($_REQUEST['plate'])) 		$plate	= $_REQUEST['plate'];
	if(isset($_REQUEST['region'])) 	$region	= $_REQUEST['region'];
	
	
	$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
		$db_server->set_charset("utf8");
		If (!$db_server) die("Can not connect to a database!!".mysqli_connect_error($db_server));
		mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));
		
		if ($model)
		{
			$textsql_insert='INSERT INTO cars
						(user_id,vin,nick,plate,region,model_id,isValid)
						VALUES( "'.$id.'","'.$vin.'","'.$nick.'","'.$plate.'","'.$region.'","'.$model.'",1)';
			
			$answsql=mysqli_query($db_server,$textsql_insert);
			if(!$answsql) die("cars table UPDATE failed: ".mysqli_error($db_server));
		}
		else
		{
			echo "ERROR: WRONG INPUT DATA FROM THE FORM";
		}
			
// reconstruct user screen	
// ? make redirect to main.php show
echo '<script>window.location.replace("main.php?command=list&id='.$id.'");</script>';			
	
	
mysqli_close($db_server);

?>