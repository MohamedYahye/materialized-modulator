<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<LINK href="css/box.css" rel="stylesheet" type="text/css">
<?php
include 'database.php';
error_reporting(0);

$f_name = $_POST['firstname'];
$l_name = $_POST['lastname'];
$email  = $_POST['email'];
$bedrijf= $_POST['b_name'];
$first  = $_POST['group1'];
$second = $_POST['group2'];
$third  = $_POST['group3'];
$fourth  = $_POST['group4'];

// Required field names
$required = array('firstname', 'lastname', 'email');
// $required = array('group1', 'group2' ,'group3','group4');

// Loop over field names, make sure each one exists and is not empty
$error = false;
$submit= false;
foreach($required as $field) {
  if (empty($_POST[$field])) {
    $error = true;
  }
}
if(empty($_POST['b_name'])){
	$bedrijf = 'n.v.t';
} else {
	$bedrijf = $_POST['b_name'];
}
?>

<div class="box15">
       <h1 class="title">Verstuur inschrijving</h1>   
       <img src="css/logo.png">
        <p>


<?php
if ($error) {
  echo "<h1>Alle velden moeten ingevuld worden.</h1><h2> <br /><a href='../index.php'>Opnieuw invullen</a></h2>";
} else {
	?>	
		<h1 class="title">De informatie die u heeft ingevuld is:</h1> <br />

		<div id="Textbox" style="    width: 88%;
    margin: 0 auto;"> 
		<b style="float: left;">Naam:</b><span style="margin-left:24.5%;float:left;"><?php echo $f_name;?></span><br />
		<b style="float: left;">email:</b><span style="margin-left:25%;float:left;"><?php echo $email;?></span><br />
		<b style="float: left;">bedrijf:</b><span style="margin-left:23%;float:left;"><?php echo $bedrijf;?></span><br />
		<br />
		<b style="float: left;">Eerste workshop:</b><span style="margin-left:5%;float:left;"><?php  echo preg_replace('/[0-9]+/', '', $first);?></span><br />
		<b style="float: left;">Tweede workshop:</b><span style="margin-left:3%;float:left;"><?php echo preg_replace('/[0-9]+/', '', $second);?></span><br />
		<b style="float: left;">Derde workshop:</b><span style="margin-left:6%;float:left;"><?php echo preg_replace('/[0-9]+/', '', $third);?></span><br />
		<b style="float: left;">Vierde workshop:</b><span style="margin-left:5%;float:left;"><?php echo preg_replace('/[0-9]+/', '', $fourth);?></span><br />

		</div>


		<table style="display:none;">
		  <tr>
		 	<th>Eerste workshop</th>
		    <th>Tweede workshop</th>
		    <th>Derde workshop</th>
		    <th>Vierde workshop</th>
		  </tr>

		  <tr>
		  	<td><?php echo preg_replace('/[0-9]+/', '', $first);?></td>
		  	<td><?php echo preg_replace('/[0-9]+/', '', $second); ?></td>
		  	<td><?php echo preg_replace('/[0-9]+/', '', $third); ?></td>
		  	<td><?php echo preg_replace('/[0-9]+/', '', $fourth); ?></td>
		  </tr>
		</table>
		<h3 class="title">Klopt dit?</h3>
		<br />
		<div id="standard_buttons">
		<button class="button button1" type="button" onclick="send(true, '<?php echo $f_name ?>','<?php echo $l_name ?>','<?php echo $email ?>','<?php echo $bedrijf ?>','<?php echo $first ?>', '<?php echo $second ?>', '<?php echo $third ?>', '<?php echo $fourth ?>')">
		     Ja
		</button> 
<button class="button button1" type="button" onclick="send(false)">
     nee
</button>
</div>
<div id="home_button" style="display:none;">
	<button class="button button1" type="button" onclick="window.location.replace('../index.php')">
	     Home
	</button> 
</div>
       </p>
    
       <br />
       <div class="box15_ribbon"></div>
</div>
	<?php

}
// $first  = $_POST['group1'];
// $second = $_POST['group2'];
// $third  = $_POST['group3'];
// $fourth  = $_POST['group4'];

?>
<form style="display:none" id="hiddenForm" action="../index.php" method="POST">

<input type="text"  value="<?php echo $f_name ?>" name="firstname">
<input type="text"  value="<?php echo $l_name ?>" name="lastname">
<input type="email" value="<?php echo $email  ?>" name="email">
<input type="text"  value="<?php echo $bedrijf?>" name="b_name">

<input name="group1" value="<?php echo $first ?>">
<input name="group2" value="<?php echo $second ?>">
<input name="group3" value="<?php echo $third ?>">
<input name="group4" value="<?php echo $fourth ?>">

</form>


<script type="text/javascript">
    function send(submit){
    	// $('.button').attr('disabled', true);
        //Get all arguments passed except the first variable, the submit boolean
        var listOfVariablesToPost = Array.prototype.slice.call(arguments,1); 
        if(submit){
            // console.log(listOfVariablesToPost);
            // console.log(listOfVariablesToPost[1]);

            var f_name = listOfVariablesToPost[0];
            var l_name = listOfVariablesToPost[1];
            var email  = listOfVariablesToPost[2];
            var bedrijf= listOfVariablesToPost[3];
            var first  = listOfVariablesToPost[4];
            var second = listOfVariablesToPost[5];
            var third  = listOfVariablesToPost[6];
            var fourth  = listOfVariablesToPost[7];
            var name = f_name + ' ' + l_name;


            $.ajax({
            	method: "POST",
            	url: 'send_confirm.php',
            	data: {
            		f_name: f_name, 
            		l_name: l_name,
            		email: email,
            		bedrijf: bedrijf,
            		first: first,
            		second: second,
            		third: third,
            		fourth: fourth
            	},
            	success: function(res) {
            		console.log(res);
            		$.ajax({
            			method: "POST",
            			url: 'send_mail.php',
            			data :{
            				name: name,
            				email: email,
            				bedrijf:bedrijf,
            				first: first,
            				second: second,
            				third: third,
            				fourth: fourth
            			},
            			success: function(res){
            				$('#Textbox').html('U heeft zich succesvol ingeschreven.<br /> <br />Tot dan!');
            				$('#Textbox').css('font-size', '23px');
            				$('#home_button').show();
            				$('#standard_buttons').hide();
            				$('.title').html('');
            				// $('#buttons').html('<button class="button button1" type="button">Terug</button>')
            				// <input name="date" id="datepicker" onchange="window.location.href = 'test.php?Date=' + this.value;">

            			}
            		});

            	}
            });

            /* Do POST here either by using XMLHttpRequest or jQuery AJAX/POST (Or any other way you like)*/
            /* XMLHttpRequest: http://stackoverflow.com/questions/9713058/sending-post-data-with-a-xmlhttprequest */
            /* jQuery POST https://api.jquery.com/jquery.post/ */
        }else{
            
        	console.log('failed');
            
            document.getElementById('hiddenForm').submit(); // SUBMIT FORM
        	// window.location.replace('../index.php');
            /* Don't post and do whatever you need to do otherwise */
        }
    }
</script>
