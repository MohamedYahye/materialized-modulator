<!DOCTYPE html>
<html>
<head>
<title></title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
   <link rel="stylesheet" href="../css/style.css">
   <link rel="stylesheet" href="../css/bootstrap.min.css">


</head>

<body>

	<?php
	$username = 'root'; //dit is je mysql username
	$password = '';	//dit is je mysql password
	//Connectie maken met MySQL
	$db = new PDO('mysql:host=localhost;dbname=login2',$username, $password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	

	?>
