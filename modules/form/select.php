<?php
header('Content-Type: application/json');

include 'includes/database.php';

$column = $_POST['column'];
$start = $_POST['start'];


if($start == 1){
	$query = "SELECT DISTINCT  `".$column."` FROM resultaten WHERE `".$column."` != ''";
	$workshop = $db->query($query);
	$workshop->execute();
	$column_results = $workshop->fetchAll(PDO::FETCH_ASSOC);

	$row_count = $workshop->rowCount();

	echo json_encode(array("value" => $column_results, "count" => $row_count));
}
if($start == 2){
	$value = $_POST['value'];
	$query1 = "SELECT voornaam, achternaam FROM resultaten WHERE `".$column."`  = '".$value."'";
	$firstWorkshop = $db->query($query1);
	$firstWorkshop->execute();
	$first_results = $firstWorkshop->fetchAll(PDO::FETCH_ASSOC);

	$row_count = $firstWorkshop->rowCount();

	echo json_encode(array("value" => $first_results, "count" => $row_count));

}
// print_r($start);

