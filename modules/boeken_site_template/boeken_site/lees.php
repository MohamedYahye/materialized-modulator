<?php
include('includes/database.php');
include_once('limit.php');
include_once('paging_functions.php');
?>
<html>
<head>
	<title>Lees bijdragen</title>
</head>

<?php

if(!$db = new PDO('mysql:host=localhost;dbname=login2','root', '')){
	echo 'openen database mislukt';
	exit;
}
if(isset($_GET['offset'])){
	$offset= (int)$_GET['offset'];
} else {
	$offset = 0;
}
//results inlezen
$result = select_records($db, $offset);
//op scherm zetten
while($record = mysqli_fetch_array($result)){
	//html code
	?>
	<div class="record">
		<div class="naam">Naam: <?php echo $record['title'] ?></div>
	</div>
	<?php
} //einde while loop
//navigatielinks op scherm zetten
toon_navigatie($db, $offset);
?>
</body>
</html>