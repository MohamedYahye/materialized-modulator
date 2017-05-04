<?php 
	
	require_once("menu.php");
	require_once("../model/tools/connect.php");



?>


<!DOCTYPE html>
<html>
<head>
	<title>modules-koppelen</title>
	<link rel="stylesheet" type="text/css" href="../controller/assets/css/modules-koppelen.css">
	<link rel="stylesheet" type="text/css" href="../controller/assets/css/materialize.css">
	<script type="text/javascript" src="../controller/assets/js/jquery.js"></script>
	<script type="text/javascript" src="../controller/assets/js/materialize.js"></script>
</head>
<body>


	<div class="modules-koppelen">
		
		<?php 

			$connect = new connect();

			$dbh = $connect->returnConnection();

			$stmt = $dbh->prepare("SELECT module_locatie FROM module");

			$stmt->execute();

			if($stmt->rowCount() > 0){
				echo " <ul class='collection with-header'>";
				echo "<li class='collection-header'>Klik op een module om module gegevens te bekijken</li>";
				$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

				foreach($res as $module){
					echo " <a href='edit_module.php?module=".base64_encode($module['module_locatie'])."' class='collection-item'>".$module['module_locatie']."</a>";
				}
				echo "</ul>";
			}

		?>

	</div>

</body>

	
	<script type="text/javascript">
		
		$(document).ready(function(){

			$(".collection-item").on("click", function(){

				$(this).addClass("active").siblings().removeClass("active");

				var data = $(this).text();
				var response;



				$.ajax({
		           type: "POST",
		           url: "../model/getModule.php",
		           data: {
		           	module: data,
		           	getUsers: true
		           
		           },
		           dataType: "html",
		           success: function(response){

		           //	response = JSON.parse(response);


		           	console.log(response);
		        

		           },
		           error: function(response){
		             console.log("Error:" + response);
		           }
		        });
			})
		})



	</script>

</html>