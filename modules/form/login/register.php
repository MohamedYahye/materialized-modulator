<?php
include('../includes/database.php');

$username = 'qennizvijver';
$password = 'kweekvijver';

	//creates pepper
$pepper = 'K:Xa8GV}p[Fjr>8;Ez$z,3%b?L^*@M29';

$salt = hash("sha256", $username . 'r>8;Ez$z,3%b?L');

//hashes the pepper and salt
$hash = hash("sha256" , hash("sha256" , $password . $pepper) . $salt);

$emailCode = md5($username + microtime());

//if everything is correct insert into databaseO.
//email, :EMAIL, $sth->bindparam(":EMAIL", $email);
$sth = $db->prepare("INSERT INTO login (username, hash, salt) VALUES (:USERNAME, :HASH, :SALT) ");
$sth->bindparam(":USERNAME", $username);
$sth->bindparam(":HASH", $hash);
$sth->bindparam(":SALT", $salt);
$sth->execute();