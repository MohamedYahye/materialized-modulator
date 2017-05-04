<?php
header('Content-Type: application/json');
// include '../includes/functions.php';
//create a "pepper"
$pepper = 'K:Xa8GV}p[Fjr>8;Ez$z,3%b?L^*@M29';


// $data = $_POST();
$username = $_POST['username'];
$password = $_POST['password'];

include('../includes/database.php');

//connects to the databaseO

// $db = new PDO('mysql:host=localhost;dbname=test','root', '');	
// $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



// //gets the username inserted in the login form
$query = $db->prepare("SELECT * FROM login WHERE username = :LOGIN");
$query->bindparam(":LOGIN", $username);
$query->execute();
$out = $query->fetch(PDO::FETCH_ASSOC);

if($out){
	//creates hash over password and ats the pepper 
	$hash = hash("sha256", $password . $pepper);
	//creates hash over the previous hash and add the salt.
	$hash = hash("sha256", $hash . $out['salt']);
	if($hash === $out['hash']){
		session_start();
		//sets session to the id of the user logged in
		$_SESSION['id'] = $out['id'];
		//echo $out['id'];
		echo json_encode(array("success" => true));
	} else {
		echo json_encode(array("success" => false, "error" => "Onjuist wachtwoord", "errorCode" => 2));
	}
} else {
	echo json_encode(array("success" => false, "error" => "Onjuiste gebruikersnaam", "errorCode" => 1));
}