<?php 
include 'includes/init.php';
include('header.php') ?>
<div class="container">
<?php include('navigation.php') ?>
</div>
<div class="site-content">
<div id="authors">
<?php

	//get author from URL.
	$view = $_GET['author'];
	//makes query to select all books from the author selected in the URL.
	$query = $db->prepare('SELECT * FROM books WHERE author_id=:AUTHOR_ID');
	$query->bindparam(':AUTHOR_ID', $view);
	$query->execute();
	$books = $query;

	//select all author information from the author_id selected in the URL.
	$query = $db->prepare('SELECT * FROM authors WHERE author_id=:AUTHOR_ID');
	$query->bindparam(':AUTHOR_ID', $view);
	$query->execute();
	$out = $query->fetch(PDO::FETCH_ASSOC);

?>

<div class="authorBlockList">
<font size="5"><b><?php echo $out['author']; ?></b></font><br>
<div class="block"><img src="assets/images/authors/<?php echo $out['image']?>"/>
</div>

</div>
<div id="authorInformation">
	<p><?php echo $out['summary']; ?></p>
</div>
<?php
//foreach loop to loop through all the books written by the specified author
foreach ($books as $book):
	//checks if the user has the book or not
	$fetch_id = $book['id'];
	$has_book = ifUserHasBook($fetch_id, $user_id);

	$addRemove = (!$has_book) ? 'add' : 'remove';
?>

<div style="width:10%" class="mt col-lg-3 col-md-3 col-sm-6 col-xs-6 col-xxs-12">
	<div class="heightChange testimonial-content">

		<img src="./assets/images/covers/<?php echo $book["image"] ?>"></img>
		
		<?php echo '<a style="float:right;" href="update_book.php?user='.$book["id"].'" class="Link '.$addRemove.'">
			<img src="./assets/images/'.$addRemove.'.png"></img></a><br>';

		 ?><div class="text">

			<?php echo $book['title']; ?>
		
			<br>
		</div>
	</div>
</div>
<?php 		endforeach;
 ?>





</div>
</div>
<!-- script to add or remove the book -->
<script src="assets/js/addRemove.js"></script>


<?php include('footer.php') ?>