<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require __DIR__ . "/vendor/autoload.php";

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = "smtp.sample.com";
$mail->SMTPAuth = true;
$mail->Username = "dlks@sample.com";
$mail->Password = "secret";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 0;

$mail->isHTML(true);

return $mail;
