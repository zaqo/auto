 <?php 
/*
Creates new customer record in the system
by S.Pavlov (c) 2017-2018 
*/
include ("header.php"); 
 require_once 'login_avia.php';	
		
		$content="";
		//Set up mySQL connection
			$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
			$db_server->set_charset("utf8");
			If (!$db_server) die("Can not connect to a database!!".mysqli_connect_error($db_server));
			mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));
		
			
			//---------------------------------------------------
			//	PREPARE LIST OF BUNDLES
			//---------------------------------------------------
				$textsql='SELECT  services.id,service_nick.nick
							FROM services
							LEFT JOIN service_nick ON services.id=service_nick.service_id
							WHERE isBundle AND isValid';
				$answsql=mysqli_query($db_server,$textsql);
				$num_of_cls=mysqli_num_rows($answsql);
				
				$cls_in=array();
				
				$bundles='';
					while ($cls_in= mysqli_fetch_row($answsql))  
					{
						$selected='';
						$bundles.='<option value="'.$cls_in[0].'" '.$selected.'>'.$cls_in[1].'</option>';
					}
				$bundles='<select name="bundle" id="bundle" class="custom-select d-block w-100"><option value="" > -- нет --- </option>'.$bundles.'</select>';
			  //------------------------------------------------//
			 //			PREPARE LIST OF TEMPLATES			   //
			//------------------------------------------------//
				$textsql_templ='SELECT  id,name
							FROM packages
							WHERE isValid=1';
				$answsql=mysqli_query($db_server,$textsql_templ);
				$num_of_tmp=mysqli_num_rows($answsql);
				
				$tmp_in=array();
				
				$templates='';
					while ($tmp_in= mysqli_fetch_row($answsql))  
					{
						$selected='';
						$templates.='<option value="'.$tmp_in[0].'" '.$selected.'>'.$tmp_in[1].'</option>';
					}
				$templates='<select name="template" id="template" class="custom-select d-block w-100"><option value="" > -- нет --- </option>'.$templates.'</select>';	
		// Top of the table
				
		$content.= '<div class="col-md-8 order-md-1">
						<h4 class="mb-3 ml-5">Форма ввода:</h4>';
		$content.= '<form id="form" method=post action=book_mileage.php class="needs-validation" novalidate>';
		$content.='
					<div class="mb-3">
						<label for="mileage">Пробег ()</label>
							<input type="number" class="form-control" value="" id="mil" name="mileage" min="0" max="1999999" step="1" placeholder="1000000" />
							<div class="invalid-feedback">
									Введите правильное значение идентификатора.
							</div>
					</div>
					 <hr class="mb-4">
						<button class="btn btn-primary btn-lg btn-block" type="submit">ВВОД</button>
					</form>';
		$content.= '</div>';
		
		
	Show_page($content);
	mysqli_close($db_server);
	
?>
	