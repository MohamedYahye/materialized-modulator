<?php 

	require_once("menu.php");
	require_once("../model/module_koppel.php");

	$module_koppel = new moduleKoppel();
?>


<!DOCTYPE html>
<html>
<head>
	
	<title>edit module</title>
	<link rel="stylesheet" type="text/css" href="../controller/assets/css/edit_module.css">
	<link rel="stylesheet" type="text/css" href="../controller/assets/css/materialize.css">
	<script type="text/javascript" src="../controller/assets/js/jquery.js"></script>
	<script type="text/javascript" src="../controller/assets/js/materialize.js"></script>
</head>
<body>


	<div class="module-wrap">
		<?php

			if(!empty(isset($_GET))){
				if($_GET['module']){
					$decoded = base64_decode($_GET['module']);

					echo "<h5 id='module_name'>Module: " . $decoded . "</h5>";

					$module_koppel->moduleKoppel($decoded);

					$id = $module_koppel->GetModuleById($decoded);


					
				}
			}

		?>
		<div class="new">
			<?php $module_koppel->GetNewGroups($id);?>

		</div>

	</div>

	

</body>


<script type="text/javascript">
	$(document).ready(function(){
		$(".member-item").on('click', function(){
			$(this).addClass("active").siblings().removeClass("active");



			var group_name = $(this).text();
			var module_name = $("#module_name").text();

			var afterComma = module_name.substr(module_name.indexOf(":") + 1);

			$.ajax({
	           type: "POST",
	           url: "../model/module_koppel.php",
	           data: {
	           	remove:"true",
	           	group_name: group_name,
	           	module_name: afterComma
	           
	           },
	           dataType: "html",
	           success: function(response){

	           	var parse = JSON.parse(response);

	           	if(parse.removed){
	           		location.reload();
	           	}
	        

	           },
	           error: function(response){
	             console.log("Error:" + response);
	           }
	        });

		})



		$(".member-new").on('click', function(){
			$(this).addClass("active").siblings().removeClass("active");



			var group_name = $(this).text();
			var module_name = $("#module_name").text();

			var afterComma = module_name.substr(module_name.indexOf(":") + 1);

			$.ajax({
	           type: "POST",
	           url: "../model/module_koppel.php",
	           data: {
	           	add: "true",
	           	group_name: group_name,
	           	module_name: afterComma
	           
	           },
	           dataType: "html",
	           success: function(response){

	           	var parse = JSON.parse(response);
	        	

	        	if(parse.added){
	        		location.reload();
	        	}

	           },
	           error: function(response){
	             console.log("Error:" + response);
	           }
	        });

		})
	})	


</script>
</html>