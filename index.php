<?php 
require_once 'login_auto.php';
// INDEX
include ("header.php"); 
require_once 'auto_funcs.php';
	
			$content= '<h3 class="mt-5 ml-5" >Заметки для водителя </h3>';
			$content.=info_message('На этом сайте можно вести учет топлива и планировать ТО для своего автомобиля. <br/><hr>
									Пожалуйста зарегистрируйтесь или введите свои учетные данные.','');
			$content.= '<small class="mt-2 ml-5"> <i></i> </small>';
			Show_page($content);
	
?>
	