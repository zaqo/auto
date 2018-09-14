<?php 
/*
 MAIN DISPATCH MODULE
	FORWARD THE REQUEST TO A GIVEN PAGE 
	OUTPUT:  HTML 
	23/07/18
	(c) 2018 TGC-1 project
*/
require_once 'login_tgc1.php';

include ("header.php"); 
include ("tgc1_funcs.php"); 
	//Set up mySQL connection
			$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
			$db_server->set_charset("utf8");
			If (!$db_server) die("Can not connect to a database!!".mysqli_connect_error($db_server));
			mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));
			
	$dispatch= array(
		'list' => 'list_users',
		'show' => 'show_user',
		'trs_all' => 'show_transactions',
		'trs_log' => 'show_trn_log',
		'shpz' => 'select_shpz',
		'model' => 'model_shpz'
	);
	
	$cmd=(isset($_REQUEST['command']) ? $_REQUEST['command'] : '');
	$id=(isset($_REQUEST['id']) ? $_REQUEST['id'] : '');
	$shpz=(isset($_REQUEST['shpz']) ? $_REQUEST['shpz'] : '');
	$pc_id=(isset($_REQUEST['pc']) ? $_REQUEST['pc'] : '');
	
	if($shpz)
	{
		$args=array($db_server,$shpz,$pc_id);
	}
	else 
		$args=array($db_server,$id);
	
	if(array_key_exists($cmd,$dispatch))
	{
		$function=$dispatch[$cmd];
		call_user_func_array($function,$args);
	}
	else 
		echo "UNKNOW COMMAND IN REQUEST $cmd";
	
	
			$content= '<h1 class="mt-5 ml-5" >Приложение мониторинга активности пользователей</h1><br/><br/>';
			$content.= '<small class="mt-2 ml-5">developed by <i>S.Pavlov</i> </small>';
	mysqli_close($db_server);
			//Show_page($content);

?>
	