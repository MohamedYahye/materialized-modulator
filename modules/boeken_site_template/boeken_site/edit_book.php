<?php 
include 'includes/init.php';


$id = $_GET['id'];

//update the book by adding the summary of the book to the database.
$query = $db->prepare('SELECT * FROM books WHERE id=:ID');
$query->bindparam(':ID', $id);
$query->execute();
$fetch_query = $query->fetch();

print_r($fetch_query);

$author = $fetch_query['author'];
$title = $fetch_query['title'];
$image = $fetch_query['image'];
?>
<html>
<head>
	<title>Edit book</title>
	<LINK href="assets/css/index.css" rel="stylesheet" type="text/css">

</head>
<body>
	<div class="login">
		<div id="loginHeader">
			Edit book
		</div>
		<div id="formInfo">
		<!-- basic login form --> 
			<table align="center">
				<tr><td>
					<form id="loginForm" action="edit_book.php?id=<?php echo $id ?>&update=yes" method="post">
<!-- 					  <input class="editField" type="text" autocomplete="off" name="author" value="<?php echo $author; ?>"><br>
 -->					  <input class="editField" type="text" name="title" value="<?php echo $title; ?>"><br />
					  <input class="editField" type="text" name="image" value="<?php echo $image; ?>"><br />

					<input id="edit" type="submit" value="submit">
					</form>
				</td></tr>
			</table>
			<div id="buttons">
				<a class="a" href="booklist.php?Books=All">Return</a>
			</div>
		</div>
	</div>
</body>
</html><?php

if(!empty($_GET['update'])){
	if($_GET['update'] == 'yes'){
		// $name = $_POST['author'];
		$title = $_POST['title'];
		$image = $_POST['image'];
		$img = md5(time());
		$new_image = $img.".jpg";

		$img_ = $image;
		$img = md5(time());

		file_put_contents("./assets/images/covers/$img.jpg", fopen($img_, 'r'));


		$query= $db->prepare('UPDATE books SET title=:TITLE, image=:IMG WHERE id=:ID');
		// $query->bindparam(":AUTHOR",$name);
		$query->bindparam(":TITLE",$title);
		$query->bindparam(":IMG",$new_image);
		$query->bindparam(":ID",$id);
		$query->execute();


	}
} 

