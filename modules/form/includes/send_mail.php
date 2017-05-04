	<?php 

	require 'PHPMailer/class.phpmailer.php';
	require 'PHPMailer/class.pop3.php';
	require 'PHPMailer/class.smtp.php';

	$name = $_POST['name'];
	$email  = $_POST['email'];
	$bedrijf  = $_POST['bedrijf'];
	$first  = $_POST['first'];
	$second = $_POST['second'];
	$third  = $_POST['third'];
	$fourth  = $_POST['fourth'];

	// $name = 'Beverly Hills';
	// $email =  'bhills_9342@mailinator.com';
	// $bedrijf = 'Beverly Hills';
	// $first = 'Zo maak je van onbekenden klanten1';
	// $second = 'Maak je eigen marketingkalender	';
	// $third = 'Maak je eigen contentkalender';
	// $fourth = 'Fotograferen met je iPhone';


	$mail = new PHPMailer;

	$mail->Password = 'kweek123';
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'testerkweek@gmail.com';
	$mail->SMTPSecure = 'tls';
	$mail->Port = 587;

	$mail->SMTPOptions = array(
	    'ssl' => array(
	        'verify_peer' => false,
	        'verify_peer_name' => false,
	        'allow_self_signed' => true
	    )
	);

	$mail->isSMTP();
	// $mail->Host = localhost;

	$mail->setFrom('e.gielink@kweekvijvernoord.nl', 'Kweekster'); //sent from
	// $mail->addAddress('aanmelden@kweekvijvernoord.nl', 'aanmelden@kweekvijvernoord.nl'); //sent to
	$mail->addAddress('e.gielink@kweekvijvernoord.nl', 'naam'); //sent to

	$mail->isHTML(true);

	$mail->Subject = 'Aanmelding '.$name;
	//the email
	$mail->Body = 
	'
		<table style="border-collapse: collapse;">
		  <tr>
		    <th style="background-color:#A9F5D0;border: 1px solid black;">Naam</th>
		    <th style="background-color:#A9F5D0;border: 1px solid black;">Email</th>
		    <th style="background-color:#A9F5D0;border: 1px solid black;">Bedrijf</th>
		  </tr>
		  <tr>
		    <td style="padding:5px 10px 5px 10px;border: 1px solid black;">'.$name.'</td>
		    <td style="padding:5px 10px 5px 10px;border: 1px solid black;">'.$email.'</td>
		    <td style="padding:5px 10px 5px 10px;border: 1px solid black;">'.$bedrijf.'</td>
		  </tr>
      <br />
      <tr>
	      <td>
	          <br />
	      </td>
      </tr>
      <tr>
        <th style="background-color:#A9F5D0;border: 1px solid black;">Workshop 14:30</th>
		    <th style="background-color:#A9F5D0;border: 1px solid black;">Workshop 15:00</th>
		    <th style="background-color:#A9F5D0;border: 1px solid black;">Workshop 16:00</th>
		    <th style="background-color:#A9F5D0;border: 1px solid black;">Workshop 16:30</th>
      </tr>
      <tr>
        <td style="padding:5px 10px 5px 10px;border: 1px solid black;">'.$first.'</td>
		    <td style="padding:5px 10px 5px 10px;border: 1px solid black;">'.$second.'</td>
		    <td style="padding:5px 10px 5px 10px;border: 1px solid black;">'.$third.'</td>
		    <td style="padding:5px 10px 5px 10px;border: 1px solid black;">'.$fourth.'</td>

      </tr>
		</table>
	';


	// '<b>'.$name.'</b> heeft zich ingeschreven bij de workshop van 14.30 '.$first.'.<br /> bij de workshop van 15.00 '.$second.'enz';
	$message = null;

	if(!$mail->send()) {
	    echo 'Message could not be sent.';
	    echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		?>
			Resultaat is verstuurd naar <?php echo $name ?> met het email adres <?php echo $first ?>
		<?php
	}	
	echo json_encode(array("name" => $name));