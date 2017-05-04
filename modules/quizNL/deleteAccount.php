<?php
require 'test/includes/database.php';

if(!empty($_GET['email'])){
	$code = $_GET['code'];
	$sql = "DELETE FROM `login` WHERE `email_code` = :email_code";
	$setActive = $db->prepare($sql);
	$setActive->execute(array(
		":email_code" => $code
	));
	?><script>alert('het account <?php echo $_GET['email'] ?> is verwijderd.');
	window.close();
	</script><?php
	// header('Location:test/login/loginForm.php');
}
?>