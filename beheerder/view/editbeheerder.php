<?php 
	
	require_once("menu.php");
	require_once("../model/tools/connect.php");

?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../controller/assets/css/editbeheerder.css">
	<link rel="stylesheet" type="text/css" href="../controller/assets/css/materialize.css">
	<script type="text/javascript" src="../controller/assets/js/jquery.js"></script>
	<script type="text/javascript" src="../controller/assets/js/materialize.js"></script>
</head>
<body>

	<div class="wrapper">
		<?php 

			if(isset($_SESSION)){

				$current_beheerder = $_SESSION['username'];

				$connect = new connect();

				$dbh = $connect->returnConnection();

				$stmt = $dbh->prepare("SELECT username FROM beheerder WHERE username!=:username");

				$stmt->bindParam(":username", $current_beheerder);

				$stmt->execute();

				if($stmt->rowCount() > 0){
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

					echo "<div class='beheerders'><ul class='collection with-header'><li class='collection-header'><h6 id='title'>Klik op een beheerder om te bewerken</h6></li>";

					foreach($result as $res){
						echo "<a href='#!' class='collection-item'>".$res['username']."</a>";
					}
					echo "</ul></div>";
				}else{
					header("Location: ../model/uitloggen.php");
				}

			}else{
				header("Location: ../model/uitloggen.php");
			}
			echo "<input type='hidden' value=".$current_beheerder." id='hidden'>";
		?>
		
	</div>

	<div id="modal1" class="modal">
	    <div class="modal-content">
	      <h4>Je past de gegevens van een andere beheerder aan!!</h4>
	      <h5>Vul je wachtwoord in voor controle</h5>

	      <form name="" class="check_password_form"><label>Wachtwoord</label><input type="password" name="" id='current_beheerder_password_value' placeholder="wachtwoord"></form>

	    </div>
	    <div class="modal-footer">
	      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat " id="current_beheerder_password">controleer wachtwoord</a>
	    </div>
	  </div>
	</body>

	<script type="text/javascript">
		
	$(document).ready(function(){
		$(".collection-item").on("click", function(){
			var data = $(this).text();
			var submitForm;
			$(this).addClass("active").siblings().removeClass("active");
			$.ajax({
	           type: "POST",
	           url: "../model/tools/edit_beheerder.php",
	           data: {
	           		beheerder:data
	           },
	           dataType: "html",
	           success: function(response){
	           	//console.log(response);
	        	
	        	var parse = JSON.parse(response);


	        	if(parse.user_found){

	        		var name = parse.name;
	        		var username = parse.username;
	        		var email = parse.email;
	        		var password = parse.password;

	        		submitForm = true;

	        		if($(".data").length){
	        			$("#name").val(name);
	        			$("#username").val(username);
	        			$("#email").val(email);
	        			$("#password").val(password);
	        			$("#__title").text("Beheerder: " +name);
	        		}else{
	        			$(".wrapper").append("<div class='data'><h4 id='__title'>Beheerder: "+name+"</h4><form name='edit_data' class='edit-beheerder' method='post'><label>naam:</label><input type='text' value="+name+" id='name'><label>gebruikersnaam:</label><input type='text' value="+username+" id='username'><label>email:</label><input type='text' value="+email+" id='email'><label>password:</label><input type='text' value="+password+" id='password'><input type='submit' class='btn'data-target='modal1' value='gegevens aanpassen'></form></div>");
	        		}
	        	}else{

	        	}

$('.modal').modal({
		      dismissible: true, // Modal can be dismissed by clicking outside of the modal
		      opacity: .5, // Opacity of modal background
		      inDuration: 300, // Transition in duration
		      outDuration: 200, // Transition out duration
		      startingTop: '4%', // Starting top style attribute
		      endingTop: '10%', // Ending top style attribute
		      ready: function(modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.
		       // console.log(modal);
		      },
		      complete: function() { 
		      	var beheerder_name = $("#__title-naam").text();

				var afterComma = beheerder_name.substr(beheerder_name.indexOf(":") + 1);

				var pass = $("#current_beheerder_password_value").val();
				var current_beheerder_name = $("#hidden").val();

		      	$.ajax({
	           type: "POST",
	           url: "../model/tools/edit_beheerder.php",
	           data: {
	           	check_password: "true",
	           	password: pass,
	           	current_name: current_beheerder_name
	           
	           },
	           dataType: "html",
	           success: function(response){
	         	$("#current_beheerder_password_value").val("");

	         	var parse = JSON.parse(response);

	         	if(parse.password){
	         		Materialize.toast("Correct password", 3000);
	         	}

	         	if(parse.password == false){
	         		Materialize.toast("Incorrect password", 3000);
	         	}
	           },
	           error: function(response){
	             console.log("Error:" + response);


	           }
	        });



		       } // Callback for Modal close
		    }
		  );


	        	

	           },
	           error: function(response){
	             console.log("Error:" + response);
	           }
	        });


		})


		$(".check_password_form").submit(function(event){
			event.preventDefault();
		})
	})

	</script>

</html>