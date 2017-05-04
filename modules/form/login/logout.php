<?php

//detroy the session so the user is logged out.
session_start();
session_destroy();

?>
<html>
<head>
	<title>Uitgelogd</title>
	<LINK href="../includes/css/loginCss.css" rel="stylesheet" type="text/css">
</head>
<body>

	<div class="login-form">
	<h1>Uitgelogd</h1>
		
		<form action="loginForm.php">
			<div class="form-group log-status-username log-status">
			<?php echo '<p style="text-align:center">U bent uitgelogd.</p>'; ?>
			</div>
		    <input class="log-btn" type="submit" value="Ga terug">
		</form>

	</div>
</body>
</html>