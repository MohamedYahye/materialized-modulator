<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<?php
$firstname = isset($_POST['firstname']) ? $_POST['firstname'] : null;
$lastname = isset($_POST['lastname']) ? $_POST['lastname'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$company = isset($_POST['b_name']) ? $_POST['b_name'] : null;

$first  = isset($_POST['group1']) ? $_POST['group1'] : null;
$second = isset($_POST['group2']) ? $_POST['group2'] : null;
$third  = isset($_POST['group3']) ? $_POST['group3'] : null;
$fourth  = isset($_POST['group4']) ? $_POST['group4'] : null;

?>
<!DOCTYPE html>
<html>
<head>
	<title>Signup</title>
	<LINK href="includes/css/style_test.css" rel="stylesheet" type="text/css">
</head>
<body>
<form style="overflow:hidden;" action="includes/send.php" method="post" id="sendForm" />

<h1 style="margin: 30 10 30 10;">Opgeven workshops</h1>
<hr style="margin-bottom:5%;">
<fieldset id="leftFS">
  <legend><span class="number">1</span>Basis gegevens</legend>
  <label for="name">Voornaam: <span class="red-dot">*</span><span style="float:right;" class="left" ></span></label>
  <input type="text"  placeholder="Voornaam" autocomplete="off" id="name" name="firstname" value="<?php echo $firstname; ?>">
  
  <label for="name">Achternaam: <span class="red-dot">*</span><span style="float:right;" class="left" ></span></label>
  <input type="text"  placeholder="Achternaam" autocomplete="off" id="name" name="lastname" value="<?php echo $lastname; ?>">

  <label for="mail">Email: <span class="red-dot">*</span><span style="float:right;" class="left" ></span></label>
  <input type="email" placeholder="Email" autocomplete="off"  id="mail" name="email" value="<?php echo $email; ?>">
  
  <label for="password">Bedrijfsnaam:<span style="float:right;" class="left" ></span></label>
  <input type="text" placeholder="Bedrijfsnaam" autocomplete="off" name="b_name" value="<?php echo $company; ?>">
  <br />
  De vragen met een <span class="red-dot">*</span> zijn verplicht
 </fieldset>
 <fieldset id="rightFS">
   <legend><span class="number">2</span>Workshops<span id="sideText">Keuze niet verplicht</span></legend>

   <label for="bio"><h4>1e Workshop:<span style="float:right;" class="left" ></span></h4></label>
<!--    <label class="choice" data-id="1"><input type="radio" name="group1" value="een">een<span class="left"></span></label>
 -->   

   <label class="choice" data-id="1"><input type="checkbox" name="group1" value="use your apple1">use your apple<span class="left" ></span></label>
   <label class="choice" data-id="1"><input type="checkbox" name="group1" value="Zo maak je van onbekenden klanten1">Zo maak je van onbekenden klanten<span class="left" ></span></label>
   <label class="choice" data-id="1"><input type="checkbox" name="group1" value="Multi media feest">Multi media feest<span class="left" ></span></label>
   <br>
   <label for="bio"><h4>2e Workshop:<span style="float:right;" class="left" ></span></h4></label>
     <label class="choice" data-id="2"><input type="checkbox" name="group2" value="use your apple2">use your apple<span class="left"></span></label>
     <label class="choice" data-id="2"><input type="checkbox" name="group2" value="Snelheid is geld2">Snelheid is geld<span class="left"></span></label>
     <label class="choice" data-id="2"><input type="checkbox" name="group2" value="Maak je eigen marketingkalender">Maak je eigen marketingkalender<span class="left""></span></label>
   <!--   <label class="choice" data-id="4"><input type="radio" name="group2" value="sd">vier</label>
    -->  <br>
    <label for="bio"><h4>3e Workshop:<span style="float:right;" class="left" ></span></h4></label>
    <label class="choice" data-id="3"><input type="checkbox" name="group3" value="Lable">Lable<span class="left"></span></label>
    <label class="choice" data-id="3"><input type="checkbox" name="group3" value="use your apple3">use your apple<span class="left"></span></label>
    <label class="choice" data-id="3"><input type="checkbox" name="group3" value="Zo maak je van onbekenden klanten">Zo maak je van onbekenden klanten<span class="left"  klanten"></span></label>
    <label class="choice" data-id="3"><input type="checkbox" name="group3" value="Maak je eigen contentkalender">Maak je eigen contentkalender<span class="left"></span></label>
    
<!--   <label class="choice" data-id="4"><input type="checkbox" name="group2" value="sd">vier</label>
 -->  <br>
 	<label for="bio"><h4>4e Workshop:<span style="float:right;" class="left" ></span></h4></label>
 	<label class="choice" data-id="4"><input type="checkbox" name="group4" value="Pretwerk OPTIE!">Pretwerk OPTIE!<span class="left"></span></label>
 	<label class="choice" data-id="4"><input type="checkbox" name="group4" value="use your apple4">use your apple<span class="left"></span></label>
 	<label class="choice" data-id="4"><input type="checkbox" name="group4" value="Snelheid is geld4">Snelheid is geld<span class="left"></span></label>
 	<label class="choice" data-id="4"><input type="checkbox" name="group4" value="Fotograferen met je iPhone">Fotograferen met je iPhone<span class="left"></span></label>
 	<br />

 </fieldset>
 <div id="submitButton" style="">
 <button type="submit" id="submitButtonText">Verstuur</button>
 </div>
</form>


<script>
var funcs = [];

$(document).ready(function(){
	var first = "<?php echo $first ?>";
	var second = "<?php echo $second ?>";
	var third = "<?php echo $third ?>";
	var fourth = "<?php echo $fourth ?>";
	// $("input[name=" + name + "]").hide();

	// $("[name$=group1][value=" + first + "]").prop("checked", "true");
	$("[name$=group1][value='" + first + "']").prop("checked", "true");
	$("[name$=group2][value='" + second + "']").prop("checked", "true");
	$("[name$=group3][value='" + third + "']").prop("checked", "true");
	$("[name$=group4][value='" + fourth + "']").prop("checked", "true");

	// the selector will match all input controls of type :checkbox
	// and attach a click event handler 
	$("input:checkbox").on('click', function() {
	  // in the handler, 'this' refers to the box clicked on
	  var $box = $(this);
	  if ($box.is(":checked")) {
	    // the name of the box is retrieved using the .attr() method
	    // as it is assumed and expected to be immutable
	    var group = "input:checkbox[name='" + $box.attr("name") + "']";
	    // the checked state of the group/box on the other hand will change
	    // and the current value is retrieved using .prop() method
	    $(group).parent().css("font-weight" , "");
	    $(group).prop("checked", false);
	    $($box).parent().css("font-weight" , "bold");
	    $box.prop("checked", true);
	  } else {
	  	console.log(this + "False");
	  	$($box).parent().css("font-weight" , "");
	    $box.prop("checked", false);
	  }
	});

	for (var i = $('.choice').length - 1; i >= 0; i--) {
		(function(i){
		var element = $('.choice')[i];
		var choiceID = $(element).data('id');
		var value = $(element).find('input').val();
		$.ajax({
			method: "POST",
			url: 'api.php',
			data: {
				choiceID: choiceID, 
				value: value
			},
			success: function(res) {
				if(JSON.parse(res).count > 39){
					var numberThing = 50 - JSON.parse(res).count;
					$(element).find("span")[0].innerHTML = numberThing + ' plekken vrij';
				}
				if(value == JSON.parse(res).value) {

					if(JSON.parse(res).count >= 50){
						$(element).on('click', false);
						$(element).addClass('full');
					}
				} 
			}
		});
	})(i)
	

	}
});
</script>


</body>
</html>