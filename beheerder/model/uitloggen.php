<?php 

	require_once("../model/tools/session.php");


	$session = new session();

	$session->destroySession();

	header("Location: ../");

	exit();

?>