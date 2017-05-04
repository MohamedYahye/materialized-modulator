<?php

include 'includes/database.php';
include 'login/session.php';

$query = "SELECT * FROM resultaten";
$getCount = $db->query($query);
$getCount->execute();
$results = $getCount->fetchAll(PDO::FETCH_ASSOC);

function count_choice($column, $value) {
	// echo $value;
	global $db;
	$query1 = "SELECT `".$column."` FROM resultaten WHERE `".$column."`  = '".$value."'";
	$firstWorkshop = $db->query($query1);
	$firstWorkshop->execute();
	$first_results = $firstWorkshop->fetchAll(PDO::FETCH_ASSOC);
	$first_results = count($first_results);

	return $first_results;
}

?>

<!DOCTYPE html>
<html>
<head>
<LINK href="includes/css/style.css" rel="stylesheet" type="text/css">

</head>
<body>

<a class="button button1 logout" href="login/logout.php">Uitloggen</a>
<a class="button button1 checklist" href="checklist.php" target="_blank">Checklist</a>

<?php 
$first_choice_first = count_choice('choice_1' , 'use your apple1');
$first_choice_second= count_choice('choice_1' , 'Zo maak je van onbekenden klanten1');
$first_choice_third= count_choice('choice_1' , 'Multi media feest');

$second_choice_first = count_choice('choice_2' , 'use your apple2');
$second_choice_second= count_choice('choice_2' , 'Snelheid is geld2');
$second_choice_third= count_choice('choice_2' , 'Maak je eigen marketingkalender');

$third_choice_first = count_choice('choice_3' , 'Lable');
$third_choice_second= count_choice('choice_3' , 'use your apple3');
$third_choice_third = count_choice('choice_3' , 'Zo maak je van onbekenden klanten');
$third_choice_fourth= count_choice('choice_3' , 'Maak je eigen contentkalender');

$fourth_choice_first = count_choice('choice_4' , 'Pretwerk OPTIE!');
$fourth_choice_second= count_choice('choice_4' , 'use your apple4');
$fourth_choice_third = count_choice('choice_4' , 'Snelheid is geld4');
$fourth_choice_fourth= count_choice('choice_4' , 'Fotograferen met je Iphone');

?>
<h2>1e workshop 14:30</h2>


<table style="width:45%">
  <tr>
<!--     <th>x</th>
 -->    <th>use your apple</th>
    <th>Zo maak je van onbekenden klanten</th>
    <th>Multi media feest</th>
  </tr>

  <tr>
  	<td><?php echo $first_choice_first?></td>
  	<td><?php echo $first_choice_second?></td>
  	<td><?php echo $first_choice_third?></td>
  </tr>
</table>

<h2>2e workshop 15:00</h2>


<table style="width:45%">
  <tr>
<!--     <th>x</th>
 -->    <th>use your apple</th>
    <th>Snelheid is geld</th>
    <th>Maak je eigen marketingkalender</th>
  </tr>

  <tr>
  	<td><?php echo $second_choice_first?></td>
  	<td><?php echo $second_choice_second?></td>
  	<td><?php echo $second_choice_third?></td>
  </tr>
</table>

<h2>3e workshop 16:00</h2>


<table style="width:45%">
  <tr>
    <th>Lable</th>
    <th>use your apple</th>
    <th>Zo maak je van onbekenden klanten</th>
    <th>Maak je eigen contentkalender</th>
  </tr>

  <tr>
  	<td><?php echo $third_choice_first?></td>
  	<td><?php echo $third_choice_second?></td>
  	<td><?php echo $third_choice_third?></td>
  	<td><?php echo $third_choice_fourth?></td>

  </tr>
</table>

<h2>4e workshop 16:30</h2>


<table style="width:45%">
  <tr>
    <th>Pretwerk OPTIE!</th>
    <th>use your apple</th>
    <th>Snelheid is geld</th>
    <th>Fotograferen met je Iphone</th>
  </tr>

  <tr>
  	<td><?php echo $fourth_choice_first?></td>
  	<td><?php echo $fourth_choice_second?></td>
  	<td><?php echo $fourth_choice_third?></td>
  	<td><?php echo $fourth_choice_fourth?></td>

  </tr>
</table>

<h2>Ingeschreven</h2>

<table>
  <tr>
    <th>Naam</th>
    <th>Email</th>
    <th>Bedrijf</th>
    <th>eerste workshop</th>
    <th>tweede workshop</th>
    <th>derde workshop</th>
    <th>vierde workshop</th>
  </tr>

  <?php 
  	foreach($results as $result){
  		?>
  		<tr>
  			<td><?php echo $result['voornaam']?></td>
  			<td><?php echo $result['email']?></td>
  			<td><?php echo $result['bedrijfsnaam']?></td>
  			<td><?php echo preg_replace('/[0-9]+/', '', $result['choice_1']);?></td>
  			<td><?php echo preg_replace('/[0-9]+/', '', $result['choice_2']);?></td>
  			<td><?php echo preg_replace('/[0-9]+/', '', $result['choice_3']);?></td>
  			<td><?php echo preg_replace('/[0-9]+/', '', $result['choice_4']);?></td>
  		</tr>
  		<?php
  	}
  ?>
</table>



</body>
</html>
