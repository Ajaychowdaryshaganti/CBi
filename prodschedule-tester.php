<?php
// Start or resume the session
session_start();

// Now you have an active session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBI | Production Schedule</title>
    <!-- References to external basic CSS file -->
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <!-- Favicon for tab -->
    <link rel="icon" type="image/x-icon" href="images/game-fill.png">
    <!-- Reference to web icons from Remixicon.com -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <!-- Reference to web icons from Fontawesome -->
    <script src="https://kit.fontawesome.com/d7376949ab.js" crossorigin="anonymous"></script>
    <!-- References to external fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .{
            display: flex;
			overflow:hidden !! important;
        }


        /* Your existing styles here */

        /* Colorful styles for the months tabs */
        .tab {
            cursor: pointer;
            padding: 8px 16px;
            border-radius: 4px 4px 0 0;
            display: inline-block;
            margin: 5px;
            width: auto;
            text-align: center;
            font-weight: bold;
            color: #fff;
            background-color: #FF5E60; /* Red */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease-in-out, transform 0.2s ease-in-out;
        }

        .tab:hover {
            background-color: #ff5252; /* Lighter Red */
            transform: translateY(-4px);
            transition: all 0.1s ease 0s;
        }

        .active-tab {
            background-color: #e57373; /* Light Red */
        }

        /* Style for the months container */
        .months-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: auto;
            animation: fadeIn 1s ease-in-out;
            overflow: auto; /* Enable horizontal scrolling if needed */
            white-space: nowrap; /* Prevent the months from wrapping to multiple rows */
            margin-left: 0px; /* Add left margin to show starting months */
        }

        /* Styles for navigation buttons container */
        .navigation-buttons-container {
            display: flex;
            align-items: center;
            //justify-content: space-between;
            margin-bottom: 10px;
        }

        /* Styles for navigation buttons */
        .navigation-button {
            cursor: pointer;
            font-size: 24px;
            padding: 6px 12px;
            border-radius: 50%;
            //background-color: #f1f1f1;
            color: #333;
            //box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease-in-out;
        }

        .navigation-button:hover {
            box-shadow: 10px 4px 8px rgba(10, 0, 1, 0.1);
        }

        /* Additional styles for default selected month */
        .default-selected {
            //background-color: #e57373; /* Light Red */
        }

        #year-container {
            display: flex;
            align-items: center;
            margin-left: 1%;
            margin-top: -2%;
        }

        #year {
            padding: 5px;
            border-radius: 4px;
            font-size: 16px;
            max-width: 10%;
            width: auto;
        }

        label {
            font-weight: bold;
        }

        #week {
            padding: 5px;
            border-radius: 4px;
            font-size: 16px;
            max-width: 20%;
            width: auto;
        }

        #week1 {
            margin-left: 1%;
            margin-top: -3%;
            z-index: 1;
        }

        #left {
            margin-left: 21.5%;
        }

        #cbi-logo img {
            width: 10.2%;
            margin-left: 88%;
            margin-top: -27.5%;
        }

        hr {
            margin-top: -2%;
            border: none;
            /* top    */ border-top: 1px solid #ccc;
            /* middle */ background-color: #ddd;
            color: #ddd;
            /* bottom */ border-bottom: 1px solid #eee;
            height: 1px;
            *height: 3px; /* IE6+7 need the total height */
        }



        /* Style for the menu items */
        ul {
            list-style: none;
            margin: 0;
            padding: 0;
		
			background-color:transparent !important;
        }        
		ul:hover {
			background-color:transparent !important;
        }
		

        li {
           
		    padding:1%;
        }
		  li:hover {
		   background-color:transparent !important;
        }

        a {
            text-decoration: none;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
        }



#top-head {
    position: sticky;
    top: 0;
    background-color: white; /* Set the background color as needed */
    z-index: 100; /* Adjust the z-index as needed */
    /* Remove any properties related to horizontal scrolling */
    /* Remove height: 250px; if not needed */
    height: 150px;
}
hr{
	margin-top:-8.5%;
}


#contentContainer {
    display: flex;
	margin-left: 0;
	margin-top: 1%;
    /* Add the following properties to enable horizontal and vertical scrolling */
    overflow-x: auto !important; /* Enable horizontal scrolling */
    overflow-y: auto !important; /* Enable vertical scrolling */
    //max-height: calc(100vh - 250px);
	height:auto;
    transition: margin-left 1.5s ease; /* Add transition to margin-left property */
	z-index:0;
}

			


        /* Additional styles for the job rows */
        .job-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .editable {
            flex: 1;
            padding: 1px;
            border: 1px solid ;
            border-radius: 3px;
			font-size:15px;
			height:auto;
        }




