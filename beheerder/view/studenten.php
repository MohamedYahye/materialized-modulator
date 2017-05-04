

<?php 
	
	require_once("menu.php");


?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../controller/assets/css/student.css">
	<link rel="stylesheet" type="text/css" href="../controller/assets/css/materialize.css">
	<script type="text/javascript" src="../controller/assets/js/materialize.js"></script>
</head>
<body>
	<div class="wrapper">
		<?php 
			try{

				require_once("../model/tools/connect.php");

				$connect = new connect();

				$dbh = $connect->returnConnection();

				$stmt = $dbh->prepare("SELECT name FROM student");

				$stmt->execute();

				if($stmt->rowCount() > 0){
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					
					echo "<ul class='collection with-header'><li class='collection-header'>Klik op een student om de gegevens te bekijken en te wijzigen</li>";
					foreach($result as $res){
						echo "<a href='#!' class='collection-item'>".$res['name']."</a>";
					}
					echo "</ul>";
				}

			}catch(PDOEXception $e){
				return $e->getMessage();
			}


		?>



	</div>

</body>
	<script type="text/javascript">

	
	
	$(document).ready(function(){

		$(".collection-item").on("click", function(){
			$(this).addClass("active").siblings().removeClass('active');
			var data = $(this).text();
			$(this).addClass("changed").siblings().removeClass("changed");
			var parse;

			if($(this).hasClass("active")){
				$.ajax({
		           type: "POST",
		           url: "../model/getStudent.php",
		           data: {
		           	student: data,
		           },
		           dataType: "html",
		           success: function(response){
		           //	console.log(response);
		           	parse = JSON.parse(response);
		           	if(parse.success){


		           		if($(".user_form").length){
		           			$("#ov_nummer").val(parse.ov_nummer);
		           			$("#name").val(parse.name);
		           			$("#active").text("Actieve student: " +parse.name);
		           			$("#username").val(parse.username);
		           			$("#email").val(parse.email);
		           			$("#password").val(parse.password);
		           			$("#opleiding").val(parse.opleiding);
		           			$("#leerjaar").val(parse.leerjaar);
		           			$("#uitstroom").val(parse.uitstroom.replace(/[""]/g, ""))
		           		}else{
		           			$(".wrapper").append("<div class='user_form'><span id='active'>Actieve student: "+parse.name+"</span><form method='post' class='userForm'><label for='ov_nummer'>Ov-nummer:</label><input id='ov_nummer' type='number' value="+parse.ov_nummer+"><label for='name'>Naam:</label><input type='text' id='name' value="+JSON.stringify(parse.name)+"><label for='username'>Gebruikersnaam: </label><input type='text' id='username' value="+parse.username+"><label for='email'>Email:</label><input id='email' type='email' value="+parse.email+"><label for='password'>Wachtwoord:</label><input id='password' type='password' value="+parse.password+"><label for='opleiding'>opleiding:</label><input id='opleiding' type='text' value="+JSON.stringify(parse.opleiding)+"><label for='leerjaar'>leerjaar:</label><input id='leerjaar' type='number' value="+parse.leerjaar+"><label for='uitstroom'>uitstroom:</label><input id='uitstroom' type='text' value="+JSON.stringify(parse.uitstroom)+"><input type='submit' class='btn' value='Gegevens aanpassen'></form><button class='btn red darken-1 delete' id='delete'>Student verwijderen</button></div>");


		           			$(".userForm").submit(function(event){

		           				var _continue = true; 
								event.preventDefault();
								var name = $("#name").val();
								var username = $("#username").val();
								var email = $("#email").val();
								var password = $("#password").val();
								var opleiding = $("#opleiding").val();
								var leerjaar = $("#leerjaar").val();
								var uitstroom = $("#uitstroom").val();
								var ov_nummer = $("#ov_nummer").val();

								var active_student =  $("#active").text();

								var afterSemiColon = active_student.substr(
									active_student.indexOf(":") + 1);


								if(name.length > 0){
									$("#name").removeClass("invalid");
									//_continue = true;
								}else{
									$("#name").addClass("invalid");
									_continue = false;
								}

								if(username.length > 0){
									$("#username").removeClass("invalid");
								}else{
									$("#username").addClass("invalid");
									_continue = false;
								}


								if(email.length > 0){
									$("#email").removeClass("invalid");
								}else{
									$("#username").addClass("invalid");
									_continue = false;
								}

								if(password.length >= 6){
									$("#password").removeClass("invalid");
								}else{
									$("#password").addClass("invalid");
									_continue = false;
								}

								if (leerjaar.length > 0) {
									$("#leerjaar").removeClass("invalid");
								}else{
									$("#leerjaar").addClass("invalid");
									_continue = false;
								}

								if(uitstroom.length > 0){
									$("#uitstroom").removeClass("invalid");
								}else{
									$("#uitstroom").addClass("invalid");
									_continue = false;
								}

								if(opleiding.length > 0){
									$("#opleiding").removeClass("invalid");
								}else{
									$("#opleiding").addClass("invalid");
									_continue = false;
								}

								if(ov_nummer.length >= 4){
									$("#ov_nummer").removeClass("invalid");
								}else{
									$("#ov_nummer").addClass("invalid");
									_continue = false;
								}


								if(_continue){
									var current_name = afterSemiColon;


									var replaced = afterSemiColon.split('"').join('');

								//	console.log(replaced);

									$.ajax({
							           type: "POST",
							           url: "../model/UpdateStudent.php",
							           data: {
							           	current_name:replaced,
							           	name: name,
							           	username: username,
							           	password:password,
							           	email:email,
							           	opleiding:opleiding,
							           	leerjaar:leerjaar,
							           	uitstroom:uitstroom,
							           	ov_nummer:ov_nummer
							           },
							           dataType: "html",
							           success: function(response){
							           	var parse = JSON.parse(response);

							           if(parse.update){
							           		$("#active").text("Actieve student: " +parse.update.newname);
							           		$(".changed").text(parse.update.newname);
							           	}else{
							           		console.log("name in use");
							           	}

							           },
							           error: function(response){
							             console.log("Error:" + response);
							           }
							        });
								}else{
									console.log("oeps.. empty values");
								}



								



						})
						$(".delete").on("click", function(){
		           				var to_delete_student = $(".changed").text();

		           				$.ajax({
							           type: "POST",
							           url: "../model/deleteStudent.php",
							           data: {
							           	student:to_delete_student,
							           },
							           dataType: "html",
							           success: function(response){

							           	var parsed = JSON.parse(response);

							           	if(parsed.deleted){
							           		setInterval(function(){
							           			$(".userForm").append('<div class="progress"><div class="indeterminate"></div></div>')
							           			location.reload();

							           		}, 100);
							           	}
							       
							           },
							           error: function(response){
							             console.log("Error:" + response);
							           }
							        });



		           			})


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