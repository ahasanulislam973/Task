<?php
	include "classes/class.phpmailer.php"; // include the class name

	if(isset($_POST["email"])){

		$email = $_POST["email"];
		$mail = new PHPMailer; // call the class
		$mail->isSMTP(); //smtp email
		$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true; // authentication enabled
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465; //Port of the SMTP like to be 25, 80, 465 or 587
		$mail->Username = 'bitm.training@bitm.org.bd';
		$mail->Password = 'aditya@tbd@123#';
		$mail->AddReplyTo($email, "bitm.training@bitm.org.bd"); //reply-to address
		$mail->SetFrom("bitm.training@bitm.org.bd", "BITM"); //From address of the mail
		// put your while loop here like below,
		$mail->Subject = "It is developer test mail"; //Subject od your mail
		$mail->AddAddress($email, "BITM"); //To address who will receive this email
		$mail->MsgHTML('message goes here'); //Put your body of the message you can place html code here
		$send = $mail->Send(); //Send the mails
		if ($send) {
			echo 'Mail sent successfully';
		} else {
			echo 'Mail error: ' . $mail->ErrorInfo;
		}
	}

?>

<form action="" method="post">
	<label for="email">E-mail Address</label>
	<input type="text" name="email" value="">
	<input type="submit" name="submit" value="Send Mail">
</form>