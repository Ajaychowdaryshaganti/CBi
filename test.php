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

        /* New styles for the navigation menu */
        #menu1 {
            //display: flex;
            flex-direction: column; /* Display the menu items vertically */
            background-color: #fff;
			-webkit-box-shadow: 1px 1px 0px rgba(0,0,0,0.1);/*For webkit browsers*/
-moz-box-shadow: 1px 1px 0px rgba(0,0,0,0.1);/*For Firefox*/
box-shadow: 1px 1px 0px rgba(0,0,0,0.1);
            position: fixed; /* Keep the menu fixed on the screen */
            top: 0;
            left: 0px; /* Initially hide the menu off the left side of the screen */
            width: 8%;
            height: auto;
            //padding: 10px;
			margin-top:9%;
            transition: left 0.8s cubic-bezier(0.68, -0.55, 0.27, 1.55);
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

		.Menu-container{
  height:5px;
  width:30px;
  cursor:pointer;
  margin: 10% 50%;
  display:flex;
  margin-bottom: -8%;
  justify-content:center;
  align-items:center;
}

.line{
  position:absolute;
  margin-left:-95%;
  margin-top:-20%;
  height:5px;
  width:30px;
  background-color:black;
  transition: .4s ease;
  }

/* it hides the checkbox*/
#Toggle{
  display:none;
}

.line::before{
  content:'';
  position:absolute;
  height:5px;
  width:30px;
  background-color:black;
  top:-8px;
  transition: .4s ease;
}


.line::after{
  content:'';
  position:absolute;
  height:5px;
  width:30px;
  background-color:black;
  top:8px;
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

#Toggle:checked + label #active{
  transform:rotate(45deg);
  background-color:#FF5E60;	
  }

#Toggle:checked + label #active::before{
  transform:rotate(-90deg) translateX(-8px);
  background-color:#FF5E60;	
}

#contentContainer {
    display: flex;
	margin-left: 0;
    /* Add the following properties to enable horizontal and vertical scrolling */
    overflow-x: auto !important; /* Enable horizontal scrolling */
    overflow-y: auto !important; /* Enable vertical scrolling */
    //max-height: calc(100vh - 250px);
	height:auto;
    transition: margin-left 1s ease; /* Add transition to margin-left property */
	z-index:0;
}

#Toggle:checked + label #active::after{
  display:none;
  background-color:#FF5E60;	
}
        #newJobForm{
			           // margin-top: 10px;
            margin-bottom: 10px;
		margin-left: 42%;}
		  #newJobID{
			           
					   border:1px solid;
					   border-radius:5px;
					   width:12%;
				
					   }
			
        #addNewJobButton {
            background-color: #007BFF; /* Blue color, you can change it */
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
			margin-left:1%;

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
#deletebutton{
		font: 400 1rem 'Jost', sans-serif;
    color: #ffeef0;
    background-color: #FF6978;
    text-decoration: none;
    border: 2px solid transparent;
    border-radius: 8px;
    padding: 8px 20px;
	 transition: margin-left 1s ease; 
}
/* Styles for the modal */

.modal {
    display: none;
	margin-top:-18%;
}
.modal2 {
    display: none;
	margin-top:-30%;

}

#moveJobsPop{
    background-color: #f2f2f2;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #ccc;
    width: 30%;
	height:40%;
    text-align: center;
    border-radius: 5px;
    box-shadow: 0px 0px 10px 0px #000;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 999;
    transition: fade-in 1s ease;
}
.modal-content {
    background-color: #f2f2f2;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #ccc;
    width: 30%;
	height:20%;
    text-align: center;
    border-radius: 5px;
    box-shadow: 0px 0px 10px 0px #000;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 999;
    transition: fade-in 1s ease;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}
