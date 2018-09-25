<?php
/*
		Updates data from the input form
			16/09/18
			
*/
 include ("login_auto.php"); 
	
	if(isset($_REQUEST['id'])) 			$id		= $_REQUEST['id'];
	if(isset($_REQUEST['cost'])) 		$cost	= $_REQUEST['cost'];
	if(isset($_REQUEST['qty'])) 		$qty	= $_REQUEST['qty'];
	if(isset($_REQUEST['from'])) 		$date_	= $_REQUEST['from'];
	if(isset($_REQUEST['grade_id'])) 	$grade	= $_REQUEST['grade_id'];
	if(isset($_REQUEST['loc_id'])) 		$location	= $_REQUEST['loc_id'];
	
	//var_dump($_REQUEST);
	
	$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
		$db_server->set_charset("utf8");
		If (!$db_server) die("Can not connect to a database!!".mysqli_connect_error($db_server));
		mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));
		
		if (($qty>0)&&($cost>0))
		{
			$textsql_insert='INSERT INTO fuel_journal
						(car_id,qty,mu_id,price,cur_id,location_id,grade_id,filledOn,isValid)
						VALUES( "'.$id.'","'.$qty.'",3,"'.$cost.'",1,"'.$location.'", "'.$grade.'", "'.$date_.'",1)';
			// MU only liters now
			$answsql=mysqli_query($db_server,$textsql_insert);
			if(!$answsql) die("fuel_journal table UPDATE failed: ".mysqli_error($db_server));
		}
		else
		{
			echo "ERROR: WRONG INPUT DATA FROM THE FORM";
		}
		
	
		
// reconstruct user screen	
// ? make redirect to main.php show
echo '<script>window.location.replace("main.php?command=show&id='.$id.'");</script>';			
	
	
mysqli_close($db_server);

?>