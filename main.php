<?php 
/*
 MAIN DISPATCH MODULE
	FORWARD THE REQUEST TO A GIVEN PAGE 
	OUTPUT:  HTML 
	14/09/18
	(c) 2018 Car maintenance
*/
require_once 'login_auto.php';

include ("header_short.php"); 
include ("auto_funcs.php"); 
session_start();
if(isset($_REQUEST['id'])) 			$id		= $_REQUEST['id'];
else $id=0;
if(isset($_SESSION['dude'])) 		$userid 	= $_SESSION['dude'];
		else
	{	

		die("Please login");
	}

//HEADER SECTION

	//Set up mySQL connection
			$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
			$db_server->set_charset("utf8");
			If (!$db_server) die("Can not connect to a database!!".mysqli_connect_error($db_server));
			mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));
			
	$dispatch= array(
		'list' => 'list_cars',
		'show' => 'show_car',
		'report_fuel' => 'show_fuel_log_card',
		'report_km' => 'show_km_log_card',
		'book_km' => 'book_mileage',
		'book_gas' => 'book_fuel',
		'new_car' => 'new_car'
	);
	
	$cmd=(isset($_REQUEST['command']) ? $_REQUEST['command'] : '');
	$id=(isset($_REQUEST['id']) ? $_REQUEST['id'] : '');
	 
	$args=array($db_server,$id);
	
	if(array_key_exists($cmd,$dispatch))
	{
		$function=$dispatch[$cmd];
		call_user_func_array($function,$args);
	}
	else 
	{
		echo "UNKNOW COMMAND IN REQUEST $cmd";
	
	}
			
	mysqli_close($db_server);
			//Show_page($content);

?>
	