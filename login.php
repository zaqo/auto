<?php
/*
		New car input form
			17/09/18
			Magnetosoft (c) 2018 by S.Pavlov 
*/
 include ("header.php"); 
 include ("login_auto.php"); 
if(isset($_GET['command'])) 		$command 	= $_GET['command'];
else $command=FALSE;
	
	$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
		$db_server->set_charset("utf8");
		If (!$db_server) die("Can not connect to a database!!".mysqli_connect_error($db_server));
		mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));
		
$content="";
$error='';
if($command)
	$error='Неправильное имя пользователя + пароль';
	// Top of the FORM
	
		$content.= '<div class="col-md-8 order-md-1">
						<h4 class="mb-3 mt-3 ml-5"> Введите учетные данные:</h4>';
		$content.= '<form id="form" method=post action=user_login.php class="needs-validation" >';
		$content.='
					<div class="mb-3">
						<label for="qty">Имя пользователя:</label>
							<input type="text" class="form-control" value="" id="userid" name="userid" minlength="3" maxlength="12" placeholder="UserID" required />
							<div class="invalidElem">
									'.$error.'
							</div>
					</div>
					
					<div class="mb-3">
						<label for="price">Пароль:</label>
							<input type="password" class="form-control" value="" id="pass" name="pass" minlength="6" maxlength="10"  />
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