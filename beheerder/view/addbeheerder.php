<?php
	require_once("menu.php");
?>


<!DOCTYPE html>
<html>
<head>
	<title>Add beheerder</title>
	<link rel="stylesheet" type="text/css" href="../controller/assets/css/addbeheerder.css">
	<link rel="stylesheet" type="text/css" href="../controller/assets/css/materialize.css">
	<script type="text/javascript" src="../controller/assets/js/jquery.js"></script>
	<script type="text/javascript" src="../controller/assets/js/materialize.js"></script>
</head>
<body>

	<div class="wrapper">
		<h5>Beheerder aanmaken</h5><br />
		<div class="form">
			
			<form name="add" class="add" method="post">
				<div class="div">
					<label for="name">Naam:</label>
					<input type="text" name="name" placeholder="naam" id="name">
				</div>

				<div class="div">
					<label for="username">Gebruikersnaam:</label>
					<input type="text" name="username" placeholder="gebruikersnaam" id="username">
				</div>

				<div class="div">
					<label for="email" data-error="wrong" data-success="right">Email:</label>
					<input type="email" name="email" placeholder="email" id="email">
				</div>
				
				<div class="div">
					<label for="password">Wachtwoord:</label>
					<input type="password" name="password" placeholder="wachtwoord" id="password">
				</div>
				
				<div class="div">
					<label for="repeat" >Herhaal wachtwoord:</label>
					<input type="password" name="repeat" id="repeat" placeholder="herhaal wachtwoord">
				</div><br />
				
				
				<input type="submit" name="submit" class="btn" id="submit"value="Beheerder aanmaken">
			</form>

		</div>
	</div>

</body>


<script type="text/javascript">
	
	$(document).ready(function(){
		$(".add").submit(function(e){

			var proceed = true;


			var name = $("#name").val();
			var username = $("#username").val();
			var email = $("#email").val();
			var password = $("#password").val();
			var repeat = $("#repeat").val();


			if(name.length > 0){
				$("#name").removeClass("invalid");

			}else{
				proceed = false;
				$("#name").addClass("invalid");
				Materialize.toast("naam kan niet leeg zijn", 3000);
			}

			if(username.length > 0){
				$("#username").removeClass("invalid");

			}else{
				proceed = false;
				$("#username").addClass("invalid");
				Materialize.toast("gebruikersnaam kan niet leeg zijn", 3000);
			}


			if(email.length > 0){
				$("#email").removeClass("invalid");

			}else{
				proceed = false;
				$("#email").addClass("invalid");
				Materialize.toast("email kan niet leeg zijn", 3000);
			}


			if(password.length >= 6){
				$("#password").removeClass("invalid");

			}else{
				proceed = false;
				$("#password").addClass("invalid");
				Materialize.toast("wachtwoord moet minstens 6 chars zijn", 3000);
			}

			if(repeat.length >= 6 && repeat==password){

				//if(repeat == password){
					$("#repeat").removeClass("invalid");
			//	}
				

			}else{
				proceed = false;
				$("#repeat").addClass("invalid");
				$("#password").addClass("invalid");
				Materialize.toast("wachtwoorden komen niet overeen", 3000);
			}

			if(proceed){

				$.ajax({
		           type: "POST",
		           url: "../model/tools/add_beheerder.php",
		           data: {
		           	name:name,
		           	username:username,
		           	email:email,
		           	password:password,
		           	repeat:repeat
		           
		           },
		           dataType: "html",
		           success: function(response){


		           	var parse = JSON.parse(response);

		           	if(parse.beheerder_exist){
		           		Materialize.toast("naam, gebruikersnaam, email moeten uniek zijn", 5000);
		           		$("#email").addClass("invalid");
		           		$("#username").addClass("invalid");
		           		$("#name").addClass("invalid");
		           	}

		           	if(parse.added){
	           			Materialize.toast("Beheerder met success toegevoegd", 3000);
		           		$("#name").val("");
		           		$("#username").val("");
		           		$("#email").val("");
		           		$("#password").val("");
		           		$("#repeat").val("");

		           		
		           	}else{
		           		Materialize.toast("oeps!... you broke the internet", 5000);
		           	}
		        

		           },
		           error: function(response){
		             console.log("Error:" + response);
		           }
		        });

			}


			e.preventDefault();
		})
	})

</script>
</html>