<?php 
include 'includes/init.php';

include('header.php') ?>
<div class="container">
<?php include('navigation.php') ?>
</div>
<div class="site-content">
<div id="authors">

<?php
//gets the paramater 'Books' from the URL. 
$view = $_GET['Books'];
//user input
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = isset($_GET['per-page']) && $_GET['per-page'] <= 50 ? (int)$_GET['per-page'] : 44;

//Paging page / amount of items per page
// Positioning paging
$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

switch($view) {
	//if 'Books' is 'User' display all the books from the user_books tabel.
	case "list":
		$user_id = $_SESSION['id'];

		//Query
		$bookId = $db->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM user_books WHERE user_id=:USER_ID LIMIT {$start}, {$perPage}");
		$bookId->bindparam(":USER_ID",$user_id);
		$bookId->execute();

		$results = $bookId->fetchAll(PDO::FETCH_ASSOC);

		// Pages
		$total = $db->query("SELECT FOUND_ROWS() as total")->fetch()['total'];
		$pages = ceil($total / $perPage);


		foreach($results as $result):
		$Id_book = $result['book_id'];
		$books = $db->prepare("SELECT * FROM books WHERE id=:ID");
		$books->bindparam(":ID",$Id_book);
		$books->execute();

		$books = $books->fetchAll(PDO::FETCH_ASSOC);

		foreach($books as $book):

			$title = $book['title'];
			$author = $book['author'];
			$id = $book['id'];
			$author_id = $book['author_id'];
			$book_id = $book['id'];

				

			$fetch_id = $book['id'];
			$has_book = ifUserHasBook($fetch_id, $user_id);
			$addRemove = (!$has_book) ? 'add' : 'remove';
			//creates a div called cover and inserts the cover of the book with the add or remove button in it.
			//on the book is a link to the information of the book.
			echo '<div class="outputList">
			 <a href="book.php?b='.$id.'"</a>'.$title.'<br>
			 <a href="authorInfo.php?author='.$author_id.'"</a>'.$author.' 
			 
			 <a href="update_book.php?user='.$book_id.'" class="Link '.$addRemove.'">
			 	<img src="./assets/images/'.$addRemove.'.png"></img></a>
			 	
			 &nbsp;&nbsp;
				</div><br>';

		endforeach;
		endforeach;

	break;
	case "User":

			//Query
			$books = $db->prepare("SELECT SQL_CALC_FOUND_ROWS books.id AS book_id, books.image , books.summary FROM books LEFT JOIN user_books ON books.id=user_books.book_id WHERE user_books.user_id=:USER_ID LIMIT {$start}, {$perPage}");
			$books->bindparam(":USER_ID",$user_id);
			$books->execute();
			$books = $books->fetchAll(PDO::FETCH_ASSOC);

			// Pages
			$total = $db->query("SELECT FOUND_ROWS() as total")->fetch()['total'];
			$pages = ceil($total / $perPage);

			foreach($books as $book):
				$user_id = $_SESSION['id'];
				$book_id = $book['book_id'];

				$value = $db->prepare('SELECT money_value, emotional_value FROM user_books WHERE user_id=:USER_ID AND book_id=:BOOK_ID');
				$value->bindparam(":USER_ID",$user_id);
				$value->bindparam(":BOOK_ID",$book_id);
				$value->execute();
				$value = $value->fetch(PDO::FETCH_ASSOC);

				$fetch_id = $book['book_id'];
				$money_value = $value['money_value'];
				$e_value = $value['emotional_value'];
				$has_book = ifUserHasBook($fetch_id, $user_id);

				$addRemove = (!$has_book) ? 'add' : 'remove';
				//creates a div called cover and inserts the cover of the book with the add or remove button in it.
				//on the book is a link to the information of the book.
				

				?><div id="width" class="mt col-lg-3 col-md-3 col-sm-6 col-xs-6 col-xxs-12">
					<div class="heightChange testimonial-content">

						<img src="./assets/images/covers/<?php echo $book["image"] ?>"></img>
						
						<?php echo '<a href="book.php?b='.$book["book_id"].'">
					<div class="cover">
							<a href="update_book.php?user='.$book["book_id"].'" class="Link '.$addRemove.'">
								<img src="./assets/images/'.$addRemove.'.png"></img></a>
								
								<a href="edit_book.php?id='.$book["book_id"].'">
									<img src="./assets/images/edit.jpg"></img>
								</a>';
							if($e_value > 0) {
								echo '<a onclick="unEmotional();">
									<img src="./assets/images/heart.jpg"></img></a>';
							} else {
								echo '<a href="value.php?value=emotional&E=1&id='.$book["book_id"].'">
									<img src="./assets/images/black_heart.png"></img></a>';

							}
							if($value['money_value'] > 0){
								echo '<a href="value.php?value=money&id='.$book["book_id"].'">
								€'.$money_value.'</a>'; 
							} else {
							echo '<a href="value.php?value=money&id='.$book["book_id"].'">
								<img src="./assets/images/money.png"></img></a>';
							}
					echo '
						</div></a>';
						 ?>
					</div>
				</div>
				<?php 		

				// echo '<div style="width:15%" class="authorBox mt col-lg-3 col-md-3 col-sm-6 col-xs-6 col-xxs-12">
				// 		<img src="./assets/images/covers/'.$book["image"].'" align="left" hspace="10" vspace="10"</img>
				// 		<p class="giveMeMoreEllipsis">'.$book['summary'].'</p>
				// 	</div>
				// ';
				
				
				

			endforeach;


		break;
	//if the case is different than 'User' display all the books known in the database. 
	default:

		//Query
		$books = $db->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM books LIMIT {$start}, {$perPage}");
		$books->execute();

		$books = $books->fetchAll(PDO::FETCH_ASSOC);

		// Pages
		$total = $db->query("SELECT FOUND_ROWS() as total")->fetch()['total'];
		$pages = ceil($total / $perPage);

		foreach ($books as $book):
			$user_id = $_SESSION['id'];
			//checks if the user has the book or not
			$fetch_id = $book['id'];
			$has_book = ifUserHasBook($fetch_id, $user_id);

			$addRemove = (!$has_book) ? 'add' : 'remove';
		?>

		<div id="width" class="mt col-lg-3 col-md-3 col-sm-6 col-xs-6 col-xxs-12">
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
<?php

		// foreach($books as $book):
			// $user_id = $_SESSION['id'];

			// $fetch_id = $book['id'];
			// $has_book = ifUserHasBook($fetch_id, $user_id);

			// $addRemove = (!$has_book) ? 'add' : 'remove';
			//creates a div called cover and inserts the cover of the book with the add or remove button in it.
			//on the book is a link to the information of the book.
		// 	echo '<a href="book.php?b='.$book["id"].'">
		// 		<div class="cover">
		// 			<img src="./assets/images/covers/'.$book["image"].'"></img>
		// 			<div class="bar">
		// 				<a href="update_book.php?user='.$book["id"].'" class="Link '.$addRemove.'">
		// 					<img src="./assets/images/'.$addRemove.'.png"></img></a>
		// 				<a href="edit_book.php?id='.$book["id"].'">
		// 				<img src="./assets/images/edit.jpg"></img>
		// 				</a>
		// 		</div>
		// 			</div></a>';

		// // endforeach;
}
?>
</div>
</div>


<div id="pagination">
	<ul class="paginationUL">
		<?php for($x = 1; $x <= $pages; $x++): ?>
			<li><a href="?Books=<?php echo $view; ?>&page=<?php echo $x; ?>&per-page=<?php echo $perPage ?>"
				<?php if($page === $x){
					echo ' class="selected"';
				} ?>><?php echo $x; ?></a></li>
		<?php endfor; ?>
	</ul>
</div><script src="assets/js/addRemove.js"></script>


<?php include('footer.php') ?>