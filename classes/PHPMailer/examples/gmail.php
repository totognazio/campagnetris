<?php
/**
 * This example shows settings to use when sending via Google's Gmail servers.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

require '../PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 2;
$mail->Debugoutput = 'html';
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = "toolcampain@gmail.com";
$mail->Password = "toolcampain2015";
$mail->setFrom('gaetano.ruocco@gmail.com', 'First Last');
$mail->addReplyTo('gaetano.ruocco@gmail.com', 'First Last');
$mail->addAddress('gaetano.ruocco@gmail.com', 'John Doe');
$mail->Subject = 'PHPMailer GMail SMTP test';
$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
$mail->AltBody = 'This is a plain-text message body';
$mail->addAttachment('images/phpmailer_mini.png');
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
