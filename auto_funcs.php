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
		require_once 'login_auto.php';
		
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

				$content.= '<tr><td>'.$counter.'</td><td>'.$brand.' </td><td>'.$model.'</td><td>'.$plate.' '.$reg.'</td><td><a href="show_car.php?command=show&id='.$rec_id.'">'.$nick.'</a></td></tr>';
				
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
	to be completed ....
*/
function show_car($db_server,$id)
{
	
		$content="";
		$image_path='/auto/src/AIRLINE.jpg';
		
			$check_in_mysql='SELECT user.name,user.surname,user.father_name,sap.sap_id,user.email,profile.name,profile.description
							FROM user
							LEFT JOIN sap ON sap.user_id=user.id
							LEFT JOIN profile_reg ON sap.user_id=profile_reg.user_id
							LEFT JOIN profile ON profile.id=profile_reg.profile_id
							WHERE user.id="'.$id.'"';
					
					$answsqlcheck=mysqli_query($db_server,$check_in_mysql);
					if(!$answsqlcheck) die("LOOKUP into user TABLE failed: ".mysqli_error($db_server));
		$row = mysqli_fetch_row( $answsqlcheck );
		
				$name=$row[0];
				$surname=$row[1];
				$fname=$row[2];
				$sap_id=$row[3];
				$email=$row[4];
				$pr_name=$row[5];
				$pr_desc=$row[6];
				
				
		  //=====================================//
		 //			PROFILES SECTION			//
		//-------------------------------------//
		// AVAIABLE
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
	// ORDERED
	$check_profiles_o='SELECT profile.name,profile.description
							FROM profile_reg 
							LEFT JOIN profile ON profile.id=profile_reg.profile_id
							WHERE profile_reg.user_id='.$id.' AND profile_reg.status=2 AND profile.isValid=1';
	
					$answsqlprof=mysqli_query($db_server,$check_profiles_o);
					if(!$answsqlprof) die("LOOKUP into profile_reg TABLE failed: ".mysqli_error($db_server));

		$content_d.= '<div class="card mt-5 mr-5 border-light" style="max-width: 50rem;" >';
		 $content_d.= '<div class="card-header">Заказаны:</div>';
		$content_d.= '<div class="card-body collapse" id="Toggle_o">';
		

		$counter_o=1;
		$disc_count=0; // FOR BADGE
		$pro_name='';
		$pro_desc='';
		$content_d.='<ul class="list-group list-group-flush">';
		while($row = mysqli_fetch_row( $answsqlprof))
		{
				$pro_name=$row[0];
				$pro_desc=$row[1];
				$content_d.='<li class="list-group-item">'.$counter_o.'. <span class="applied">'.$pro_name.'</span>  <br/> '.$pro_desc.'  </li>';
				$counter_o+=1;
		}
		
		$content_d.='</ul>';
		$content_d.= '</div>';
		$content_d.= '</div>';
		$content_d.= '</div>'; //COLUMN END

if($counter>0) $counter-=1;
if($counter_o>0) $counter_o-=1;	
	// Top of the table
		$content.= '<div class="row">
						<div class="col-sm-6">';
		$content.= '<div class="card mt-3 ml-3"  style="max-width: 28rem;">
						<div class="card-header"><h5 class="card-title"> # '.$id.' | '.$surname.' '.$name.' '.$fname.'</h5></div>';
		$content.= '<div class="card-body">';					
			$content.= '<ul class="list-group list-group-flush">';
				$content.= '<li class="list-group-item">email: '.$email.'</li>';
				$content.= '<li class="list-group-item active">USER ID:   '.$sap_id.'</li>';
				
				$content.= '<li class="list-group-item ">
								<button class="btn list-group-item list-group-item-action d-flex justify-content-between align-items-center" type="button" data-toggle="collapse" data-target="#Toggle" aria-controls="Toggle" aria-expanded="false" aria-label="Info">
									Доступные Профили  <span class="badge badge-primary badge-pill">'.$counter.'</span>
								</button>
								<button class="btn list-group-item list-group-item-action d-flex justify-content-between align-items-center" type="button" data-toggle="collapse" data-target="#Toggle_o" aria-controls="Toggle_o" aria-expanded="false" aria-label="Info">
									Профили Заявлены  <span class="badge badge-primary badge-pill">'.$counter_o.'</span>
								</button>
							</li>';
				//$content.= '<li class="list-group-item">Российская а/к:<input type="checkbox" name="isRus" class="form-control" value="1" '.$status_Rus.' disabled/></li>';
				//$content.= '<li class="list-group-item">Базирование:<input type="checkbox" name="isBased" class="form-control" value="1" '.$status_Base.' disabled/></li>';
			$content.= '</ul>';	
		$content.= '</div>';//BODY
		$content.= '</div>';//CARD
		$content.= '</div>'; //COLUMN END
		
		$content.=$content_d;
		
		$content.= '</div>'; //ROW END
	Show_page($content);
	
}

