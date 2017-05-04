<?php 
include 'header.php';
?>
<div class="container">
	<?php include 'navigation.php'; ?>
</div>
<div class="site-header"></div>
<div class="content-container">
<div class="site-content">

<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes

//includes init.php in which the basic files are includes aswell which (almost) every file / page uses
include 'includes/init.php';

	$XMLtitle = (isset($_POST['title'])) ? $_POST['title'] : $_GET['title'];
	//gets the API of the books from the goodreads website
	$out = file_get_contents("http://www.goodreads.com/search/index.xml?key=yczfJHz3RA9FbWihOmw&search[title]&q=".urlencode($XMLtitle));
	$xml = simplexml_load_string($out);
	$goodreadsExists = $xml->search->results->work;
	

if(!empty($goodreadsExists)){
//gets information of each result of the API.
foreach($xml->search->results->work as $book):

		//gets all the information from the book
		$author_name = $book->best_book->author->name;
		$title = $book->best_book->title;
		$cover = $book->best_book->image_url;
		$release = $book->original_publication_year;
		$id = (string)$book->best_book->id;
		$authorGoodreads_id = (string)$book->best_book->author->id;
		$user_id = 	$_SESSION['id'];

		//get XML of the author related to the book
		$out_ = file_get_contents("https://www.goodreads.com/author/show.xml?key=yczfJHz3RA9FbWihOmw&id=".$authorGoodreads_id);
		$xml = simplexml_load_string($out_, null ,LIBXML_NOCDATA);
		$summary = $xml->author->about;
		$img_ = $xml->author->image_url;
		$img = md5(time());
		$image = $img.".jpg";

		//gets the books ID
		$book = getBookByGoodreadsId($id);
		//checks if the ID / book doesnt exist yet
		if(!$book) {
			// $has_book = ifUserHasBook($id, $user_id);
			// echo $has_book;
			// $addRemove = (!$has_book) ? 'add' : 'remove';

			// echo '<div class="output">
			// 	 '.$title.'<br>'.$author_name.'
				 
			// 	 <a href="update_book.php?user='.$id.'" class="Link '.$addRemove.'">
			// 	 	<img src="./assets/images/'.$addRemove.'.png"></img></a>
				 	
			// 	 &nbsp;&nbsp;
			// 		</div><br>';

			//var_dump($title);

			// $query = $db->prepare("SELECT * FROM books WHERE title = :TITLE");
			// $query = $db->prepare("SELECT * FROM books WHERE title COLLATE UTF8_GENERAL_CI LIKE '%$title%'");
			// $query->bindparam(":TITLE", $title);
			// $query->execute();
			// $bookTitle = $query->fetch();			

			// var_dump($bookTitle);
			// if(!$bookTitle){
			// 	echo 'doesnt exists';
			// } else {
			// 	echo 'exist';
			// }
			// exit();
			//continious if the ID / book doesn't exist and checks if the authors ID exists
			$author = getAuthorByGoodreadsId($authorGoodreads_id);
			if(!$author){
				//if the authors ID doesnt exist, place the information of the author in the database.
				$query = $db->prepare('INSERT INTO authors (author, id_goodreads, summary, image) VALUES (:AUTHOR, :ID_GOODREADS, :DATA, :IMG) ON DUPLICATE KEY UPDATE author=author ');
				$query->bindparam(":AUTHOR",$author_name);
				$query->bindparam(":ID_GOODREADS",$authorGoodreads_id);
				$query->bindparam(":IMG",$image);
				$query->bindparam(":DATA",$summary);
				file_put_contents("./assets/images/authors/$img.jpg", fopen($img_, 'r'));
				$image = $img.".jpg";
				$query->execute();
				$author_id = $db->lastInsertId();
				$author = getAuthorByGoodreadsId($authorGoodreads_id);


			}
			// $book_title = getBookByTitle($title);
			//places the books information in the Book database
			$query = $db->prepare('INSERT INTO books (author, author_id, id_goodreads, title, image,  dor) VALUES (:AUTHOR, :AUTHOR_ID, :ID_GOODREADS, :TITLE, :IMAGE, :DOR)');
			$query->bindparam(":AUTHOR",$author['author']);
			$query->bindparam(":AUTHOR_ID",$author['author_id']);
			$query->bindparam(":ID_GOODREADS",$id);
			$query->bindparam(":TITLE",$title);
			$query->bindparam(":IMAGE",$image);
			$query->bindparam(":DOR",$release);
			$filename = md5(time().$id);
			file_put_contents("./assets/images/covers/$filename.jpg", fopen($cover, 'r'));
			$image = $filename.".jpg";

			$query->execute();
		}
endforeach;
} else {
	//header('Location: uploadBook.php?clicked=form');

}
		//returns to the uploadBook page and gives the paramater XML in the URL.
		//header('Location: uploadBook.php?xml=yes');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title></title>
  <link rel="stylesheet" href="css/index.css">

</head>

<body>

	

</body>
</html> 