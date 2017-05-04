<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes

//includes init.php in which the basic files are includes aswell which (almost) every file / page uses
include 'includes/init.php';

//if form is not returned, return to previous page.
if(!$_GET['form']) {
	header('Location: uploadBook.php');
//if form is returned POST the information and insert into database
} else {
	$image_ = md5(time());
	$img = $image_.".jpg";
	$author = $_POST['author'];
	$summary = $_POST['summary'];

	$title = $_POST['title'];
	$bookSummary = $_POST['bookSummary'];
	$dor = $_POST['dor'];
	$bookImage = $_FILES['bookImage']['tmp_name'];
	$secondImg_ = md5($bookImage);
	$secondImg = $secondImg_.".jpg";
	
	$return = '<br /><a href="../boeken_site/uploadBook.php?clicked=form">Go back</a>';

	if(!empty($title)){
		if(!empty($dor)){
			if(!empty($bookImage)){
				if(!empty($author)){
					if(!empty($author_image)){
						if ($_FILES['image']['size'] > 0) {
							if ($_FILES['image'] [ 'size'] <= 153600) {
								if(move_uploaded_file($_FILES['image']['tmp_name'], "assets/images/authors/".$img)){
								} else {
									//upload failed
									echo 'not uploaded';
								}
							} else {
								//file is too big.
							}

						}

						if ($_FILES['bookImage']['size'] > 0) {
							if ($_FILES['bookImage'] [ 'size'] <= 153600) {
								if(move_uploaded_file($_FILES['bookImage']['tmp_name'], "assets/images/covers/".$secondImg)){

								} else {
									echo 'hoi ';
								}
							} else {
								echo '2 big';
							}

						}

						$bookTitle = selectBookByTitle($title);
						if(!$bookTitle){
							$bookAuthor = selectAuthorByName($author);
							if(!$bookAuthor){
								insertAuthor($author, $img , $summary);
							}
							insertBook($author,$title, $secondImg, $bookSummary, $dor);

						} else {
							echo 'book already exists';
						}


						if(!$bookTitle){
							$query = $db->prepare('SELECT * FROM books WHERE title = :TITLE');
							$query->bindparam(":TITLE", $title);
							$query->execute();
							//fetch the info from database.
							$out = $query->fetch(PDO::FETCH_ASSOC);

							if(!$out['author_id']){

								$query = $db->prepare("SELECT author_id FROM authors WHERE author=:AUTHOR");
								$query->bindparam("AUTHOR", $author);
								$query->execute();
								$author_id = $query->fetch();

								$query = $db->prepare("UPDATE books SET author_id=:AUTHOR_ID WHERE title=:TITLE");
								$query->bindparam("AUTHOR_ID", $author_id['author_id']);
								$query->bindparam(":TITLE", $title);
								$query->execute();
							};
						}
					} else {
						echo 'please fill in an image for the author';
						echo $return;					}
				} else {
					echo 'please fill in the author name';
					echo $return;
				}
			} else {
				echo 'please upload a cover image';
				echo $return;
			}
		} else {
			echo 'please fill in a date';
			echo $return;
		}
	} else {
		echo 'please fill in a title';
		echo $return;
	}

	// exit();

	// $move = "/Users/George/Desktop/uploads/".$_FILES['file']['name'];
	// That's one.

	// move_uploaded_file($_FILES['file']['tmp_name'], $move);

	//$moveLoc = "/"

	

}