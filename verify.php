<?php
// Start a session
session_start();

// Include the database connection file
include 'connection.php';

// Function to check the username and password against the database
function authenticateUser($username, $password) {
    global $conn; // Access the database connection

    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        // Set user data in the session
        $_SESSION['Loggedinas'] = $user['username'];
        $_SESSION['accesslevel'] = $user['accesslevel'];
        $accesslevel = $user['accesslevel'];
        return true;
    } else {
        return false;
    }

    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from the POST request
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Call the authentication function
    if (authenticateUser($username, $password)) {
		
		
		
        $response = [
            'status' => 'success',
            'message' => 'Authentication successful',
            'accesslevel' => $_SESSION['accesslevel']
        ];

		
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Invalid Credentials'
        ];
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
