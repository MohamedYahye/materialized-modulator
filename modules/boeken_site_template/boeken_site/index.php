<?php
//checks if user is logged in, if not send to login screen.
include 'includes/init.php'; 
include 'limit.php'; 
include 'paging_functions.php';

//creates standard layout
include('header.php'); ?>
<div class="container">
<?php include('navigation.php');
//creates author query
$query = "SELECT * FROM authors ORDER BY author ASC";

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = isset($_GET['per-page']) && $_GET['per-page'] <= 8 ? (int)$_GET['per-page'] : 8;

//Paging page / amount of items per page
// Positioning paging
$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;


?>

<br>
<br>
<br>
<br>
<br>
</div>




<div class="site-content">
<center><h1>Authors</h1></center>
<div id="authors">

<?php 
	$authors = $db->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM authors LIMIT {$start}, {$perPage}");
	$authors->execute();

	$authors = $authors->fetchAll(PDO::FETCH_ASSOC);

	// Pages
	$total = $db->query("SELECT FOUND_ROWS() as total")->fetch()['total'];
	$pages = ceil($total / $perPage);
	?><!-- Start Testimornial Area -->
	<section id="testimornial-area">
		<div class="container">
			<div class="row text-center">
	<?php foreach ($authors as $author):
		?>

	
				<div class="mt col-lg-3 col-md-3 col-sm-6 col-xs-6 col-xxs-12">
					<div class="testimonial-content">
						<?php if (!empty ($author['image']) ): ?>

						<img src="assets/images/authors/<?php echo $author['image']?>" alt="Image">
						<div class="text">
							<h2><?php echo $author['author']; ?></h2>
							<p class="giveMeEllipsis"><?php echo $author['summary'] ?></p>
							<br>
							<p id="redd"></p>
						</div>
					<?php endif; ?>
					</div>
					<a style="margin-top:-5%" href="authorInfo.php?author=<?php echo $author['author_id'] ?>" class="content-link">more</a>

				</div>
			


		


	<?php endforeach; ?>
			</div>
		</div>
	</section>
	<!-- End Testimornial Area -->

		</div>


</div>

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


