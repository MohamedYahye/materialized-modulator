<?php 
	
	require_once("menu.php");


	if(!empty(isset($_GET['message']))){

		$decode = base64_decode($_GET['message']);

		echo "<script type='text/javascript'>
			$(document).ready(function(){
				Materialize.toast('".$decode."', 4000)
			})

		</script>";
	}


?>



<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../controller/assets/css/groepen.css">
	<link rel="stylesheet" type="text/css" href="../controller/assets/css/materialize.css">
	<script type="text/javascript" src="../controller/assets/js/jquery.js"></script>
	<script type="text/javascript" src="../controller/assets/js/materialize.js"></script>
	<title>Groepen</title>
</head>
<body>
	<div class="groep-maken">
		<h4>Groepen maken</h4>
		<form name="groepmaken" class="groepmaken" method="post" action="../model/newgroep.php">
			
			<label for="groupname">Kies een groepnaam:</label>
			<input type="text" name="groepnaam" id="group_input" placeholder="Groep naam">
			<label for="groep-leden">Kies minstens 1 lid:</label><br /><br />
			<?php 

				require_once("../model/getstudents.php");

				$studentObj = new getstudents();	

				$students = $studentObj->getStudents();


				if(!empty($students)){
					foreach($students as $student){

						echo "<input type='checkbox' name='box[]'class='filled-in' value=".$student['name']." id='filled-in-box ".$student['name']."' />
     						 <label for='filled-in-box ".$student['name']."'>".$student['name']."</label><br />";
					}
				}else{
					echo "oeps.... something went wrong! please reload the page";
				}

				



			?>
			<br /><br /><button class="btn" type="submit" name="action">groep maken </button>
		</form>


	</div>
	<ul class="groups collection with-header">
	 <li class="collection-header"><h6>Klik op een groep om aan te passen</h6></li>
		<?php 


			require_once("../model/getGroup.php");

			$groupOb = new GetGroup();

			$groups = $groupOb->GetGroup();

			if(!empty($groups)){
				foreach($groups as $group){
					echo "<a href='../view/edit_group.php?group=".base64_encode($group['groep_naam'])."' class='collection-item'>".$group['groep_naam']."</a>";
				}
			}else{
				echo "<h5>Er zijn geen groepen om weer te geven</h5>";
			}


		?>

	</ul>
</body>

	
	<script type="text/javascript">

	$(document).ready(function(){


		console.log($(".collection > a").length);

		$(".groepmaken").submit(function(e){
			

			var proceed = false;

			var groepnaam = $("#group_input").val();

			var studentNamearray = new Array();

			$("input[type='checkbox']:checked").each(function() {

			   var a= $(this).next().text();
			   studentNamearray.push({lid: a});

			});

			//console.log(studentNamearray);



			if(groepnaam.length > 0){
				proceed = true;
			}else{
				proceed = false;
				Materialize.toast('groepnaam kan niet leeg zijn', 4000)
			}

			// if(studentNamearray.length > 0){
			// 	proceed = true;
			// }else{
			// 	Materialize.toast('Groep moet minstens 1 lid hebben', 4000)
			// 	proceed = false;
			// }

			if(proceed){

			}else{
				console.log("not ajax");
				e.preventDefault();
			}
		


		
		})
	})




	</script>


</html>