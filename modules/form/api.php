<?php
include 'includes/database.php';

$choiceID = $_POST["choiceID"];
$value = $_POST["value"];
$kolom = "choice_" . $choiceID;

$counter = 0;
$array = [];

$query = "SELECT choice_1 FROM resultaten WHERE choice_1 = '".$value."'";
$getCount = $db->query($query);
$getCount->execute(array("value"=>$value));
$results = $getCount->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT choice_2 FROM resultaten WHERE choice_2 = '".$value."'";
$getCount = $db->query($query);
$getCount->execute(array("value"=>$value));
$results2 = $getCount->fetchAll(PDO::FETCH_ASSOC);
$query = "SELECT choice_3 FROM resultaten WHERE choice_3 = '".$value."'";
$getCount = $db->query($query);
$getCount->execute(array("value"=>$value));
$results3 = $getCount->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT choice_4 FROM resultaten WHERE choice_4 = '".$value."'";
$getCount = $db->query($query);
$getCount->execute(array("value"=>$value));
$results4 = $getCount->fetchAll(PDO::FETCH_ASSOC);

// $counter = 0;
// $array = [];
for ($i=0; $i < count($results); $i++) {
	$object = $results[$i];
	array_push($array, $object);
}
for ($i=0; $i < count($results2); $i++) {
	$object = $results2[$i];
	array_push($array, $object);
}
for ($i=0; $i < count($results3); $i++) {
	$object = $results3[$i];
	array_push($array, $object);
}
for ($i=0; $i < count($results4); $i++) {
	$object = $results4[$i];
	array_push($array, $object);
}
// $value_result = $array[$i][$value];
// echo $value_result;
for ($i=0; $i < count($array); $i++) {
	$value_result = $array[$i][$kolom];
	if($value_result == $value) {
		$counter++;
	}
}

// function selectDB($table, $var){
// 	// echo $var;
// 	global $db;
// 	$query = $db->query('SELECT '.$table.' FROM resultaten WHERE '.$table.' = "'.$var.'"');
// 	$select = $query->fetchAll(PDO::FETCH_ASSOC);

// 	$select = count($select);
// 	$array = [$table , $select];
// 	return $array;
// }


// // $select = $db->prepare('SELECT choice_1 FROM resultaten WHERE choice_1 = "'.$first.'"');
// // $select->execute();
// // $select = $select->fetchAll(PDO::FETCH_ASSOC);
// $eerste_eerste = selectDB('choice_1', 'een');
// $eerste_tweede = selectDB('choice_1', 'twee');
// $eerste_derde = selectDB('choice_1', 'drie');
// $eerste_vierde = selectDB('choice_1', 'vier');




echo json_encode(array("value" => $value, "count"=> $counter, "ID" => $choiceID));