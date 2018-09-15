<?php
/*
		THIS IS A COLLECTION OF UNDERLYING SCRIPTS
		FOR MAIN MENU ITEMS 
		14/09/18
	(c) 2018 Car maintenance project
*/
// LIST ALL CARS IN THE DATABASE
function list_cars($db_server) 
{

		$content="";
		
			$check_in_mysql="SELECT cars.id,cars.vin,cars.nick,cars.plate,cars.region,
								brands.name,models.name
							FROM cars
							LEFT JOIN models ON cars.model_id=models.id
							LEFT JOIN brands ON models.brand_id=brands.id
							WHERE 1
							ORDER by cars.id ";
					
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
	return;
}
/*
	VIEW FOR INDIVIDUAL CAR CARD 
	
	OUTPUT:  HTML TABLE
	(c) 2018 Car maintenance project
	
*/
function show_car($db_server,$id)
{

		$content="";
		$image_path='/auto/src/AIRLINE.jpg';
	
			
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
		
		// Engine Oil
		$check_eo='SELECT put_on.bookedOn,material_items.name,oil_visc.value,oil_visc.season
							FROM put_on
							LEFT JOIN material_items ON put_on.item_id=material_items.id
							LEFT JOIN material_class ON material_items.class_id=material_class.id
							LEFT JOIN oil_attributes ON material_items.id=oil_attributes.item_id
							LEFT JOIN oil_visc ON oil_attributes.visc_winter_id=oil_visc.id OR oil_attributes.visc_summer_id=oil_visc.id
							WHERE put_on.car_id="'.$id.'" AND material_class.id=1';		
							
		$answsql_eo=mysqli_query($db_server,$check_eo);
					if(!$answsql_eo) die("LOOKUP into mileage failed: ".mysqli_error($db_server));
					
		$row2 = mysqli_fetch_row( $answsql_eo );
		$oil_fill_date=$row2[0];
		$oil_name=$row2[1];
		if($row2[3]) $oil_summer_visc=$row2[2];
		else $oil_winter_visc=$row2[2];
		$row2 = mysqli_fetch_row( $answsql_eo );
		if($row2[3]) $oil_summer_visc=$row2[2];
		else $oil_winter_visc=$row2[2];
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
				$content.= '<li class="list-group-item"><b>Моторное масло:</b> '.$oil_name.' '.$oil_winter_visc.'W - '.$oil_summer_visc.' залито: '.$oil_fill_date.'</li>';
			
				/* BUTTONS FOR FUTURE USE
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
	return;
	
}
function show_fuel_log($db_server,$id)
{
	
	$content="";
		
			$check_in_mysql="SELECT fuel_journal.qty,fuel_journal.price,fuel_journal.filledOn,
								locations.name,vendors.name, currency.name,mu.name,locations.address	
							FROM fuel_journal
							LEFT JOIN locations ON fuel_journal.location_id=locations.id
							LEFT JOIN vendors ON locations.owner_id=vendors.id
							LEFT JOIN currency ON fuel_journal.cur_id=currency.id
							LEFT JOIN mu ON fuel_journal.mu_id=mu.id
							LEFT JOIN fuel_grades ON fuel_journal.grade_id=fuel_grades.id
							WHERE fuel_journal.isValid
							ORDER by fuel_journal.filledOn ";
					
					$answsqlcheck=mysqli_query($db_server,$check_in_mysql);
					if(!$answsqlcheck) die("LOOKUP into services TABLE failed: ".mysqli_error($db_server));
		// Top of the table
		
		$content.= '<h2>Журнал расхода топлива</h2>';
		$content.= '<div class="">';
		$content.= '<table class="table table-striped table-hover table-sm ml-3 mr-1 mt-1">';
		$content.= '<thead>';
		$content.= '<tr><th>№</th><th>Дата</th><th>АЗС</th><th>Кол-во, литр.</th><th>Цена</th><th>Стоимость</th>
					</tr>';
		$content.= '<tbody>';
		// Iterating through the array
		$counter=1;
		$rec_prev=0;
		$isFirst=1;
		$tot_price=0;
		$tot_qty=0;
		while( $row = mysqli_fetch_row( $answsqlcheck ))  
		{ 
				$qty=$row[0];
				$price=$row[1];
				$date_set=$row[2];
				
				$loc_name=$row[3];
				$loc_addr=$row[7];
				$loc_owner=$row[4];
				
				$cur_name=$row[5];
				$mu_name=$row[6];
				$unit_price=round($price/$qty,2);
				$content.= '<tr><td>'.$counter.'</td><td>'.$date_set.' </td><td>'.$loc_owner.'<br/><small>'.$loc_name.' | '.$loc_addr.'</small></td><td>'.$qty.'</td>
							<td><small>'.$unit_price.' '.$cur_name.'</small></td><td>'.$price.' '.$cur_name.'</td></tr>';
				
			$counter+=1;
			$tot_price+=$price;
			$tot_qty+=$qty;
		}
		$content.= '<tr><td> </td><td><b>ИТОГО:</b> </td><td></td><td>'.$tot_qty.' </td>
							<td></td><td><b>'.$tot_price.' '.$cur_name.'</b></td></tr>';
				
		$content.= '</tbody>';
		$content.= '</table>';
		$content.= '</div>';
	//$content="This page is under construction! <br/>";
	Show_page($content);
	return;
}
?>