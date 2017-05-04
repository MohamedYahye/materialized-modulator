<?php 
include 'includes/init.php';
include 'header.php';
?>
<div class="container">
	<?php include 'navigation.php'; ?>
</div>
<div class="site-header"></div>
<div class="content-container">
<div class="site-content">
<section id="blog-area">
	<div class="container">
		<div class="row text-center inner">
			<div style="width: 100%;" class="Mtop col-sm-6">
				<div class="Rbgc blog-content">
					<img src="../img/search_book.jpg" alt="Image">
					<h2>Search results</h2>
					<div id="empty"></div>
<?php
$searchVar = $_GET['search'];
$output = '';
//checks if the user puts in a search result
if($searchVar == 'All') {
	if(isset($_POST['search'])){

		$searchq = $_POST['search'];
		$_SESSION['searchqSession'] = $searchq;
		
		$query = $db->prepare("SELECT * FROM books WHERE title COLLATE UTF8_GENERAL_CI LIKE '%$searchq%' OR author COLLATE UTF8_GENERAL_CI LIKE '%$searchq%'") or die("could not search");
		$query->execute();
		$count = $query->rowCount();

		//if there are no search results the rowCount gives 0 because there are 0 results.
		//if it is 0 continuou to the next search field to search on goodreads.  
		if($count == 0){
			$output = '';
			?>
			<script>
			document.getElementById('empty').innerHTML += "There was no search result";

			$(document).ready(function() {

			    var input = $("#autofocusCursor");
			    var len = input.val().length;
			    input[0].focus();
			    input[0].setSelectionRange(len, len);

			});
			</script>


			<?php 
			searchBookXMLHTML($searchq);
		//if rowCount has results found in the database fetch the results and print it on the screen.
		} else {
			while($row = $query->fetch(PDO::FETCH_BOTH)){


				$title = $row['title'];
				$author = $row['author'];
				$id = $row['id'];
				$author_id = $row['author_id'];
				$book_id = $row['id'];

				//checks if the user has the book in their personal database.
				$has_book = ifUserHasBook($id, $user_id);
				//gets the result of $has_book, if the user doesn't have the book $addRemove will be 'add', Otherwise it will be 'remove'.
				$addRemove = (!$has_book) ? 'add' : 'remove';
				//prints the result on the screen.
				// $output .= '
						
				// 							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam tempor eros eget eros maximus, ut cursus sem euismod. Donec iaculis tristique odio at consectetur. Nullam dignissim varius suscipit. Sed in leo sit amet velit finibus pretium.<br><br>
				// 								Vestibulum vel mauris at erat mattis accumsan et ac lorem. Cras non venenatis orci, sed tincidunt massa. Duis nisl lectus, auctor eu sodales at, dignissim eu orci. Sed vitae venenatis magna, in blandit metus.</p>
				// 								<br>		
				// '

				$output .= '<div class="fullWidth output">
				 <a href="book.php?b='.$id.'"</a>'.$title.'</a> - 
				 <a href="authorInfo.php?author='.$author_id.'"</a>'.$author.' 
				 
				 <a href="update_book.php?user='.$book_id.'" class="Link '.$addRemove.'">
				 	<img src="./assets/images/'.$addRemove.'.png"></img></a>
				 	
				 &nbsp;&nbsp;
					</div><br>';

			}
		}

	}
} else {
	if(isset($_POST['search'])){

		$searchq = $_POST['search'];
		$_SESSION['searchqSession'] = $searchq;
		
		$id_query = $db->prepare("SELECT book_id FROM user_books WHERE user_id=:USER_ID");
		$id_query->bindparam(":USER_ID",$user_id);
		$id_query->execute();
		$id_query = $id_query->fetchAll(PDO::FETCH_ASSOC);

		$id_author = $db->prepare("SELECT author_id FROM user_authors WHERE user_id=:USER_ID");
		$id_author->bindparam(":USER_ID",$user_id);
		$id_author->execute();
		$id_author = $id_author->fetchAll(PDO::FETCH_ASSOC);
		$idaID = [];
		$idbID = [];
		foreach($id_author as $ida){
			$idaID[] = $ida['author_id'];
		}
		foreach($id_query as $idb){
			$idbID[] = $idb['book_id'];
		}
		$q = "SELECT * FROM books WHERE (title COLLATE UTF8_GENERAL_CI LIKE '%$searchq%' AND id IN (".implode(',',$idbID).")) OR (author COLLATE UTF8_GENERAL_CI LIKE '%$searchq%' AND id IN (".implode(',',$idbID).") AND author_id IN (".implode(',',$idaID)."))";
		$query = $db->prepare($q) or die("could not search");
		$query->execute();
		$count = $query->rowCount();

		//if there are no search results the rowCount gives 0 because there are 0 results.
		//if it is 0 continuou to the next search field to search on goodreads.
		if($count == 0){
			$output = 'There was no search results!';
			?>
			<script>
			$(document).ready(function() {
			  
			    var input = $("#autofocusCursor");
			    var len = input.val().length;
			    input[0].focus();
			    input[0].setSelectionRange(len, len);

			});
			</script>


			<?php 
			searchBookXMLHTML($searchq);

		//if rowCount has results found in the database fetch the results and print it on the screen.
		} else {
			while($row = $query->fetch(PDO::FETCH_BOTH)){


				$title = $row['title'];
				$author = $row['author'];
				$id = $row['id'];
				$author_id = $row['author_id'];
				$book_id = $row['id'];

				//checks if the user has the book in their personal database.
				$has_book = ifUserHasBook($id, $user_id);
				//gets the result of $has_book, if the user doesn't have the book $addRemove will be 'add', Otherwise it will be 'remove'.
				$addRemove = (!$has_book) ? 'add' : 'remove';

				//prints the result on the screen.
				$output .= '<div class="fullWidth output">
				 <a href="book.php?b='.$id.'"</a>'.$title.'</a> - 
				 <a href="authorInfo.php?author='.$author_id.'"</a>'.$author.' 
				 
				 <a href="update_book.php?user='.$book_id.'" class="Link '.$addRemove.'">
				 	<img src="./assets/images/'.$addRemove.'.png"></img></a>
				 	
				 &nbsp;&nbsp;
					</div><br>';

			}
		}

	}

}
print("$output");
?>
			</div>
		</div>
		</div>
	</div>
</section>
</div>
</div>
<?php include('footer.php') ?>