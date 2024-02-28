<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

// Set the SMTP server details (replace these with your actual credentials)
$mail->isSMTP();
$mail->Host       = 'smtp.office365.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'stockmanagement@cbi-electric.com.au'; // Your Office 365 email address
$mail->Password   = 'BNWijFm3wY1qPZvy'; // Your Office 365 password
$mail->SMTPSecure = 'tls';
$mail->Port       = 587;

function email($to, $subject, $message) {
    global $mail; // Access the $mail object declared outside the function

    try {
        // Sender and recipient details
        $mail->setFrom('stockmanagement@cbi-electric.com.au', 'Stock Management System');
        $mail->addAddress($to, '');

        // Email content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        // Send the email
        $mail->send();
        // Return success flag
        return true;
    } catch (Exception $e) {
        // Log the error instead of echoing it
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        // Return failure flag
        return false;
    }
}
?>

