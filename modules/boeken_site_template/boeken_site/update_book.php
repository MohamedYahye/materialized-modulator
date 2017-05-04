<?php
include 'includes/init.php';
//if the user is not logged in return to the previous page.
if(isset($_GET['remove'])){
	$query = $db->prepare("SELECT * FROM books WHERE id=:ID");
	$query->bindparam("ID", $_GET['user']);
	$query->execute();
	$result = $query->fetch();

	$author_name = $result['author'];
	$book_title = $result['title'];

	removeUpdateUserToCome($author_name, $book_title, $user_id);

};
if(!isset($_GET['user']))	{
	header('Location: ./');
	die(); 
}
?> 
<!-- alert box display's the name of the book you removed or added.
	After OK has been pressed go back to the bookList page -->
<script type="text/javascript">
	function addRemove(title , name) {
		var title = title;
		var check = name;
		var confirmAddRemove = alert(title + ' has been ' + name);
		window.location.assign("bookList.php?Books=All")
	}
</script>

<?php
//gets the ID of the user that is logged in.
$user_id = $_SESSION['id'];
//gets the id of the book.
$book_id = $_GET['user']; 

//gets the ID of the author from the book that is set in the URL.
$query = $db->prepare("SELECT author_id , title FROM books WHERE $book_id = id");
$query->execute();
$get_author = $query->fetch();
$get_author_id = $get_author['author_id'];
$get_title = $get_author['title'];

//sets the variable $book to the information of the book set by the ID of the book.
$book = getBookById($_GET['user']);
//checks if the book exists in the database
if($book){
	//checks if the user has the book or not. 
	if(!ifUserHasBook($book_id, $user_id)) {
		//if the user doesn't have the book add the book to the table of the user.
		favoriteBook($book_id, $user_id);
		//checks if the user has the author in their personal table. 
		if(!ifUserHasAuthor($get_author_id, $user_id)) {
			//if the user doesn't have the author , add the author to the table of the user.
			favoriteAuthor($get_author_id, $user_id);
		}
		?>
		<!-- calls the addRemove function to display the alert box and continue to the previous page --> 
		<script type="text/javascript">
			var Title = "<?php echo $get_title; ?>";
			addRemove(Title , 'added');

		</script>
		<?php
	  //if the user already has the book added to their personal database remove it from their database.
	} else {

		//counts all the authors with the ID of author_id.
		$query = $db->prepare("SELECT * FROM user_authors WHERE user_id = $user_id AND author_id = $get_author_id");
		$query->execute();
		$count = $query->rowCount();
		
		//remove the book from the users database. 
		removeUserBook($user_id, $book_id);

		//if there is an author found with the ID of author_id remove it from the users database.
		if($count === 1){
			removeUserAuthor($user_id, $get_author_id);
			 ?>
			 <!-- calls the addRemove function to display the alert box and continue to the previous page -->
			 <script type="text/javascript">
				var Title = "<?php echo $get_title; ?>";
			 	addRemove(Title , 'removed');

			 </script>
			 <?php

			}
		}
	}
