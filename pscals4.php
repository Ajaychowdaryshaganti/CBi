<!DOCTYPE html>
<html>
<head>
    <title>Your Page Title</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
#fitterinfo{
	
	margin-left:88.1%;
	margin-top:1%;
	color:black;
	font-size: 20px;
	border: 0.1px solid;
	background-color:#FFFCF9;
}
#calsinfo{
	margin-top:3%;
	width:15%;
	color:black;
	font-size: 20px;
	border: 0.1px solid;
	background-color:#FFFCF9;
}
	


</style>
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

            $sql = "SELECT Date1, Date2, daycap, nooffitters ,broughtfwd
                    FROM jobsnew 
                    WHERE Date1 >= '$startDate' AND Date2 <= '$endDate' 
                    GROUP BY Date1, Date2
                    LIMIT 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $day_capacity = $row['daycap'];
                $no_of_fitters = $row['nooffitters'];
                $broughtfwd = $row['broughtfwd'];

                echo "<div id='fitterinfo' hidden>Fitter Capacity per day: <span id='daycap'>$day_capacity</span><br>";
                echo "No of Fitters Available: <span id='nooffitters'>$no_of_fitters</span></div>";
                echo "<div id='calsinfo'>Hours brought forward: <span id='broughtfwd'>$broughtfwd</span><br>";
                echo "Total Work Hours: <span id='workrem'></span><br>";
                echo "Total Capacity: <span id='totalCapacity'></span><br>";
                echo "<p id='extracapreq1'>Extra Hours Required: <span id='extracapreq'></span><br></p>";
                echo "<p id='extracapavailable1'>Extra Hours Available: <span id='extracapavailable'></span></p></div>";

                // Add JavaScript to handle inline editing and calculate total capacity
                echo "<script>
                    var startDate = '$startDate';
                    var endDate = '$endDate';

                    $(document).ready(function() {
                        $('#daycap').click(function() {
                            updateValue('daycap', 'Enter new capacity:');
                        });

                        $('#nooffitters').click(function() {
                            updateValue('nooffitters', 'Enter no of fitters Available:');
                        });

                        function updateValue(elementId, promptMessage) {
                            var newValue = prompt(promptMessage);
                            if (newValue !== null) {
                                $('#' + elementId).text(newValue);
                                updateTotalCapacity();
                                updateDatabase(elementId, newValue);
                            }
                        }

                        function updateDatabase(elementId, newValue) {
                            var dayCap = parseFloat($('#daycap').text());
                            var noFitters = parseFloat($('#nooffitters').text());

                            // Send the updated values to the server
                            $.ajax({
                                type: 'POST',
                                url: 'psupdatecals.php', // Replace with the actual PHP script URL
                                data: {
                                    elementId: elementId,
                                    newValue: newValue,
                                    daycap: dayCap,
                                    nooffitters: noFitters,
                                    startDate: startDate,
                                    endDate: endDate
                                },
                                success: function(response) {
                                    console.log(response);
                                },
                                error: function(xhr, status, error) {
                                    console.error(xhr.responseText);
                                }
                            });
                        }

function updateTotalCapacity() {
    var dayCap = parseFloat($('#daycap').text());
    var noFitters = parseFloat($('#nooffitters').text());
    var currentDate = new Date();
    var startDateObj = new Date(startDate);
    var endDateObj = new Date(endDate);

    // Calculate the number of working days between the start date and end date
    var workingDays = 0;

    // Check if the end date is in the past
    if (endDateObj < currentDate) {
        $('#totalCapacity').text(0);
        settotal(0);
    } else {
        while (startDateObj <= endDateObj) {
            if (startDateObj.getDay() >= 1 && startDateObj.getDay() <= 5) {
                // Check if it's a working day (Monday to Friday)
                if (startDateObj <= currentDate) {
                    // Check if the day has already passed
                    startDateObj.setDate(startDateObj.getDate() + 1);
                    continue;
                }
                workingDays++;
            }
            startDateObj.setDate(startDateObj.getDate() + 1);
        }

        // Calculate the total capacity based on the working days
        var totalCapacity = dayCap * noFitters * workingDays;
        settotal(totalCapacity);
        $('#totalCapacity').text(totalCapacity);
    }
}


                        // Initial calculation of total capacity
                        updateTotalCapacity();
						function settotal(capacity){
							localStorage.setItem('totalCapacity', capacity);
						}
                    });
                </script>";
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
