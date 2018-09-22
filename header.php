<?php // header.php
	session_start();
	?>
	<html lang="ru">
		<head>
			<script src="/auto/js/OSC.js"></script>
			<script src="/auto/js/menu.js"></script>
			<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
			<!--<link rel="stylesheet" href="/auto/css/jquery.minical.plain.css" type="text/css">-->
			<link rel="stylesheet" type="text/css" href="/auto/css/style.css" />
			<!-- Bootstrap core CSS -->
			<link href="/auto/css/bootstrap.min.css" rel="stylesheet">
			<link rel="stylesheet" href="bootstrap-datepicker3.css">
<!-- Custom styles for this template -->
    <link href="/auto/css/docs.min.css" rel="stylesheet" />
			
			<!--[if lt IE 9]> 
			<script type="text/javascript" src="./js/html5.js"></script>
			<![endif]-->
			<!--<script type="text/javascript" src="./js/jquery.js"></script>-->
			<script src="/auto/js/jquery-3.1.1.js"></script>
			<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
			
			<script type="text/javascript" src="/auto/js/bootstrap.min.js"></script>
			<script type="text/javascript"  src="/auto/js/myFunctions.js"></script>
			<script type="text/javascript"  src="/auto/js/addfield.js"></script>
			<script src="/auto/js/calender.js" type="text/javascript"></script>
			<script src="bootstrap-datepicker.js"></script>
<?php
	include_once 'functions.php';
	
	if (isset($user))
	{
		unset($user);
	}
	$userstr = '';
	if (isset($_SESSION['user']))
	{
		$user = $_SESSION['user'];
		$loggedin = TRUE;
		$status = $_SESSION['status'];
		$userstr = " ($user)";
	}
	else $loggedin = TRUE; //FALSE;
	echo "<title>My CAR project</title>".
	"</head><body>";
	$status=0; // Delete it later on
	$nav_bar_mobile= ' 
					 <nav class="navbar navbar-expand-md bg-dark navbar-dark">
						<!-- Brand -->
						<a class="navbar-brand mr-0 mr-md-2" href="/auto/" aria-label="Auto">
						<svg version="1.1" id="Car_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="98.54px" height="98.54px" viewBox="0 0 98.54 98.54" style="enable-background:new 0 0 98.54 98.54;" xml:space="preserve"
	>
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
<g></g>
<g></g>
<g></g>
<g></g>
<g></g>
<g></g>
<g></g>
<g></g>
<g></g>
<g></g>
<g></g>
<g></g>
<g></g>
<g></g>
<g></g>
</svg>
<!--						
							<svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 34 34">
							<title>AVEBRAVA.COM</title>
								<path fill="white" d="M33.663,18.748v-3.3H28.652a13.358,13.358,0,0,0-.757-3.714,8.617,8.617,0,0,0,3.248-6.906H27.72a5.2,5.2,0,0,1-1.543,3.881,9.984,9.984,0,0,0-3.836-2.82h0a5.3,5.3,0,0,0-5.392-4.074,5.3,5.3,0,0,0-5.392,4.074A9.989,9.989,0,0,0,7.733,8.7,5.289,5.289,0,0,1,6.22,4.872c0-.011-.008-.04-.019-.04H2.8c-.011,0-.02.03-.02.04A8.538,8.538,0,0,0,6,11.734H6a13.358,13.358,0,0,0-.758,3.718H.337v3.3H5.426a17.828,17.828,0,0,0,1.159,3.691h0a8.206,8.206,0,0,0-3.8,7.3h3.4A4.776,4.776,0,0,1,8.193,25.5h0c2.332,3.718,5.681,6.685,8.756,6.685,3.094,0,6.463-3,8.8-6.752a5.186,5.186,0,0,1,1.959,4.186c0,.015.013.119.028.119h3.41a8.178,8.178,0,0,0-3.821-7.316h0a17.8,17.8,0,0,0,1.15-3.67ZM11.618,17.191a2.419,2.419,0,1,1,2.419-2.419A2.419,2.419,0,0,1,11.618,17.191ZM16.949,24.7a2.992,2.992,0,1,1,2.992-2.992A2.992,2.992,0,0,1,16.949,24.7Zm5.331-7.479A2.419,2.419,0,1,1,24.7,14.8,2.419,2.419,0,0,1,22.28,17.223Z"></path>
							</svg>						
