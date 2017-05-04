<?php
include 'includes/init.php';

//gets the ID of the book.
if(!isset($_GET['b']))	{
	header('Location: ./');
	die(); 
}

//selects the information of the book by the ID of the book.
$query = $db->prepare('SELECT * FROM books WHERE  id = :ID ');
$query->bindparam(":ID",$_GET['b']);
$query->execute();
//FETCH_ASSOC = overzichtelijke selects (in plaats van nummers gebruik van letters)
$out = $query->fetch(PDO::FETCH_ASSOC);
//checks if summary is missing or not
if(!$out['summary']){
	//if the summary is missing, find the summary in the XML. 
	$out = file_get_contents("https://www.goodreads.com/book/show.xml?key=yczfJHz3RA9FbWihOmw&id=".$out['id_goodreads']);
	$xml = simplexml_load_string($out, null ,LIBXML_NOCDATA);
	$summary= $xml->book->description;

	//update the book by adding the summary of the book to the database.
	$query= $db->prepare('UPDATE books SET summary=:DATA WHERE id=:ID');
	$query->bindparam(":DATA",$summary);
	$query->bindparam(":ID",$_GET['b']);
	$query->execute();

	//goes to the page of the book by ID.
	header('location: ./book.php?b='.$_GET['b']);
}

//echo's the summary.
echo $out['summary'];
?>