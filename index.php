<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="beheerder/controller/assets/css/menu.css">
	<link rel="stylesheet" type="text/css" href="beheerder/controller/assets/css/materialize.css">
	<script type="text/javascript" src="beheerder/controller/assets/js/jquery.js"></script>
	<script type="text/javascript" src="beheerder/controller/assets/js/materialize.js"></script>
	<link rel="stylesheet" type="text/css" href="controller/css/login.css">
</head>
<body>

	<div class="wrap">
		
		<form name="login" class="login_form" method="POST">
			<h4>Login</h4>
			<label for="ov-nummer">Ov-nummer:</label>
			<input type="number" name="ov-nummer" placeholder="12345" id="ov">
			<label for="password">Wachtwoord:</label>
			<input type="password" name="password" placeholder="********" id="password">
			<input type="submit" name="" class="btn" value="Login"><br />

			<h4>Geen account?</h4>
			<a href="register.php">Registreren</a>
		</form>

	</div>


</body>
	
	<script type="text/javascript">
		
		$(document).ready(function(){

			$(".login_form").submit(function(e){
				e.preventDefault();

				var proceed = true;
				var response;
				var ov = $("#ov").val();
				var password = $("#password").val();

				if(ov.length > 0){
					$("#ov").removeClass("invalid")
				}else{
					Materialize.toast('Ov kan niet leeg zijn', 3000, 'rounded');
					proceed = false;
					$("#ov").addClass("invalid");
					
				}


				if(password.length >= 6){
					$("#password").removeClass("invalid");
				}else{
					Materialize.toast('Wachtwoord moet minstens 6 chars zijn', 3000, 'rounded');
					proceed = false;
					$("#password").addClass("invalid");

				}



				if(proceed){
					$.ajax({
		           type: "POST",
		           url: "model/login_student.php",
		           data: {
		           		ov: ov,
		           		password: password
		           },
		           dataType: "html",
		           success: function(response){

		           	response = JSON.parse(response);

		           	console.log(response);

		           	if(response.password == false){
		           		Materialize.toast("Incorrect gebruikersnaam of Wachtwoord", 3000, "rounded");
		           		$("#ov").addClass("invalid");
		           		$("#password").addClass("invalid");
		           	}


		           	if(response.user == true){
		           		location.replace("view/index.php");
		           	}else{
		           		Materialize.toast("Incorrect gebruikersnaam of Wachtwoord", 3000, "rounded");
		           		$("#ov").addClass("invalid");
		           		$("#password").addClass("invalid");
		           	}
		           },
		           error: function(response){
		             console.log("Error:" + response);
		           }
		        });
				}
				

			})
		})


	</script>

</html>