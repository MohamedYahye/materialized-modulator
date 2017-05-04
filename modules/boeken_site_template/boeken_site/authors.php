<?php include('header.php') ?>

	  <div class="container">
	  <?php include('navigation.php') ?>

	    </div>



<div class="site-content">
   <h1>Authors</h1>
	<div id="authors">

	<!-- gets the information of the author and order it by their lastname. --> 
	<?php $authors = $db->query('SELECT * FROM authors ORDER BY last_name ');
	
	//checks foreach author if the image of the author is available in the database.
	foreach ($authors as $author): 
		//if the author_image is not empty echo out the image and description.
		 if ( !empty ($author['author_image']) ): ?>

		<div class="authorBlock">
		<div class="scrollbar" id="ex3">

		<div class="block">
			<img src="uploads/<?php echo $author['author_image']?>" />
			<div class="description"><?php echo $author['author_description'] ?></div>
		</div>


		</div>
		<!-- button for all the books of a specific author. -->
			<div class="button"><a href="books.php?author=<?php echo $author['id'] ?>">Books</a></div>		
		</div>
		<?php endif; ?>
	<?php endforeach; ?>

		   
	</div>
</div>

<?php include('footer.php') ?>