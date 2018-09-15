 <?php require_once 'login_auto.php';
/*
 VIEW FOR USER CARD 
	
	OUTPUT:  HTML TABLE
	(c) 2018 Car maintenance project
*/
	include ("header.php"); 
	
		$id= $_REQUEST['id'];
		$content="";
		$image_path='/auto/src/AIRLINE.jpg';
		//Set up mySQL connection
			$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
			$db_server->set_charset("utf8");
			If (!$db_server) die("Can not connect to a database!!".mysqli_connect_error($db_server));
			mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));
		
			
			$check_in_mysql='SELECT cars.id,cars.vin,cars.nick,cars.plate,cars.region,
								brands.name,models.name
							FROM cars
							LEFT JOIN models ON cars.model_id=models.id
							LEFT JOIN brands ON models.brand_id=brands.id
							WHERE cars.id="'.$id.'"';		
					$answsqlcheck=mysqli_query($db_server,$check_in_mysql);
					if(!$answsqlcheck) die("LOOKUP into cars TABLE failed: ".mysqli_error($db_server));
					
			$row = mysqli_fetch_row( $answsqlcheck );
		
				$rec_id=$row[0];
				$vin=strtoupper($row[1]);
				$nick=$row[2];
				$plate=strtoupper($row[3]);
				$reg=$row[4];
				$brand=$row[5];
				$model=$row[6];
		

		// Check Mileage
		$check_mileage='SELECT MAX(qty),mu.name
							FROM road_meter
							LEFT JOIN mu ON road_meter.mu_id=mu.id 
							WHERE road_meter.car_id="'.$id.'"';		
							
		$answsql_mileage=mysqli_query($db_server,$check_mileage);
					if(!$answsql_mileage) die("LOOKUP into mileage failed: ".mysqli_error($db_server));
					
		$row1 = mysqli_fetch_row( $answsql_mileage );
		$distance=number_format($row1[0]);
		$mu=$row1[1];
		  //=====================================//
		 //			ACTIONS SECTION			    //
		//-------------------------------------//
		/*
		$check_profiles='SELECT profile.name,profile.description
							FROM profile_reg 
							LEFT JOIN profile ON profile.id=profile_reg.profile_id
							WHERE profile_reg.user_id='.$id.' AND profile_reg.status=1 AND profile.isValid=1';
			
					$answsqlprof=mysqli_query($db_server,$check_profiles);
					if(!$answsqlprof) die("LOOKUP into profile_reg TABLE failed: ".mysqli_error($db_server));
		$content_d= '';

		$content_d.= '<div class="col-sm-6">';
		$content_d.= '<div class="card mt-5 mr-5 border-light" style="max-width: 50rem;" >';
		$content_d.= '<div class="card-header">Доступны в системе:</div>';
		$content_d.= '<div class="card-body collapse" id="Toggle">';
		

		$counter=1;
		$disc_count=0; // FOR BADGE
		$pro_name='';
		$pro_desc='';
		$content_d.='<ul class="list-group list-group-flush">';
		while($row = mysqli_fetch_row( $answsqlprof))
		{
			
				$pro_name=$row[0];
				$pro_desc=$row[1];
				$content_d.='<li class="list-group-item">'.$counter.'. <span class="available">'.$pro_name.'</span>  <br/> '.$pro_desc.'  </li>';
				$counter+=1;
		
		}
		
		$content_d.='</ul>';

		$content_d.= '</div>';
		$content_d.= '</div>'; //COLUMN END
*/
	// Top of the table
		$content.= '<div class="row">
						<div class="col-sm-6">';
		$content.= '<div class="card mt-3 ml-3"  style="max-width: 28rem;">
						<div class="card-header"><h5 class="card-title"> # '.$id.' | '.$nick.'</h5></div>';
		$content.= '<div class="card-body">';					
			$content.= '<ul class="list-group list-group-flush">';
				$content.= '<li class="list-group-item"><b>Марка:</b> '.$brand.'</li>';
				$content.= '<li class="list-group-item"><b>Модель:</b> '.$model.'</li>';
				$content.= '<li class="list-group-item active"><b>Гос.номер:  </b> '.$plate.' | '.$reg.' RUS</li>';
				$content.= '<li class="list-group-item"><b>VIN:</b> '.$vin.'</li>';
				$content.= '<li class="list-group-item"><b>Пробег:</b> '.$distance.' '.$mu.'</li>';
			
				/*
				$content.= '<li class="list-group-item ">
								<button class="btn list-group-item list-group-item-action d-flex justify-content-between align-items-center" type="button" data-toggle="collapse" data-target="#Toggle" aria-controls="Toggle" aria-expanded="false" aria-label="Info">
									Доступные Профили  <span class="badge badge-primary badge-pill">'.$counter.'</span>
								</button>
								<button class="btn list-group-item list-group-item-action d-flex justify-content-between align-items-center" type="button" data-toggle="collapse" data-target="#Toggle_o" aria-controls="Toggle_o" aria-expanded="false" aria-label="Info">
									Профили Заявлены  <span class="badge badge-primary badge-pill">'.$counter_o.'</span>
								</button>
							</li>';
				*/
			$content.= '</ul>';	
		$content.= '</div>';//BODY
		$content.= '</div>';//CARD
		$content.= '</div>'; //COLUMN END
		
		//$content.=$content_d;
		
		$content.= '</div>'; //ROW END
	Show_page($content);
	mysqli_close($db_server);
	
?>
	