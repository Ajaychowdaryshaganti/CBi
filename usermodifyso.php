<?php
session_start();

include 'connection.php';

// Retrieve the values sent from the JavaScript code
$jobid = $_POST['jobid'];
$status = $_POST['status'];

$fittername = $_SESSION['fittername'];


try {
    if ($conn) {
        // Retrieve the existing comments2 value from the database
        $selectQuery = "SELECT comments2 FROM jobsnew WHERE jobid = ?";
        $selectStatement = mysqli_prepare($conn, $selectQuery);
        mysqli_stmt_bind_param($selectStatement, 's', $jobid);
        mysqli_stmt_execute($selectStatement);
        mysqli_stmt_bind_result($selectStatement, $existingComments);
        mysqli_stmt_fetch($selectStatement);
        mysqli_stmt_close($selectStatement);

        // Combine the existing comments and new comments
        $combinedComments = $existingComments . ' ' . $comments;

        // Prepare the SQL statement to update the comments
        $updateQuery = "UPDATE jobsnew SET currentstate = ?, lastupdated = ?,completionrate=100, lastupdatedby = ? WHERE jobid = ?";
        $updateStatement = mysqli_prepare($conn, $updateQuery);

        if ($updateStatement) {
            $currentTimestamp = date('Y-m-d H:i:s');
            mysqli_stmt_bind_param($updateStatement, 'ssss', $status, $currentTimestamp, $fittername, $jobid);

            // Execute the statement
            $result = mysqli_stmt_execute($updateStatement);

            if ($result) {
                $response = array(
                    'success' => true,
                    'message' => "Status has been updated to $status for Job No: $jobid"
                );
            } else {
                throw new Exception("<h3>Failed to update</h3>");
            }

            // Close the statement
            mysqli_stmt_close($updateStatement);
        } else {
            throw new Exception("<h3>Failed to prepare statement</h3>");
        }
    } else {
        throw new Exception("<h3>Connection failed: " . mysqli_connect_error() . "</h3>");
    }
} catch (Exception $e) {
    $response = array(
        'success' => false,
        'message' => "Error: " . $e->getMessage()
    );
}

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
