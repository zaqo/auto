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

		//LOCATION DROPDOWN
	$select_loc='<SELECT name="user_loc" id="loc" class="form-control" required/>';
	$select_loc.='<option selected value="" disabled /> ..выберите.. </option>';
	$check_grades='SELECT cities.id,cities.name,cities.name_en 
						FROM cities
						WHERE 1  
						ORDER BY cities.name DESC';
					
	$answsql_grades=mysqli_query($db_server,$check_grades);
	if(!$answsql_grades) die("LOOKUP into cities TABLE failed: ".mysqli_error($db_server));
		
		while($row = mysqli_fetch_row( $answsql_grades ))
			$select_loc.='<option value="'.$row[0].'">'.$row[1].' </option>';	 
	$select_loc.='</select>';		
$content="";
	
	// Top of the FORM
	
		$content.= '<div class="col-md-8 order-md-1">
						<h4 class="mb-3 mt-3 ml-5"> Введите учетные данные:</h4>';
		$content.= '<form id="form" method=post action=book_user.php class="needs-validation" >';
		$content.='
					<div class="mb-3">
						<label for="userid">Имя пользователя:</label>
							<input type="text" class="form-control" value="" id="userid" name="username" minlength="3" maxlength="12" placeholder="Mr.Incognito" required />
							<div class="invalid-feedback">
									Введите правильное значение идентификатора.
							</div>
					</div>
					
					<div class="mb-3">
						<label for="pass">Pass:</label>
							<input type="password" class="form-control" value="" id="pass" name="pass" minlength="6" maxlength="17" pattern="[A-Z\d]{,6}$" />
							<div class="invalid-feedback">
									Введите правильное значение идентификатора.
							</div>
					</div>
					<div class="mb-3">
						<label for="email">Email:</label>
							<input type="text" class="form-control" value="" id="email" name="email" minlength="5" maxlength="20" placeholder="u@at.ru" required />
							<div class="invalid-feedback">
									Введите правильное значение идентификатора.
							</div>
					</div>
					<div class="mb-3">
						<label for="loc">Местонахождение:</label>
							'.$select_loc.'
					</div>
					 <hr class="mb-4">
						<button class="btn btn-primary btn-lg btn-block " type="submit">ВВОД</button>
					</form>';
		$content.= '</div>';
		
	Show_page($content);
	//NEW PAGE REDIRECT
	
	
mysqli_close($db_server);
?>