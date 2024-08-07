<?php
date_default_timezone_set('Asia/Dhaka');

include "classes/class.phpmailer.php"; // include the class name
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (isset($_POST["email"])) {

    ob_start();
    //include email template
    include('mailt.html');
    $message = ob_get_contents();
    ob_end_clean();

    $email = $_POST["email"];
    $mail = new PHPMailer; // call the class
    $mail->isSMTP(); //smtp email

    // $mail->Host = 'mail.jbldruglaboratories.com';
    $mail->Host = '192.168.241.222';
    $mail->Port = 25; //Port of the SMTP like to be 25, 80, 465 or 587
    $mail->SMTPAuth = true; //Whether to use SMTP authentication
    $mail->Username = 'vasmarketing@ssd-tech.com';
    $mail->Password = '';
    $mail->AddReplyTo($email, "rhmoon21@gmail.com"); //reply-to address
    $mail->SetFrom("rhmoon21@gmail.com", "Moon"); //From address of the mail
    // put your while loop here like below,
    $mail->Subject = "Test SMTP Mail"; //Subject od your mail
    $mail->AddAddress($email, "THT"); //To address who will receive this email
    $mail->MsgHTML($message); //Put your body of the message you can place html code here
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