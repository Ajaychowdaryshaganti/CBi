<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Use the correct path for your PHPMailer files
require '/var/www/html/PHPMailer-master/src/Exception.php';
require '/var/www/html/PHPMailer-master/src/PHPMailer.php';
require '/var/www/html/PHPMailer-master/src/SMTP.php';

function sendEmail($to, $subject, $message) {
    $mail = new PHPMailer(true); // Set to true to enable exceptions
    
    try {
        // Suppress verbose debugging
        $mail->SMTPDebug = SMTP::DEBUG_OFF;

        // Set the mailer to use SMTP
        $mail->isSMTP();
        $mail->isHTML(true); // Set email format to HTML

        // Specify the SMTP server
        $mail->Host = 'smtp.office365.com';

        // Enable SMTP authentication
        $mail->SMTPAuth = true;

        // Your Office 365 username and password
        $mail->Username = 'stockmanagement@cbi-electric.com.au'; // Your Office 365 email address
        $mail->Password = 'BNWijFm3wY1qPZvy'; // Your Office 365 password

        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Set the "from" email address and name
        $mail->setFrom('sms@cbi-electric.com.au', 'Stock Management System');

        // Add a recipient
        $mail->addAddress($to);

        // Set the subject
        $mail->Subject = $subject;

        // Set the message body
        $mail->Body = $message;

        // Add BCC recipient
        $bccEmail = 'corpug23@gmail.com';
        $mail->addBCC($bccEmail);

        // Send the email
        $mail->send();
        return true; // Email sent successfully
    } catch (Exception $e) {
        return false; // Email could not be sent
    }
}

function sendEmailWithAttachment($recipients, $subject, $message, $attachment) {
    $mail = new PHPMailer(true); // Set to true to enable exceptions
    
    try {
        // Suppress verbose debugging
        $mail->SMTPDebug = SMTP::DEBUG_OFF;

        // Set the mailer to use SMTP
        $mail->isSMTP();
        $mail->isHTML(true); // Set email format to HTML

        // Specify the SMTP server
        $mail->Host = 'smtp.office365.com';

        // Enable SMTP authentication
        $mail->SMTPAuth = true;

        // Your Office 365 username and password
        $mail->Username = 'stockmanagement@cbi-electric.com.au'; // Your Office 365 email address
        $mail->Password = 'BNWijFm3wY1qPZvy'; // Your Office 365 password

        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Set the "from" email address and name
        $mail->setFrom('sms@cbi-electric.com.au', 'Stock Management System');

        // Add recipients
        foreach ($recipients as $recipient) {
            $mail->addAddress($recipient);
        }

        // Set the subject
        $mail->Subject = $subject;

        // Set the message body
        $mail->Body = $message;

        // Add BCC recipient
        $bccEmail = 'corpug23@gmail.com';
        $mail->addBCC($bccEmail);

        // Add attachment
        $mail->addAttachment($attachment);

        // Send the email
        $mail->send();
        return true; // Email sent successfully
    } catch (Exception $e) {
        return false; // Email could not be sent
    }
}
?>

