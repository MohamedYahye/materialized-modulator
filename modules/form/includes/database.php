<?php 
$db = new PDO('mysql:host=localhost;dbname=form','root', '');	
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$query = 0;
