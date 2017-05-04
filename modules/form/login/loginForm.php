<?php 
error_reporting(0);
session_start();
$previous_location = $_SESSION['previous_location'];
if(!isset($previous_location)){
	$previous_location = '/form/results.php';
}
?>
<html>
<head>
	<title>Inlogscherm</title>
	<LINK href="../includes/css/loginCss.css" rel="stylesheet" type="text/css">

	<link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css'>

</head>
<body>

	<div class="login-form">
	<h1 style="font-size:40px;">Workshop gegevens</h1>
	<form action="login.php" method="post">
		<div class="form-group log-status-username log-status">
		  <input type="text" class="form-control" placeholder="Gebruikersnaam " name="username" autocomplete="off" id="input_username">
		  <i class="fa fa-user"></i>
		</div>
		<div class="form-group log-status-pwd log-status">
		  <input type="password" class="form-control" placeholder="Wachtwoord" name="password" id="input_password">
		  <i class="fa fa-lock"></i>
		</div>
		<div id="centerSpan" style="text-align: center;">
		<span class="alert"></span>
		</div>
		<input id="login"  class="log-btn" type="submit" value="Inloggen">

	</form>
	</div>
	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

	<script type="text/javascript">
	var prev_loc = "<?php echo $previous_location; ?>"
	console.log(prev_loc);
		(function() {
			$('#login').on('click', function(e) {
				e.preventDefault();
				var inputUsername = $('#input_username').val();
				var inputPassword = $('#input_password').val();

				var login_data = {
					username: inputUsername,
					password: inputPassword
				};


				$('.form-control').keypress(function(){
					$('.log-status').removeClass('wrong-entry');
				});


				$.ajax({
					type: 'POST',
					url: 'login.php',
					data: login_data,
					success: function(data, status) {
						console.log(data);
						if(data.success) {
							console.log(prev_loc);
        					window.location.replace(prev_loc);
						} else {
							if(data.errorCode === 1) {
								// User does not exist.
								$('.log-status-username').addClass('wrong-entry');
								$(".alert").text(data.error);
								$('.alert').fadeIn(1500);
								setTimeout( "$('.alert').fadeOut(1500);",3000 );
							} else if(data.errorCode === 3){
								$('.login-form').addClass('wrong-entry');
								$(".alert").text(data.error);
								$('.alert').fadeIn(1500);
								setTimeout( "$('.alert').fadeOut(1500);",3000 );
							} else {
								$('.log-status-pwd').addClass('wrong-entry');
								$(".alert").text(data.error);
								$('.alert').fadeIn(1500);
								setTimeout( "$('.alert').fadeOut(1500);",3000 );
								// Password wrong
							}
							console.log(data.error);
						}
					}
				});

			});
		}());
	</script>

</body>
</html>