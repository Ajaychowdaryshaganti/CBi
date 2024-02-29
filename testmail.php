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

function email($to, $subject, $message, $attachmentFilePath = null) {
    global $mail; // Access the $mail object declared outside the function

    try {
        // Sender and recipient details
        $mail->setFrom('stockmanagement@cbi-electric.com.au', 'Stock Management System');
        $mail->addAddress($to, '');

        // Email content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        // Add attachment if provided
        if ($attachmentFilePath !== null) {
            $mail->addAttachment($attachmentFilePath);
        }

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

// Example usage:
$to = 'cbielectricsms@gmail.com';
$subject = 'Email with Attachment';
$message = 'This email contains an attachment.';
$attachmentFilePath = '/var/www/html/Backup/20240116/CBi_backup_2024011615.sql'; // Replace with the actual file path

$emailResponse = email($to, $subject, $message, $attachmentFilePath);

if ($emailResponse) {
    echo 'Email with attachment sent successfully!';
} else {
    echo 'Error sending email with attachment.';
}
?>

