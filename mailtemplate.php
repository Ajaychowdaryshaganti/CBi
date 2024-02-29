<?php
require 'mail.php';
$username=$_POST['username'];

// Example usage:
$to = 'ajaychowdaryshaganti@gmail.com';
$subject = 'Test Email';
$message = 'This is a test email sent from XAMPP with Gmail SMTP using PHPMailer.';

if (sendEmail($to, $subject, $message)) {
    echo 'Email sent successfully!';
} else {
    echo 'Email could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
?>