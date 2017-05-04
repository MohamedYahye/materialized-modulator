

<?php 
	require_once("../model/tools/session.php");

	$session = new session();

	if(strlen($session->returnUsername()) <= 0){
		header("Location: ../index.php");
	}



?>


<!DOCTYPE html>
<html>
<head>
	<title></title>

	<link rel="stylesheet" type="text/css" href="../controller/css/menu.css">
	<link rel="stylesheet" type="text/css" href="../controller/css/materialize.css">
	<script type="text/javascript" src="../controller/js/jquery.js"></script>
	<script type="text/javascript" src="../controller/js/materialize.js"></script>

</head>
<body>

	<div class="wrap">
		<div class="inner-wrap">
			
		<nav>
		    <div class="nav-wrapper">
		      <a href="#" class="brand-logo"><img src="../beheerder/controller/assets/logo/modulator-logo.png"/></a>
		      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
		      <ul class="right hide-on-med-and-down">
		        <li><a href="#">Home</a></li>
		        <li><a href="#">Beheren</a></li>
		        <li><a href="#">Uitloggen</a></li>
		      </ul>
		      <ul class="left-menu">

		      	<li><a href="#">Ingelogd als: <?php echo $session->returnUsername();?></a></li>
		      </ul>
		      
		      <ul class="side-nav" id="mobile-demo">
		       <li><a href="#">Home</a></li>
		        <li><a href="#">Beheren</a></li>
		        <li><a href="#">Uitloggen</a></li>
		         <li><a href="#">Ingelogd als: <?php echo $session->returnUsername();?></a></li>

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