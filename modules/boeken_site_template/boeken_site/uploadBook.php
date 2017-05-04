<?php
ini_set("max_execution_time", 0);

include 'includes/init.php'; 
include('header.php');
?>
<div class="container">
<?php include('navigation.php') ?>
</div>
<div class="site-header"></div>
<div class="content-container">

<div class="site-content">
<br />
<br />
<br />
<section id="testimornial-area">
						<div class="container">
							<div class="row">
								<div class="col-lg-12">
									<div class="tm-box">
										<img src="../img/open_book.jpg" alt="Image" class="img-responsive">

<!-- <div id="buttons">
	<a class="a" href="uploadBook.php?clicked=form">Handmatig</a>
	<a class="a" href="uploadBook.php?clicked=online">Online</a>
</div>

 --><?php

$output = '';
//gets the 'clicked' parameter 
if(!empty($_GET['clicked'])) {
	$getClicked = $_GET['clicked'];

//if the 'clicked' parameter is put to yes give the ability to search for a new book.
if ($getClicked == 'yes') {
	?><style type="text/css">.Dbase{
	display:none;
	}</style>
	<?php 
	searchBookXMLHTML('');
}
//if the 'clicked' parameter is put to 'form' hide the search box and create a form to upload your own book.
if ($getClicked == 'form') {
?>
	<script type="text/javascript">
		$(document).ready(function(){
				$("#searchDatabase").hide();	
		});
	</script>
<?php
	//create form 
	echo '	
	<fieldset>
		<legend>Add book to database</legend>

		<form action="uploadForm.php?form=yes" method="post" enctype="multipart/form-data">
			<fieldset><legend>Author information</legend>
				<input type="text" name="author" placeholder="authorname"><br />
				<input type="text" name="summary" placeholder="author information"><br />
				<input type="file" name="image" id="image">
			</fieldset>

			<br /><br />
			<fieldset><legend>Book Information</legend>
				<input type="text" name="title" placeholder="book title"<br />
				<input type="text" name="bookSummary" placeholder="book information"><br />
				<input type="date" name="dor">
				<input type="file" name="bookImage" id="bookImage">
			</fieldset>

			<input type="submit" value=">>" name="submit" />
		</form>
	</fieldset>';
}
}
//checks if the user puts in a search result
if(isset($_POST['search'])){
	$searchq = $_POST['search'];
	$_SESSION['searchqSession'] = $searchq;

	$query = $db->prepare("SELECT * FROM books WHERE title COLLATE UTF8_GENERAL_CI LIKE '%$searchq%' OR author COLLATE UTF8_GENERAL_CI LIKE '%$searchq%'") or die("could not search");
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
		echo '<div class="centerForm tm-box-description">
			<p class="tm-box-p">
			Not the book you were looking for?&nbsp&nbsp
					<button id="formButton">
						<a href="uploadBook.php?clicked=yes">Click here</a>
					</button>
			</p>
		</div>';                   
		while($row = $query->fetch(PDO::FETCH_BOTH)){


			$title = $row['title'];
			$author = $row['author'];
			$id = $row['id'];

			//checks if the user has the book in their personal database.
			$has_book = ifUserHasBook($id, $user_id);
			//gets the result of $has_book, if the user doesn't have the book $addRemove will be 'add', Otherwise it will be 'remove'.
			$addRemove = (!$has_book) ? 'add' : 'remove';

			//prints the result on the screen.
			$output .= '<div class="output"> '.$title.' '.$author.'&nbsp;&nbsp;
							<a href="update_book.php?user='.$id.'">
				<img src="./assets/images/'.$addRemove.'.png" height="25" width="25"/></a></div><br>';



		}
	}

}
		if(!empty($_GET['xml'])){
		//gets the XML parameter in the url
		$getXml = $_GET['xml'];
		//checks if the parameter is set to 'yes'
		if($getXml == 'yes'){
		//button for if the book you were looking for is not in the list 
		echo 'Still not the book you were looking for?&nbsp&nbsp
			<button id="formButton">
				<a href="uploadBook.php?clicked=form">Click here</a>
			</button>';


		$titles_posted = $_SESSION['searchqSession'];
		$query = $db->prepare("SELECT * FROM books WHERE title COLLATE UTF8_GENERAL_CI LIKE '%$titles_posted%' OR author COLLATE UTF8_GENERAL_CI LIKE '%$titles_posted%'") or die("could not search");
		$query->execute();

		while($row = $query->fetch(PDO::FETCH_BOTH)){


			$title = $row['title'];
			$author = $row['author'];
			$id = $row['id'];

			//checks if the user has the book in their personal database.
			$has_book = ifUserHasBook($id, $user_id);
			//gets the result of $has_book, if the user doesn't have the book $addRemove will be 'add', Otherwise it will be 'remove'.
			$addRemove = (!$has_book) ? 'add' : 'remove';
			//prints the result on the screen.
			$output .= '<div class="output"> '.$title.' '.$author.'&nbsp;&nbsp;
							<a href="update_book.php?user='.$id.'">
				<img src="./assets/images/'.$addRemove.'.png" height="25" width="25"/></a></div><br>';



		}	
	}
}


	?>

	<div class="Dbase centerForm tm-box-description">
		<h2>Search if book is already in database</h2>
		<p class="tm-box-p">
			<fieldset id="searchDatabase">
				<form action="uploadBook.php" method="post">
					<input type="text" name="search" placeholder="Search book" id="bottomSearch">&nbsp;&nbsp;&nbsp;
					<input type="submit" value=">>" />
				</form>
				<?php print ("$output"); ?>
			</fieldset>
		</p>
	</div>                        
					</div>                    
				</div>
			</div>
		</div>
	</section>



</table>
</td></tr>

</div>


</div>

<?php include('footer.php') ?>