.close1 {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover {
    color: red;
    cursor: pointer;
}
.close1:hover {
    color: red;
    cursor: pointer;
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

#confirmDelete {
    background-color: red;
    color: white;
    border: none;
    padding: 10px 20px;
    margin-top: 10px;
    cursor: pointer;
    border-radius: 3px;
    transition: background-color 0.3s;
}

#confirmDelete:hover {
    background-color: #cc0000;
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
$_SESSION['Loggedinas'] = 'Ajay'; // Store a value in the session
/*(
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
//echo $_SESSION['defaultWeek'];

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
    <nav id="menu1">

        <ul>
            <li><a href="Dashboard.php"><p>Dashboard</p></a></li>
            <li><a href="Stock.php"><p>Stock</p></a></li>
            <li><a href="prodschedule.php"><p>Production Schedule</p></a></li>
            <li><a href="viewjobs1.php"><p>View Jobs</p></a></li>
            <li><a href="managejobs1.php"><p>Manage Jobs</p></a></li>
            <li><a href="Viewusers1.php"><p>View Users</p></a></li>
            <li><a href="manageusers1.php"><p>Manage Users</p></a></li>
            <li><a href="updatestock1.php"><p>Update Stock Data</p></a></li>
            <li><a href="usage.php"><p>Usage</p></a></li>
            <li><a href="reorder.php"><p>Re-Order</p></a></li>
            <li><a href="orderhistory.php"><p>Order History</p></a></li>
        </ul>
    </nav>
 
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
<input type="checkbox" id="Toggle">

<label for="Toggle">
  <div class="Menu-container">
    <div class="line" id="active"></div>
  </div>
</label>
        <div id="cbi-logo"><img src="images/cbi-logo.png" alt="CBI logo"></div>	
		</div>
        <hr>
</div>
    </div>
<br>
<div id="newJobForm">
    <label>Add New Job:</label>
    <input type="text" id="newJobID" placeholder="Sales Order No" required>
    <button id="addNewJobButton" onclick="addNewJob()">ADD</button>
</div><div id="addjobmsg"><center><h2>Select a week to add new job</h2><br><center></div>
<div id="errormsgs"></div>


	<div id="contentContainer"></div>
    <br>
<button id="deletebutton" class="botbuttons1" onclick="deletejob()"> Delete </button>&nbsp;
<button id="fill-green" class="botbuttons2" onclick="initPop()"> Move </button>
	<div id="caluculationsContainer"></div>
<div id="confirmationModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Confirm Deletion</h2>
        <p>Are you sure you want to delete the following jobs?</p>
        <ul id="jobIdList"></ul>
        <button id="confirmDelete">Yes, delete</button>
    </div>
</div>
   <div id="moveJobsPop" class="modal2">
   <h3>Select week to move selected jobs:<span class="close1">&times;</span>
        <div id="yearContainerPop">
            <label for="yearPop">Select Year: </label>
            <select id="yearPop" onchange="updateWeeksPop()">
                <!-- The years will be populated dynamically -->
            </select>
        </div>

        <div id="monthsContainerPop">
            <label for="monthPop">Select Month: </label>
            <select id="monthPop" onchange="updateWeeksPop()">
                <!-- The months will be populated dynamically -->
                <option value="January">January</option>
                <option value="February">February</option>
                <option value="March">March</option>
                <option value="April">April</option>
                <option value="May">May</option>
                <option value="June">June</option>
                <option value="July">July</option>
                <option value="August">August</option>
                <option value="September">September</option>
                <option value="October">October</option>
                <option value="November">November</option>
                <option value="December">December</option>
            </select>
        </div>

        <div id="weekContainerPop">
            <label for="weekPop">Select Week:</label>
            <select id="weekPop">
                <!-- Week options will be added dynamically -->
            </select>
        </div>
		<button id="fill" onclick="movejob()">Move</button>
		<h4 id="errormsgmove"></h4>
    </div>



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
	
function deletejob() {
    // Collect the selected job IDs
    const selectedJobIds = [];
    const checkboxes = document.querySelectorAll('input[name="selectedJobs[]"]:checked');
    checkboxes.forEach(function(checkbox) {
        selectedJobIds.push(checkbox.value);
    });

    // Make sure there are selected jobs
    if (selectedJobIds.length === 0) {
        alert("Please select jobs to delete.");
        return;
    }

    // Show the confirmation modal
    const modal = document.getElementById('confirmationModal');
    const jobIdList = document.getElementById('jobIdList');
    const confirmDeleteButton = document.getElementById('confirmDelete');
    jobIdList.innerHTML = ''; // Clear previous list items

    // Populate job IDs in the modal
    selectedJobIds.forEach(function(jobId) {
        const listItem = document.createElement('li');
        listItem.textContent = jobId;
        jobIdList.appendChild(listItem);
    });

    modal.style.display = 'block';

    // Handle confirmation or cancellation
    confirmDeleteButton.onclick = function() {
        modal.style.display = 'none'; // Hide the modal

        // AJAX request to delete jobs
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'psdeletejobs.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        console.log("Deleted successfully");
                        var selectedOption = $('#week').val();
                        loadData(selectedOption);
                    } else {
                        console.error("Server returned an unexpected response:", response);
                        alert("Failed to delete jobs. Please try again.");
                    }
                } catch (error) {
                    console.error("Error parsing JSON response:", error);
                    alert("Failed to parse server response.");
                }
            } else {
                console.error("Server returned an error status:", xhr.status);
                alert("Failed to delete jobs. Please try again.");
            }
        };

        xhr.send('jobIds=' + JSON.stringify(selectedJobIds));
    };

    // Handle modal close button
    const closeButton = document.querySelector('.close');
    closeButton.onclick = function() {
        modal.style.display = 'none';
        modal2.style.display = 'none';
    };
}


    function populateYearsPop() {
        const yearDropdown = document.getElementById("yearPop");
        const yearsToShow = 15; // Total years to display, 10 previous years and 5 forward years
        const currentYearPop = new Date().getFullYear();

        for (let i = currentYearPop - 10; i <= currentYearPop + 4; i++) {
            const option = document.createElement("option");
            option.value = i;
            option.text = i;
            yearDropdown.appendChild(option);
        }

        yearDropdown.value = currentYearPop; // Set current year as the default selected
    }

    function updateWeeksPop() {
        const yearDropdown = document.getElementById("yearPop");
        const monthDropdown = document.getElementById("monthPop");
        const weekDropdown = document.getElementById("weekPop");

        const selectedYearPop = parseInt(yearDropdown.value, 10);
        const selectedMonthPop = monthDropdown.value;
        const monthIndexPop = months.indexOf(selectedMonthPop);
				const selectedWeek = weekDropdown.value;
				console.log('test:'+selectedWeek);

        // Clear the existing options and populate the week dropdown
        weekDropdown.innerHTML = "";

        // Calculate the number of days in the selected month
        const daysInMonthPop = new Date(selectedYearPop, monthIndexPop + 1, 0).getDate();

        // Calculate the number of weeks
        let weekNumber = 1;
        let startDay = 1; // Default start day for the first week
        let endDay = 0; // Default end day for the first week

        for (let day = 1; day <= daysInMonthPop; day++) {
            const currentDate = new Date(selectedYearPop, monthIndexPop, day);
            const currentDay = currentDate.getDay(); // 0 for Sunday, 1 for Monday, ...

            if (currentDay === 1) {
                // Monday, start of a new week
                startDay = day;
            } else if (currentDay === 0 || day === daysInMonthPop) {
                // Sunday or end of the month, end of the week
                endDay = day;

                // Create the week option if it has at least one weekday
                if (endDay > startDay) {
                    const startOfWeekPop = new Date(selectedYearPop, monthIndexPop, startDay);
                    const endOfWeekPop = new Date(selectedYearPop, monthIndexPop, endDay);

                    const formattedWeekPop = `Week ${weekNumber} (${formatDatePop(startOfWeekPop)} to ${formatDatePop(endOfWeekPop)})`;
                    const weekOptionPop = document.createElement("option");
                    weekOptionPop.value = `${formatDatePop(startOfWeekPop)},${formatDatePop(endOfWeekPop)}`;
                    weekOptionPop.textContent = formattedWeekPop;
                    weekDropdown.appendChild(weekOptionPop);

                    // Update for the next week
                    weekNumber++;
                }
            }
        }

        // Call the function to load data based on the selected week
        loadDataPop(weekDropdown.value);
    }

    function formatDatePop(date) {
        const yearPop = date.getFullYear();
        const monthPop = String(date.getMonth() + 1).padStart(2, "0");
        const dayPop = String(date.getDate()).padStart(2, "0");
        return `${dayPop}-${monthPop}-${yearPop}`;
    }

    function loadDataPop(selectedWeek) {
        // Replace this with your code to load data based on the selected week
        console.log("Data loaded for week: " + selectedWeek);
    }

function initPop() {
    const currentMonthIndexPop = new Date().getMonth();
    const currentYearPop = new Date().getFullYear();

    // Initial population of the year dropdown
    populateYearsPop();

    // Set the default selected month to the current month
    const monthDropdown = document.getElementById("monthPop");
    monthDropdown.value = months[currentMonthIndexPop];

    // Update weeks based on the selected month
    updateWeeksPop();
	
	const modal2 = document.getElementById('moveJobsPop');
	modal2.style.display = 'block';
	    const closeButton = document.querySelector('.close1');
    closeButton.onclick = function() {
        //modal.style.display = 'none';
        modal2.style.display = 'none';
    };
	
}

function movejob() {
    // Collect the selected job IDs
    const selectedJobIds = [];
    const checkboxes = document.querySelectorAll('input[name="selectedJobs[]"]:checked');
    checkboxes.forEach(function (checkbox) {
        selectedJobIds.push(checkbox.value);
    });

    const weekDropdown = document.getElementById("weekPop");
    const selectedWeek = weekDropdown.value;
	const modal2 = document.getElementById('moveJobsPop');
	const error2 = document.getElementById('errormsgmove');
    // Prepare the data as a JSON object
    const data = {
        selectedJobIds: selectedJobIds,
        selectedWeek: selectedWeek,
    };

    // Use jQuery to send the AJAX request
    $.ajax({
        type: "POST",
        url: "psmovejobs.php",
        data: JSON.stringify(data),
        contentType: "application/json",
        success: function (response) {
            // Handle the response from the server here
            if (response.success) {
                console.log("Record updated successfully");
				modal2.style.display = 'none';
				
            } else {
                console.error("Failed to update jobs: " + response.message);
				error2.innerHTML="Failed to move Jobs. Technical Issue";
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX request failed: " + error);
        }
    });
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


    function loadData(selectedOption) {
		
        // Make an AJAX request to your PHP script
        $.ajax({
            type: 'POST',
            url: 'psdata.php', // Replace with your PHP script's URL
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
    }
	
	function loadCal(selectedOption){
		
		        $.ajax({
            type: 'POST',
            url: 'pscals.php', // Replace with your PHP script's URL
            data: { option: selectedOption }, // Send data to PHP script if needed
            success: function(response) {
                // Update the content container with the PHP-generated content
                $('#caluculationsContainer').html(response);
				
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
		
		
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
                cell.css('background-color', '#ffad99');
            }
        }); 
    }); 



// Handle change event of #week select element
$('#week').on('change', function() {
    var selectedOption = $(this).val();
	 var firstOption = $('#week option:first').val();
	 disable1stOption(firstOption,selectedOption)
	 //console.log(selectedOption);
	 //console.log(firstOption);
	 
    loadData(selectedOption);
});

    // Manually trigger the initial load on page load
    var selectedOption = $('#week').val();
	 var firstOption = $('#week option:first').val();
    loadData(selectedOption);
	disable1stOption(firstOption,selectedOption)
	//console.log(selectedOption);
	//console.log(firstOption);
});


function disable1stOption(first,selected){
	
	var addjob=document.getElementById('newJobForm');
	var addjobmsg=document.getElementById('addjobmsg');
	
	if(first===selected){
		console.log('yes');
		addjob.style.display='none';
		addjobmsg.style.display='block';
	}
	else{
		console.log('no');
		addjob.style.display='block';
		addjobmsg.style.display='none';
	}
	
}



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


// Event listener for the burger menu
const burger = document.getElementById("Toggle");
const navMenu = document.getElementById("menu1");
const content = document.getElementById("contentContainer");
 const botbuttons = document.getElementById('deletebutton');
navMenu.style.left = "-250px";

burger.addEventListener("change", () => {
    if (burger.checked) {
        navMenu.style.left = "0"; // Display the menu when checkbox is checked
        content.style.marginLeft = "200px"; // Move content right when the menu is displayed
        botbuttons.style.marginLeft = "200px"; // Move content right when the menu is displayed
    } else {
        navMenu.style.left = "-250px"; // Hide the menu when checkbox is not checked
        content.style.marginLeft = "0"; // Reset content margin
        botbuttons.style.marginLeft = "0"; // Reset content margin
    }
});

let errorCount = 0; // Initialize the error count

function addNewJob() {
    // Get the job ID input element
    const jobIDInput = document.getElementById("newJobID");

    // Get the entered job ID value
    const jobID = jobIDInput.value.trim(); // Trim to remove leading/trailing whitespace

    // Get the selected option value
    const selectedOption = document.getElementById("week").value; // Use the correct ID

    // Check if the job ID is not empty
    if (jobID !== "") {
        // Prepare data for the AJAX request
        const data = {
            jobID: jobID,
            selectedOption: selectedOption
        };

        // Make an AJAX POST request to psaddnewjob.php
        $.ajax({
            type: "POST",
            url: "psaddnewjob.php",
            data: data,
            success: function(response) {
                // Handle the success response from the server
                if (response.status === 'success') {
                    // Reload the page on success
                    location.reload();
                } else {
                    // Display the error message in the error div
                    document.getElementById("errormsgs").innerHTML = '<h3 style="color: red;">Error adding new job: ' + response.message + '</h3>';
                }
            }
        });
    } else {
        // Job ID is empty, display an error message
        alert("Job ID cannot be empty. Please enter a valid job ID.");
    }
}


	  	<?php if (isset($_SESSION['defaultWeek'])) : ?>
    // Retrieve the default week value from the PHP session
    var defaultWeek = "<?php echo $_SESSION['defaultWeek']; ?>";

    // Set the default week in the week dropdown
    document.getElementById("week").value = defaultWeek;
<?php endif; ?>


  </script>
</body>
</html>

