<?php 
	
	require_once("../model/tools/session.php");

	$session = new session();

	if(strlen($session->returnUsername()) <= 0){
		header("Location: ../index.html");
	}


?>


<!DOCTYPE html>
<html>
<head>
	<title></title>

	<link rel="stylesheet" type="text/css" href="../controller/assets/css/menu.css">
	<link rel="stylesheet" type="text/css" href="../controller/assets/css/materialize.css">
	<script type="text/javascript" src="../controller/assets/js/jquery.js"></script>
	<script type="text/javascript" src="../controller/assets/js/materialize.js"></script>

</head>
<body>

	<div class="wrap">
		<div class="inner-wrap">
			
		<nav>
		    <div class="nav-wrapper">
		      <a href="index.php" class="brand-logo"><img src="../controller/assets/logo/modulator-logo.png"/></a>
		      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
		      <ul class="right hide-on-med-and-down">
		        <li><a href="index.php">Modules</a></li>
		        <li><a href="studenten.php">Studenten</a></li>
		        <li><a href="groepen.php">Groepen</a></li>
		        <li><a href="modules-koppelen.php">modules-koppelen</a></li>
		        <li><a href="beheren.php">Beheren</a></li>
		        <li><a href="../model/uitloggen.php">Uitloggen</a></li>
		      </ul>
		      <ul class="left-menu">
		      	<li><a href="#">Ingelogd als: <?php echo $session->returnUsername();?></a></li>
		      </ul>
		      
		      <ul class="side-nav" id="mobile-demo">
		       <li><a href="modules.php">Modules</a></li>
		        <li><a href="studenten.php">Studenten</a></li>
		        <li><a href="groepen.php">Groepen</a></li>
		        <li><a href="modules-koppelen.php">modules-koppelen</a></li>
		        <li><a href="beheren.php">Beheren</a></li>
		        <li><a href="#">Ingelogd als: <?php echo $session->returnUsername();?></a></li>
		        <li><a href="#">Uitloggen</a></li>

		      </ul>
		    </div>
	  </nav>


		</div>
	</div>

</body>

	<script type="text/javascript">
		$(document).ready(function(){
			$(".button-collapse").sideNav();
		})
	</script>

</html>