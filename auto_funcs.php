<?php
/*
		THIS IS A COLLECTION OF UNDERLYING SCRIPTS
		FOR MAIN MENU ITEMS 
		14/09/18
	(c) 2018 Car maintenance project
*/
/*
	LIST ALL CARS IN THE DATABASE
	deprecated 16/09
	use list_cars.php instead to select a subject for operations
 
 */
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
		$oil_mess=' - ';
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
		$check_eo='SELECT put_on.bookedOn,material_items.name,oil_visc.value,oil_visc.season,vendors.name
							FROM put_on
							LEFT JOIN material_items ON put_on.item_id=material_items.id
							LEFT JOIN vendors ON material_items.manuf_by_id=vendors.id
							LEFT JOIN material_class ON material_items.class_id=material_class.id
							LEFT JOIN oil_attributes ON material_items.id=oil_attributes.item_id
							LEFT JOIN oil_visc ON oil_attributes.visc_winter_id=oil_visc.id OR oil_attributes.visc_summer_id=oil_visc.id
							WHERE put_on.car_id="'.$id.'" AND material_class.id=1';		
							
		$answsql_eo=mysqli_query($db_server,$check_eo);
					if(!$answsql_eo) die("LOOKUP into mileage failed: ".mysqli_error($db_server));
					
		$row2 = mysqli_fetch_row( $answsql_eo );
		$oil_fill_date=$row2[0];
		$oil_name=$row2[1];
		$vendor=$row2[4];
		$oil_winter_visc='';
		$oil_summer_visc='';
		
		if($row2[3]) $oil_summer_visc=$row2[2];
		else $oil_winter_visc=$row2[2];
		$row2 = mysqli_fetch_row( $answsql_eo );
		
		if($row2[3]) $oil_summer_visc=$row2[2];
		else $oil_winter_visc=$row2[2];
		$mu=$row1[1];
		
		//Oil compartment
		if($oil_fill_date)
			$oil_mess=$vendor.' '.$oil_name.' '.$oil_winter_visc.'W - '.$oil_summer_visc.'<br/><small> заправлено: '.$oil_fill_date.'</small>';
		
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
						<div class="card-header"><h5 class="card-title"> <i>pseudo</i>  | '.$nick.'</h5></div>';
		$content.= '<div class="card-body">';					
			$content.= '<ul class="list-group list-group-flush">';
				$content.= '<li class="list-group-item"><b>Марка:</b> '.$brand.'</li>';
				$content.= '<li class="list-group-item"><b>Модель:</b> '.$model.'</li>';
				$content.= '<li class="list-group-item active"><b>Гос.номер:  </b> '.$plate.' | '.$reg.' RUS</li>';
				$content.= '<li class="list-group-item"><b>VIN:</b> '.$vin.'</li>';
				$content.= '<li class="list-group-item"><b>Пробег:</b> <i>'.$distance.'</i> '.$mu.'</li>';
				$content.= '<li class="list-group-item"><b>Моторное масло:</b> '.$oil_mess.'</li>';
			
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
/* 

Dumps all fuel records on the screen 
15/09 
	- pagination is necessary
	- by week, by month
*/
function show_fuel_log($db_server,$id)
{
	
	$content="";
		
			$check_in_mysql='SELECT fuel_journal.qty,fuel_journal.price,fuel_journal.filledOn,
								locations.name,vendors.name, currency.name,mu.name,locations.address,fuel_grades.name	
							FROM fuel_journal
							LEFT JOIN locations ON fuel_journal.location_id=locations.id
							LEFT JOIN vendors ON locations.owner_id=vendors.id
							LEFT JOIN currency ON fuel_journal.cur_id=currency.id
							LEFT JOIN mu ON fuel_journal.mu_id=mu.id
							LEFT JOIN fuel_grades ON fuel_journal.grade_id=fuel_grades.id
							WHERE fuel_journal.isValid AND car_id="'.$id.'"
							ORDER by fuel_journal.filledOn ';
					
					$answsqlcheck=mysqli_query($db_server,$check_in_mysql);
					if(!$answsqlcheck) die("LOOKUP into services TABLE failed: ".mysqli_error($db_server));
		// Top of the table
		
		$content.= '<h2>Журнал расхода топлива</h2>';
		$content.= '<div class="">';
		$content.= '<table class="table table-striped table-hover table-sm ml-3 mr-1 mt-1">';
		$content.= '<thead>';
		$content.= '<tr><th>№</th><th>Дата</th><th>АЗС</th><th>Марка</th><th>Кол-во, литр.</th><th>Цена</th><th>Стоимость</th>
					</tr>';
		$content.= '<tbody>';
		// Iterating through the array
		$counter=1;
		$rec_prev=0;
		$isFirst=1;
		$tot_price=0;
		$tot_qty=0;
		$cur_name='';
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
				$grade=$row[8];
				$unit_price=round($price/$qty,2);
				$content.= '<tr><td>'.$counter.'</td><td>'.$date_set.' </td><td>'.$loc_owner.'<br/><small>'.$loc_name.' | '.$loc_addr.'</small></td>
							<td>'.$grade.'</td><td>'.$qty.'</td>
							<td><small>'.$unit_price.' '.$cur_name.'</small></td><td>'.$price.' '.$cur_name.'</td></tr>';
				
			$counter+=1;
			$tot_price+=$price;
			$tot_qty+=$qty;
		}
		
		$content.= '<tr><td> </td><td><b>ИТОГО:</b> </td><td></td><td></td><td>'.$tot_qty.' </td>
							<td></td><td><b>'.$tot_price.' '.$cur_name.'</b></td></tr>';
				
		$content.= '</tbody>';
		$content.= '</table>';
		$content.= '</div>';
		if(!$tot_qty)
			$content	= info_message('РАСХОДОВ НЕ ЗАРЕГИСТРИРОВАНО:','');
