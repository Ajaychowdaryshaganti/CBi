<?php
// Start a session
session_start();

// Clear specific session variables
unset($_SESSION['Loggedinas']);

// Redirect to a different page after clearing the session variable
header("Location: index.html");
?>