h2 {
    color: red;
}

ul {
    list-style: none;
    padding: 0;
}

li {
    margin: 5px 0;
    font-weight: bold;
    color: #333;
}
#loading-animation {
  display: flex;
  align-items: center;
  justify-content: center;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(242, 242, 242, 0.5);
  z-index: 9999;
 
}
#loading-animation img{
	width:60%;
	height:60%;
	margin-left:10%;
}
.refresh{
	
margin-top:10%;
margin-left:70%;	
}
.logout{
	//margin-left:90%;

}



        /* Media query to show the menu when the checkbox is checked (hamburger icon clicked) */
        @media (max-width:3000px) {
            nav {
                left: 0; /* Display the menu when checkbox is checked */
            }


        }

    </style>
</head>
<?php
// Start a PHP session
//session_start();

// Now you can store and retrieve session data
/*
$status = session_status();

// Check the session status
if ($status == PHP_SESSION_DISABLED) {
    echo "Sessions are disabled on the server.";
} elseif ($status == PHP_SESSION_NONE) {
    echo "Sessions are enabled, but no session exists or has started.";
} elseif ($status == PHP_SESSION_ACTIVE) {
    echo "A session has started.";
} else {
    echo "Unknown session status.";
}
*/
//echo $_SESSION['Loggedinas'];

if (isset($_SESSION['defaultWeek'])) {
    $currentTime = time();
    $variableTimestamp = $_SESSION['defaultWeek_timestamp'];
    $expirationTime = 30; // 30 seconds

    if (($currentTime - $variableTimestamp) > $expirationTime) {
        // Variable has expired, unset it
        unset($_SESSION['defaultWeek']);
        unset($_SESSION['defaultWeek_timestamp']); // Optionally unset the timestamp too
    }
}
?>
<form method="post"></form>
<body>

 
    <div id="top-head">
        <center>
            <h1> Production Schedule </h1>
        </center>
        <div id="year-container">
            <label for="year">Select Year: </label>
            <select id="year" onchange="updateMonthsAndWeeks()">
                <!-- The years will be populated dynamically -->
            </select>
        </div>

        <div class="navigation-buttons-container">
            <div id="left" class="navigation-button" onclick="navigateMonths(-1)">
                &#9664; <!-- Left arrow icon -->
            </div>
            <div class="months-container" id="months-container">
                <!-- The months will be populated dynamically as tabs -->
            </div>
            <div class="navigation-button" onclick="navigateMonths(1)">
                &#9654; <!-- Right arrow icon -->
            </div>
        </div>
        <div id="week1">
		
            <label for="week">Select Week:</label>
            <select id="week" >
                <option selected disabled>No weeks available for this month</option>
            </select>
			</div>
			
			<div>

        <div id="cbi-logo"><img src="images/cbi-logo.png" alt="CBI logo"></div>	
		</div>
        <hr>
		
</div>
    </div>
<br>
<hr>
<button id="fill-green" onclick="window.location.href = 'workorders3.php'">Work Orders</button>&nbsp;<button class="logout" id="fill" onclick="window.location.href = 'workordershistory3.php'">Work Order History</button><button class="refresh" id="fill-green" onclick="refresh()">Refresh</button>
<button class="logout" id="fill" onclick="window.location.href = 'logout.php'">Logout</button>
	<div id="contentContainer"></div>

		<h4 id="errormsgmove"></h4>
  <div id="loading-animation"><img src="images/loading.gif" alt="Loading..." class="spinner"></div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>




    let currentMonthIndex = new Date().getMonth();
    let currentYear = new Date().getFullYear();
    const months = [
      "January", "February", "March", "April", "May", "June",
      "July", "August", "September", "October", "November", "December"
    ];

    // Function to populate the year dropdown with 10 previous years and 5 forward years
    function populateYears() {
      const yearDropdown = document.getElementById("year");
      const yearsToShow = 15; // Total years to display, 10 previous years and 5 forward years

      for (let i = currentYear - 10; i <= currentYear + 4; i++) {
        const option = document.createElement("option");
        option.value = i;
        option.text = i;
        yearDropdown.appendChild(option);
      }

      yearDropdown.value = currentYear; // Set current year as default selected
    }
	function refresh(){
		
		var selectedOption = $('#week').val();
		loadData(selectedOption);
	}

