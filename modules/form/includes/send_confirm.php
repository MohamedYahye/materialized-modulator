<?php
include 'database.php';

// require 'PHPMailer/class.phpmailer.php';
// require 'PHPMailer/class.pop3.php';
// require 'PHPMailer/class.smtp.php';


$f_name = $_POST['f_name'];
$l_name = $_POST['l_name'];
$email  = $_POST['email'];
$bedrijf= $_POST['bedrijf'];
$first  = $_POST['first'];
$second = $_POST['second'];
$third  = $_POST['third'];
$fourth  = $_POST['fourth'];

$sth = $db->prepare("INSERT INTO resultaten (voornaam, achternaam, email,  bedrijfsnaam, choice_1, choice_2, choice_3, choice_4) VALUES (:VNAME, :ANAME, :MAIL, :BS, :C1, :C2, :C3, :C4) ");
$sth->bindparam(":VNAME", $f_name);
$sth->bindparam(":ANAME", $l_name);
$sth->bindparam(":MAIL", $email);
$sth->bindparam(":BS", $bedrijf);
$sth->bindparam(":C1", $first);
$sth->bindparam(":C2", $second);
$sth->bindparam(":C3", $third);
$sth->bindparam(":C4", $fourth);
$sth->execute();

// header("Location: ../index.php");
echo json_encode(array("value" => $first, "count"=> $second, "ID" => $third));