<?php
/*
		New car input form
			17/09/18
			Magnetosoft (c) 2018 by S.Pavlov 
*/
 include ("header.php"); 
 include ("login_auto.php"); 
	
	$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
		$db_server->set_charset("utf8");
		If (!$db_server) die("Can not connect to a database!!".mysqli_connect_error($db_server));
		mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));
		
$content="";
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
	
	/* POTENTIALLY TO BE USED FOR MODELS
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
	*/
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
						<label for="price">VIN:</label>
							<input type="text" class="form-control" value="" id="vin" name="vin" minlength="17" maxlength="17"  placeholder="JKBXGCW2W86435678" pattern="[A-Z\d]{3}[A-Z\d]{3}[A-Z0-9]{5}\d{6}$" />
							<div class="invalid-feedback">
									Введите правильное значение идентификатора.
							</div>
					</div>
					<div class="mb-3">
						<label for="plate">Гос.номер:</label>
							<input type="text" class="form-control" value="" id="plate" name="plate" minlength="6" maxlength="6" pattern="[a-cehkmoptx][0-9]{3}[a-cehkmoptx]{2}" minplaceholder="o777oo" required />
							<div class="invalid-feedback">
									Введите правильное значение идентификатора.
							</div>
					</div>
					<div class="mb-3">
						<label for="plate">Регион:</label>
							<input type="number" class="form-control" value="" id="reg" name="region" min="1" max="199" step="1" placeholder="199" required />
							<div class="invalid-feedback">
									Введите правильное значение идентификатора.
							</div>
					</div>
					 <hr class="mb-4">
						<button class="btn btn-primary btn-lg btn-block " type="submit">ВВОД</button>
					</form>';
		$content.= '</div>';
		
	Show_page($content);
	//NEW PAGE REDIRECT
	
	
mysqli_close($db_server);
?>