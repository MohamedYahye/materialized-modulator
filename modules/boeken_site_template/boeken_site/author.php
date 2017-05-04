<?php
include 'includes/init.php';
include 'header.php';
include'navigation.php';

//if the author ID is not set return to previous page.
if(!isset($_GET['author']))	{
	header('Location: ./');
	die(); 
}
//get author_id from URL 
$author_id = $_GET['author'];

//select the information of the book by the author_id 
$query = $db->prepare('SELECT * FROM books WHERE author_id = :AUTHOR_ID');
$query->bindparam(':AUTHOR_ID', $author_id);
$query->execute();
$books = $query;

//select author information of the author defined in the URL.
$query = $db->prepare('SELECT author FROM authors WHERE author_id = :AUTHOR_ID');
$query->bindparam(':AUTHOR_ID', $author_id);
$query->execute();
$authorName = $query->fetch(PDO::FETCH_ASSOC);

//echo's out the name of the specific author selected.
echo '<div id="authorBooks"><b><font size="5">Books written by '. $authorName['author'].'</font> <br><br>';
			//creates foreach loop to display all the books written by the specified author
			foreach ($books as $book):

				$fetch_id = $book['id'];
				$has_book = ifUserHasBook($fetch_id, $user_id);

				$addRemove = (!$has_book) ? 'add' : 'remove';
				echo '<a href="book.php?b='.$book["id"].'"><div class="cover"><img src="./assets/images/covers/'.$book["image"].'"></img>
				<div class="bar">

				<a href="update_book.php?user='.$book["id"].'" class="Link '.$addRemove.'">
			
				<img src="./assets/images/'.$addRemove.'.png"></img></a><br>

				

				</div>

				</div>
				</a>';				
			endforeach;

		'</div>'
	?>
</div>
<!-- loads the script for the addRemove button -->
<script src="assets/js/addRemove.js"></script>

<?php include 'footer.php'; ?>
