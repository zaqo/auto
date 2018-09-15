<?php // header.php
	session_start();
	?>
	<html lang="ru">
		<head>
			<script src="/auto/OSC.js"></script>
			<script src="/auto/js/menu.js"></script>
			<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
			<!--<link rel="stylesheet" href="/auto/css/jquery.minical.plain.css" type="text/css">-->
			<link rel="stylesheet" type="text/css" href="/auto/css/style.css" />
			<!-- Bootstrap core CSS -->
			<link href="/auto/css/bootstrap.min.css" rel="stylesheet">
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
	if ($loggedin)
	{
		if($status==0) //full access
		{
			echo ' <header class="navbar navbar-expand navbar-dark flex-column flex-md-row bd-navbar ">
						<a class="navbar-brand mr-0 mr-md-2" href="/prod/" aria-label="Users">
							<svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 34 34">
							<title>Logo</title>
								<path fill="currentColor" d="M33.663,18.748v-3.3H28.652a13.358,13.358,0,0,0-.757-3.714,8.617,8.617,0,0,0,3.248-6.906H27.72a5.2,5.2,0,0,1-1.543,3.881,9.984,9.984,0,0,0-3.836-2.82h0a5.3,5.3,0,0,0-5.392-4.074,5.3,5.3,0,0,0-5.392,4.074A9.989,9.989,0,0,0,7.733,8.7,5.289,5.289,0,0,1,6.22,4.872c0-.011-.008-.04-.019-.04H2.8c-.011,0-.02.03-.02.04A8.538,8.538,0,0,0,6,11.734H6a13.358,13.358,0,0,0-.758,3.718H.337v3.3H5.426a17.828,17.828,0,0,0,1.159,3.691h0a8.206,8.206,0,0,0-3.8,7.3h3.4A4.776,4.776,0,0,1,8.193,25.5h0c2.332,3.718,5.681,6.685,8.756,6.685,3.094,0,6.463-3,8.8-6.752a5.186,5.186,0,0,1,1.959,4.186c0,.015.013.119.028.119h3.41a8.178,8.178,0,0,0-3.821-7.316h0a17.8,17.8,0,0,0,1.15-3.67ZM11.618,17.191a2.419,2.419,0,1,1,2.419-2.419A2.419,2.419,0,0,1,11.618,17.191ZM16.949,24.7a2.992,2.992,0,1,1,2.992-2.992A2.992,2.992,0,0,1,16.949,24.7Zm5.331-7.479A2.419,2.419,0,1,1,24.7,14.8,2.419,2.419,0,0,1,22.28,17.223Z"></path>
							</svg>						
						</a>

						<div class="navbar-nav-scroll">
							<ul class="navbar-nav bd-navbar-nav flex-row">
								<li class="nav-item dropdown">
									<a class="nav-item nav-link dropdown-toggle mr-md-2" href="#" id="cars" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
										Авто
									</a>
									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="cars">
										<a class="dropdown-item " href="main.php?command=list" title="Cars">Перечень</a>
							
									</div>
								</li>
								<li class="nav-item dropdown">
									<a class="nav-item nav-link dropdown-toggle mr-md-2" href="#" id="mileage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
										Пробег
									</a>
									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="mileage">
										<a class="dropdown-item " href="main.php?command=book_km" title="Book">Ввести показания</a>
										<a class="dropdown-item " href="main.php?command=report_km" title="All">Отчет</a>
									</div>
								</li>
								<li class="nav-item dropdown">
									<a class="nav-item nav-link dropdown-toggle mr-md-2" href="#" id="services" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
										Статистика
									</a>
									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="services">
										<a class="dropdown-item " href="main.php?command=report_fuel" title="All">Топливный журнал</a>
										
									</div>
								</li>
							</ul>
						</div>
					<ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
    

    <li class="nav-item">
      <a class="nav-link p-2" href="" target="_blank" rel="nofollow noopener" aria-label="Киса" title="Kitten">
        <svg class="navbar-nav-svg" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 512 499.36" focusable="false"><title>Kitten</title><path d="M256 0C114.64 0 0 114.61 0 256c0 113.09 73.34 209 175.08 242.9 12.8 2.35 17.47-5.56 17.47-12.34 0-6.08-.22-22.18-.35-43.54-71.2 15.49-86.2-34.34-86.2-34.34-11.64-29.57-28.42-37.45-28.42-37.45-23.27-15.84 1.73-15.55 1.73-15.55 25.69 1.81 39.21 26.38 39.21 26.38 22.84 39.12 59.92 27.82 74.5 21.27 2.33-16.54 8.94-27.82 16.25-34.22-56.84-6.43-116.6-28.43-116.6-126.49 0-27.95 10-50.8 26.35-68.69-2.63-6.48-11.42-32.5 2.51-67.75 0 0 21.49-6.88 70.4 26.24a242.65 242.65 0 0 1 128.18 0c48.87-33.13 70.33-26.24 70.33-26.24 14 35.25 5.18 61.27 2.55 67.75 16.41 17.9 26.31 40.75 26.31 68.69 0 98.35-59.85 120-116.88 126.32 9.19 7.9 17.38 23.53 17.38 47.41 0 34.22-.31 61.83-.31 70.23 0 6.85 4.61 14.81 17.6 12.31C438.72 464.97 512 369.08 512 256.02 512 114.62 397.37 0 256 0z" fill="currentColor" fill-rule="evenodd"/></svg>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link p-2" href="" target="_blank" rel="nofollow noopener" aria-label="Bird" title="Birdy">
        <svg class="navbar-nav-svg" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 512 416.32" focusable="false"><title>Birdy</title><path d="M160.83 416.32c193.2 0 298.92-160.22 298.92-298.92 0-4.51 0-9-.2-13.52A214 214 0 0 0 512 49.38a212.93 212.93 0 0 1-60.44 16.6 105.7 105.7 0 0 0 46.3-58.19 209 209 0 0 1-66.79 25.37 105.09 105.09 0 0 0-181.73 71.91 116.12 116.12 0 0 0 2.66 24c-87.28-4.3-164.73-46.3-216.56-109.82A105.48 105.48 0 0 0 68 159.6a106.27 106.27 0 0 1-47.53-13.11v1.43a105.28 105.28 0 0 0 84.21 103.06 105.67 105.67 0 0 1-47.33 1.84 105.06 105.06 0 0 0 98.14 72.94A210.72 210.72 0 0 1 25 370.84a202.17 202.17 0 0 1-25-1.43 298.85 298.85 0 0 0 160.83 46.92" fill="currentColor"/></svg>

      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link p-2" href="" target="_blank" rel="nofollow noopener" aria-label="Data" title="Data">
        <svg class="navbar-nav-svg" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 512 512" focusable="false"><title>Hash-tag</title><path fill="currentColor" d="M210.787 234.832l68.31-22.883 22.1 65.977-68.309 22.882z"/><path d="M490.54 185.6C437.7 9.59 361.6-31.34 185.6 21.46S-31.3 150.4 21.46 326.4 150.4 543.3 326.4 490.54 543.34 361.6 490.54 185.6zM401.7 299.8l-33.15 11.05 11.46 34.38c4.5 13.92-2.87 29.06-16.78 33.56-2.87.82-6.14 1.64-9 1.23a27.32 27.32 0 0 1-24.56-18l-11.46-34.38-68.36 22.92 11.46 34.38c4.5 13.92-2.87 29.06-16.78 33.56-2.87.82-6.14 1.64-9 1.23a27.32 27.32 0 0 1-24.56-18l-11.46-34.43-33.15 11.05c-2.87.82-6.14 1.64-9 1.23a27.32 27.32 0 0 1-24.56-18c-4.5-13.92 2.87-29.06 16.78-33.56l33.12-11.03-22.1-65.9-33.15 11.05c-2.87.82-6.14 1.64-9 1.23a27.32 27.32 0 0 1-24.56-18c-4.48-13.93 2.89-29.07 16.81-33.58l33.15-11.05-11.46-34.38c-4.5-13.92 2.87-29.06 16.78-33.56s29.06 2.87 33.56 16.78l11.46 34.38 68.36-22.92-11.46-34.38c-4.5-13.92 2.87-29.06 16.78-33.56s29.06 2.87 33.56 16.78l11.47 34.42 33.15-11.05c13.92-4.5 29.06 2.87 33.56 16.78s-2.87 29.06-16.78 33.56L329.7 194.6l22.1 65.9 33.15-11.05c13.92-4.5 29.06 2.87 33.56 16.78s-2.88 29.07-16.81 33.57z" fill="currentColor"/></svg>

      </a>
    </li>
  </ul>

  <a class="btn btn-bd-download d-none d-lg-inline-block mb-3 mb-md-0 ml-md-3" href="http://localhost:8082//auto/search_daily.php">Поиск</a>
</header>';

	}
}
?>