

<?php 
	
	require_once("menu.php");
	require_once("../model/getGroup.php");

	$memeberOb = new GetGroup();

	$decoded = "";
?>


<!DOCTYPE html>
<html>
<head>
	<title>Edit groep</title>
	<link rel="stylesheet" type="text/css" href="../controller/assets/css/edit_groep.css">
	<link rel="stylesheet" type="text/css" href="../controller/assets/css/materialize.css">
	<script type="text/javascript" src="../controller/assets/js/jquery.js"></script>
	<script type="text/javascript" src="../controller/assets/js/materialize.js"></script>
</head>
<body>


	<div class="wrapper">
		<?php 

			if(isset($_GET['group'])){
				if(!empty($_GET['group'])){
					$decoded = base64_decode($_GET['group']);

					echo "<h3 id='groep-naam'>Groep: ".$decoded."</h3><form class='change-name'><label for='name'>Kies een nieuwe groepnaam</label><input id='new-group-name'type='text' placeholder='$decoded'><button type='submit' class='btn'>Vernader groepnaam</button></form><div class='delete-group'><button data-target='modal1' class='btn red darken-4 delete'>Verwijder Groep</button></div>";

					echo "<h5>Leden van deze groep</h5>";


					

					$memeberOb->getGroupMemebers($decoded);

					//var_export($memebers);
				}
			}else{
				die();
			}


		?>


		<div class="new-members">
			
			<?php
				$memeberOb->getNewMembers($decoded);
			?>

		</div>

	

			


	</div>
	 <div id="modal1" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4>Warning</h4>
      <p>Weet je zeker je de groep: <span class='delete_span'><?php echo "'" . $decoded . "'";?></span> Wilt verwijderen?</p>
      <p>Als je de groep verwijdert dan wordt de groep ook uit modules weggehaald en kunnen bepaalde gebruikers de module niet meer gebruiken</p>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat yes">Ja</a>
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Nee</a>
    </div>
  </div>

</body>

<script type="text/javascript">
	
	$(document).ready(function(){
		$(".members").on("click", function(){
			var member = $(this).text();
			var groupname = $("#groep-naam").text();

			var afterComma = groupname.substr(groupname.indexOf(":") + 1);


			//console.log(afterComma);

			var response;

			$.ajax({
	           type: "POST",
	           url: "../model/getGroup.php",
	           data: {
	           	groepnaam: afterComma,
	           	member: member,
	           	remove: "remove"
	           
	           },
	           dataType: "html",
	           success: function(response){

	           	response = JSON.parse(response);

	           	if(response.removed){
	           		location.reload();
	           	}
	        

	           },
	           error: function(response){
	             console.log("Error:" + response);
	           }
	        });
		})


		$(".new_members").on("click", function(){
			var member = $(this).text();
			var groupname = $("#groep-naam").text();

			var afterComma = groupname.substr(groupname.indexOf(":") + 1);


			//console.log(afterComma);

			var response;

			$.ajax({
	           type: "POST",
	           url: "../model/getGroup.php",
	           data: {
	           	groepnaam: afterComma,
	           	member: member,
	           	add: "add"
	           
	           },
	           dataType: "html",
	           success: function(response){

	           	response = JSON.parse(response);

	           	if(response.added){
	           		location.reload();
	           	}
	        

	           },
	           error: function(response){
	             console.log("Error:" + response);
	           }
	        });
		})


		$(".change-name").submit(function(e){
			e.preventDefault();
			var groupname = $("#groep-naam").text();

			var afterComma = groupname.substr(groupname.indexOf(":") + 1);


			var proceed = true;

			var new_group_name = $("#new-group-name").val();

			if(new_group_name.length > 0){
				$("new-group-name").removeClass("invalid");
				proceed = true;
			}else{
				$("#new-group-name").addClass("invalid");
				 Materialize.toast('nieuwe groepnaam kan niet leeg zijn', 4000)
				proceed = false;
			}


			if(proceed){
				$.ajax({
		           type: "POST",
		           url: "../model/getGroup.php",
		           data: {
		           	groepnaam: afterComma,
		           	new_group_name:new_group_name,
		           	new_group:false
		           
		           },
		           dataType: "html",
		           success: function(response){

		           	response = JSON.parse(response);

		           

		           	if(response.updated){

		           		//$("#groep-naam").text("Groep: " + response.new_name);

		           		window.location.replace("edit_group.php?group="+response.new_name);
		           	}

		           	if(response.name == false){
		           		 Materialize.toast('groepnaam is in gebruik', 4000);
		           		 $("#new-group-name").addClass("invalid");
		           	}




		           	console.log(response);
		        

		           },
		           error: function(response){
		             console.log("Error:" + response);
		           }
		        });
			}

		})

		$(".delete").on("click", function(){
			
			$('.modal').modal({
		      dismissible: true, // Modal can be dismissed by clicking outside of the modal
		      opacity: .5, // Opacity of modal background
		      inDuration: 300, // Transition in duration
		      outDuration: 200, // Transition out duration
		      startingTop: '4%', // Starting top style attribute
		      endingTop: '10%', // Ending top style attribute
		      ready: function(modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.
		       // console.log(modal);
		      },
		      complete: function() {  } // Callback for Modal close
		    }
		  );
			
		})

		$(".yes").on("click", function(){


			var groupname = $("#groep-naam").text();

			var afterComma = groupname.substr(groupname.indexOf(":") + 1);

			$.ajax({
	           type: "POST",
	           url: "../model/getGroup.php",
	           data: {
	           	delete_group: "true",
	           	groepnaam: afterComma
	           
	           },
	           dataType: "html",
	           success: function(response){

	           //	var parse = JSON.parse(response);

	           //	if(parse.groep_deleted){
	           		//location.replace("groepen.php");
	          // 	}else{
	           	location.replace("groepen.php");
	           //	}
	        	//console.log(response);

	           },
	           error: function(response){
	             console.log("Error:" + response);
	           }
	        });
		})
	})

</script>

</html>