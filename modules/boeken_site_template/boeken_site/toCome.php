<?php include('header.php') ?>
<div class="container">
<?php include('navigation.php') ?>
<style>
	.form-control {
		border: none;
		background: rgba(242, 242, 242, 0.4);
		color: #000;
	}

	.form-control::-webkit-input-placeholder {
	   color: black;
	}
	.form-control:-moz-placeholder { /* Firefox 18- */
	   color: black;  
	}
	.form-control::-moz-placeholder {  /* Firefox 19+ */
	   color: black;  
	}
	.form-control:-ms-input-placeholder {  
	   color: black;  
	}
</style>

</div>

<div class="site-header"></div>
<div class="content-container">

<div class="site-content">

<!-- Start Contact Area -->
<div id="moveFromTop"></div>
<section id="contact-area" class="contact-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center inner">
				<div class="contact-content">
					<h1>Upload book to be released</h1>
					<!-- <div class="row">                            
						<div class="col-sm-12">
							<p>Add a book that is not released yet.<br />
							Fill in the name of the author<br />
							the name of the book<br />
							the date it is released</p>
							</div>                            
						</div> -->

					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<form action="uploadRelease.php" method="post">
						<div class="col-sm-6 contact-form-left" 
							style="margin-left: auto;
	    						   margin-right: auto;
	    						   float: none;">
							<div class="form-group">
								<input type="text" class="form-control2 form-control" autocomplete="off" placeholder="enter name of author here" name="author"> <br>
								<input type="text" class="form-control2 form-control" autocomplete="off" placeholder="enter name of book here" name="title"> <br>
								<input type="date" class="form-control2 form-control" name="date">
							</div>
							<div class="form-group"
								style="
								    text-align: center;">
								<button type="submit" class="btn btn-default">Send</button><br />
								<a href="toComeList.php?list=general"><li class="button2">General list</li></a>
								<a href="toComeList.php?list=personal"><li class="button2">Personal list</li></a>

							</div>
						</div>
								
					</form>  
				</div>                
			</div>
		</div>
	</section>
<!-- End Contact Area -->


	

</div>
</div>

<?php include('footer.php') ?>