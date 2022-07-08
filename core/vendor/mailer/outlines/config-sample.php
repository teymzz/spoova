<?php

 // try {
 //     //$mail = new PHPMailer(true); //initialize
 //     //Server settings
 //     //$mail->SMTPDebug = 1;                // Enable verbose debug output
 //     //$mail->isSMTP();                     // Set mailer to use SMTP
 //     $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers  
 //     $mail->SMTPAuth   = true;              // Enable SMTP authentication mail.dufma.ng
 //     $mail->Username   = 'info@dufma.ng';   // SMTP username 12345
 //     $mail->Password   = 'demishoc12345';   // SMTP password  :gmailpass(abiola) teymss@gmail.com
 //     $mail->SMTPSecure = 'tls';             // Enable TLS encryption, PHPMailer::ENCRYPTION_STARTTLS`PHPMailer::ENCRYPTION_SMTPS` also acceptedteymss@gmail.com
 //     $mail->Port       = 587;               // TCP port to connect to

 //     //Recipients
 //     $mail->setFrom('info@dufma.ng', 'Dufma');
 //     $mail->addAddress('princessdarlexy@gmail.com', 'Princess Darlexy');     // Add a recipient
 //     // $mail->addAddress('ellen@example.com');               // Name is optional
 //     // $mail->addReplyTo('info@example.com', 'Information');
 //     // $mail->addCC('cc@example.com');
 //     // $mail->addBCC('bcc@example.com');

 //     // Attachments
 //     // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
 //     // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

 //     $subject = 'Welcome to dufma';
 //     $body = "<strong>Hi there Princess</strong>,<br> <p>You are welcome to dufma.ng</p>";
 //     // Content
 //     $mail->isHTML(true);                                  // Set email format to HTML
 //     $mail->Subject = $subject;
 //     $mail->Body    = $body;
 //     $mail->AltBody = strip_tags($body);

 //     $mail->send();
 //     echo 'Message has been sent';
 // } catch (Exception $e) {
 //     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
 // }