<?php
include('includes/database.php');
function safe_query($db, $query){
	$result = '';
	if(empty($query) || empty($db)){
		//er zijn geen geldige parameters meegegeven
		return false; 
	} else {
		if(!$result = mysqli_query($db, $query)){
			die("OOOPS: Er is een fout opgetreden bij het werken met de database: <br>
				<br> uitgevoerde query: $query . 
				<br> MySQL-foutnummer: ". mysqli_errno($db) . "<br> MySQL-melding: ". mysqli_erorr($db));
		} else {
			return $result;
		}
	}
}

function select_records($db, $offset=0){
	if(empty($offset)){
		$offset=0;
	} else {
		//beveiliging: $offset casten naar een integer
		//zodat we zeker weten dat $offset een int is
		$offset = (int)$offset;
	}
	$query = "SELECT * FROM books ORDER BY title LIMIT $offset, " . LIMIET;
	return(safe_query($db, $query));
}//einde functie select_records

function toon_navigatie($db, $offset = 0){
	//initialisatie
	if(empty($offset)){
		$offset = 0;
	}
	$deze_pagina = $_SERVER['PHP_SELF'];
	$aantal_records = 0;
	$vorige_records = $offset - LIMIET;
	$volgende_records = $offset + LIMIET;
	//Het aantal records in de tabel ophalen en toekennen aan 
	//$aantal_records
	$query = 'SELECT COUNT(*) FROM books';
	$result = safe_query($db,$query);
	list($aantal_records) = mysqli_fetch_array($result);
	//De links <- Vorige en VOlgende -> op het scherm schrijven
	// de links worden getoond binnen een <div class="navigatie",
	// welke met CSS verder opgemaakt kan worden.
	echo "<div class=\"navigatie\">";
	if($offset > 0){
		//We staan niet aan het begin van de recordset, er kan dus
		//acheruit worden gebladerd. Toon de link 'Vorige' op het
		//scherm
		echo "<a href=\"$deze_pagina?offset=$vorige_records\">
			&lt;- Vorige records</a> &nbsp; &nbsp;";
	}
	if ($volgende_records < $aantal_records){
		// als het aantal records groter is dan $volgende_records,
		//zijn er nog records over i nde database, toon daarom de
		//link 'Volgende' op het scherm
		echo "<a href=\$deze_pagina?offset=$volgende_records\">
			Volgende records -&gt;</a> &nbsp; &nbsp;";
	}
	echo "</div>";
}// einde functie toon_navigatie
?>