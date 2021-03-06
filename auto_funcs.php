<?php
/*
		THIS IS A COLLECTION OF UNDERLYING SCRIPTS
		FOR MAIN MENU ITEMS 
		14/09/18
	(c) 2018 Car maintenance project
*/
/*
	LIST ALL CARS IN THE DATABASE 
	for the GIVEN USER ACCOUNT

	
 
 */
 function list_cars($db_server,$userid) 
{
		$nav_bar_mobile= entry_menu_maker($userid);
		$content="";
		$content.=$nav_bar_mobile;
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
	
		while( $row = mysqli_fetch_row( $answsqlcheck ))  
		{ 
				$rec_id=$row[0];
				
				$vin=$row[1];
				$nick=$row[2];
				$plate=$row[3];
				$reg=$row[4];
				$brand=$row[5];
				$model=$row[6];
				if($plate)
					$plate.=' '.$reg;
				else
					$plate=' - ';
				$content.= '<tr><td>'.$counter.'</td><td>'.$brand.' </td><td>'.$model.'</td><td>'.$plate.'</td><td><a href="main.php?command=show&id='.$rec_id.'">'.$nick.'</a></td></tr>';
				
			$counter+=1;
			
		}
		
		$content.= '</tbody>';
		$content.= '</table>';
		$content.= '</div>';
		if(!$answsqlcheck->num_rows)
			$content.= info_message('Машин не обнаружено!','пожалуйста зарегистрируйте авто в базе <a href="new_car.php">здесь</a>');
	Show_page($content);
mysqli_free_result($answsqlcheck);
	return;
}
//SAME FUNCTION CARDS OUTPUT
function list_cars_cards($db_server,$userid) 
{
		$nav_bar_mobile= entry_menu_maker($userid);
		$content="";
		$content.=$nav_bar_mobile;
			$check_in_mysql='SELECT cars.id,cars.vin,cars.nick,cars.plate,cars.region,
								brands.name,models.name
							FROM cars
							LEFT JOIN models ON cars.model_id=models.id
							LEFT JOIN brands ON models.brand_id=brands.id
							WHERE user_id="'.$userid.'"
							ORDER by brands.id,models.name ';
					
					$answsqlcheck=mysqli_query($db_server,$check_in_mysql);
					if(!$answsqlcheck) die("LOOKUP into services TABLE failed: ".mysqli_error($db_server));
		// Top of the table
		
		
		$content.= '<div class="card mt-3 ml-5" style="width: 28rem;">';
		$content.= '<div class="card-header">У вас в гараже</div>';
		
		$content.= ' <ul class="list-group list-group-flush">';
		
		// Iterating through the array
		$counter=1;
		$rec_prev=0;
	
		while( $row = mysqli_fetch_row( $answsqlcheck ))  
		{ 
				$rec_id=$row[0];
				
				$vin=$row[1];
				$nick=$row[2];
				$plate=$row[3];
				$reg=$row[4];
				$brand=$row[5];
				$model=$row[6];
				if($plate)
					$plate.=' '.$reg;
				else
					$plate=' - ';
				$content.= '<li class="list-group-item">'.$brand.' &nbsp&nbsp&nbsp&nbsp'.$model.'&nbsp&nbsp&nbsp&nbsp'.$plate.'&nbsp&nbsp&nbsp&nbsp<a href="main.php?command=show&id='.$rec_id.'">'.$nick.'</a></li>';
				
			$counter+=1;
			
		}
		
		$content.= '</ul>';
		$content.= '</div>';
		if(!$answsqlcheck->num_rows)
			$content.= info_message('Машин не обнаружено!','пожалуйста зарегистрируйте авто в базе <a href="new_car.php">здесь</a>');
	Show_page($content);
mysqli_free_result($answsqlcheck);
	return;
}
/*
	New CAR FORM 
	
	
	(c) 2018 Car maintenance project
	
*/
function new_car($db_server,$id)
{
$nav_bar_mobile= void_menu_maker();
$content="";
$content.=$nav_bar_mobile;
	// MAKE UP DROPDOWN ITEMS
	$select_br='<SELECT name="model_id" id="model" class="form-control" required/>';
	$select_br.='<option selected value="" disabled /> ..выберите.. </option>';
	$check_grades='SELECT models.id,models.name,brands.name 
						FROM models
						LEFT JOIN brands ON models.brand_id=brands.id
						WHERE 1  
						ORDER BY brands.id,models.name';
					
	$answsql_grades=mysqli_query($db_server,$check_grades);
	if(!$answsql_grades) die("LOOKUP into brands TABLE failed: ".mysqli_error($db_server));
		
		while($row = mysqli_fetch_row( $answsql_grades ))
			$select_br.='<option value="'.$row[0].'">'.$row[1].' | '.$row[2].'</option>';	 
	$select_br.='</select>';
	$select_fuel='<SELECT name="fuel_id" id="fuel" class="form-control" required/>';
	$select_fuel.='<option selected value="1"> Бензин </option>
					<option value="2"> Дизель </option>
					<option value="3"> Газ </option>
					<option value="4"> Электро </option>
					</select>';	 
	
	// Top of the table
	
		$content.= '<div class="col-md-8 order-md-1">
						<h4 class="mb-3 ml-5"> Создаем учетную карточку для авто:</h4>';
		$content.= '<form id="form" method=post action=book_car.php class="needs-validation" >';
		$content.='
					<div class="mb-3">
						<label for="qty">Имя:</label>
							<input type="text" class="form-control" value="" id="car_nick" name="nick" minlength="3" maxlength="10" placeholder="MyCar" required />
							<div class="invalid-feedback">
									Введите правильное значение идентификатора.
							</div>
					</div>
					<div class="mb-3">
						<label for="grade">Марка:</label>
							'.$select_br.'
					</div>
					<div class="mb-3">
						<label for="fuel">Тип двигателя:</label>
							'.$select_fuel.'
					</div>
					<div class="mb-3">
						<label for="vin">VIN (латиница):</label>
							<input type="text" class="form-control" value="" id="vin" name="vin" minlength="17" maxlength="17"  placeholder="JKBXGCW2W86435678" pattern="[a-zA-Z0-9\d]{17}$" />
							<div class="invalid-feedback">
									17 - знаков! Только латиница или цифры.
							</div>
					</div>
					<div class="mb-3">
						<label for="plate">Гос.номер (латиница):</label>
							<input type="text" class="form-control" value="" id="plate" name="plate" minlength="6" maxlength="6" placeholder="A007BC" pattern="[a-cehkmoptxA-CEHKMOPTX][0-9]{3}[a-cehkmoptxA-CEHKMOPTX]{2}" minplaceholder="o777oo" />
							<div class="invalid-feedback">
									6 - знаков! Только латиница или цифры.
							</div>
					</div>
					<div class="mb-3">
						<label for="plate">Регион:</label>
							
							<input type="number" class="form-control" value="" id="reg" name="region" min="1" max="199" step="1" placeholder="199" />
							<div class="invalid-feedback">
									Введите правильное значение идентификатора.
							</div>
					</div>
					 <hr class="mb-4">
						<input type="hidden"  value="'.$id.'" id="user" name="userid" >
						<button class="btn btn-primary btn-lg btn-block " type="submit">ВВОД</button>
					</form>';
		$content.= '</div>';
		
	Show_page($content);


return;

}
/*
	VIEW FOR INDIVIDUAL CAR CARD 
	
	OUTPUT:  HTML TABLE
	(c) 2018 Car maintenance project
	
*/
function show_car($db_server,$id,$userid)
{

		$content="";
		$nav_bar_alert= trouble_menu_maker($userid);
		$oil_m=' - ';
		$mileage_m=' - ';
		$distance=0;
		$image_path='/auto/src/AIRLINE.jpg';
	
			
			$check_in_mysql='SELECT cars.id,cars.vin,cars.nick,cars.plate,cars.region,
								brands.name,models.name,users.id
							FROM cars
							LEFT JOIN models ON cars.model_id=models.id
							LEFT JOIN brands ON models.brand_id=brands.id
							LEFT JOIN users	 ON cars.user_id=users.id
							WHERE cars.id="'.$id.'"';		
					$answsqlcheck=mysqli_query($db_server,$check_in_mysql);
					if(!$answsqlcheck) die("LOOKUP into cars TABLE failed: ".mysqli_error($db_server));
					
			$row = mysqli_fetch_row( $answsqlcheck );
		
				$rec_id=$row[0];
				$vin=strtoupper($row[1]);
				$nick=$row[2];
				if ($row[3])
					$plate=strtoupper($row[3]);
				else
					$plate=' - ';
				$reg=$row[4];
				$brand=$row[5];
				$model=$row[6];
				$user=$row[7];
		
		mysqli_free_result($answsqlcheck);
		if($user==$userid)
		{
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
			mysqli_free_result($answsql_mileage);		
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
			$oil_m=$vendor.' '.$oil_name.' '.$oil_winter_visc.'W - '.$oil_summer_visc.'<br/><small> заправлено: '.$oil_fill_date.'</small>';
			if($distance)
				$mileage_m='<i>'.$distance.'</i> '.$mu;
		
			mysqli_free_result($answsql_eo);
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
	
		$content.= car_card_menu_maker($user,$id);
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
				$content.= '<li class="list-group-item"><b>Пробег:</b> '.$mileage_m.'</li>';
				$content.= '<li class="list-group-item"><b>Моторное масло:</b> '.$oil_m.'</li>';
			
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
		}
		else
		{
			$content	= $nav_bar_alert.alert_message('Доступ запрещен!','');
		}
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
	$nav_bar_mobile= car_menu_maker($id);
	$content="";
	$content.=$nav_bar_mobile;	
			$check_in_mysql='SELECT fuel_journal.qty,fuel_journal.price,fuel_journal.filledOn,
								locations.name,vendors.name, currency.name,mu.name,locations.address,fuel_grades.name,locations.id
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
		$format = 'Y-m-d H:i:s';
		
		while( $row = mysqli_fetch_row( $answsqlcheck ))  
		{ 
				$qty=$row[0];
				$price=$row[1];
				$date_set=substr($row[2],0,10);
				$trn_date = DateTime::createFromFormat($format,$row[2]);
				$trn_date_cl=$trn_date->format('d-m-y');
				if($row[9]==8)  //FIXED DEFAULT
				{
					
					$azs=' - ';
				}
				else
				{
					$loc_name=$row[3];
					$loc_addr=$row[7];
					$loc_owner=$row[4];
					$azs= $loc_owner.'<br/><small>'.$loc_name.' | '.$loc_addr.'</small>';
				}
				$cur_name=$row[5];
				$mu_name=$row[6];
				$grade=$row[8];
				$unit_price=round($price/$qty,2);
				$content.= '<tr><td>'.$counter.'</td><td>'.$trn_date_cl.' </td><td>'.$azs.'</td>
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
			$content	= $nav_bar_mobile.info_message('РАСХОДОВ НЕ ЗАРЕГИСТРИРОВАНО:','');
//$content="This page is under construction! <br/>";
mysqli_free_result($answsqlcheck);
	Show_page($content);
	return;
}
// SAME FUNCTION OUTPUT FORMATTED FOR MOBILE (CARD)
function show_fuel_log_card($db_server,$id,$userid)
{
	$nav_bar_mobile= car_menu_maker($id);
	$nav_bar_alert= trouble_menu_maker($userid);
	$content="";
	$content.=$nav_bar_mobile;	
			$check_in_mysql='SELECT fuel_journal.qty,fuel_journal.price,fuel_journal.filledOn,
								locations.name,vendors.name, currency.name,mu.name,locations.address,fuel_grades.name,locations.id,
								users.id,cars.nick
							FROM fuel_journal
							LEFT JOIN locations ON fuel_journal.location_id=locations.id
							LEFT JOIN vendors ON locations.owner_id=vendors.id
							LEFT JOIN currency ON fuel_journal.cur_id=currency.id
							LEFT JOIN mu ON fuel_journal.mu_id=mu.id
							LEFT JOIN fuel_grades ON fuel_journal.grade_id=fuel_grades.id
							LEFT JOIN cars ON  fuel_journal.car_id=cars.id
							LEFT JOIN users ON cars.user_id=users.id
							WHERE fuel_journal.isValid AND fuel_journal.car_id="'.$id.'"
							ORDER by fuel_journal.filledOn DESC';
					
					$answsqlcheck=mysqli_query($db_server,$check_in_mysql);
					if(!$answsqlcheck) die("LOOKUP into services TABLE failed: ".mysqli_error($db_server));
					
		// Iterating through the array
		$counter=1;
		$rec_prev=0;
		$isFirst=1;
		$tot_price=0;
		$tot_qty=0;
		$cur_name='';
		$format = 'Y-m-d H:i:s';
		$row = mysqli_fetch_row( $answsqlcheck );
		$user_id=$row[10];
		$nick=$row[11];		
		//CARD HEADER
		
					$content.= '<div class="card border-primary mb-3 ml-5 mt-5" style="max-width: 28rem;">';
					$content.= '		<div class="card-header">Топливный журнал <b># '.$nick.'</b></div>';
					$content.= '			<div class="card-body text-primary">';
					$content.= '				<div class="row">';
					$col_count='<div class="col-1 col-sm-1"><p >#</p><hr>';
					$col_date='<div class="col-3 col-sm-3 text-sm-center "><p class="size-15"> <b>Дата</b></p><hr>';
					$col_price='<div class="col-3 col-sm-4  text-sm-center"><p class="size-15"><b> Цена </b></p><hr>';
					$col_qty='<div class="col-4 col-sm-4 ml-auto text-sm-center"><p class="size-15"><b> Кол-во </b></p><hr>';
		if($user_id==$userid)
		{
			$qty=$row[0];
				$price=$row[1];
				$date_set=substr($row[2],0,10);
				$trn_date = DateTime::createFromFormat($format,$row[2]);
				$trn_date_cl=$trn_date->format('d-m-y');
				if($row[9]==8)  //FIXED DEFAULT
				{
					
					$azs=' - ';
				}
				else
				{
					$loc_name=$row[3];
					$loc_addr=$row[7];
					$loc_owner=$row[4];
					$azs= $loc_owner.'<br/><small>'.$loc_name.' | '.$loc_addr.'</small>';
				}
				$cur_name=$row[5];
				$mu_name=$row[6];
				$grade=$row[8];
				$unit_price=round($price/$qty,2);
				
					$col_count.='<p>'.$counter.'</p>';
					$col_date.='<p>'.$trn_date_cl.'</p>';
					$col_price.='<p class="text-sm-right">'.number_format($price).' '.$cur_name.'</p>';
					$col_qty.='<p class="text-sm-right">'.number_format($qty).' '.$mu_name.'</p>';
				
			$counter+=1;
			$tot_price+=$price;
			$tot_qty+=$qty;
			while( $row = mysqli_fetch_row( $answsqlcheck ))  
			{ 
				$qty=$row[0];
				$price=$row[1];
				$date_set=substr($row[2],0,10);
				$trn_date = DateTime::createFromFormat($format,$row[2]);
				$trn_date_cl=$trn_date->format('d-m-y');
				if($row[9]==8)  //FIXED DEFAULT
				{
					
					$azs=' - ';
				}
				else
				{
					$loc_name=$row[3];
					$loc_addr=$row[7];
					$loc_owner=$row[4];
					$azs= $loc_owner.'<br/><small>'.$loc_name.' | '.$loc_addr.'</small>';
				}
				$cur_name=$row[5];
				$mu_name=$row[6];
				$grade=$row[8];
				$unit_price=round($price/$qty,2);
				
					$col_count.='<p>'.$counter.'</p>';
					$col_date.='<p>'.$trn_date_cl.'</p>';
					$col_price.='<p class="text-sm-right">'.number_format($price).' '.$cur_name.'</p>';
					$col_qty.='<p class="text-sm-right">'.number_format($qty).' '.$mu_name.'</p>';
				
				$counter+=1;
				$tot_price+=$price;
				$tot_qty+=$qty;
			}
		
			if ($tot_qty)
			{
				$content.=$col_count.'</div>'.$col_date.'</div>'.$col_qty.'</div>'.$col_price.'</div>';
				$content.='<div class="card-footer text-muted ">
								ИТОГО: &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.number_format($tot_qty).' '.$mu_name.'
								</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <span>'.number_format($tot_price).' '.$cur_name.'</div>';
			}
			else
			$content.= info_message('РАСХОДОВ НЕ ЗАРЕГИСТРИРОВАНО:','');
		
			$content.= '</div>';
			$content.= '</div>';
			$content.= '</div>';
		}
		else
		{
			//PLUG ALERT HERE
			$content	= $nav_bar_alert.alert_message('Доступ запрещен!','');
		}
mysqli_free_result($answsqlcheck);
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
	$nav_bar_mobile= car_menu_maker($id);
	$content="";
	$content.=$nav_bar_mobile;	
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
	mysqli_free_result($answsqlcheck);
	return;
}
/* 
	REMAKE FOR OUTPUT via CARDS instead of table (as above)
	(tailored for mobile)
	26/09/18
*/
function show_km_log_card($db_server,$id,$userid)
{
	
	$nav_bar_mobile= car_menu_maker($id);
	$nav_bar_alert= trouble_menu_maker($userid);
	$content="";
	$content.=$nav_bar_mobile;	
			$check_in_mysql='SELECT road_meter.qty,mu.name,road_meter.bookedOn,users.id,cars.nick
							FROM road_meter
							LEFT JOIN mu ON road_meter.mu_id=mu.id
							LEFT JOIN cars ON  road_meter.car_id=cars.id
							LEFT JOIN users ON cars.user_id=users.id
							WHERE road_meter.isValid AND road_meter.car_id="'.$id.'"
							ORDER by road_meter.bookedOn DESC LIMIT 10';
					
					$answsqlcheck=mysqli_query($db_server,$check_in_mysql);
					if(!$answsqlcheck) die("LOOKUP into services TABLE failed: ".mysqli_error($db_server));
		// Top of the table
		
		
		// Iterating through the array
		$counter=1;
		$rec_prev=0;
		$isFirst=1;
		$lastM=0;
		$format = 'Y-m-d H:i:s';
		$trn_date_cl='';
		$row = mysqli_fetch_row( $answsqlcheck ); //FIRST RUN
		$user_id=$row[3];
		$nick=$row[4];
		if($userid==$user_id)
		{
				$qty=$row[0];
				$mu=$row[1];
				$date_=$row[2];
				$trn_date = DateTime::createFromFormat($format,$date_);
				$trn_time=$trn_date->format('H:i:s');
				$trn_date_cl=$trn_date->format('d-m-y');
		//CARD HEADER
		
					$content.= '<div class="card border-primary mb-3 ml-5 mt-5" style="max-width: 28rem;">';
					$content.= '		<div class="card-header">Пробег автомобиля <b># '.$nick.'</b></div>';
					$content.= '			<div class="card-body text-primary">';
					$content.= '<div class="row">				';//<h5 class="card-title">Report</h5>';
					//$content.= '<ul class="list-group list-group-flush">';
					$col_count='<div class="col-1 col-sm-1"><p >#</p><hr>';
					$col_date='<div class="col-3 col-sm-3 text-sm-center "><p class="size-15"> <b>Дата</b></p><hr>';
					$col_mes='<div class="col-3 col-sm-4  text-sm-center"><p class="size-15"><b> Пробег </b></p><hr>';
					$col_total='<div class="col-4 col-sm-4 ml-auto text-sm-center"><p class="size-15"><b> Итого </b></p><hr>';
					//FIRST LANE
					$col_count.='<p>'.$counter.'</p>';
					$col_date.='<p>'.$trn_date_cl.'</p>';
					$col_mes.='<p ></p>';
					$col_total.='<p class="text-sm-right">'.number_format($qty).' '.$mu.'</p>';
					$lastM=$qty;
		while( $row = mysqli_fetch_row( $answsqlcheck ))  
		{ 
				$qty=$row[0];
				$mu=$row[1];
				$date_=$row[2];
				$trn_date = DateTime::createFromFormat($format,$date_);
				$trn_time=$trn_date->format('H:i:s');
				$trn_date_cl=$trn_date->format('d-m-y');
					$col_count.='<p>'.$counter.'</p>';
					$col_date.='<p>'.$trn_date_cl.'</p>';
					$col_mes.='<p class="text-sm-right">'.number_format($lastM-$qty).' '.$mu.'</p>';
					$col_total.='<p class="text-sm-right">'.number_format($qty).' '.$mu.'</p>';
			$counter+=1;
			$lastM=$qty;
		
		}
		if ($lastM)
		{
			//$content.= '<li class="list-group-item">'.$counter.' '.$trn_date_cl.' '.number_format($lastM,0).'</td></tr>';
			$content.=$col_count.'</div>'.$col_date.'</div>'.$col_mes.'</div>'.$col_total.'</div>';
		}
		else
			$content.= info_message('НЕТ ПОКАЗАНИЙ:','');
		
		$content.= '</div>';
		$content.= '</div>';
		$content.= '</div>';
	}
	else // BAD USER!
	{
			//PLUG ALERT HERE!
			$content	= $nav_bar_alert.alert_message('Доступ запрещен!','');
			
	}
	
	Show_page($content);
	mysqli_free_result($answsqlcheck);
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
function alert_message($header,$body)
{
	return '<div class="alert alert-danger mt-5 ml-5 mr-5" role="alert">
										<h5>'.$header.'</h5>
										<br/>'.$body.'<br/>
						</div>';
}
/*
	INPUT FORM: MILEAGE 
*/

function book_mileage($db_server,$id)
{
	$nav_bar_mobile= car_menu_maker($id);
	$content="";
	$content.=$nav_bar_mobile;
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
	
	$nav_bar_mobile= car_menu_maker($id);
	$content="";
	$content.=$nav_bar_mobile;
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
	
	$select_lc='<SELECT name="loc_id" id="loc_dd" class="form-control" />';
	$select_lc.='<option selected value="8"  /> ..не указано.. </option>';
	$check_loc='SELECT id,name, address FROM locations
						WHERE 1  
						ORDER BY city_id,address';
					
	$answsql_loc=mysqli_query($db_server,$check_loc);
	if(!$answsql_loc) die("LOOKUP into locations TABLE failed: ".mysqli_error($db_server));
		
		while($row = mysqli_fetch_row( $answsql_loc ))
			$select_lc.='<option value="'.$row[0].'">'.$row[1].' | '.$row[2].'</option>';	 
	$select_lc.='</select>';
	
	$check_fuel='SELECT cars.fuel,engine_types.grade FROM cars
						LEFT JOIN engine_types ON cars.fuel=engine_types.id 
						WHERE cars.id="'.$id.'"';
					
	$answsql_fuel=mysqli_query($db_server,$check_fuel);
	if(!$answsql_fuel) die("LOOKUP into cars TABLE failed: ".mysqli_error($db_server));
	$row_fuel = mysqli_fetch_row( $answsql_fuel );
	if($row_fuel)
	{
		$fuel_id=$row_fuel[0];
		$fuel_grade=$row_fuel[1];
	}
	else
	{//DEFAULT - 95!!!
		$fuel_grade='4';
	}
	// Top of the table
	
		$content.= '<div class="col-md-8 order-md-1">
						<h4 class="mb-3 ml-5"></h4>';
		$content.= '<form id="form" method=post action=book_gas.php class="needs-validation" >';
		$content.='
					
					<div class="mb-3">
						<input type="hidden" name="grade_id" value="'.$fuel_grade.'">
					</div>
					<div class="mb-3">
						<label for="price">Стоимость:</label>
							<input type="number" class="form-control" value="" id="price" name="cost" min="0" max="99999" step="any" placeholder="1000" required/>
							<div class="invalid-feedback">
									Введите правильное значение идентификатора.
							</div>
					</div>
					<div class="mb-3">
						<label for="qty">Кол-во:</label>
							<input type="number" class="form-control" value="" id="qty" name="qty" min="0" max="999" step="any" placeholder="100" required/>
							<div class="invalid-feedback">
									Введите правильное значение идентификатора.
							</div>
					</div>
					<div class="mb-3">
						<label for="grade">АЗС:</label>
							'.$select_lc.'
					</div>
					<div class="mb-3 ">
						<label class="form-check-label" for="dateInput">Дата:</label>
							<input type="date" class="form-control" id="dateInput" name="from" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">
							<span class="validity"></span>	
					</div>
					
					 <hr class="mb-4">
						<input type="hidden" value="'.$id.'" name="id">
						<button class="btn btn-primary btn-lg btn-block " data-container="body" data-toggle="popover" data-placement="top" data-content="Vivamus sagittis" type="submit">ВВОД</button>
					</form>';
		$content.= '</div>';
	
	Show_page($content);
	return;
}
/* 
	MAKES UP HEADER MENU SECTION FOR THE INITIAL ENTRY SECTION
	
*/
function entry_menu_maker($id)
{
	return '<nav class="navbar navbar-expand-md bg-dark navbar-dark">
						<!-- Brand -->
						<a class="navbar-brand mr-0 mr-md-2" href="login.php" aria-label="Auto" name="List">
						<svg version="1.1" id="Car_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="98.54px" height="98.54px" viewBox="0 0 98.54 98.54" style="enable-background:new 0 0 98.54 98.54;" xml:space="preserve">
<g>
	<g>
		<path fill="white" d="M78.823,62.794c0,0.359,0.029,0.71,0.074,1.059c0.521,4.149,4.056,7.361,8.347,7.361c4.407,0,8.019-3.389,8.384-7.7
			c0.02-0.238,0.037-0.478,0.037-0.72c0-4.65-3.771-8.421-8.421-8.421C82.593,54.374,78.823,58.144,78.823,62.794z M92.47,62.08
			h-2.42c-0.068-0.264-0.172-0.511-0.306-0.741l1.718-1.718C91.994,60.326,92.345,61.163,92.47,62.08z M91.462,65.995l-1.729-1.728
			c0.136-0.228,0.245-0.47,0.313-0.73h2.42C92.338,64.45,91.994,65.292,91.462,65.995z M87.974,65.596
			c0.259-0.067,0.504-0.166,0.729-0.299l1.712,1.714c-0.701,0.528-1.53,0.886-2.442,1.013L87.974,65.596L87.974,65.596z
			 M87.974,57.571c0.918,0.127,1.755,0.483,2.459,1.019l-1.716,1.716c-0.23-0.138-0.479-0.242-0.744-0.312L87.974,57.571
			L87.974,57.571z M83.025,59.621l1.719,1.718c-0.135,0.229-0.238,0.478-0.306,0.741h-2.42
			C82.144,61.163,82.495,60.326,83.025,59.621z M86.515,59.994c-0.265,0.069-0.513,0.174-0.744,0.312l-1.716-1.717
			c0.704-0.534,1.542-0.89,2.459-1.018L86.515,59.994L86.515,59.994z M84.071,67.012l1.711-1.712
			c0.226,0.133,0.474,0.229,0.731,0.296v2.429C85.604,67.898,84.772,67.541,84.071,67.012z M82.01,63.537h2.438
			c0.069,0.26,0.172,0.505,0.306,0.731l-1.722,1.721C82.5,65.288,82.138,64.451,82.01,63.537z"/>
		<path fill="white" d="M9.198,62.794c0,0.359,0.03,0.71,0.074,1.059c0.521,4.149,4.056,7.361,8.347,7.361c4.408,0,8.02-3.389,8.385-7.7
			c0.021-0.238,0.037-0.478,0.037-0.72c0-4.65-3.77-8.421-8.421-8.421S9.198,58.144,9.198,62.794z M22.846,62.08h-2.421
			c-0.067-0.264-0.171-0.511-0.305-0.741l1.718-1.718C22.369,60.326,22.72,61.163,22.846,62.08z M21.837,65.995l-1.728-1.728
			c0.135-0.228,0.245-0.47,0.313-0.73h2.42C22.714,64.45,22.369,65.292,21.837,65.995z M18.348,65.596
			c0.259-0.067,0.505-0.166,0.73-0.299l1.712,1.714c-0.701,0.528-1.531,0.886-2.443,1.013L18.348,65.596L18.348,65.596z
			 M18.348,57.571c0.919,0.127,1.755,0.483,2.459,1.019l-1.715,1.716c-0.23-0.138-0.479-0.242-0.745-0.312L18.348,57.571
			L18.348,57.571z M13.4,59.621l1.72,1.718c-0.135,0.229-0.238,0.478-0.306,0.741h-2.421C12.519,61.163,12.87,60.326,13.4,59.621z
			 M16.89,59.994c-0.265,0.069-0.514,0.174-0.744,0.312l-1.716-1.717c0.705-0.534,1.542-0.89,2.46-1.018V59.994z M14.447,67.012
			l1.711-1.712c0.226,0.133,0.473,0.229,0.731,0.296v2.429C15.979,67.898,15.148,67.541,14.447,67.012z M12.384,63.537h2.438
			c0.069,0.26,0.172,0.505,0.305,0.731l-1.722,1.721C12.875,65.288,12.513,64.451,12.384,63.537z"/>
		<path fill="white" d="M0.608,64.732l6.75-0.105c-0.029-0.172-0.066-0.342-0.089-0.517c-0.061-0.477-0.09-0.905-0.09-1.314
			c0-5.757,4.683-10.439,10.439-10.439c5.758,0,10.441,4.684,10.441,10.439c0,0.3-0.019,0.594-0.043,0.891
			c-0.018,0.209-0.053,0.413-0.083,0.619l48.903-0.768c-0.021-0.256-0.033-0.504-0.033-0.741c0-5.757,4.683-10.439,10.44-10.439
			c5.244,0,9.587,3.891,10.319,8.936c0.583-1.279,1.146-3.031,0.927-4.744c-0.418-3.258-3.258-6.421-3.425-8.012
			s0.534-2.897,0.116-5.152c-0.418-2.255-4.334-9.698-8.301-12.224c-2.882-1.835-4.958-3.084-13.711-3.586
			c-12.331-0.707-20.794,0.099-28.225,2.358c-4.418,1.344-19.541,9.212-24.126,11.751c-5.428,3.006-7.621,3.471-11.371,4.829
			c-4.333,1.569-7.086,5.012-8.172,7.614S-0.603,59.971,0.608,64.732z M69.973,41.622l-1.296-10.998
			c7.179,0.126,14.629,0.691,15.283,3.207c0.388,1.491-1.575,5.05-3.926,6.097C78.218,40.737,75.401,41.043,69.973,41.622z
			 M34.938,39.997l0.82-2.399c9.711-5.215,14.664-7.011,26.704-7.011c0.551,0,1.121,0,1.702,0l-1.383,11.728
			c-12.625,1.121-27.527,2.039-27.527,2.039C36.453,41.891,34.938,39.997,34.938,39.997z"/>
	</g>
</g>
<g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
</svg>
						</a>
						<!-- Toggler/collapsibe Button -->
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
							<span class="navbar-toggler-icon"></span>
						</button>

							<!-- Navbar links -->
							<div class="collapse navbar-collapse ml-3" id="collapsibleNavbar">
								<ul class="navbar-nav">
								
								 <li class="nav-item dropdown ml-3">
									<a class="nav-link dropdown-toggle" href="#" id="new" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Гараж
									</a>
									<div class="dropdown-menu" aria-labelledby="new">
											<a class="dropdown-item" href="main.php?command=new_car&id='.$id.'">Добавить машину</a>
									</div>
								</li> 
								</ul>
							</div>
						</nav>';
}
/* 
	MAKES UP HEADER MENU SECTION with Logo only
	
*/
function void_menu_maker()
{
	return '<nav class="navbar navbar-expand-md bg-dark navbar-dark">
						<!-- Brand -->
						<a class="navbar-brand mr-0 mr-md-2" href="'.$_SERVER['HTTP_REFERER'].'" aria-label="Auto">
						<svg version="1.1" id="Car_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="98.54px" height="98.54px" viewBox="0 0 98.54 98.54" style="enable-background:new 0 0 98.54 98.54;" xml:space="preserve">
<g>
	<g>
		<path fill="white" d="M78.823,62.794c0,0.359,0.029,0.71,0.074,1.059c0.521,4.149,4.056,7.361,8.347,7.361c4.407,0,8.019-3.389,8.384-7.7
			c0.02-0.238,0.037-0.478,0.037-0.72c0-4.65-3.771-8.421-8.421-8.421C82.593,54.374,78.823,58.144,78.823,62.794z M92.47,62.08
			h-2.42c-0.068-0.264-0.172-0.511-0.306-0.741l1.718-1.718C91.994,60.326,92.345,61.163,92.47,62.08z M91.462,65.995l-1.729-1.728
			c0.136-0.228,0.245-0.47,0.313-0.73h2.42C92.338,64.45,91.994,65.292,91.462,65.995z M87.974,65.596
			c0.259-0.067,0.504-0.166,0.729-0.299l1.712,1.714c-0.701,0.528-1.53,0.886-2.442,1.013L87.974,65.596L87.974,65.596z
			 M87.974,57.571c0.918,0.127,1.755,0.483,2.459,1.019l-1.716,1.716c-0.23-0.138-0.479-0.242-0.744-0.312L87.974,57.571
			L87.974,57.571z M83.025,59.621l1.719,1.718c-0.135,0.229-0.238,0.478-0.306,0.741h-2.42
			C82.144,61.163,82.495,60.326,83.025,59.621z M86.515,59.994c-0.265,0.069-0.513,0.174-0.744,0.312l-1.716-1.717
			c0.704-0.534,1.542-0.89,2.459-1.018L86.515,59.994L86.515,59.994z M84.071,67.012l1.711-1.712
			c0.226,0.133,0.474,0.229,0.731,0.296v2.429C85.604,67.898,84.772,67.541,84.071,67.012z M82.01,63.537h2.438
			c0.069,0.26,0.172,0.505,0.306,0.731l-1.722,1.721C82.5,65.288,82.138,64.451,82.01,63.537z"/>
		<path fill="white" d="M9.198,62.794c0,0.359,0.03,0.71,0.074,1.059c0.521,4.149,4.056,7.361,8.347,7.361c4.408,0,8.02-3.389,8.385-7.7
			c0.021-0.238,0.037-0.478,0.037-0.72c0-4.65-3.77-8.421-8.421-8.421S9.198,58.144,9.198,62.794z M22.846,62.08h-2.421
			c-0.067-0.264-0.171-0.511-0.305-0.741l1.718-1.718C22.369,60.326,22.72,61.163,22.846,62.08z M21.837,65.995l-1.728-1.728
			c0.135-0.228,0.245-0.47,0.313-0.73h2.42C22.714,64.45,22.369,65.292,21.837,65.995z M18.348,65.596
			c0.259-0.067,0.505-0.166,0.73-0.299l1.712,1.714c-0.701,0.528-1.531,0.886-2.443,1.013L18.348,65.596L18.348,65.596z
			 M18.348,57.571c0.919,0.127,1.755,0.483,2.459,1.019l-1.715,1.716c-0.23-0.138-0.479-0.242-0.745-0.312L18.348,57.571
			L18.348,57.571z M13.4,59.621l1.72,1.718c-0.135,0.229-0.238,0.478-0.306,0.741h-2.421C12.519,61.163,12.87,60.326,13.4,59.621z
			 M16.89,59.994c-0.265,0.069-0.514,0.174-0.744,0.312l-1.716-1.717c0.705-0.534,1.542-0.89,2.46-1.018V59.994z M14.447,67.012
			l1.711-1.712c0.226,0.133,0.473,0.229,0.731,0.296v2.429C15.979,67.898,15.148,67.541,14.447,67.012z M12.384,63.537h2.438
			c0.069,0.26,0.172,0.505,0.305,0.731l-1.722,1.721C12.875,65.288,12.513,64.451,12.384,63.537z"/>
		<path fill="white" d="M0.608,64.732l6.75-0.105c-0.029-0.172-0.066-0.342-0.089-0.517c-0.061-0.477-0.09-0.905-0.09-1.314
			c0-5.757,4.683-10.439,10.439-10.439c5.758,0,10.441,4.684,10.441,10.439c0,0.3-0.019,0.594-0.043,0.891
			c-0.018,0.209-0.053,0.413-0.083,0.619l48.903-0.768c-0.021-0.256-0.033-0.504-0.033-0.741c0-5.757,4.683-10.439,10.44-10.439
			c5.244,0,9.587,3.891,10.319,8.936c0.583-1.279,1.146-3.031,0.927-4.744c-0.418-3.258-3.258-6.421-3.425-8.012
			s0.534-2.897,0.116-5.152c-0.418-2.255-4.334-9.698-8.301-12.224c-2.882-1.835-4.958-3.084-13.711-3.586
			c-12.331-0.707-20.794,0.099-28.225,2.358c-4.418,1.344-19.541,9.212-24.126,11.751c-5.428,3.006-7.621,3.471-11.371,4.829
			c-4.333,1.569-7.086,5.012-8.172,7.614S-0.603,59.971,0.608,64.732z M69.973,41.622l-1.296-10.998
			c7.179,0.126,14.629,0.691,15.283,3.207c0.388,1.491-1.575,5.05-3.926,6.097C78.218,40.737,75.401,41.043,69.973,41.622z
			 M34.938,39.997l0.82-2.399c9.711-5.215,14.664-7.011,26.704-7.011c0.551,0,1.121,0,1.702,0l-1.383,11.728
			c-12.625,1.121-27.527,2.039-27.527,2.039C36.453,41.891,34.938,39.997,34.938,39.997z"/>
	</g>
</g>
<g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
</svg>
						</a>
						
						</nav>';
}
/* TOUBLE SITUATION MENUE (USER TRIED TO FETCH WRONG PARAM IN THE REQUEST) */
function trouble_menu_maker()
{
	return '<nav class="navbar navbar-expand-md bg-dark navbar-dark">
						<!-- Brand -->
						<a class="navbar-brand mr-0 mr-md-2" href="login.php" aria-label="Auto">
						<svg version="1.1" id="Car_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="98.54px" height="98.54px" viewBox="0 0 98.54 98.54" style="enable-background:new 0 0 98.54 98.54;" xml:space="preserve">
<g>
	<g>
		<path fill="white" d="M78.823,62.794c0,0.359,0.029,0.71,0.074,1.059c0.521,4.149,4.056,7.361,8.347,7.361c4.407,0,8.019-3.389,8.384-7.7
			c0.02-0.238,0.037-0.478,0.037-0.72c0-4.65-3.771-8.421-8.421-8.421C82.593,54.374,78.823,58.144,78.823,62.794z M92.47,62.08
			h-2.42c-0.068-0.264-0.172-0.511-0.306-0.741l1.718-1.718C91.994,60.326,92.345,61.163,92.47,62.08z M91.462,65.995l-1.729-1.728
			c0.136-0.228,0.245-0.47,0.313-0.73h2.42C92.338,64.45,91.994,65.292,91.462,65.995z M87.974,65.596
			c0.259-0.067,0.504-0.166,0.729-0.299l1.712,1.714c-0.701,0.528-1.53,0.886-2.442,1.013L87.974,65.596L87.974,65.596z
			 M87.974,57.571c0.918,0.127,1.755,0.483,2.459,1.019l-1.716,1.716c-0.23-0.138-0.479-0.242-0.744-0.312L87.974,57.571
			L87.974,57.571z M83.025,59.621l1.719,1.718c-0.135,0.229-0.238,0.478-0.306,0.741h-2.42
			C82.144,61.163,82.495,60.326,83.025,59.621z M86.515,59.994c-0.265,0.069-0.513,0.174-0.744,0.312l-1.716-1.717
			c0.704-0.534,1.542-0.89,2.459-1.018L86.515,59.994L86.515,59.994z M84.071,67.012l1.711-1.712
			c0.226,0.133,0.474,0.229,0.731,0.296v2.429C85.604,67.898,84.772,67.541,84.071,67.012z M82.01,63.537h2.438
			c0.069,0.26,0.172,0.505,0.306,0.731l-1.722,1.721C82.5,65.288,82.138,64.451,82.01,63.537z"/>
		<path fill="white" d="M9.198,62.794c0,0.359,0.03,0.71,0.074,1.059c0.521,4.149,4.056,7.361,8.347,7.361c4.408,0,8.02-3.389,8.385-7.7
			c0.021-0.238,0.037-0.478,0.037-0.72c0-4.65-3.77-8.421-8.421-8.421S9.198,58.144,9.198,62.794z M22.846,62.08h-2.421
			c-0.067-0.264-0.171-0.511-0.305-0.741l1.718-1.718C22.369,60.326,22.72,61.163,22.846,62.08z M21.837,65.995l-1.728-1.728
			c0.135-0.228,0.245-0.47,0.313-0.73h2.42C22.714,64.45,22.369,65.292,21.837,65.995z M18.348,65.596
			c0.259-0.067,0.505-0.166,0.73-0.299l1.712,1.714c-0.701,0.528-1.531,0.886-2.443,1.013L18.348,65.596L18.348,65.596z
			 M18.348,57.571c0.919,0.127,1.755,0.483,2.459,1.019l-1.715,1.716c-0.23-0.138-0.479-0.242-0.745-0.312L18.348,57.571
			L18.348,57.571z M13.4,59.621l1.72,1.718c-0.135,0.229-0.238,0.478-0.306,0.741h-2.421C12.519,61.163,12.87,60.326,13.4,59.621z
			 M16.89,59.994c-0.265,0.069-0.514,0.174-0.744,0.312l-1.716-1.717c0.705-0.534,1.542-0.89,2.46-1.018V59.994z M14.447,67.012
			l1.711-1.712c0.226,0.133,0.473,0.229,0.731,0.296v2.429C15.979,67.898,15.148,67.541,14.447,67.012z M12.384,63.537h2.438
			c0.069,0.26,0.172,0.505,0.305,0.731l-1.722,1.721C12.875,65.288,12.513,64.451,12.384,63.537z"/>
		<path fill="white" d="M0.608,64.732l6.75-0.105c-0.029-0.172-0.066-0.342-0.089-0.517c-0.061-0.477-0.09-0.905-0.09-1.314
			c0-5.757,4.683-10.439,10.439-10.439c5.758,0,10.441,4.684,10.441,10.439c0,0.3-0.019,0.594-0.043,0.891
			c-0.018,0.209-0.053,0.413-0.083,0.619l48.903-0.768c-0.021-0.256-0.033-0.504-0.033-0.741c0-5.757,4.683-10.439,10.44-10.439
			c5.244,0,9.587,3.891,10.319,8.936c0.583-1.279,1.146-3.031,0.927-4.744c-0.418-3.258-3.258-6.421-3.425-8.012
			s0.534-2.897,0.116-5.152c-0.418-2.255-4.334-9.698-8.301-12.224c-2.882-1.835-4.958-3.084-13.711-3.586
			c-12.331-0.707-20.794,0.099-28.225,2.358c-4.418,1.344-19.541,9.212-24.126,11.751c-5.428,3.006-7.621,3.471-11.371,4.829
			c-4.333,1.569-7.086,5.012-8.172,7.614S-0.603,59.971,0.608,64.732z M69.973,41.622l-1.296-10.998
			c7.179,0.126,14.629,0.691,15.283,3.207c0.388,1.491-1.575,5.05-3.926,6.097C78.218,40.737,75.401,41.043,69.973,41.622z
			 M34.938,39.997l0.82-2.399c9.711-5.215,14.664-7.011,26.704-7.011c0.551,0,1.121,0,1.702,0l-1.383,11.728
			c-12.625,1.121-27.527,2.039-27.527,2.039C36.453,41.891,34.938,39.997,34.938,39.997z"/>
	</g>
</g>
<g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
</svg>
						</a>
						
						</nav>';
}
/* 

	MAKES UP HEADER MENU SECTION FOR THE CAR AND AFTER
	25/09/18
*/
function car_menu_maker($id)
{
	return '<nav class="navbar navbar-expand-md bg-dark navbar-dark">
						<!-- Brand -->
						<a class="navbar-brand mr-0 mr-md-2" href="main.php?command=show&id='.$id.'" aria-label="Back">			
						<svg version="1.1" id="Car_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
							width="98.54px" height="98.54px" viewBox="0 0 98.54 98.54" style="enable-background:new 0 0 98.54 98.54;" xml:space="preserve">
<g>
	<g>
		<path fill="gold" d="M78.823,62.794c0,0.359,0.029,0.71,0.074,1.059c0.521,4.149,4.056,7.361,8.347,7.361c4.407,0,8.019-3.389,8.384-7.7
			c0.02-0.238,0.037-0.478,0.037-0.72c0-4.65-3.771-8.421-8.421-8.421C82.593,54.374,78.823,58.144,78.823,62.794z M92.47,62.08
			h-2.42c-0.068-0.264-0.172-0.511-0.306-0.741l1.718-1.718C91.994,60.326,92.345,61.163,92.47,62.08z M91.462,65.995l-1.729-1.728
			c0.136-0.228,0.245-0.47,0.313-0.73h2.42C92.338,64.45,91.994,65.292,91.462,65.995z M87.974,65.596
			c0.259-0.067,0.504-0.166,0.729-0.299l1.712,1.714c-0.701,0.528-1.53,0.886-2.442,1.013L87.974,65.596L87.974,65.596z
			 M87.974,57.571c0.918,0.127,1.755,0.483,2.459,1.019l-1.716,1.716c-0.23-0.138-0.479-0.242-0.744-0.312L87.974,57.571
			L87.974,57.571z M83.025,59.621l1.719,1.718c-0.135,0.229-0.238,0.478-0.306,0.741h-2.42
			C82.144,61.163,82.495,60.326,83.025,59.621z M86.515,59.994c-0.265,0.069-0.513,0.174-0.744,0.312l-1.716-1.717
			c0.704-0.534,1.542-0.89,2.459-1.018L86.515,59.994L86.515,59.994z M84.071,67.012l1.711-1.712
			c0.226,0.133,0.474,0.229,0.731,0.296v2.429C85.604,67.898,84.772,67.541,84.071,67.012z M82.01,63.537h2.438
			c0.069,0.26,0.172,0.505,0.306,0.731l-1.722,1.721C82.5,65.288,82.138,64.451,82.01,63.537z"/>
		<path fill="gold" d="M9.198,62.794c0,0.359,0.03,0.71,0.074,1.059c0.521,4.149,4.056,7.361,8.347,7.361c4.408,0,8.02-3.389,8.385-7.7
			c0.021-0.238,0.037-0.478,0.037-0.72c0-4.65-3.77-8.421-8.421-8.421S9.198,58.144,9.198,62.794z M22.846,62.08h-2.421
			c-0.067-0.264-0.171-0.511-0.305-0.741l1.718-1.718C22.369,60.326,22.72,61.163,22.846,62.08z M21.837,65.995l-1.728-1.728
			c0.135-0.228,0.245-0.47,0.313-0.73h2.42C22.714,64.45,22.369,65.292,21.837,65.995z M18.348,65.596
			c0.259-0.067,0.505-0.166,0.73-0.299l1.712,1.714c-0.701,0.528-1.531,0.886-2.443,1.013L18.348,65.596L18.348,65.596z
			 M18.348,57.571c0.919,0.127,1.755,0.483,2.459,1.019l-1.715,1.716c-0.23-0.138-0.479-0.242-0.745-0.312L18.348,57.571
			L18.348,57.571z M13.4,59.621l1.72,1.718c-0.135,0.229-0.238,0.478-0.306,0.741h-2.421C12.519,61.163,12.87,60.326,13.4,59.621z
			 M16.89,59.994c-0.265,0.069-0.514,0.174-0.744,0.312l-1.716-1.717c0.705-0.534,1.542-0.89,2.46-1.018V59.994z M14.447,67.012
			l1.711-1.712c0.226,0.133,0.473,0.229,0.731,0.296v2.429C15.979,67.898,15.148,67.541,14.447,67.012z M12.384,63.537h2.438
			c0.069,0.26,0.172,0.505,0.305,0.731l-1.722,1.721C12.875,65.288,12.513,64.451,12.384,63.537z"/>
		<path fill="gold" d="M0.608,64.732l6.75-0.105c-0.029-0.172-0.066-0.342-0.089-0.517c-0.061-0.477-0.09-0.905-0.09-1.314
			c0-5.757,4.683-10.439,10.439-10.439c5.758,0,10.441,4.684,10.441,10.439c0,0.3-0.019,0.594-0.043,0.891
			c-0.018,0.209-0.053,0.413-0.083,0.619l48.903-0.768c-0.021-0.256-0.033-0.504-0.033-0.741c0-5.757,4.683-10.439,10.44-10.439
			c5.244,0,9.587,3.891,10.319,8.936c0.583-1.279,1.146-3.031,0.927-4.744c-0.418-3.258-3.258-6.421-3.425-8.012
			s0.534-2.897,0.116-5.152c-0.418-2.255-4.334-9.698-8.301-12.224c-2.882-1.835-4.958-3.084-13.711-3.586
			c-12.331-0.707-20.794,0.099-28.225,2.358c-4.418,1.344-19.541,9.212-24.126,11.751c-5.428,3.006-7.621,3.471-11.371,4.829
			c-4.333,1.569-7.086,5.012-8.172,7.614S-0.603,59.971,0.608,64.732z M69.973,41.622l-1.296-10.998
			c7.179,0.126,14.629,0.691,15.283,3.207c0.388,1.491-1.575,5.05-3.926,6.097C78.218,40.737,75.401,41.043,69.973,41.622z
			 M34.938,39.997l0.82-2.399c9.711-5.215,14.664-7.011,26.704-7.011c0.551,0,1.121,0,1.702,0l-1.383,11.728
			c-12.625,1.121-27.527,2.039-27.527,2.039C36.453,41.891,34.938,39.997,34.938,39.997z"/>
	</g>
</g>
<g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
</svg>
</a>
						<!-- Toggler/collapsibe Button -->
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
							<span class="navbar-toggler-icon"></span>
						</button>

							<!-- Navbar links -->
							<div class="collapse navbar-collapse ml-3" id="collapsibleNavbar">
								<ul class="navbar-nav">
								
								 <li class="nav-item dropdown ml-3">
									<a class="nav-link dropdown-toggle" href="#" id="navbarMil" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Пробег
									</a>
									<div class="dropdown-menu" aria-labelledby="navbarMil">
											<a class="dropdown-item" href="main.php?command=book_km&id='.$id.'">Ввод</a>
											<a class="dropdown-item" href="main.php?command=report_km&id='.$id.'">Просмотр</a>
									</div>
								</li> 
								<li class="nav-item dropdown ml-3">
									<a class="nav-link dropdown-toggle" href="#" id="navbarFuel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Топливо
									</a>
									<div class="dropdown-menu" aria-labelledby="navbarFuel">
											<a class="dropdown-item" href="main.php?command=book_gas&id='.$id.'">Ввод</a>
											<a class="dropdown-item" href="main.php?command=report_fuel&id='.$id.'">Просмотр</a>
									</div>
								</li>
								</ul>
							</div>
						</nav> ';
}
function car_card_menu_maker($user,$id)
{
	return '<nav class="navbar navbar-expand-md bg-dark navbar-dark">
						<!-- Brand -->
						<a class="navbar-brand mr-0 mr-md-2" href="main.php?command=list&id='.$user.'" aria-label="Back">			
						<svg version="1.1" id="Car_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
							width="98.54px" height="98.54px" viewBox="0 0 98.54 98.54" style="enable-background:new 0 0 98.54 98.54;" xml:space="preserve">
<g>
	<g>
		<path fill="gold" d="M78.823,62.794c0,0.359,0.029,0.71,0.074,1.059c0.521,4.149,4.056,7.361,8.347,7.361c4.407,0,8.019-3.389,8.384-7.7
			c0.02-0.238,0.037-0.478,0.037-0.72c0-4.65-3.771-8.421-8.421-8.421C82.593,54.374,78.823,58.144,78.823,62.794z M92.47,62.08
			h-2.42c-0.068-0.264-0.172-0.511-0.306-0.741l1.718-1.718C91.994,60.326,92.345,61.163,92.47,62.08z M91.462,65.995l-1.729-1.728
			c0.136-0.228,0.245-0.47,0.313-0.73h2.42C92.338,64.45,91.994,65.292,91.462,65.995z M87.974,65.596
			c0.259-0.067,0.504-0.166,0.729-0.299l1.712,1.714c-0.701,0.528-1.53,0.886-2.442,1.013L87.974,65.596L87.974,65.596z
			 M87.974,57.571c0.918,0.127,1.755,0.483,2.459,1.019l-1.716,1.716c-0.23-0.138-0.479-0.242-0.744-0.312L87.974,57.571
			L87.974,57.571z M83.025,59.621l1.719,1.718c-0.135,0.229-0.238,0.478-0.306,0.741h-2.42
			C82.144,61.163,82.495,60.326,83.025,59.621z M86.515,59.994c-0.265,0.069-0.513,0.174-0.744,0.312l-1.716-1.717
			c0.704-0.534,1.542-0.89,2.459-1.018L86.515,59.994L86.515,59.994z M84.071,67.012l1.711-1.712
			c0.226,0.133,0.474,0.229,0.731,0.296v2.429C85.604,67.898,84.772,67.541,84.071,67.012z M82.01,63.537h2.438
			c0.069,0.26,0.172,0.505,0.306,0.731l-1.722,1.721C82.5,65.288,82.138,64.451,82.01,63.537z"/>
		<path fill="gold" d="M9.198,62.794c0,0.359,0.03,0.71,0.074,1.059c0.521,4.149,4.056,7.361,8.347,7.361c4.408,0,8.02-3.389,8.385-7.7
			c0.021-0.238,0.037-0.478,0.037-0.72c0-4.65-3.77-8.421-8.421-8.421S9.198,58.144,9.198,62.794z M22.846,62.08h-2.421
			c-0.067-0.264-0.171-0.511-0.305-0.741l1.718-1.718C22.369,60.326,22.72,61.163,22.846,62.08z M21.837,65.995l-1.728-1.728
			c0.135-0.228,0.245-0.47,0.313-0.73h2.42C22.714,64.45,22.369,65.292,21.837,65.995z M18.348,65.596
			c0.259-0.067,0.505-0.166,0.73-0.299l1.712,1.714c-0.701,0.528-1.531,0.886-2.443,1.013L18.348,65.596L18.348,65.596z
			 M18.348,57.571c0.919,0.127,1.755,0.483,2.459,1.019l-1.715,1.716c-0.23-0.138-0.479-0.242-0.745-0.312L18.348,57.571
			L18.348,57.571z M13.4,59.621l1.72,1.718c-0.135,0.229-0.238,0.478-0.306,0.741h-2.421C12.519,61.163,12.87,60.326,13.4,59.621z
			 M16.89,59.994c-0.265,0.069-0.514,0.174-0.744,0.312l-1.716-1.717c0.705-0.534,1.542-0.89,2.46-1.018V59.994z M14.447,67.012
			l1.711-1.712c0.226,0.133,0.473,0.229,0.731,0.296v2.429C15.979,67.898,15.148,67.541,14.447,67.012z M12.384,63.537h2.438
			c0.069,0.26,0.172,0.505,0.305,0.731l-1.722,1.721C12.875,65.288,12.513,64.451,12.384,63.537z"/>
		<path fill="gold" d="M0.608,64.732l6.75-0.105c-0.029-0.172-0.066-0.342-0.089-0.517c-0.061-0.477-0.09-0.905-0.09-1.314
			c0-5.757,4.683-10.439,10.439-10.439c5.758,0,10.441,4.684,10.441,10.439c0,0.3-0.019,0.594-0.043,0.891
			c-0.018,0.209-0.053,0.413-0.083,0.619l48.903-0.768c-0.021-0.256-0.033-0.504-0.033-0.741c0-5.757,4.683-10.439,10.44-10.439
			c5.244,0,9.587,3.891,10.319,8.936c0.583-1.279,1.146-3.031,0.927-4.744c-0.418-3.258-3.258-6.421-3.425-8.012
			s0.534-2.897,0.116-5.152c-0.418-2.255-4.334-9.698-8.301-12.224c-2.882-1.835-4.958-3.084-13.711-3.586
			c-12.331-0.707-20.794,0.099-28.225,2.358c-4.418,1.344-19.541,9.212-24.126,11.751c-5.428,3.006-7.621,3.471-11.371,4.829
			c-4.333,1.569-7.086,5.012-8.172,7.614S-0.603,59.971,0.608,64.732z M69.973,41.622l-1.296-10.998
			c7.179,0.126,14.629,0.691,15.283,3.207c0.388,1.491-1.575,5.05-3.926,6.097C78.218,40.737,75.401,41.043,69.973,41.622z
			 M34.938,39.997l0.82-2.399c9.711-5.215,14.664-7.011,26.704-7.011c0.551,0,1.121,0,1.702,0l-1.383,11.728
			c-12.625,1.121-27.527,2.039-27.527,2.039C36.453,41.891,34.938,39.997,34.938,39.997z"/>
	</g>
</g>
<g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
</svg>
</a>
						<!-- Toggler/collapsibe Button -->
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
							<span class="navbar-toggler-icon"></span>
						</button>

							<!-- Navbar links -->
							<div class="collapse navbar-collapse ml-3" id="collapsibleNavbar">
								<ul class="navbar-nav">
								
								 <li class="nav-item dropdown ml-3">
									<a class="nav-link dropdown-toggle" href="#" id="navbarMil" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Пробег
									</a>
									<div class="dropdown-menu" aria-labelledby="navbarMil">
											<a class="dropdown-item" href="main.php?command=book_km&id='.$id.'">Ввод</a>
											<a class="dropdown-item" href="main.php?command=report_km&id='.$id.'">Просмотр</a>
									</div>
								</li> 
								<li class="nav-item dropdown ml-3">
									<a class="nav-link dropdown-toggle" href="#" id="navbarFuel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Топливо
									</a>
									<div class="dropdown-menu" aria-labelledby="navbarFuel">
											<a class="dropdown-item" href="main.php?command=book_gas&id='.$id.'">Ввод</a>
											<a class="dropdown-item" href="main.php?command=report_fuel&id='.$id.'">Просмотр</a>
									</div>
								</li>
								</ul>
							</div>
						</nav> ';
}
?>