-->
						</a>		
					
						<!-- Toggler/collapsibe Button -->
						<button class="navbar-toggler ml-3" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
							<span class="navbar-toggler-icon"></span>
						</button>

							<!-- Navbar links -->
							<div class="collapse navbar-collapse ml-3" id="collapsibleNavbar">
								<ul class="navbar-nav">
									
									<li class="nav-item dropdown ml-3">
										<a class="nav-link dropdown-toggle" href="#" id="Start" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Ваши авто
									</a>
									<div class="dropdown-menu" aria-labelledby="navbarStart">
											<a class="dropdown-item" href="new_car.php">Новая</a>
											<a class="dropdown-item" href="list_cars.php">Выбрать</a>
									</div>
								</li> 
								
								</ul>
							</div>
						</nav> ';
				
				$nav_bar_pc= ' <header class="navbar navbar-expand-lg navbar-light flex-column flex-md-row bd-navbar" >
						<a class="navbar-brand ml-3 mr-0 mr-md-2" href="/auto/" aria-label="Users">
							<svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 34 34">
							<title>Logo</title>
								<path fill="white" d="M33.663,18.748v-3.3H28.652a13.358,13.358,0,0,0-.757-3.714,8.617,8.617,0,0,0,3.248-6.906H27.72a5.2,5.2,0,0,1-1.543,3.881,9.984,9.984,0,0,0-3.836-2.82h0a5.3,5.3,0,0,0-5.392-4.074,5.3,5.3,0,0,0-5.392,4.074A9.989,9.989,0,0,0,7.733,8.7,5.289,5.289,0,0,1,6.22,4.872c0-.011-.008-.04-.019-.04H2.8c-.011,0-.02.03-.02.04A8.538,8.538,0,0,0,6,11.734H6a13.358,13.358,0,0,0-.758,3.718H.337v3.3H5.426a17.828,17.828,0,0,0,1.159,3.691h0a8.206,8.206,0,0,0-3.8,7.3h3.4A4.776,4.776,0,0,1,8.193,25.5h0c2.332,3.718,5.681,6.685,8.756,6.685,3.094,0,6.463-3,8.8-6.752a5.186,5.186,0,0,1,1.959,4.186c0,.015.013.119.028.119h3.41a8.178,8.178,0,0,0-3.821-7.316h0a17.8,17.8,0,0,0,1.15-3.67ZM11.618,17.191a2.419,2.419,0,1,1,2.419-2.419A2.419,2.419,0,0,1,11.618,17.191ZM16.949,24.7a2.992,2.992,0,1,1,2.992-2.992A2.992,2.992,0,0,1,16.949,24.7Zm5.331-7.479A2.419,2.419,0,1,1,24.7,14.8,2.419,2.419,0,0,1,22.28,17.223Z"></path>
							</svg>						
						</a>

						<div class="navbar-nav-scroll">
							<ul class="navbar-nav bd-navbar-nav flex-row">
								<li class="nav-item dropdown">
									<a class="nav-item nav-link dropdown-toggle mr-md-2" href="#" id="cars" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
										Авто
									</a>
									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="cars">
										<a class="dropdown-item " href="new_car.php" title="New">Добавить машину</a>
										<a class="dropdown-item " href="list_cars.php" title="Cars">Перечень</a>
							
									</div>
								</li>
							</ul>
						</div>
					<ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
					</ul>
				<a class="btn btn-bd-download d-none d-lg-inline-block mb-3 mb-md-0 ml-md-3" href="#">Поиск</a>
				</header>';

	if ($loggedin)
	{
		if($status==0) //full access
		{
							echo $nav_bar_mobile;
		}

	}
?>