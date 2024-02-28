<?php
require 'email.php';
require 'connection.php';

$username = $_POST['username'];

$stmt = $conn->prepare("SELECT email FROM users WHERE username = ?");
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($email);

if ($stmt->fetch()) {
    $stmt->close();
    $to = $email;
    $subject = 'Password Reset Link';
    $message = "<html><body>";
    $message .= '<img src="http://stockmanagement.cbi.local/images/password_reset_header.jpeg" alt="Password Reset Header" /><br>';
    $message .= "<p>Hello, $username!</p>";
    $message .= "<p>To reset your password, please click the following link:</p>";
    $message .= '<a href="http://stockmanagement.cbi.local/passwordreset.php?username=' . $username . '">Reset Password</a>';
    $message .= "<p>This link is valid for one-time use only.</p>";
    $message .= "</body></html>";

    // Additional headers to set the content type to HTML
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	
	// Pass SMTP details as parameters to the email function
	$emailResponse = email($to, $subject, $message);

    if ($emailResponse) {
        $response = array('status' => 'success', 'message' => 'Password Reset link sent successfully!');
    } else {
        $response = array('status' => 'error', 'message' => 'Email could not be sent.');
    }
} else {
    $response = array('status' => 'error', 'message' => 'Username not found.');
}

$conn->close();

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>