// LIST ALL TRANSACTIONS
function show_transactions($db_server)

{
		
		$content="";
		$check_in_mysql="SELECT transactions.id,transactions.code,transactions.description,func_area.description
							FROM transactions
							LEFT JOIN func_area ON transactions.area=func_area.id
							WHERE 1
							ORDER by transactions.id ";
					
					$answsqlcheck=mysqli_query($db_server,$check_in_mysql);
					if(!$answsqlcheck) die("LOOKUP into services TABLE failed: ".mysqli_error($db_server));
		// Top of the table
		
		$content.= '<h2>SAP ERP список транзакций</h2>';
		$content.= '<div class="">';
		$content.= '<table class="table table-striped table-hover table-sm ml-3 mr-1 mt-1">';
		$content.= '<thead>';
		$content.= '<tr><th>№</th><th>Код</th><th>Описание</th><th>Функц.область</th>
					</tr>';
		$content.= '<tbody>';
		// Iterating through the array
		$counter=1;
		$rec_prev=0;
		$isFirst=1;
		while( $row = mysqli_fetch_row( $answsqlcheck ))  
		{ 
				$rec_id=$row[0];
				
				$code=$row[1];
				$dsc=$row[2];
				$f_area=$row[3];
				
				$content.= '<tr><td>'.$counter.'</td><td>'.$code.'</td><td>'.$dsc.'</td><td>'.$f_area.'</td></tr>';
				
			$counter+=1;
			
		}
		
		$content.= '</tbody>';
		$content.= '</table>';
		$content.= '</div>';
	Show_page($content);
}

// LIST LAST 350 USER TRANSACTIONS LOGGED IN THE SYSTEM

