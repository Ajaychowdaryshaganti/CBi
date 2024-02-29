<?php
require 'mail.php';
require 'connection.php';

if (isset($_POST['newPassword'])) {
    $username = $_POST['username'];
    $newPassword = $_POST['newPassword'];

    // Retrieve the user's email from the database
    $stmt = $conn->prepare("SELECT email FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($email);

    if ($stmt->fetch()) {
        $stmt->close();

        // Update the user's password in the database
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
        $stmt->bind_param('ss', $newPassword, $username);

        if ($stmt->execute()) {
            // Password updated successfully
            $subject = 'Password Changed Successfully';
            $message = "Your password has been changed successfully.";
            sendEmail($email, $subject, $message);

            echo "success"; // Return a success response
        } else {
            // Password update failed
            echo "error"; // Return an error response
        }
    } else {
        // User not found
        echo "error"; // Return an error response
    }

    $conn->close();
}
?>
