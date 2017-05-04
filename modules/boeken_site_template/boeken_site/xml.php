<?php
include('includes/init.php');

//get the XML information of inserted book in the search box
		$out = file_get_contents("http://www.goodreads.com/search/index.xml?key=yczfJHz3RA9FbWihOmw&search[title]&q=".urlencode($_POST['title']));
		$xml = simplexml_load_string($out);
		//print_r($xml);
		$author_name = $xml->search->results->work[0]->best_book->author->name;
		$cover = $xml->search->results->work[0]->best_book->image_url;
		$title = $xml->search->results->work[0]->best_book->title;
		$release = $xml->search->results->work[0]->original_publication_year;
		$id = (string)$xml->search->results->work[0]->best_book->id;
		$authorGoodreads_id = (string)$xml->search->results->work[0]->best_book->author->id;
		$user_id = 	$_SESSION['id'];

		//get XML of the author related to the book
		$out_ = file_get_contents("https://www.goodreads.com/author/show.xml?key=yczfJHz3RA9FbWihOmw&id=".$authorGoodreads_id);
		$xml = simplexml_load_string($out_, null ,LIBXML_NOCDATA);
		$summary = $xml->author->about;
		$img_ = $xml->author->image_url;
		$img = md5(time());
		file_put_contents("./assets/images/authors/$img.jpg", fopen($img_, 'r'));
		$image = $img.".jpg";

?>