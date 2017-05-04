<?php
include 'includes/init.php';

$unixtime = strtotime($_POST['date']);
$unixDate = date("Y-m-d",$unixtime);

$postDate = $_POST['date'];

$author = $_POST['author'];
$title = $_POST['title'];
$user_id = 	$_SESSION['id'];

if(empty($postDate)){
	echo 'Please fill in a date';
	echo '<br />';
	echo '<a href="../boeken_site/toCome.php">Go back</a>';
	exit();
} else if(empty($title)){
	echo 'Please fill in a title';
	echo '<br />';
	echo '<a href="../boeken_site/toCome.php">Go back</a>';
	exit();
} else if(empty($author)) {
	echo 'Please fill in an author';
	echo '<br />';
	echo '<a href="../boeken_site/toCome.php">Go back</a>';
	exit();
}
if(!empty($postDate || $title || $author)){
	function ifExists($title){
		global $db;
		$query = $db->prepare('SELECT * FROM tocome WHERE book_title = :BOOK_TITLE');
		$query->bindparam(":BOOK_TITLE", $title);
		$query->execute();
		$toComeExists = $query->fetch();
		return $toComeExists;
	}

	echo $title;
	$toComeExists = ifExists($title);


// $book = getBookByGoodreadsId($id);

// function getBookById($id){
// 	global $db;
// 	$sth = $db->prepare("SELECT * FROM books WHERE id = :BOOK_ID");
// 	$sth->bindparam(":BOOK_ID", $id);
// 	$sth->execute();
// 	$book = $sth->fetch();
// 	return $book;
// }

if(!$toComeExists){
	$query = $db->prepare('INSERT INTO tocome (author, book_title, released) VALUES (:AUTHOR, :BOOK_TITLE, :RELEASE)'); 
	$query->bindparam(":AUTHOR",$author);
	$query->bindparam(":BOOK_TITLE",$title);
	$query->bindparam(":RELEASE",$postDate);
	$query->execute();

	$query = $db->prepare('INSERT INTO user_tocome (author, book_title, released, user_id) VALUES (:AUTHOR, :BOOK_TITLE, :RELEASE, :USER_ID)');
	$query->bindparam(":AUTHOR",$author);
	$query->bindparam(":BOOK_TITLE",$title);
	$query->bindparam(":RELEASE",$postDate);
	$query->bindparam(":USER_ID",$user_id);
	$query->execute();	


} else {
	echo 'Book already exists!';
}
}

//header('Location: toCome.php');
?>