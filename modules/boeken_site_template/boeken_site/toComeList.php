<?php 
include 'includes/init.php';
include 'header.php';
?>
<div class="container">
	<?php include 'navigation.php'; ?>
</div>
	<?php
	$getList = $_GET['list'];
	//echo $getList;

	if($getList == 'general'){
		$userOut_id = [];
		$today_date = date("Y-m-d");

		//gets all the content from the tocome table
		$query = $db->prepare('SELECT * FROM tocome WHERE released > "'. $today_date . '" ORDER BY released DESC LIMIT 5');
		$query->execute();
		$out = $query->fetchAll(PDO::FETCH_ASSOC);


		$user_query = $db->prepare('SELECT * FROM tocome WHERE released < "'. $today_date . '" ORDER BY released DESC LIMIT 5');
		$user_query->execute();
		$user_out = $user_query->fetchAll(PDO::FETCH_ASSOC);
		
		foreach($user_out as $uo){
			$author_name = $uo['author'];
			$book_title = $uo['book_title'];

			//removeUpdateToCome($author_name, $book_title);
		}
		
		// foreach($user_out as $uo){

		// }

		// for($i = 0; $i < count($out); $i++){
		// 	if($today_date >= $out[$i]['released']){
		// 		//if its smaller remove and update the selected book
		// 		$author_name = $out[$i]['author'];
		// 		$book_title = $out[$i]['book_title'];
		// 		$datum = $out[$i]['released'];

		// 		// foreach($released_query_out as $rqo){
		// 		// 	echo 'released title = '. $rqoTitle.' / book title = '.$book_title; 
		// 		// 	echo '<br />';
		// 		// 	$rqoTitle = $rqo['title'];
		// 		// 	if($rqoTitle == $book_title){
		// 		// 		echo 'Already exists';
		// 		// 	} else {
		// 		// 		echo 'doesn"t exist';
		// 		// 		//insertReleased($author_name, $book_title, $user_id, $datum);
		// 		// 	}
		// 		// }
		// 		// if(empty($released_query_out)){
		// 		// 	insertReleased($author_name, $book_title, $user_id, $datum);
		// 		// }

		// 	}
		// }


			// foreach ($user_out as $userOut) {
			// 	$userOut_id[] = $userOut['user_id'];
			// }
			// $userOut_id_implode = implode(',',$userOut_id);

		//loop through each element from the tocomet able
		//$dateOfBook = [];
		//$today = date("Y-m-d");
		// foreach ($out as $outs) {
		// 	$datum = $outs['released'];
		// 	//gets the date of the selected book.
		// 	$bookDate = date("d-m-Y", strtotime($datum));
		// 	$dateOfBook = $outs['released'];
		// 	//gets the name of the author
		// 	$author_name = $outs['author'];
		// 	//gets the title of the book
		// 	$book_title = $outs['book_title'];

		// 	$today = strtotime($today);
		// 	$bookDate = strtotime($bookDate);
		// 	//checks if today is equal or smaller then the bookdate 
	
		// }
		
		// if($today >= $dateOfBook){
		// 	//echo $today;
		// 	//echo '<br />';
		// 	//if its smaller remove and update the selected book
		// 	//removeUpdateToCome($author_name, $book_title);
		// 	//removeUpdateUserToCome($author_name, $book_title);
		// 	//echo $DOB;
		// 	//insertReleased($author_name, $book_title, $user_id, $datum);
		// }

	} else if($getList == 'personal') {
		$today_date = date("Y-m-d");

		//gets all the content from the tocome table
		$query = $db->prepare('SELECT * FROM user_tocome WHERE (user_id=:USER_ID AND released > "'. $today_date .'") ORDER BY released DESC LIMIT 5');
		$query->bindparam(":USER_ID",$user_id);
		$query->execute();
		$out = $query->fetchAll(PDO::FETCH_ASSOC);


		$user_query = $db->prepare('SELECT * FROM user_tocome WHERE user_id=:USER_ID AND released < "'. $today_date . '" ORDER BY released DESC LIMIT 5');
		$user_query->bindparam(":USER_ID",$user_id);
		$user_query->execute();
		$user_out = $user_query->fetchAll(PDO::FETCH_ASSOC);


		foreach($user_out as $uo){
			$author_name = $uo['author'];
			$book_title = $uo['book_title'];
			//removeUpdateUserToCome($author_name, $book_title, $user_id);
		}


		// //gets all the content from the tocome table
		// $query = $db->prepare('SELECT * FROM user_tocome WHERE user_id=:USER_ID');
		// $query->bindparam(":USER_ID",$user_id);
		// $query->execute();
		// $out = $query->fetchAll(PDO::FETCH_ASSOC);
		// //loop through each element from the tocomet able
		// foreach ($out as $outs) {
		// 	$datum = $outs['released'];
		// 	//gets the date of the selected book.
		// 	$bookDate = date("d-m-Y", strtotime($datum));
		// 	$today = date("d-m-Y");

		// 	//gets the name of the author
		// 	$author_name = $outs['author'];
		// 	//gets the title of the book
		// 	$book_title = $outs['book_title'];

		// 	$today = strtotime($today);
		// 	$bookDate = strtotime($bookDate);			

		// 	//checks if today is equal or smaller then the bookdate 
		// 	if($today >= $bookDate){
		// 		// echo $today;
		// 		// echo '<br />';
		// 		// echo $bookDate;
		// 		//if its smaller remove and update the selected book
		// 		//removeUpdateToCome($author_name, $book_title);
		// 		//removeUpdateUserToCome($author_name, $book_title);
		// 		// echo $author_name;
		// 		// echo '<br />';
		// 		// echo $book_title;
		// 		// echo '<br />';
		// 		// echo $user_id;
		// 		// echo '<br />';
		// 		// echo $datum;
		// 		//insertReleased($author_name, $book_title, $user_id, $datum);
		// 	} else {
		// 		//echo 'hoi';
		// 	}
		// /}
	}
	?>	

		<section id="feature-area" class="about-section">
			<div class="container">
				<div class="Mtop row text-center inner">
					<div style="width:50%" class="bookButton col-sm-4">
						<div style="background: white;" class="feature-content">
							<h2>To be released</h2>
							<table align="center" id="informationTable" style="width:100%">
								<tr>
									<th><b>Name</th>
									<th><b>Title</th>
									<th><b>Release date</th>
								</tr>
								
								<?php
									for($i = 0; $i < count($out); $i++){
								?> 		
								<?php
								$datum = $out[$i]['released'];
								$bookDate = date("d-m-Y", strtotime($datum));
								?>
										<!-- echo's the content of the tocome table -->
										<tr id= "<?php echo 'row'.$i ?>" class="rows">
										<td><?php echo $out[$i]['author'].'&nbsp&nbsp'; ?></td>
										<td><?php echo $out[$i]['book_title'].'&nbsp&nbsp';?></td>
										<td><?php echo $bookDate;?></td>
									</tr>
								<?php
								}
								?>
							</table>	 					
						</div>
					</div>
					<div style="width:50%" class="bookButton col-sm-4">
						<div style="background: white;" class="feature-content">
							<h2>Already released</h2>
							<table align="center" id="informationTable" style="width:100%">
								<tr>
									<th><b>Name</th>
									<th><b>Title</th>
									<th><b>Released</th>
								</tr>
								
								<?php
									for($i = 0; $i < count($user_out); $i++){
								?> 		
								<?php
								$datum = $user_out[$i]['released'];
								$bookDate = date("d-m-Y", strtotime($datum));
								$book_title = $user_out[$i]['book_title'];
								$author_name = $user_out[$i]['author'];

								if($_GET['list'] == 'personal'){
									$remove = '<a href="toComeList.php?remove=remove&author='.$author_name.'&title='.$book_title.'"><img style="width:4%"src="./assets/images/remove.png"></img></a>';
									$width = 'style="width: 4%;margin-left: 5%;"';
								} else {
									$remove = '';
									$width = 'style="width: 8%;margin-left: 5%;"';
								}
								//echo $user_out[$i]['author'];
								?>
										<!-- echo's the content of the tocome table -->
										<tr id= "<?php echo 'row'.$i ?>" class="rows">
										<td><?php echo $user_out[$i]['author'].'&nbsp&nbsp'; ?></td>
										<td><?php echo $user_out[$i]['book_title'].'&nbsp&nbsp';?></td>
										<td><?php echo $bookDate;?><a href="upload.php?title=<?php echo $book_title ?>&author=<?php echo $author_name ?>" class="Link add'">
											<img <?php echo $width ?> src="./assets/images/add.png"></img></a><?php echo $remove ?>
							</td></td>

									</tr>
								<?php
								}
								?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</section>

<?php
	if(!empty($_GET['remove'])){
		if($_GET['remove'] == 'remove') {
			$author_name = $_GET['author'];
			$book_title = $_GET['title'];
			echo $author_name;
			removeUpdateUserToCome($author_name, $book_title, $user_id);
		}
	}
?>


<?php include('footer.php') ?>