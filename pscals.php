<!DOCTYPE html>
<html>
<head>
    <title>Your Page Title</title>
</head>
<body>
    <?php
    include 'connection.php';

    try {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $selectedOption = $_POST['option'];

            $result = explode(",", $selectedOption);
            $startDate = $result[0];
            $endDate = $result[1];

            $startDate = date('Y-m-d', strtotime($startDate));
            $endDate = date('Y-m-d', strtotime($endDate));
            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }

            // Modify your SQL query to get the sum of ahrs and wdays for the first distinct Date1 and Date2 set
            $sql = "SELECT Date1, Date2, daycap, nooffitters
                    FROM jobsnew 
                    WHERE Date1 >= '$startDate' AND Date2 <= '$endDate' 
                    GROUP BY Date1, Date2
                    LIMIT 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $day_capacity = $row['daycap'];
                $no_of_fitters = $row['nooffitters'];

                echo "<h2>Fitter Capacity per day: $day_capacity</h2>";
                echo "<h2>No of Fitters Available: $no_of_fitters</h2>";
            } else {
                echo "No data found for the selected date range.";
            }

            $conn->close();
        }
    } catch (Exception $e) {
        // Handle the exception by displaying the error message
        echo "Error: " . $e->getMessage();
    }
    ?>
</body>
</html>
