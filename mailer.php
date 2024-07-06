<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/vendor/autoload.php";

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = "smtp.@sample.com";
$mail->SMTPAuth = true;
$mail->Username = "email@sample.com";
$mail->Password = "secret";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 0;

$mail->isHTML(true);

return $mail;
