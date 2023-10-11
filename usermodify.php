<?php
include 'connection.php';

// Retrieve the values sent from the JavaScript code
$jobid = $_POST['jobid'];
$status = $_POST['status'];



try {
    if ($conn) {


        // Prepare the SQL statement with placeholders
        $updateQuery = "UPDATE jobs SET currentstate = ?, lastupdated = ? WHERE jobid = ?";
        $statement = mysqli_prepare($conn, $updateQuery);

        if ($statement) {
            // Bind the parameters to the statement
            mysqli_stmt_bind_param($statement, 'sss', $status, date('Y-m-d H:i:s'), $jobid);

            // Execute the statement
            $result = mysqli_stmt_execute($statement);

            if ($result) {
				$response = array(
                'success' => true,
                'message' => "Status has been updated to $status for Job No: $jobid"
            );
			
            } else {
                throw new Exception("<h3>Failed to update</h3>");
            }

            // Close the statement
            mysqli_stmt_close($statement);
        } else {
            throw new Exception("<h3>Failed to prepare statement</h3>");
        }
    } else {
        throw new Exception("<h3>Connection failed: " . mysqli_connect_error() . "</h3>");
    }
} catch (Exception $e) {
	$response = array(
                'success' => false,
				'message' => "Something went wrong! Please try again. If the issue persists, please contact the administrator."
				);
}

// Send the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
?>
