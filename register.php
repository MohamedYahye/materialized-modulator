<!DOCTYPE html>
<html>
<head>
	<title>Registreren</title>
	<link rel="stylesheet" type="text/css" href="controller/css/register.css">
	<link rel="stylesheet" type="text/css" href="beheerder/controller/assets/css/menu.css">
	<link rel="stylesheet" type="text/css" href="beheerder/controller/assets/css/materialize.css">
	<script type="text/javascript" src="beheerder/controller/assets/js/jquery.js"></script>
	<script type="text/javascript" src="beheerder/controller/assets/js/materialize.js"></script>
</head>
<body>
	<div class="wrap">
		
		<form class="register_form" method="post" name="register">
			
			<h4>Registreren</h4>
			<span>* = Verplicht</span>
			<input type="number" name="ov" placeholder="* ov-nummer" id="ov">
			<input type="text" name="name" placeholder="* name" id="name">
			<input type="text" name="username" placeholder="* username" id="username">
			<input type="text" name="email" placeholder="* email" id="email">
			<input type="password" name="password" placeholder="* password" id="password">
			<input type="password" name="repeat_password" placeholder="* repeat password" id="repeat">
			<input type="text" name="opleiding" placeholder="* opleiding" id="opleiding">
			<input type="text" name="uitstroom" placeholder="* uitstroom richting" id="uitstroom">
			<input type="number" name="leerjaar" placeholder="* leerjaar" id="leerjaar">
			<input type="submit" name="" class="btn" value="Registreren">

		</form>

	</div>

</body>


<script type="text/javascript">
	$(document).ready(function(){

		$(".register_form").submit(function(e){

			e.preventDefault();

			var proceed = true;

			var ov = $("#ov").val();
			var name = $("#name").val();
			var username = $("#username").val();
			var email = $("#email").val();
			var password = $("#password").val();
			var repeat = $("#repeat").val();
			var opleiding = $("#opleiding").val();
			var uitstroom = $("#uitstroom").val();
			var leerjaar = $("#leerjaar").val();


			if(ov.length >= 4){
				
				$("#ov").removeClass("invalid");
			}else{
				proceed = false;
				$("#ov").addClass("invalid");
			}

			if(name.length > 0){
				
				$("#name").removeClass("invalid");
			}else{
				proceed = false;
				$("#name").addClass("invalid");
			}


			if(username.length >= 4){
				
				$("#username").removeClass("invalid");
			}else{
				proceed = false;
				$("#username").addClass("invalid");
			}


			if(email.length > 0){
				
				$("#email").removeClass("invalid");
			}else{
				proceed = false;
				$("#email").addClass("invalid");
			}


			if(password.length >= 6){
				
				$("#password").removeClass("invalid");
			}else{
				proceed = false;
				$("#password").addClass("invalid");
			}


			if(repeat.length >= 6 && repeat == password){
				// if(repeat == password){
					
				 	$("#repeat").removeClass("invalid");
				// }
				
			}else{
				proceed = false;
				Materialize.toast("wachtwoord komt niet overeen", 5000, "rounded");
				$("#repeat").addClass("invalid");
				$("#password").addClass("invalid");
			}


			if(opleiding.length > 0){
				
				$("#opleiding").removeClass("invalid");
			}else{
				proceed = false;
				$("#opleiding").addClass("invalid");
			}
			
			if(uitstroom.length > 0){
				
				$("#uitstroom").removeClass("invalid");
			}else{
				proceed = false;
				$("#uitstroom").addClass("invalid");
			}

			if(leerjaar.length > 0){
				
				$("#leerjaar").removeClass("invalid");
			}else{
				proceed = false;
				$("#leerjaar").addClass("invalid");
			}


			if(proceed == true){
				$.ajax({
	           type: "POST",
	           url: "model/register_student.php",
	           data: {
	           		ov: ov,
	           		name: name,
	           		username: username,
	           		email: email,
	           		password: password,
	           		repeat_password: repeat,
	           		opleiding: opleiding,
	           		uitstroom: uitstroom,
	           		leerjaar: leerjaar
	           },
	           dataType: "html",
	           success: function(response){
	           	var parse = JSON.parse(response);
	           	console.log(parse);
	           	if(parse.user){
	           		$("#ov").addClass("invalid");
	           		$("#name").addClass("invalid");
	           		$("#username").addClass("invalid");
	           		$("#email").addClass("invalid");

	           		Materialize.toast("ov-nummer, naam, gberuikersnaam en email moeten uniek zijn", 5000);
	           	}

	           	if(parse.created){
	           		location.replace("index.php");
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