function show_trn_log($db_server)
{
	$content="";
		
		
			$check_in_mysql="SELECT user.name,user.father_name,user.surname,transactions.code,activity_reg.date,
									activity_reg.message,func_area.description,user.id,transactions.description
							FROM activity_reg
							LEFT JOIN user ON activity_reg.user_id=user.id
							LEFT JOIN transactions ON activity_reg.trn_id=transactions.id
							LEFT JOIN func_area ON transactions.area=func_area.id
							ORDER BY activity_reg.date,user.surname
							LIMIT 300  ";
					
					$answsqlcheck=mysqli_query($db_server,$check_in_mysql);
					if(!$answsqlcheck) die("LOOKUP into services TABLE failed: ".mysqli_error($db_server));
		$rows='';
		$counter=1;
		$rec_prev=0;
		$isFirst=1;
		$user_block='';
		$day_block='';
		$user_block_head='';
		$last_id=0;// Index to control switch to nex user_id
		while( $row = mysqli_fetch_row( $answsqlcheck ))  
		{ 
				
				$name=$row[2].' ';
				$name.=$row[0].' ';
				$name.=$row[1];
				$sap_code=$row[3];
				$trn_date=$row[4];
				//TIME CALCULATION BLOC
				$format = 'Y-m-d H:i:s';
				$trn_date_o = DateTime::createFromFormat($format,$trn_date);
				//echo "Формат: $format; " . $trn_date_o->format('d-m-Y H:i:s') . "\n";
				//$trn_time=substr($trn_date,-8);
				//$trn_date_cl=substr($trn_date,0,10);
				$trn_time=$trn_date_o->format('H:i:s');
				$trn_date_cl=$trn_date_o->format('d-m-y');
				$msg=$row[5];
				$area=$row[6];
				$user_id=$row[7];
				$tr_desc=$row[8];
				$user_block_head='<tr><td colspan="6"><b>'.$name.' : '.$trn_date_cl.'</b>';
				if(!$last_id) // VERY FIRST ITERATION
				{
					$start=DateTime::createFromFormat($format,$trn_date);
					$day_block.=$user_block_head;
				}
				elseif($user_id!=$last_id)
				{
					
						$interval = $start->diff($last_date);
						$total_time=$interval->format('%H : %I :%S');
						$day_block.=' Total time: '.$total_time.'</td></tr>';
	
					$day_block.=$user_block;
					$day_block.=$user_block_head;
					$user_block='';
					$start=DateTime::createFromFormat($format,$trn_date);
				}
				
				$user_block.= '<tr><td>'.$counter.'</td><td>'.$trn_time.'</td><td>'.$sap_code.'</td><td>'.$area.'</td><td>'.$tr_desc.'</td><td>'.$msg.'</td></tr>';
			
			$last_id=$user_id;
			$last_date=DateTime::createFromFormat($format,$trn_date);
			$counter+=1;
			//if ($counter>1000)break;
			
		}
		$interval = $start->diff($last_date);
						$total_time=$interval->format('%H : %I :%S');
						$day_block.=' Total time: '.$total_time.'</td></tr>';
		$day_block.=$user_block;
		// Top of the table
		
		$content.= '<h2 class="ml-3 mr-1 mt-3">Активность пользователей за сутки  </h2>';
		$content.= '<div class="">';
		$content.= '<table class="table table-striped table-hover table-sm ml-3 mr-1 mt-1">';
		$content.= '<thead>';
		$content.= '<tr><th>#</th><th>Время</th><th>Транзакция</th><th>Функц.область</th><th>Описание</th><th>Сообщение</th>
					</tr>';
		$content.= '<tbody>';
		$content.= $day_block;
		$content.= '</tbody>';
		$content.= '</table>';
		$content.= '</div>';
	Show_page($content);
}
function select_shpz($db_server)
{

	$select='<SELECT name="shpz" id="shpz" class="form-control" required/>';
	$select.='<option selected value="" disabled /> ..выберите.. </option>';
 
			$check_in_mysql='SELECT id,code,description
							FROM account
							WHERE 1 ORDER BY code';
					
			$answsql=mysqli_query($db_server,$check_in_mysql);
			if(!$answsql) die("LOOKUP into user TABLE failed: ".mysqli_error($db_server));
			while($row=mysqli_fetch_row($answsql))
			{
				$desc_abb=mb_substr($row[2],0,50,$enc=mb_internal_encoding());
				$select.='<option value="'.$row[0].'">'.$row[1].' | '.$desc_abb.'</option>';
			}
			$select.='</select>';
			//PROFIT CENTER SELECT
			$select_pc='<SELECT name="pc" id="pc" class="form-control" >';
			$select_pc.='<option selected value="" disabled /> ..выберите.. </option>';
			$check_pc='SELECT code, short_desc, id
							FROM profit_center
							WHERE 1';
					
					$answsql1=mysqli_query($db_server,$check_pc);
					if(!$answsql1) die("LOOKUP into profit_center TABLE failed: ".mysqli_error($db_server));
			while($row=mysqli_fetch_row($answsql1))
			{
				//$desc_abb=mb_substr($row[2],0,50,$enc=mb_internal_encoding());
				$select_pc.='<option value="'.$row[2].'">'.$row[0].' | '.$row[1].'</option>';
			}
			$select_pc.='</select>';

	$content='
				<div class="container mt-5">
				<h4 class="mb-3">Моделирование Отнесения Затрат:</h4>
					<form class=" mt-5" id="inlineForm" method="post" action="main.php?command=model">
					<div class="form-row">		
						<label  class="form-check-label" for="shpz">Шифр Производственных Затрат:</label>
						'.$select.'
			</div >
			<div class="form-row">		
						<label  class="form-check-label" for="pc">МВП:</label>
						'.$select_pc.'
			</div >		
			<button type="submit" class="btn btn-primary btn-lg mt-2" >ВВОД</button>		
		</form>
	</div>';
	Show_page($content);
	return;
}
//MODEL SHPZ
function model_shpz($db_server,$id,$pc_id)
{
		//$id= $_REQUEST['shpz'];
		//$pc_id= $_REQUEST['pc'];// PROFIT CENTER
		
		$content="";
		$image_path='/TGC1/src/AIRLINE.jpg';
		//Set up mySQL connection
			
			$check_in_mysql='SELECT cost.code,cost.description,account.code,account.description,pfm.code,pfm.description,pfm.id,
									fin_pos.code,fin_pos.short_desc,fin_pos.id, cost_center.code,cost_center.short_desc,cost.id
							FROM account
							LEFT JOIN costs_by_acc ON costs_by_acc.account_id=account.id
							LEFT JOIN cost ON costs_by_acc.cost_id=cost.id
							LEFT JOIN pfm_by_acc ON (costs_by_acc.cost_id=pfm_by_acc.cost_id )
							LEFT JOIN pfm ON (pfm_by_acc.pfm_id=pfm.id )
							LEFT JOIN mm_fp_material ON costs_by_acc.cost_id=mm_fp_material.cost_id
							LEFT JOIN fin_pos ON mm_fp_material.fp_id=fin_pos.id
							LEFT JOIN bpcj ON ( bpcj.fp_id=fin_pos.id AND bpcj.pfm_id=pfm.id )
							LEFT JOIN budget_matrix ON costs_by_acc.cost_id=budget_matrix.cost_id
							LEFT JOIN cost_center ON budget_matrix.cc_id=cost_center.id 
							WHERE account.id="'.$id.'"  AND account.isValid AND (pfm_by_acc.cc_id IN (SELECT cc_pc.cc_id FROM cc_pc WHERE cc_pc.pc_id="'.$pc_id.'"))  
							ORDER BY cost.id,pfm.id,fin_pos.id,cost_center.id';
					
					$answsqlcheck=mysqli_query($db_server,$check_in_mysql);
					if(!$answsqlcheck) die("LOOKUP into user TABLE failed: ".mysqli_error($db_server));
		$row = mysqli_fetch_row( $answsqlcheck );
		
				$cost_code=$row[0];
				$cost_desc=$row[1];
				$cost_id=$row[12];
				$shpz_code=$row[2];
				$shpz_desc=$row[3];
				$pfm_code=$row[4];
				$pfm_desc=$row[5];
				$pfm_id=$row[6];
				$fp_code=$row[7];
				$fp_desc=$row[8];
				$fp_id=$row[9];
				$cost_c_code=$row[10];
				$cost_c_desc=$row[11];
				
		if(!$row)
		{
			$content.= '<div class="alert alert-primary mt-5 ml-5 mr-5" role="alert">ПО ВАШЕМУ ЗАПРОСУ В БАЗЕ ДАННЫХ ЗАПИСЕЙ НЕ ОБНАРУЖЕНО!</div>';
		}
		else
		{
	// Top of the table
			$content.= '<div class="row">
						<div class="col-sm-8">';
			$content.= '<div class="card mt-3 ml-3"  style="max-width: 88rem;">
						<div class="card-header"><h5 class="card-title"> # ШПЗ : '.$shpz_code.' | '.$shpz_desc.' </h5>
						Вид затрат: '.$cost_code.' - '.$cost_desc.'<br/>
						<small>Фин.позиция: '.$fp_code.' | '.$fp_desc.'</small></div>';
			$content.= '<div class="card-body">';					
			$content.= '<ul class="list-group list-group-flush">';
				
				$pfm_message='<li class="list-group-item"> ПФМ: '.$pfm_code.' - '.$pfm_desc.' | <br/> МВЗ: <br/>';
				//$c_c_c_message=$cost_c_code.' - '.$cost_c_desc.'<br/>';
				$content.= $pfm_message;
				if((strlen($cost_c_code)>0)||(strlen($cost_c_desc)>0))
							{
								$content.='<small>'.$cost_c_code.' - '.$cost_c_desc.'</small><br/>';
								$count=1;
							}
				else $count=0;
				$head_flag=1; //LIST OPEN
				$new_card=0;
				while($row = mysqli_fetch_row( $answsqlcheck ))
				{
					if($cost_id!=$row[12]) //NEW CARD
					{
						// CLOSE LAST LINE
						if($count&&((strlen($cost_c_code)>0)||(strlen($cost_c_desc)>0))) $content.= ' 
									 Итого: '.$count.'</li>';
						$content.= '</ul>';	//LIST
						$content.= '</div>';//BODY
						$content.= '</div>';//CARD
						$cost_code=$row[0];
						$cost_desc=$row[1];
						$cost_id=$row[12];
						$shpz_code=$row[2];
						$shpz_desc=$row[3];
						$pfm_code=$row[4];
						$pfm_desc=$row[5];
						$pfm_id=$row[6];
						$fp_code=$row[7];
						$fp_desc=$row[8];
						$fp_id=$row[9];
						$content.= '<div class="row">
						<div class="col-sm-8">';
						$content.= '<div class="card mt-3 ml-3"  style="max-width: 88rem;">
						<div class="card-header"><h5 class="card-title"> # ШПЗ : '.$shpz_code.' | '.$shpz_desc.' </h5>
						Вид затрат: '.$cost_code.' - '.$cost_desc.'<br/>
						<small>Фин.позиция: '.$fp_code.' | '.$fp_desc.'</small></div>';
						$content.= '<div class="card-body">';					
						$content.= '<ul class="list-group list-group-flush">';
						$new_card=1;
					}
						if(($pfm_id!=$row[6])||($new_card)) // FINISH THE CYCLE: PRINT THE MESSAGE
						{
							if ($head_flag) 
							{	
								$content.= ' 
									 Итого: '.$count.'</li>';
								$head_flag=0;
							}
							$pfm_code=$row[4];
							$pfm_desc=$row[5];
							$pfm_id=$row[6];
							$content.='<li class="list-group-item"> ПФМ: '.$pfm_code.' - '.$pfm_desc.' | <br/> МВЗ: <br/>';
							$count=0;	
							$new_card=0;
							$c_c_c_message='';	
						}
						if (($cost_c_code!=$row[10])||(!$count)) // ADD STRING TO THE Cost Centers MESSAGE
						{	
							$cost_c_code=trim($row[10]);
							$cost_c_desc=trim($row[11]);
							if((strlen($cost_c_code)>0)||(strlen($cost_c_desc)>0))
							{
								$content.='<small>'.$cost_c_code.' - '.$cost_c_desc.'</small><br/>';
								$count+=1;
							}
						}	
					
				} // END OF CYCLE
			
			// PROCESS LAST LINE
			 if($count) $content.= ' 
									 Итого: '.$count.'</li>';
			$content.= '</ul>';	
			$content.= '</div>';//BODY
			$content.= '</div>';//CARD
			$content.= '</div>'; //COLUMN END
			$content.= '</div>'; //ROW END
		}
	Show_page($content);
	return;
}
function getUserBySAPID($db_server,$sap_id)
{
	$check_in_mysql='SELECT user_id
							FROM sap
							WHERE sap_id LIKE "'.$sap_id.'"';
					
					$answsqlcheck=mysqli_query($db_server,$check_in_mysql);
					if(!$answsqlcheck) die("LOOKUP into sap TABLE failed: ".mysqli_error($db_server));
		$row = mysqli_fetch_row( $answsqlcheck );
	if ($row)
		return $row[0];
	else return FALSE;
}
?>