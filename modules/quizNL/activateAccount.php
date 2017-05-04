<?php
require 'test/includes/database.php';

if(!empty($_GET['code'])){
	$sql = "UPDATE `login` SET `active`= 1 WHERE email_code = :email_code";
	$setActive = $db->prepare($sql);
	$setActive->execute(array(
		":email_code" => $_GET['code']
	));
	?><script>alert('Account is geactiveerd');
	window.close();
	</script><?php
}
?>