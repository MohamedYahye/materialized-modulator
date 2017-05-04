<?php 
include 'includes/init.php';
$all_authors = $db->query('SELECT * FROM authors ORDER BY author ASC');

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = isset($_GET['per-page']) && $_GET['per-page'] <= 50 ? (int)$_GET['per-page'] : 18;

//Paging page / amount of items per page
// Positioning paging
$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;


//displays the HTML of the author on screen
function insertHTML($author){
	?>
	<div style="width:15%" class="authorBox mt col-lg-3 col-md-3 col-sm-6 col-xs-6 col-xxs-12">
			<?php if (!empty ($author['image']) ): ?>
			<h2><?php echo $author['author']; ?></h2>
			<a href="authorInfo.php?author=<?php echo $author['author_id'] ?>">
				<img src="assets/images/authors/<?php echo $author['image']?>" alt="Image">
			</a>
		<?php endif; ?>
		
<!-- 		<a href="authorInfo.php?author=<?php echo $author['author_id'] ?>"</a>
 -->
	</div>

<!-- 	<div class="authorBlockList">
	<font size="5"><b><?php echo $author['author']; ?></b></font><br>
	<div class="block">
		<a href="authorInfo.php?author=<?php echo $author['author_id'] ?>">
			<img src="assets/images/authors/<?php echo $author['image']?>"/>
		</a>
	</div>

	</div>
 -->	<?php
}

include('header.php') ?>
<div class="container">
<?php include('navigation.php') ?>
</div>
<div class="site-content">
<div id="authors">
<?php
//gets the case of "authors"
$view = $_GET['Authors'];

switch($view) {
	//if Authors is User all authors added to the user database are displayed
	case "User":

		$authors = $db->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM authors LEFT JOIN user_authors ON authors.author_id=user_authors.author_id WHERE user_id=:USER_ID LIMIT {$start}, {$perPage}");
		$authors->bindparam(":USER_ID",$user_id);
		$authors->execute();

		$authors = $authors->fetchAll(PDO::FETCH_ASSOC);

		// Pages
		$total = $db->query("SELECT FOUND_ROWS() as total")->fetch()['total'];
		$pages = ceil($total / $perPage);

		foreach($authors as $author):
			if ( !empty ($author['image']) ): 
				insertHTML($author);
			endif;
		endforeach;

		// $user_id = $_SESSION['id'];
		// //select author information based on the author id's known in the user database
		// $query = $db->prepare('SELECT * FROM authors LEFT JOIN user_authors ON authors.author_id=user_authors.author_id WHERE user_id=:USER_ID');
		// $query->bindparam(":USER_ID", $user_id);
		// $query->execute();
	
		// $authors = $query;
		// //if the image of the author is not empty , call the insertHTML function.
		// foreach ($authors as $author):
		// 	if (!empty ($author['image']) ): 
		// 			insertHTML($author);
		// endif;
		// endforeach; 




		break;
	//if anything except of User is put in "Authors" , by default display all.
	default:
		$authors = $db->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM authors LIMIT {$start}, {$perPage}");
		$authors->execute();

		$authors = $authors->fetchAll(PDO::FETCH_ASSOC);

		// Pages
		$total = $db->query("SELECT FOUND_ROWS() as total")->fetch()['total'];
		$pages = ceil($total / $perPage);

		foreach($authors as $author):
			if ( !empty ($author['image']) ): 
				insertHTML($author);
			endif;
		endforeach;


	break;
}

?>

</div>
</div>

<div id="pagination">
	<ul class="paginationUL">
		<?php for($x = 1; $x <= $pages; $x++): ?>
			<li><a href="?Authors=<?php echo $view; ?>&page=<?php echo $x; ?>&per-page=<?php echo $perPage ?>"
				<?php if($page === $x){
					echo ' class="selected"';
				} ?>><?php echo $x; ?></a></li>
		<?php endfor; ?>
	</ul>
</div>


<?php include('footer.php') ?>