<LINK href="test/css/loginCss.css" rel="stylesheet" type="text/css">

<link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css'>

<?php
require 'PHPMailer/class.phpmailer.php';
require 'PHPMailer/class.pop3.php';
require 'PHPMailer/class.smtp.php';

if(isset($_GET['sendmail'])){
	$aV = $_POST['aValue'];  	// naam    -> blue
	$aP = $_POST['aPercent'];	// procent -> 24

	$bV = $_POST['bValue'];
	$bP = $_POST['bPercent'];

	$cV = $_POST['cValue'];
	$cP = $_POST['cPercent'];

	$dV = $_POST['dValue'];
	$dP = $_POST['dPercent'];

	$eV = $_POST['eValue'];
	$eP = $_POST['ePercent'];

	$fV = $_POST['fValue'];
	$fP = $_POST['fPercent'];

	//filled in email & name of the person who it needs to be send to.
	$email = $_POST['email'];
	$naam = $_POST['naam'];
	//the results from the quiz
	$values = array(
		$aV=>$aP, 
		$bV=>$bP, 
		$cV=>$cP, 
		$dV=>$dP,
		$eV=>$eP,
		$fV=>$fP
	);
	//sorts the results from high to low.
	arsort($values);

	$names  = array_keys($values);
	$values = array_values($values);

	$mail = new PHPMailer;

	// $mail->Password = 'kweek123';
	// $mail->Host = 'smtp.gmail.com';
	// $mail->SMTPAuth = true;
	// $mail->Username = 'testerkweek@gmail.com';
	// $mail->SMTPSecure = 'tls';
	// $mail->Port = 587;

	// $mail->SMTPOptions = array(
	//     'ssl' => array(
	//         'verify_peer' => false,
	//         'verify_peer_name' => false,
	//         'allow_self_signed' => true
	//     )
	// );

	$mail->isSMTP();
	$mail->Host = localhost;

	$mail->setFrom('e.gielink@kweekvijvernoord.nl', 'Kweek2'); //sent from
	// $mail->addAddress('e.gielink@kweekvijvernoord.nl', 'Elon Gielink'); //sent to
	$mail->addAddress($email, $naam); //sent to

	$mail->isHTML(true);

	$mail->Subject = 'Score resultaat!';
	//the email
	$mail->Body = '
	<body style="margin:0; padding: 0;">
	<table align="center" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc;border-radius:20px;">
			<tr>
			<td align="center" style="background-color: rgb(42, 169, 72);padding: 40px 0 30px 0;border-top-left-radius: 20px;border-top-right-radius: 20px;border-bottom: thick solid #f68121;">
			<a href="http://www.snoekgroep.nl/">
			<img src="http://tuintest.kweekvijvernoord.nl/img/SnoekWit.png" alt="Snoek Hoveniers" width="auto" height="50" style="display: block;" />
			</a>
				</td>
			</tr>
			<tr>
				<td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					 <tr>
					 <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
					  <b>Resultaat Tuintest Snoek</b>
					 </td>					 
					 </tr>
					 <tr>

					  <td style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;padding: 20px 0 30px 0;">
					   De resultaten op volgorde van score. Voor meer informatie over de score klik op de link in het resultaat vlak!
					  </td>
					 </tr>
					 <tr>

					  <td>
					   <table border="0" cellpadding="0" cellspacing="0" width="100%">
					    <tr>
					     <td width="260" valign="top">
					      <table border="0" cellpadding="5" cellspacing="0" width="100%" style="    border: 3px solid #2aa948;;padding: 10px;border-radius:15px;">
					       <tr>
					        <td>
					         <img src="http://tuintest.kweekvijvernoord.nl/imgs/'.$names[0].'.jpg" alt="" width="100%" height="140" style="display: block;border-radius:20px;border: 3px solid #2aa948;" />
					        </td>
					       </tr>
					       <tr>
					       <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
					        <b>'.$names[0].'</b>
					       </td>					 
					       </tr>
					       <tr>
					        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;padding: 25px 0 0 0;">
					         <a href="http://www.snoekgroep.nl/'.$names[0].'">meer informatie over het resultaat <b> '.$names[0].'</b></a>
					        </td>
					       </tr>
					       <div class="myProgress" 
					       	style="border: 2px solid #2aa948;
					       		   border-radius:25px;
					       		   position:absolute;
					       		   width:95%;
					       		   height:30px;
					       		   background-color:#E0F8F7;
					       		   margin-bottom: 2%;
					       		   margin-top: 2%;
					       		   margin-left: auto;
					       		   margin-right: auto;
					       	">
					       	<div id="result'.$names[0].'" class="resultBar" 
					       		style="border-radius:25px;
					       			   position:absolute;
					       			   width:'.$values[0].'%;
					       			   height:100%;
					       			   background-color:#2aa948;" >
					       		<div class="label" 
					       			style="text-align:center;
					       				   line-height:30px;
					       				   color:white;">
					       			'.$values[0].'%
					       		</div>
					       	</div>
					       </div>

					      </table>
					     </td>

					     <td style="font-size: 0; line-height: 0;" width="20">
					      &nbsp;
					     </td>

					     <td width="260" valign="top">
					      <table border="0" cellpadding="5" cellspacing="0" width="100%" style="    border: 3px solid #2aa948;;padding: 10px;border-radius:15px;">
					       <tr>
					        <td>
					         <img src="http://tuintest.kweekvijvernoord.nl/imgs/'.$names[1].'.jpg" alt="" width="100%" height="140" style="display: block;border-radius:20px;border: 3px solid #2aa948;" />
					        </td>
					       </tr>
					       <tr>
					       <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
					        <b>'.$names[1].'</b>
					       </td>					 
					       </tr>
					       <tr>
					        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;padding: 25px 0 0 0;">
					        <a href="http://www.snoekgroep.nl/'.$names[1].'">meer informatie over het resultaat <b> '.$names[1].'</b></a>
					        </td>
					       </tr>
					       <div class="myProgress" 
					       	style="border: 2px solid #2aa948;
					       		   border-radius:25px;
					       		   position:absolute;
					       		   width:95%;
					       		   height:30px;
					       		   background-color:#E0F8F7;
					       		   margin-bottom: 2%;
					       		   margin-top: 2%;
					       		   margin-left: auto;
					       		   margin-right: auto;
					       	">
					       	<div id="result'.$names[1].'" class="resultBar" 
					       		style="border-radius:25px;
					       			   position:absolute;
					       			   width:'.$values[1].'%;
					       			   height:100%;
					       			   background-color:#2aa948;" >
					       		<div class="label" 
					       			style="text-align:center;
					       				   line-height:30px;
					       				   color:white;">
					       			'.$values[1].'%
					       		</div>
					       	</div>
					       </div>

					      </table>
					     </td>
					    </tr>
					   </table>
					  </td>
					 </tr>
					</table>
				</td>
			</tr>

			<tr>
				<td bgcolor="#ffffff" style="padding: 0px 30px 40px 30px;">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					 <tr>

					  <td>
					   <table border="0" cellpadding="0" cellspacing="0" width="100%">
					    <tr>
					     <td width="260" valign="top">
					      <table border="0" cellpadding="5" cellspacing="0" width="100%" style="    border: 3px solid #2aa948;;padding: 10px;border-radius:15px;">
					       <tr>
					        <td>
					         <img src="http://tuintest.kweekvijvernoord.nl/imgs/'.$names[2].'.jpg" alt="" width="100%" height="140" style="display: block;border-radius:20px;border: 3px solid #2aa948;" />
					        </td>
					       </tr>
					       <tr>
					       <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
					        <b>'.$names[2].'</b>
					       </td>					 
					       </tr>
					       <tr>
					        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;padding: 25px 0 0 0;">
					         <a href="http://www.snoekgroep.nl/'.$names[2].'">meer informatie over het resultaat <b> '.$names[2].'</b></a>
					        </td>
					       </tr>
					       <div class="myProgress" 
					       	style="border: 2px solid #2aa948;
					       		   border-radius:25px;
					       		   position:absolute;
					       		   width:95%;
					       		   height:30px;
					       		   background-color:#E0F8F7;
					       		   margin-bottom: 2%;
					       		   margin-top: 2%;
					       		   margin-left: auto;
					       		   margin-right: auto;
					       	">
					       	<div id="result'.$names[2].'" class="resultBar" 
					       		style="border-radius:25px;
					       			   position:absolute;
					       			   width:'.$values[2].'%;
					       			   height:100%;
					       			   background-color:#2aa948;" >
					       		<div class="label" 
					       			style="text-align:center;
					       				   line-height:30px;
					       				   color:white;">
					       			'.$values[2].'%
					       		</div>
					       	</div>
					       </div>

					      </table>
					     </td>

					     <td style="font-size: 0; line-height: 0;" width="20">
					      &nbsp;
					     </td>

					     <td width="260" valign="top">
					      <table border="0" cellpadding="5" cellspacing="0" width="100%" style="    border: 3px solid #2aa948;;padding: 10px;border-radius:15px;">
					       <tr>
					        <td>
					         <img src="http://tuintest.kweekvijvernoord.nl/imgs/'.$names[3].'.jpg" alt="" width="100%" height="140" style="display: block;border-radius:20px;border: 3px solid #2aa948;" />
					        </td>
					       </tr>
					       <tr>
					       <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
					        <b>'.$names[3].'</b>
					       </td>					 
					       </tr>
					       <tr>
					        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;padding: 25px 0 0 0;">
					        <a href="http://www.snoekgroep.nl/'.$names[3].'">meer informatie over het resultaat <b> '.$names[3].'</b></a>
					        </td>
					       </tr>
					       <div class="myProgress" 
					       	style="border: 2px solid #2aa948;
					       		   border-radius:25px;
					       		   position:absolute;
					       		   width:95%;
					       		   height:30px;
					       		   background-color:#E0F8F7;
					       		   margin-bottom: 2%;
					       		   margin-top: 2%;
					       		   margin-left: auto;
					       		   margin-right: auto;
					       	">
					       	<div id="result'.$names[3].'" class="resultBar" 
					       		style="border-radius:25px;
					       			   position:absolute;
					       			   width:'.$values[3].'%;
					       			   height:100%;
					       			   background-color:#2aa948;" >
					       		<div class="label" 
					       			style="text-align:center;
					       				   line-height:30px;
					       				   color:white;">
					       			'.$values[3].'%
					       		</div>
					       	</div>
					       </div>

					      </table>
					     </td>
					    </tr>
					   </table>
					  </td>
					 </tr>
					</table>
				</td>
			</tr>

			<tr>
				<td bgcolor="#ffffff" style="padding: 0px 30px 40px 30px;">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					 <tr>

					  <td>
					   <table border="0" cellpadding="0" cellspacing="0" width="100%">
					    <tr>
					     <td width="260" valign="top">
					      <table border="0" cellpadding="5" cellspacing="0" width="100%" style="    border: 3px solid #2aa948;;padding: 10px;border-radius:15px;">
					       <tr>
					        <td>
					         <img src="http://tuintest.kweekvijvernoord.nl/imgs/'.$names[4].'.jpg" alt="" width="100%" height="140" style="display: block;border-radius:20px;border: 3px solid #2aa948;" />
					        </td>
					       </tr>
					       <tr>
					       <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
					        <b>'.$names[4].'</b>
					       </td>					 
					       </tr>
					       <tr>
					        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;padding: 25px 0 0 0;">
					         <a href="http://www.snoekgroep.nl/'.$names[4].'">meer informatie over het resultaat <b> '.$names[4].'</b></a>
					        </td>
					       </tr>
					       <div class="myProgress" 
					       	style="border: 2px solid #2aa948;
					       		   border-radius:25px;
					       		   position:absolute;
					       		   width:95%;
					       		   height:30px;
					       		   background-color:#E0F8F7;
					       		   margin-bottom: 2%;
					       		   margin-top: 2%;
					       		   margin-left: auto;
					       		   margin-right: auto;
					       	">
					       	<div id="result'.$names[4].'" class="resultBar" 
					       		style="border-radius:25px;
					       			   position:absolute;
					       			   width:'.$values[4].'%;
					       			   height:100%;
					       			   background-color:#2aa948;" >
					       		<div class="label" 
					       			style="text-align:center;
					       				   line-height:30px;
					       				   color:white;">
					       			'.$values[4].'%
					       		</div>
					       	</div>
					       </div>

					      </table>
					     </td>

					     <td style="font-size: 0; line-height: 0;" width="20">
					      &nbsp;
					     </td>

					     <td width="260" valign="top">
					      <table border="0" cellpadding="5" cellspacing="0" width="100%" style="    border: 3px solid #2aa948;;padding: 10px;border-radius:15px;">
					       <tr>
					        <td>
					         <img src="http://tuintest.kweekvijvernoord.nl/imgs/'.$names[5].'.jpg" alt="" width="100%" height="140" style="display: block;border-radius:20px;border: 3px solid #2aa948;" />
					        </td>
					       </tr>
					       <tr>
					       <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
					        <b>'.$names[5].'</b>
					       </td>					 
					       </tr>
					       <tr>
					        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;padding: 25px 0 0 0;">
					        <a href="http://www.snoekgroep.nl/'.$names[5].'">meer informatie over het resultaat <b> '.$names[5].'</b></a>
					        </td>
					       </tr>
					       <div class="myProgress" 
					       	style="border: 2px solid #2aa948;
					       		   border-radius:25px;
					       		   position:absolute;
					       		   width:95%;
					       		   height:30px;
					       		   background-color:#E0F8F7;
					       		   margin-bottom: 2%;
					       		   margin-top: 2%;
					       		   margin-left: auto;
					       		   margin-right: auto;
					       	">
					       	<div id="result'.$names[5].'" class="resultBar" 
					       		style="border-radius:25px;
					       			   position:absolute;
					       			   width:'.$values[5].'%;
					       			   height:100%;
					       			   background-color:#2aa948;" >
					       		<div class="label" 
					       			style="text-align:center;
					       				   line-height:30px;
					       				   color:white;">
					       			'.$values[5].'%
					       		</div>
					       	</div>
					       </div>

					      </table>
					     </td>
					    </tr>
					   </table>
					  </td>
					 </tr>
					</table>
				</td>
			</tr>


			<tr>
				<td bgcolor="#2aa948" style="padding: 10px 30px 10px 30px;border-top: thick solid #f68121;border-bottom-left-radius: 20px;border-bottom-right-radius: 20px;">
				 	<table border="0" cellpadding="0" cellspacing="0" width="100%">
				 	 <tr>
				 	 	<td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;">
				 	 	 &reg; Snoek Hoveniers 2015 - Alle rechten voorbehouden<br/>
				 	 	</td>
				 	  <td>
				 	  		<td align="right">
				 	  		 <table border="0" cellpadding="0" cellspacing="0">
				 	  		  	<tr>
					 	  		  	<td style="text-align: center;width: 60%;height: 40px;background-color:#2aa948;border:2px solid white;border-radius:20px;">
					 	  		  		<a href="http://www.snoekgroep.nl/contact/" style="color: white;font-size: 16px;text-decoration: none;">Contact</a>
					 	  		 	</td>
					 	  		</tr>
				 	  		 </table>
				 	  		</td>
				 	  </td>
				 	 </tr>
				 	</table>
				</td>
			</tr>
		</table>
	</body>	';

	// extra option to add buttons/links to the twitter/facebook etc. pages. placed in the footer in the {td align="right"} table.
	//  <td>
	//   <a href="https://twitter.com/snoekhoveniers">
	//    <img src="http://findicons.com/files/icons/819/social_me/64/twitter.png" alt="Twitter" width="38" height="38" style="display: block;" border="0" />
	//   </a>
	//  </td>
	//  <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
	//  <td>
	//   <a href="https://www.facebook.com/groenvoorzieningen">
	//    <img src="http://findicons.com/files/icons/1983/aquaticus_social/60/facebook.png" alt="Facebook" width="38" height="38" style="display: block;" border="0" />
	//   </a>
	//  </td>
	//  <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
	//  <td>
	//   <a href="https://www.youtube.com/user/SnoekHoveniers">
	//    <img src="http://findicons.com/files/icons/2229/social_media_mini/48/youtube.png" alt="Facebook" width="38" height="38" style="display: block;" border="0" />
	//   </a>
	//  </td>
	//  <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
	//  <td>
	//   <a href="https://www.linkedin.com/company/snoek-hoveniers-grou-bv.">
	//    <img src="http://findicons.com/files/icons/1979/social/50/linkedin.png" alt="Facebook" width="38" height="38" style="display: block;" border="0" />
	//   </a>
	//  </td>

	$message = null;
	?>
	<div class="login-form">
	<h1>Verstuur resultaat</h1>
	<form>

	<?php
	if(!$mail->send()) {
	    echo 'Message could not be sent.';
	    echo 'Mailer Error: ' . $mail->ErrorInfo;
	    ?><input type="button" class="log-btn" value="Sluit Venster en verstuur opnieuw" onClick="window.close()"><?php
	} else {
		?>
			Resultaat is verstuurd naar <?php echo $naam ?> met het email adres <?php echo $email ?>
			<input type="button" class="log-btn" value="Sluit Venster" onClick="window.close()">
		<?php
	}
	?>
	</form>
	</div>

	<?php

	// echo json_encode(array("success" => true, "message" => $message));
} else {
	$aV = $_POST['aValue'];  	// naam    -> blue
	$aP = $_POST['aPercent'];	// procent -> 24

	$bV = $_POST['bValue'];
	$bP = $_POST['bPercent'];

	$cV = $_POST['cValue'];
	$cP = $_POST['cPercent'];

	$dV = $_POST['dValue'];
	$dP = $_POST['dPercent'];

	$eV = $_POST['eValue'];
	$eP = $_POST['ePercent'];

	$fV = $_POST['fValue'];
	$fP = $_POST['fPercent'];

	?>
	<div class="login-form">
	<h1>Verstuur resultaat</h1>
	<!-- Hidden form which sends the variables to the mail function wich sends it to the user -->
	<form action="mailer.php?sendmail=true" method="post">
		<input type="hidden" name="aValue" value="<?php echo $aV ?>">
		<input type="hidden" name="bValue" value="<?php echo $bV ?>">
		<input type="hidden" name="cValue" value="<?php echo $cV ?>">
		<input type="hidden" name="dValue" value="<?php echo $dV ?>">
		<input type="hidden" name="eValue" value="<?php echo $eV ?>">
		<input type="hidden" name="fValue" value="<?php echo $fV ?>">


		<input type="hidden" name="aPercent" value="<?php echo $aP ?>">
		<input type="hidden" name="bPercent" value="<?php echo $bP ?>">
		<input type="hidden" name="cPercent" value="<?php echo $cP ?>">
		<input type="hidden" name="dPercent" value="<?php echo $dP ?>">
		<input type="hidden" name="ePercent" value="<?php echo $eP ?>">
		<input type="hidden" name="fPercent" value="<?php echo $fP ?>">

		<div class="form-group log-status-username log-status">
			<input type="text" class="form-control" placeholder="Email" autocomplete="off" name="email">
		  <i class="fa fa-envelope"></i>
		</div>

		<div class="form-group log-status-username log-status">
		  <input type="text" class="form-control" placeholder="Naam" name="naam" autocomplete="off">
		  <i class="fa fa-user"></i>
		</div>
		<input id="login" class="log-btn" type="submit" value="Mail je resultaat">

	</form>
	</div>

	<?php
}
?>