//$content="This page is under construction! <br/>";
	Show_page($content);
	return;
}
/* 

Dumps all mileage records on the screen 
16/09 
	- pagination is necessary
	- by week, by month
	22.09.18
*/
function show_km_log($db_server,$id)
{
	
	$content="";
		
			$check_in_mysql='SELECT road_meter.qty,mu.name,road_meter.bookedOn
							FROM road_meter
							LEFT JOIN mu ON road_meter.mu_id=mu.id
							WHERE road_meter.isValid AND car_id="'.$id.'"
							ORDER by road_meter.bookedOn DESC LIMIT 10';
					
					$answsqlcheck=mysqli_query($db_server,$check_in_mysql);
					if(!$answsqlcheck) die("LOOKUP into services TABLE failed: ".mysqli_error($db_server));
		// Top of the table
		
		
		// Iterating through the array
		$counter=0;
		$rec_prev=0;
		$isFirst=1;
		$lastM=0;
		$format = 'Y-m-d H:i:s';
		$trn_date_cl='';
		while( $row = mysqli_fetch_row( $answsqlcheck ))  
		{ 
				$qty=$row[0];
				$mu=$row[1];
				$date_=$row[2];
				
				$trn_date = DateTime::createFromFormat($format,$date_);
				
				$trn_time=$trn_date->format('H:i:s');
				$trn_date_cl=$trn_date->format('d-m-y');
				if($isFirst)
				{
					$content.= '<h2>Пробег автомобиля</h2>';
					$content.= '<div class="">';
					$content.= '<table class="table table-striped table-hover table-sm ml-3 mr-7 mt-1">';
					$content.= '<thead>';
					$content.= '<tr><th>№</th><th>Дата</th><th>Пробег, '.$mu.'</th><th>Итого, '.$mu.'</th></tr>';
					$content.= '<tbody>';
						$isFirst=0;
				
				}
				else 
					$content.= '<tr><td>'.$counter.'</td><td>'.$trn_date_cl.' </td><td>'.number_format(($lastM-$qty),0).'</td><td>'.number_format($lastM,0).'</td>
							</tr>';
				
			$counter+=1;
			$lastM=$qty;
		
		}
		if ($lastM)
			$content.= '<tr><td>'.$counter.'</td><td>'.$trn_date_cl.' </td><td></td><td>'.number_format($lastM,0).'</td>
							</tr>';
		else
			$content.= info_message('НЕТ ПОКАЗАНИЙ:','');/*'<div class="alert alert-primary mt-5 ml-5 mr-5" role="alert">
										<h5>НЕТ ПОКАЗАНИЙ:</h5>
						</div>';
		*/
		//$content.= '<tr><td> </td><td><b>ИТОГО:</b> </td><td></td><td>'.$tot_qty.' </td>
		//					<td></td><td><b>'.$tot_price.' '.$cur_name.'</b></td></tr>';
				
		$content.= '</tbody>';
		$content.= '</table>';
		$content.= '</div>';
	
	Show_page($content);
	return;
}
/*
	Makes up a messge for the user screen
	INPUT:
		- $header - message's header
		- $body	-	messages main text
	OUTPUT
		- HTML 
*/
function info_message($header,$body)
{
	return '<div class="alert alert-primary mt-5 ml-5 mr-5" role="alert">
										<h5>'.$header.'</h5>
										<br/>'.$body.'<br/>
						</div>';
}
/*
	INPUT FORM: MILEAGE 
*/

