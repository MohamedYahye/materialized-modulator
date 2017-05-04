<?php 
	require_once("menu.php");

	require_once("../model/tools/connect.php");

	
?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../controller/css/index.css">
	<link rel="stylesheet" type="text/css" href="../controller/css/materialize.css">
	<script type="text/javascript" src="../controller/js/jquery.js"></script>
	<script type="text/javascript" src="../controller/js/materialize.js"></script>
</head>
<body>
	<div class="wrapper">
		
		<?php

			$proceed = true;

			if(isset($_SESSION)) {

				$connect = new connect();

				$dbh = $connect->returnConnection();

				$stmt = $dbh->prepare("SELECT student_id FROM student WHERE username=:username");

				$stmt->bindParam(":username", $_SESSION['username']);

				$stmt->execute();

				if($stmt->rowCount() > 0){
					$result = $stmt->fetch(PDO::FETCH_ASSOC);


					$stmt = $dbh->prepare("SELECT groep_id FROM koppeltabel WHERE student_id=:student_id");

					$stmt->bindParam("student_id", $result['student_id']);

					$stmt->execute();

					if($stmt->rowCount() > 0){
						$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

						echo "<div class='collection modules'>";


						foreach($result as $groep_id){
							$stmt = $dbh->prepare("SELECT module_id FROM module_koppel WHERE groep_id=:groep_id");
							$stmt->bindParam(":groep_id", $groep_id['groep_id']);

							$stmt->execute();

							if($stmt->rowCount() > 0){
								$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

								$stmt = $dbh->prepare("SELECT DISTINCT module_locatie FROM module WHERE module_id=:module_id AND module_status!=0");

								foreach($result as $res){
									$stmt->bindParam(":module_id", $res['module_id']);
									$stmt->execute();

									if($stmt->rowCount() > 0){
										$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

										

										foreach($result as $res){
											
											echo "<a href='#!' class='collection-item'>".$res['module_locatie']."</a>";

										}
										
									}else{
										//echo "<span>module is uitgeschakeld</span>";
									}
								}

							}else{
								$proceed = false;
								//echo "groep mag nog geen module gebruiken";
							}
						}

					}else{
						echo "student hoort niet bij een groep";
					}
					echo "<div>";
				}

			}else{
				echo "<h5>Er lijkt hier helemaal niet te zijn</h5>";
			}


			if(!$proceed){
				//echo "<h5>Er lijkt hier helemaal niet te zijn</h5>";
			}
		?>

	</div>
</body>

<script type="text/javascript">
	
	$(document).ready(function(){
		
		$(".collection-item").on("click", function(){
			$(this).addClass("active").siblings().removeClass("active");
			iframeLoaded();
			if($(".frame").length){
				$(".frame").attr("src", "../modules/"+$(this).text());
			}else{
				$(".wrapper").append("<iframe id='iFrameID' class='frame'src=../modules/"+$(this).text()+"></iframe>");
			}
		     
		})

		function iframeLoaded() {
		      var iFrameID = document.getElementById('iFrameID');
		      if(iFrameID) {
		            // here you can make the height, I delete it first, then I make it again
		            //iFrameID.height = "";
		            iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + "px";
		      }   
		  }
		
	})

</script>
</html>