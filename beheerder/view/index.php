<?php 

	
	require_once("menu.php");
	require_once("../model/modules.php");
?>



<!DOCTYPE html>
<html>
<head>
	<title>Modules</title>
	<link rel="stylesheet" type="text/css" href="../controller/assets/css/modules.css">
	<link rel="stylesheet" type="text/css" href="../controller/assets/css/materialize.css">
	<script type="text/javascript" src="../controller/assets/js/jquery.js"></script>
	<script type="text/javascript" src="../controller/assets/js/materialize.js"></script>
</head>
<body>

	<div class="wrapper">
		
		<?php 

			$modules = new modules();

			$_modules = $modules->Modules();

			if(!empty(is_array($_modules))){
				echo "<div class='collection modules newdir'>";

				foreach($_modules as $module){
					echo "<a href='#!' class='collection-item'>".$module['module_locatie']."</a>";
				}
				echo "</div>";
			}


		?>

		<div class="data">
			<ul class="collection with-header">
	        <li class="collection-header" id='moduel_name'><h4></h4></li>
	        <li class="collection-header" id="module_status"></li>
	      </ul>
		</div>

	</div>

</body>


<script type="text/javascript">
	
	$(document).ready(function(){


		setInterval(function(){ 

			var data = "test";

			$.ajax({
	           type: "POST",
	           url: "../model/tools/newmodule.php",
	           data: {
	           	module_name: data,
	           },
	           dataType: "html",
	           success: function(response){
	           	//console.log(response);

	           var parse = JSON.parse(response);

	           	//console.log(parse);

	           	if(parse.added){
	         		$(".newdir").append("<a href='#!' class='collection-item'>"+parse.newdir+"</a>");
	         		//$('.wrapper').load(document.URL +  ' .newdir');
	           	}


	           },
	           error: function(response){
	             alert("Error:" + response);
	           }
	        });

		}, 3000);

		$(".collection-item").on("click", function(){

			$(this).addClass("active").siblings().removeClass("active");
			var proceed = false;
			var data = $(this).text();
			$.ajax({
	           type: "POST",
	           url: "../model/getModule.php",
	           data: {
	           	module: data,
	           },
	           dataType: "html",
	           success: function(response){
	           	var parse = JSON.parse(response);

	           	var status = "";

	           	if(parse.module_status == 0){
	           		$("#checkbox").prop("checked", false);
	           		status = "Uit";
	           	}else{
	           		$("#checkbox").prop("checked", true);

	           		status = "Aan";
	           	}

	           	$("#moduel_name").text("Module: " + parse.module_locatie);

	           	$("#module_status").text("Module status is : " + status);


	           	

	           },
	           error: function(response){
	             alert("Error:" + response);
	           }
	        });


			if($("#edit").length){
				proceed = true
           	}else{
           		$(".data > ul").append("<li class='collection-header' id='edit'>Status aanpassen<div class='switch'><label> Off <input type='checkbox' id='checkbox'> <span class='lever'></span> On </label></div></li>");


           		$("#checkbox").change(function(event){
           			var checkbox = event.target;

           			var module_name = $("#moduel_name").text();

           			var afterComma = module_name.substr(module_name.indexOf(":") + 1)

           			var state;

           			if(checkbox.checked){
           				state = 1;
           			}else{
           				state = 0;
           			}


           				$.ajax({
					           type: "POST",
					           url: "../model/tools/changeModuleStatus.php",
					           data: {
					           	change_module: "true",
					           	module_name: afterComma,
					           	module_status: state

					           },
					           dataType: "html",
					           success: function(response){
					           		//console.log(response);
					           		var parse = JSON.parse(response);

					           		if(parse.changed){
					           			setInterval(function(){
					           				location.reload();
					           			}, 100)
					           			
					           		}else{
					           			Materialize.toast("oeps.. er ging iets fout", 300, "rounded");
					           		}
					           },
					           error: function(response){
					             alert("Error:" + response);
					           }
					        });


           		})

           		proceed = true;
           	}

           	if(proceed){
           		$.ajax({
		           type: "POST",
		           url: "../model/getModuleGroup.php",
		           data: {
		           	module_name: data,
		           },
		           dataType: "html",
		           success: function(response){
		           //console.log(response);

		           var parse = JSON.parse(response);

		           if(parse.group){
		           	for(var i = 0; i < parse.group_name.length; i++){

			          	if(!$(".groups").length){
			           			//$(".groups_").text()
			           			$(".data").append("<div class='groups'><li href='#!' class='collection-item groups_'>"+parse.group_name[i]+"</li></div>");
		           		}else{
		           			$(".groups_").children().text(parse.group_name[i]);
		           		}

		           		
		           	}

		           }else{
		           		if(!$(".groups").length){
			           		$(".groups").remove();
		           		}else{
		           			$(".groups").remove();
		           		}
		           }

		           },
		           error: function(response){
		             alert("Error:" + response);
		           }
		        });
           	}
		})


		
		
	})

</script>
</html>