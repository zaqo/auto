﻿<?php 
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
if(isset($_REQUEST['id'])) 			$id		= $_REQUEST['id'];
else $id=0;
//HEADER SECTION
echo ' <header class="navbar navbar-expand navbar-grey flex-column flex-md-row bd-navbar ">
						<a class="navbar-brand mr-0 mr-md-2" href="/auto/" aria-label="Users">
							<svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 34 34">
							<title>Logo</title>
								<path fill="gold" d="M33.663,18.748v-3.3H28.652a13.358,13.358,0,0,0-.757-3.714,8.617,8.617,0,0,0,3.248-6.906H27.72a5.2,5.2,0,0,1-1.543,3.881,9.984,9.984,0,0,0-3.836-2.82h0a5.3,5.3,0,0,0-5.392-4.074,5.3,5.3,0,0,0-5.392,4.074A9.989,9.989,0,0,0,7.733,8.7,5.289,5.289,0,0,1,6.22,4.872c0-.011-.008-.04-.019-.04H2.8c-.011,0-.02.03-.02.04A8.538,8.538,0,0,0,6,11.734H6a13.358,13.358,0,0,0-.758,3.718H.337v3.3H5.426a17.828,17.828,0,0,0,1.159,3.691h0a8.206,8.206,0,0,0-3.8,7.3h3.4A4.776,4.776,0,0,1,8.193,25.5h0c2.332,3.718,5.681,6.685,8.756,6.685,3.094,0,6.463-3,8.8-6.752a5.186,5.186,0,0,1,1.959,4.186c0,.015.013.119.028.119h3.41a8.178,8.178,0,0,0-3.821-7.316h0a17.8,17.8,0,0,0,1.15-3.67ZM11.618,17.191a2.419,2.419,0,1,1,2.419-2.419A2.419,2.419,0,0,1,11.618,17.191ZM16.949,24.7a2.992,2.992,0,1,1,2.992-2.992A2.992,2.992,0,0,1,16.949,24.7Zm5.331-7.479A2.419,2.419,0,1,1,24.7,14.8,2.419,2.419,0,0,1,22.28,17.223Z"></path>
							</svg>						
						</a>

						<div class="navbar-nav-scroll">
							<ul class="navbar-nav bd-navbar-nav flex-row">
								<li class="nav-item dropdown">
									<a class="nav-item nav-link dropdown-toggle mr-md-2" href="#" id="cars" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
										Авто
									</a>
									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="cars">
										<a class="dropdown-item " href="main.php?command=show&id='.$id.'"  title="Cars">Данные авто</a>
							
									</div>
								</li>
								<li class="nav-item dropdown">
									<a class="nav-item nav-link dropdown-toggle mr-md-2" href="#" id="input_data" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
										Ввод данных
									</a>
									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="input_data">
										<a class="dropdown-item " href="main.php?command=book_km&id='.$id.'" title="mileage">Пробег</a>
										<a class="dropdown-item " href="main.php?command=book_gas&id='.$id.'" title="fuel">Топливо</a>
										<a class="dropdown-item " href="main.php?command=book_svs&id='.$id.'" title="service">Обслуживание</a>
									</div>
								</li>
								<li class="nav-item dropdown">
									<a class="nav-item nav-link dropdown-toggle mr-md-2" href="#" id="stats" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
										Статистика
									</a>
									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="stats">
										<a class="dropdown-item " href="main.php?command=report_fuel&id='.$id.'" title="fuel">Топливный журнал</a>
										<a class="dropdown-item " href="main.php?command=report_km&id='.$id.'" title="mileage">Пробег</a>
									</div>
								</li>
							</ul>
						</div>
					<ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
    

    
  </ul>

  <a class="btn btn-bd-download d-none d-lg-inline-block mb-3 mb-md-0 ml-md-3" href="#">Поиск</a>
</header>';

	//Set up mySQL connection
			$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
			$db_server->set_charset("utf8");
			If (!$db_server) die("Can not connect to a database!!".mysqli_connect_error($db_server));
			mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));
			
	$dispatch= array(
		'list' => 'list_cars',
		'show' => 'show_car',
		'report_fuel' => 'show_fuel_log',
		'report_km' => 'show_km_log',
		'book_km' => 'book_mileage',
		'book_gas' => 'book_fuel',
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
	