function book_mileage($db_server,$id)
{
	
	$content="";
//CHECK the current mileage
	$check_in_mysql='SELECT qty FROM road_meter 
						WHERE car_id = '.$id.'  
						ORDER BY qty DESC LIMIT 1';
					
					$answsqlcheck=mysqli_query($db_server,$check_in_mysql);
					if(!$answsqlcheck) die("LOOKUP into services TABLE failed: ".mysqli_error($db_server));
		
		$row = mysqli_fetch_row( $answsqlcheck );
		$cur_km= $row[0];
	// Top of the table
				
		
		$content.= '<div class="col-md-8 order-md-1">
						<h4 class="mb-3 ml-5"></h4>';
		$content.= '<form id="form" method=post action=book_km.php class="needs-validation" >';
		$content.='
					<div class="mb-3">
						<label for="kms">Введите пробег вашего автомобиля (км):
						<br/><small><i>последнее показание '.$cur_km.' км </></small>
						</label>
							<input type="number" class="form-control" value="" id="kms" name="mileage" min="'.$cur_km.'" max="1999999" step="1" placeholder="1000000" />
							<div class="invalid-feedback">
									Введите правильное значение идентификатора.
							</div>
					</div>
					
					 <hr class="mb-4">
						<input type="hidden" value="'.$id.'" name="id">
						<button class="btn btn-primary btn-lg btn-block" type="submit">ВВОД</button>
					</form>';
		$content.= '</div>';
		

	Show_page($content);
	return;
}
/*
	INPUT FORM: MILEAGE 
*/

function book_fuel($db_server,$id)
{
	
	$content="";
	// MAKE UP DROPDOWN ITEMS
	$select_gr='<SELECT name="grade_id" id="grade_dd" class="form-control" required/>';
	$select_gr.='<option selected value="" disabled /> ..выберите.. </option>';
	$check_grades='SELECT id,name FROM fuel_grades
						WHERE 1  
						ORDER BY name';
					
	$answsql_grades=mysqli_query($db_server,$check_grades);
	if(!$answsql_grades) die("LOOKUP into fuel_grades TABLE failed: ".mysqli_error($db_server));
		
		while($row = mysqli_fetch_row( $answsql_grades ))
			$select_gr.='<option value="'.$row[0].'">'.$row[1].'</option>';	 
	$select_gr.='</select>';
	
	$select_lc='<SELECT name="loc_id" id="loc_dd" class="form-control" required/>';
	$select_lc.='<option selected value="" disabled /> ..выберите.. </option>';
	$check_loc='SELECT id,name, address FROM locations
						WHERE 1  
						ORDER BY city_id,address';
					
	$answsql_loc=mysqli_query($db_server,$check_loc);
	if(!$answsql_loc) die("LOOKUP into locations TABLE failed: ".mysqli_error($db_server));
		
		while($row = mysqli_fetch_row( $answsql_loc ))
			$select_lc.='<option value="'.$row[0].'">'.$row[1].' | '.$row[2].'</option>';	 
	$select_lc.='</select>';
	// Top of the table
	
		$content.= '<div class="col-md-8 order-md-1">
						<h4 class="mb-3 ml-5"></h4>';
		$content.= '<form id="form" method=post action=book_gas.php class="needs-validation" >';
		$content.='
					
					<div class="mb-3">
						<label for="grade">Марка:</label>
							'.$select_gr.'
					</div>
					<div class="mb-3">
						<label for="price">Стоимость:</label>
							<input type="number" class="form-control" value="" id="price" name="cost" min="0" max="99999" step="any" placeholder="1000" />
							<div class="invalid-feedback">
									Введите правильное значение идентификатора.
							</div>
					</div>
					<div class="mb-3">
						<label for="qty">Кол-во:</label>
							<input type="number" class="form-control" value="" id="qty" name="qty" min="0" max="999" step="any" placeholder="100" />
							<div class="invalid-feedback">
									Введите правильное значение идентификатора.
							</div>
					</div>
					<div class="mb-3">
						<label for="grade">АЗС:</label>
							'.$select_lc.'
					</div>
					<div class="mb-3 ">
						<label class="form-check-label" for="inlineFormInput">Дата:</label>
							<input type="text" class="form-control mb-2 mr-sm-2 " id="inlineFormInput" value="" name="from" onfocus="this.select();lcs(this)"
												onclick="event.cancelBubble=true;this.select();lcs(this)" >
						
					</div>
					
					 <hr class="mb-4">
						<input type="hidden" value="'.$id.'" name="id">
						<button class="btn btn-primary btn-lg btn-block " data-container="body" data-toggle="popover" data-placement="top" data-content="Vivamus sagittis" type="submit">ВВОД</button>
					</form>';
		$content.= '</div>';
		/* Just for testing. Clean it pls
		$content.='<button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Tooltip on top">
						Tooltip on top
					</button>
					<button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="right" title="Tooltip on right">
						Tooltip on right
					</button>
					<button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title="Tooltip on bottom">
						Tooltip on bottom
					</button>
					<button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="left" title="Tooltip on left">
						Tooltip on left
					</button>';
		*/
	Show_page($content);
	return;
}
?>