function getWeeksOfMonth(year, month) {
  const weeks = [];
  const firstDay = new Date(year, month, 1);
  const lastDay = new Date(year, month + 1, 0);

  let currentWeek = [];
  let currentDate = new Date(firstDay);

  while (currentDate <= lastDay) {
    if (currentDate.getDay() === 1) {
      if (currentWeek.length > 0) {
        weeks.push(currentWeek);
      }
      currentWeek = [new Date(currentDate)];
    } else {
      currentWeek.push(new Date(currentDate));
    }
    currentDate.setDate(currentDate.getDate() + 1);
  }
  	  // Check if the first week contains only Saturday and Sunday and remove it
  if (weeks.length > 0 && weeks[0].length <= 2) {
    weeks.shift();
  }

  // Add the last week if it's not empty
  if (currentWeek.length > 0) {
    weeks.push(currentWeek);
  }

  return weeks;
}

    // Function to update the months and weeks based on user selection
    function updateMonthsAndWeeks() {
      const monthsContainer = document.getElementById("months-container");
      monthsContainer.innerHTML = "";

      for (let i = 0; i < months.length; i++) {
        const tab = document.createElement("div");
        tab.className = "tab";
        tab.textContent = months[i];
        tab.onclick = () => updateWeeks(months[i]);
        monthsContainer.appendChild(tab);
      }

      currentMonthIndex = new Date().getMonth();
      highlightActiveTab(months[currentMonthIndex]);
      updateWeeks(months[currentMonthIndex]);

    }

    // Function to update the week dropdown based on the selected month and year
    function updateWeeks(selectedMonth) {
      const yearDropdown = document.getElementById("year");
      const selectedYear = parseInt(yearDropdown.value, 10);
      const monthIndex = months.indexOf(selectedMonth);
	  const monthName = getMonthName(monthIndex);
	  const firstDay = new Date(selectedYear, monthIndex, 1);
	  const lastDay = new Date(selectedYear, monthIndex + 1, 0);
	  
	  const weekDropdown = document.getElementById("week");
	  weekDropdown.innerHTML = "";
	  
	  const option1 = document.createElement("option");
	  option1.value = `${formatDate(firstDay)},${formatDate(lastDay)}`;
	  option1.text = `${monthName} (${formatDate(firstDay)} to ${formatDate(lastDay)})`;
	  weekDropdown.appendChild(option1);


      const weeksOfMonth = getWeeksOfMonth(selectedYear, monthIndex);

      for (let i = 0; i < weeksOfMonth.length; i++) {
        const weekDates = weeksOfMonth[i];
        const startWeekDate = formatDate(weekDates[0]);
        const endWeekDate = formatDate(weekDates[weekDates.length - 1]);

        const option = document.createElement("option");
        option.value = `${startWeekDate},${endWeekDate}`;
        option.text = `Week ${i + 1} (${startWeekDate} to ${endWeekDate})`;
        weekDropdown.appendChild(option);
      }	 
		//console.log('hello');
	    var selectedOption = $('#week').val();
		//console.log(selectedOption);
        loadData(selectedOption);
		
	    const full=firstDay+ ','+lastDay;
		

		//if(selectedOption
    }


	function getMonthName(monthIndex) {
  const months = [
    "January", "February", "March", "April",
    "May", "June", "July", "August",
    "September", "October", "November", "December"
  ];

  // Ensure the monthIndex is within a valid range (0 to 11)
  if (monthIndex >= 0 && monthIndex < 12) {
    return months[monthIndex];
  } else {
    return "Invalid Month";
  }
}

    // Function to format a date as DD-MM-YYYY
    function formatDate(date) {
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, "0");
      const day = String(date.getDate()).padStart(2, "0");
      return `${day}-${month}-${year}`;
    }

