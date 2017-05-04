<?php

include 'includes/init.php';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Library</title>
</head>
<body>
	<?php include('header.php') ?>
	<div class="container">
	<?php include('navigation.php') ?>


	<!-- Start Feature Area -->
	<section id="feature-area" class="about-section">
		<div class="container">
			<div class="Mtop row text-center inner">
				<div style="width:50%" class="bookButton col-sm-4">
					<div style="background: white;" class="feature-content">
						<a href="authorList.php?Authors=All">
							<img src="../img/allA.jpg" alt="Image">
						</a>
 					</div>
				</div>
				<div style="width:50%" class="bookButton col-sm-4">
					<div style="background: white;" class="feature-content">
						<a href="bookList.php?Books=All">
							<img src="../img/allB.jpg" alt="Image">
						</a>
					</div>
				</div>
				<div style="width:50%" class="bookButton col-sm-4">
					<div style="background: white;" class="feature-content">
						<a href="authorlist.php?Authors=User">
							<img src="../img/personalA.jpg" alt="Image">
						</a>
					</div>
				</div>
				<div style="width:50%" class="bookButton col-sm-4">
					<div style="background: white;" class="feature-content">
						<a href="bookList.php?Books=User">
							<img src="../img/personalB.jpg" alt="Image">
						 </a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Feature Area -->

<!-- <div id="header">
</div>

<div class="content-container">

<div class="site-content">
	<div class="sideBar"> 
		<ul>

			<li class="button">
				<a href="authorList.php?Authors=All">All authors</a></li>
			<li class="button">
				<a href="authorlist.php?Authors=User">My authors</a></li>
			<li class="button">
				<a href="bookList.php?Books=All">All books</a></li>
			<li class="button">
				<a href="bookList.php?Books=User">My books</a></li>
		</ul>

	</div>


</div>
</div>
 -->
<?php include('footer.php') ?>