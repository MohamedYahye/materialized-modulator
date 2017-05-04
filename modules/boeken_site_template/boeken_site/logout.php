<?php

//detroy the session so the user is logged out.
session_start();
session_destroy();

?>
<LINK href="assets/css/index.css" rel="stylesheet" type="text/css">

<div id="logout">
<?php echo '<p>You have been logged out.</p> <a class="a" href="index.php">Go back</a>'; ?>
</div>