// Handle change event of #week select element
$('#week').on('change', function() {
    var selectedOption = $(this).val();
	 
    loadData(selectedOption);
});
    function loadData(selectedOption) {
		
        // Make an AJAX request to your PHP script
        $.ajax({
            type: 'POST',
            url: 'psdata-tester.php', // Replace with your PHP script's URL
            data: { option: selectedOption }, // Send data to PHP script if needed
            success: function(response) {
                // Update the content container with the PHP-generated content
                $('#contentContainer').html(response);
				
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
		loadCal(selectedOption);
		document.documentElement.style.zoom = "80%";
    }
	


function getNextOption(selectedOption) {
  const weekDropdown = document.getElementById("week");
  const options = weekDropdown.options;
  let nextOption = null;

  for (let i = 0; i < options.length; i++) {
    if (options[i].value === selectedOption) {
      // If the selected option is found, get the next option if available
      if (i < options.length - 1) {
        nextOption = options[i + 1].value;
      } else {
// If the selected option is the last one, get the first option of the next month
const currentYear = parseInt(document.getElementById("year").value, 10);
const selectedMonth = selectedOption.split(",")[1];
const parts = selectedMonth.split('-');
const day = parseInt(parts[0], 10);
const month = parseInt(parts[1], 10);
const year = parseInt(parts[2], 10);

let nextMonth = month + 1;
let nextYear = year;


if (nextMonth > 12) {
    nextMonth = 1;
    nextYear = year + 1;
}

let startDate =`01-${String(nextMonth).padStart(2, '0')}-${nextYear}`;

// Create a Date object for the input date
const currentDate = new Date(year, month - 1, day); // Month is 0-based

// Calculate the day of the week (0 = Sunday, 6 = Saturday)
const currentDayOfWeek = currentDate.getDay();

// Calculate the number of days until the next Sunday
const daysUntilNextSunday = 7 - currentDayOfWeek;

// Create a new Date object for the next Sunday
const nextSunday = new Date(currentDate);
nextSunday.setDate(currentDate.getDate() + daysUntilNextSunday);

// Format the next Sunday as DD-MM-YYYY
const formattedNextSunday = `${String(nextSunday.getDate()).padStart(2, '0')}-${String(nextSunday.getMonth() + 1).padStart(2, '0')}-${nextSunday.getFullYear()}`;

nextOption = `${startDate},${formattedNextSunday}`;



      }

      break; // Stop searching
    }
  }

  return nextOption;
}
	
	
$(document).ready(function() {
    // Function to load data and handle inline editing


    // Function to handle inline editing
    $('#contentContainer').on('blur', '.editable', function() {
        // Get the job ID, column name, and new value
        var jobID = $(this).data('jobid');
        var columnName = $(this).data('columnname');
            if ($(this).find('select').length > 0) {
        newValue = $(this).find('select').val(); // Get the selected value of the dropdown
    } else {
        newValue = $(this).text(); // Get the text content if it's not a dropdown
    }
        var cell = $(this); // Store a reference to the cell element
		
		console.log(jobID);
		console.log(columnName);
		console.log(newValue);
if (typeof columnName !== 'undefined') {
        // Make an AJAX request to update the data
$.ajax({
            type: 'POST',
            url: 'psupdateRow.php', // Replace with your PHP script's URL for updating
            data: { jobID: jobID, columnName: columnName, newValue: newValue },
            success: function(response) {
                // Log the response to the console
                console.log(response);

                // Check if the update was successful
                if (response.status === 'success') {
                    // Update the cell background color to green
                    cell.css('background-color', '#80ff80');
                } else {
                    // Update the cell background color to red
                    cell.css('background-color', '#ffad99');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);

			// Update the cell background color to red in case of an error
			if (typeof columnName !== 'undefined') {
				cell.css('background-color', '#ffad99');
			}

            }
        }); 
}
    }); 



    // Manually trigger the initial load on page load
    var selectedOption = $('#week').val();
	 var firstOption = $('#week option:first').val();
    loadData(selectedOption);
	disable1stOption(firstOption,selectedOption)
	//console.log(selectedOption);
	//console.log(firstOption);
});



    // Function to navigate months
    function navigateMonths(step) {
      currentMonthIndex += step;

      if (currentMonthIndex < 0) {
        currentMonthIndex = 11;
        currentYear--;
        document.getElementById("year").value = currentYear;
      } else if (currentMonthIndex > 11) {
        currentMonthIndex = 0;
        currentYear++;
        document.getElementById("year").value = currentYear;
      }

      const selectedMonth = months[currentMonthIndex];
      updateWeeks(selectedMonth);
      highlightActiveTab(selectedMonth);

    }

    // Function to highlight the active month tab
    function highlightActiveTab(selectedMonth) {
      const tabs = document.querySelectorAll(".tab");
      tabs.forEach((tab) => {
        tab.classList.remove("active-tab", "default-selected");
        if (tab.textContent === selectedMonth) {
          tab.classList.add("active-tab");
        }
        if (tab.textContent === months[new Date().getMonth()] && currentYear === new Date().getFullYear()) {
          tab.classList.add("default-selected");
        }
      });
	  

    }

    // Initial population of the year dropdown and months/weeks tabs
    populateYears();
    updateMonthsAndWeeks();



let errorCount = 0; // Initialize the error count



	  	<?php if (isset($_SESSION['defaultWeek'])) : ?>
    // Retrieve the default week value from the PHP session
    var defaultWeek = "<?php echo $_SESSION['defaultWeek']; ?>";

    // Set the default week in the week dropdown
    document.getElementById("week").value = defaultWeek;
<?php endif; ?>


  </script>

<?php include 'loading.php'; ?>
</body>
</html>


