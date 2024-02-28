<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Database connection parameters
include "connection.php";

// Backup directory
$backupDirectory = '/var/www/html/Backup/';

// Ensure the backup directory exists
if (!is_dir($backupDirectory)) {
    mkdir($backupDirectory, 0755, true);
}

// Path to mysqldump executable
$mysqldumpPath = '/usr/bin/mysqldump'; // Change this path according to your environment

// Output file name with timestamp
$timestamp = date('Ymd_His');
$timestamp1 = date('d/m/y - H:i:s');
$backupFilename = "{$backupDirectory}CBi_Database_Backup_{$timestamp}.sql";

// Construct the mysqldump command
$command = "{$mysqldumpPath} -u {$username} -p{$password} -h {$servername} {$database} > {$backupFilename}";

// Execute the command
$output = array();
exec($command, $output, $returnValue);

// Check for success
if ($returnValue === 0) {
    echo 'Database backup successful.';

    // Load Composer's autoloader for PHPMailer
    require 'vendor/autoload.php';

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    // Set the SMTP server details
    $mail->isSMTP();
    $mail->Host       = 'smtp.office365.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'stockmanagement@cbi-electric.com.au'; // Your Office 365 email address
    $mail->Password   = 'BNWijFm3wY1qPZvy'; // Your Office 365 password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Sender email address
    $mail->setFrom('stockmanagement@cbi-electric.com.au', 'Stock Management');

    // Array of recipient email addresses
    $recipients = array(
        'stockmanagement@cbi-electric.com.au' => 'Stock Management System 1',
        'sabeysinghe@cbi-electric.com.au' => 'Suminda',
        // Add more recipients as needed
    );

    // Loop through recipients and add them to the email
    foreach ($recipients as $email => $name) {
        $mail->addAddress($email, $name);
    }

    $mail->addBCC('cbielectricsms@gmail.com','Stock Management System',);
    // Email subject and body
    $mail->Subject = 'Database Backup for ' .$timestamp1;
    $mail->Body    = 'Please find attached the database backup file.';

    // Attach the backup file
    $mail->addAttachment($backupFilename);

    // Send the email
    try {
        $mail->send();
        echo ' Email sent successfully.';
    } catch (Exception $e) {
        echo ' Email could not be sent. Error: ', $mail->ErrorInfo;
    }
} else {
    echo 'Error creating database backup. Error: ' . implode("\n", $output);

    // Send an error email
    $mail = new PHPMailer(true);

    // Set the SMTP server details for error email
    $mail->isSMTP();
    $mail->Host       = 'smtp.office365.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'stockmanagement@cbi-electric.com.au'; // Your Office 365 email address
    $mail->Password   = 'BNWijFm3wY1qPZvy'; // Your Office 365 password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Sender email address for error email
    $mail->setFrom('stockmanagement@cbi-electric.com.au', 'Stock Management');

    // Recipient email address for error email
    $mail->addAddress('stockmanagement@cbi-electric.com.au', 'Stock Management System');

    // Email subject and body for error email
    $mail->Subject = 'Database Backup Error';
    $mail->Body    = 'Error creating database backup. Check logs for more details.';
    
    try {
        $mail->send();
        echo ' Error email sent successfully.';
    } catch (Exception $e) {
        echo ' Error email could not be sent. Error: ', $mail->ErrorInfo;
    }
}
?>
