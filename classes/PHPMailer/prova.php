<?php
require './PHPMailerAutoload.php';
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->CharSet = 'UTF-8';
$mail->Host       = "smtp.gmail.com";      // SMTP server example, use smtp.live.com for Hotmail
$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->Port       = 465;                   // SMTP port for the GMAIL server 465 or 587
$mail->Username   = "gaetano.ruocco@gmail.com";  // SMTP account username example
$mail->Password   = "n4i2n4o218";            // SMTP account password example

$mail->SMTPSecure = 'ssl';
date_default_timezone_set('Etc/UTC');


//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Set the hostname of the mail server
//Set who the message is to be sent from
$mail->setFrom('gaetano.ruocco@gmail.com', 'First Last');
//Set an alternative reply-to address
$mail->addReplyTo('gaetano.ruocco@gmail.com', 'First Last');
$mail->addAddress('gaetano.ruocco@gmail.com', 'John Doe');

//Set who the message is to be sent to
//Set the subject line
$mail->Subject = 'PHPMailer SMTP test';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML(file_get_contents('examples/contents.html'), dirname(__FILE__));
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
?>