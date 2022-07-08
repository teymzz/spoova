<?php

//require starter file
require_once 'mail-starter.php';

//set server configuration
$mail->Host       = '';    // Specify main and backup SMTP servers smtp.gmail.com / website hostname
$mail->SMTPAuth   = true;  // Enable SMTP authentication
$mail->Username   = '';    // SMTP username e.g info@site.com..
$mail->Password   = '';    // SMTP password  ..
$mail->SMTPSecure = 'tls'; // Enable TLS encryption, PHPMailer::ENCRYPTION_STARTTLS`PHPMailer::ENCRYPTION_SMTPS` also acceptedteymss@gmail.com
$mail->Port       = 465;   // TCP port to connect to (mostly constant)

/*DO NOT DELETE THIS FILE BUT YOU MAY EDIT THE SERVER CONFIGURATION VALUES WITH VALID CREDENTIALS*/