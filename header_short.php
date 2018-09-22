<?php // header.php
	
	?>
	<html lang="ru">
		<head>
			<script src="/auto/js/OSC.js"></script>
			<script src="/auto/js/menu.js"></script>
			<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
			<!--<link rel="stylesheet" href="/auto/css/jquery.minical.plain.css" type="text/css">-->
			<link rel="stylesheet" type="text/css" href="/auto/css/style.css" />
			<!-- Bootstrap core CSS 
			<link href="/auto/css/bootstrap.min.css" rel="stylesheet">-->
<!-- Custom styles for this template -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link href="/auto/css/docs.min.css" rel="stylesheet" />
			
			<!--[if lt IE 9]> 
			<script type="text/javascript" src="./js/html5.js"></script>
			<![endif]-->
			<!--<script type="text/javascript" src="./js/jquery.js"></script>-->
			<script src="/auto/js/jquery-3.1.1.js"></script>
			<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
			 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
			 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
				<!--<script type="text/javascript" src="/auto/js/bootstrap.min.js"></script>-->
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
	

?>