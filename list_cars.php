<?php
/*
		START screen 
		select your car
			16/09/18
			
*/
require_once 'login_auto.php';

include ("header.php"); 

if(isset($_SESSION['dude'])) 		$userid 	= $_SESSION['dude'];
else
{	

	die("Please login");
}
	$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
		$db_server->set_charset("utf8");
		If (!$db_server) die("Can not connect to a database!!".mysqli_connect_error($db_server));
		mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));

		$content="";
		
			$check_in_mysql='SELECT cars.id,cars.vin,cars.nick,cars.plate,cars.region,
								brands.name,models.name
							FROM cars
							LEFT JOIN models ON cars.model_id=models.id
							LEFT JOIN brands ON models.brand_id=brands.id
							WHERE user_id="'.$userid.'"
							ORDER by cars.id ';
					
					$answsqlcheck=mysqli_query($db_server,$check_in_mysql);
					if(!$answsqlcheck) die("LOOKUP into services TABLE failed: ".mysqli_error($db_server));
		// Top of the table
		
		$content.= '<h2>У вас в гараже</h2>';
		$content.= '<div class="">';
		$content.= '<table class="table table-striped table-hover table-sm ml-3 mr-1 mt-1">';
		$content.= '<thead>';
		$content.= '<tr><th>№</th><th>Авто</th><th>Модель</th><th>Гос.номер</th><th>Сокр.имя</th>
					</tr>';
		$content.= '<tbody>';
		// Iterating through the array
		$counter=1;
		$rec_prev=0;
		$isFirst=1;
		while( $row = mysqli_fetch_row( $answsqlcheck ))  
		{ 
				$rec_id=$row[0];
				
				$vin=$row[1];
				$nick=$row[2];
				$plate=$row[3];
				$reg=$row[4];
				$brand=$row[5];
				$model=$row[6];

				$content.= '<tr><td>'.$counter.'</td><td>'.$brand.' </td><td>'.$model.'</td><td>'.$plate.' '.$reg.'</td><td><a href="main.php?command=show&id='.$rec_id.'">'.$nick.'</a></td></tr>';
				
			$counter+=1;
			
		}
		
		$content.= '</tbody>';
		$content.= '</table>';
		$content.= '</div>';
	Show_page($content);
mysqli_close($db_server);

?>