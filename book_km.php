<?php
/*
		Updates data from the input form
			16/09/18
			
*/
 include ("login_auto.php"); 
	
	if(isset($_REQUEST['id'])) 			$id		= $_REQUEST['id'];
	if(isset($_REQUEST['mileage'])) 	$km		= $_REQUEST['mileage'];
	
	//var_dump($_REQUEST);
	
	$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
		$db_server->set_charset("utf8");
		If (!$db_server) die("Can not connect to a database!!".mysqli_connect_error($db_server));
		mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));
		

//CHECK the current mileage
	$check_in_mysql='SELECT qty FROM road_meter 
						WHERE car_id = '.$id.'  
						ORDER BY qty DESC LIMIT 1';
					
					$answsqlcheck=mysqli_query($db_server,$check_in_mysql);
					if(!$answsqlcheck) die("LOOKUP into services TABLE failed: ".mysqli_error($db_server));
		
		$row = mysqli_fetch_row( $answsqlcheck );
		$cur_km= $row[0];
		
		if ($cur_km<$km)
		{
			$textsql_insert='INSERT INTO road_meter
						(car_id,qty,mu_id,isValid)
						VALUES( "'.$id.'","'.$km.'",1,1)';
			// MU only KM now
			$answsql=mysqli_query($db_server,$textsql_insert);
			if(!$answsql) die("road_meter table UPDATE failed: ".mysqli_error($db_server));
		}
		else
		{
			echo "ERROR: WRONG INPUT DATA FROM THE FORM";
		}
		
	
		
// reconstruct user screen	
// ? make redirect to main.php show
	echo '<script>history.go(-2);</script>';			
		
	
mysqli_close($db_server);

?>