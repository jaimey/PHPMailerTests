<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('America/Bogota');

require_once 'vendor/autoload.php';
Dotenv\Dotenv::createImmutable(__DIR__)->load();

$mail = new PHPMailer();
$mail->isSMTP();

//SMTP::DEBUG_OFF = off (for production use)
//SMTP::DEBUG_CLIENT = client messages
//SMTP::DEBUG_SERVER = client and server messages
$mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->Host = $_ENV['SMTP_HOST'];
$mail->Port = $_ENV['SMTP_PORT'];
$mail->SMTPAuth = true;
$mail->Username = $_ENV['SMTP_USERNAME'];
$mail->Password = $_ENV['SMTP_PASSWORD'];
$mail->setFrom($_ENV['FROM_EMAIL']);
$mail->addAddress($_ENV['TO_EMAIL']);
$mail->Subject = 'PHPMailer SMTP test';
$mail->isHTML(true);
$mail->Body = '<h1>PHPMailer test</h1><p>This is a test email</p>';
$mail->AltBody = 'This is a plain-text message body';
// $mail->addAttachment('images/phpmailer_mini.png');

if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
}
