<?php
// Start or resume the session
session_start();

if($_SESSION['Loggedinas']){
	
}
else{
	 header("Location:index.html");
}
	
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
            transition: left 1s cubic-bezier(0.68, -0.55, 0.27, 1.55);
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
    transition: margin-left 1.5s ease; /* Add transition to margin-left property */
	z-index:0;
}

#caluculationsContainer{
	
	display:block;
	
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

        }        #refresh {
            background-color: #007BFF; /* Blue color, you can change it */
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
			margin-left:88%;
			margin-right:2%;

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
	 transition: margin-left 1.5s ease; 
}
/* Styles for the modal */

.modal {
    display: none;
	margin-top:0%;
	background-color: rgba(0, 0, 0, 0.7);
	width:100%;
	height:100%
}
.modal2 {
    display: none;
	margin-top:-30%;

}

#moveJobsPop {
background-color: #f2f2f2;
    box-shadow: 0 0 20px 0 rgba(0, 0, 10, 0.2), 0 5px 5px 0 rgba(0, 0, 10, 0.24); /* Apply shadow with opacity */
    padding: 20px;
    border: 1px solid #ccc;
    width: 30%;
    height: 40%;
    text-align: center;
    border-radius: 5px;
    //box-shadow: 0px 0px 10px 0px #000;
    position: fixed;
    top: 120%; /* Center vertically */
    left: 50%; /* Center horizontally */
    transform: translate(-50%, -50%); /* Center both vertically and horizontally */
    z-index: 999;
    transition: fade-in 1s ease;
}

.modal-content {
    background-color: #f2f2f2;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 20px;
    border: 1px solid #ccc;
    width: 30%;
    height: auto;
    text-align: center;
    border-radius: 5px;
    box-shadow: 0px 0px 10px 0px #000;
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
#calsinfo{
	transition: margin-left 1.5s ease;
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

#extracapavailable1{
	
	display:none;
	
}
#extracapreq1{
	
	display:none;
	
}
#confirmDelete:hover {
    background-color: #cc0000;
}

        #goToTop, #goToBottom {
            position: fixed;
            right: 20px;
            cursor: pointer;
            font-size: 20px;
            background-color: #A9A9A9;
            color: #fff;
            border: none;
            padding: 5px;
            border-radius: 200%;
        }

        #goToTop {
            top: 20px;
        }

        #goToBottom {
            bottom: 20px;
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
//$_SESSION['Loggedinas'] = 'Ajay'; // Store a value in the session

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

echo $_SESSION['Loggedinas'];
*/
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
        <li><a href="Dashboard4.php"><p>Home</p></a></li>
        <li><a href="Stock4.php"><p>Stock</p></a></li>
        <li><a href="prodschedule4.php"><p>Production Schedule</p></a></li>
        <li><a href="workorders4.php"><p>Work Orders</p></a></li>
        <li><a href="usage4.php"><p>Usage</p></a></li>
        <li><a href="logout.php"><p>Logout</p></a></li>
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
	<div id="top"></div>
<br>

<button id="refresh" onclick="refresh()">Refresh</button><button class="logout" id="fill" onclick="window.location.href = 'logout.php'">Logout</button><br>
<div id="errormsgs"></div>


	<div id="contentContainer"></div>
			<div id="bottom"></div>
    <a id="goToTop" href="#top">▲</a>
<a id="goToBottom" href="#bottom">▼</a>
    <br>

	<div id="caluculationsContainer"></div>
 



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
	
// Handle change event of #week select element
$('#week').on('change', function() {
    var selectedOption = $(this).val();
	 var firstOption = $('#week option:first').val();
	 disable1stOption(firstOption,selectedOption)
	 
    loadData(selectedOption);
});

    // Manually trigger the initial load on page load
    var selectedOption = $('#week').val();
	 var firstOption = $('#week option:first').val();
    loadData(selectedOption);
	disable1stOption(firstOption,selectedOption)
	//console.log(selectedOption);
	//console.log(firstOption);

		
		function disable1stOption(first,selected){
	
	var cals=document.getElementById('caluculationsContainer');
	
	if(first===selected){
		//console.log('yes');
		//addjob.style.display='none';
		cals.style.display='none';
		//addjobmsg.style.display='block';
	}
	else{
		//console.log('no');
		//addjob.style.display='block';
		cals.style.display='block';
		//addjobmsg.style.display='none';
	}
	
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


    function loadData(selectedOption) {
		
        // Make an AJAX request to your PHP script
        $.ajax({
            type: 'POST',
            url: 'psdata4.php', // Replace with your PHP script's URL
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
	
function loadCal(selectedOption) {
    $.ajax({
        type: 'POST',
        url: 'pscals4.php',
        data: { option: selectedOption },
        success: function(response) {
			
            $('#caluculationsContainer').html(response);
			
			var totalcap=localStorage.getItem('totalCapacity');
				gettotal();
				
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

function gettotal() {
    var check = document.getElementById('check');
    setTimeout(function () {
        var totalcap1 = localStorage.getItem('totalCapacity');
        if (totalcap1 !== null) {
    var wrkhrs = parseFloat($('#wrkhrs').text());
	var remhrs = parseFloat($('#remhrs').text());
	var broughtfwd = parseFloat($('#broughtfwd').text());
	var totalwork=remhrs + broughtfwd;
	$('#workrem').text(totalwork);
	if(totalcap1<totalwork)
	{
		
var extrareq = totalwork - totalcap1;
var disp = document.getElementById('extracapreq1');
$('#extracapreq').text(extrareq);
disp.style.display = 'block';

var selectedOption = $('#week').val();
var nextOption = getNextOption(selectedOption);

console.log(extrareq);


	
        }
		else if (totalcap1>=totalwork)
		{   var extrareq=0;
			var extracap = (totalcap1 - totalwork).toFixed(2);
			var disp=document.getElementById('extracapavailable1');
			$('#extracapavailable').text(extracap);
			disp.style.display = 'block';
			var selectedOption = $('#week').val();
var nextOption = getNextOption(selectedOption);

		}
		}		else {
            console.log('Total capacity not found in local storage.');
        }
    }, 500);
	

}


// Handle change event of #week select element
$('#week').on('change', function() {
    var selectedOption = $(this).val();
	 var firstOption = $('#week option:first').val();
	 disable1stOption(firstOption,selectedOption)
	 
    loadData(selectedOption);
});

    // Manually trigger the initial load on page load

	//console.log(selectedOption);
	//console.log(firstOption);


function disable1stOption(first,selected){
	
	//var addjob=document.getElementById('newJobForm');
	var cals=document.getElementById('caluculationsContainer');
	
	if(first===selected){
		//console.log('yes');
		//addjob.style.display='none';
		cals.style.display='none';
		//addjobmsg.style.display='block';
	}
	else{
		//console.log('no');
		//addjob.style.display='block';
		cals.style.display='block';
		//addjobmsg.style.display='none';
	}
	
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
	    var selectedOption = $('#week').val();
	 var firstOption = $('#week option:first').val();
    loadData(selectedOption);
	disable1stOption(firstOption,selectedOption)


// Event listener for the burger menu
const burger = document.getElementById("Toggle");
const navMenu = document.getElementById("menu1");
const content = document.getElementById("contentContainer");
 const botbuttons = document.getElementById('deletebutton');
 const calsinfo = document.getElementById('calsinfo');
navMenu.style.left = "-250px";

burger.addEventListener("change", () => {
    if (burger.checked) {
        navMenu.style.left = "0"; // Display the menu when checkbox is checked
        content.style.marginLeft = "200px"; // Move content right when the menu is displayed
        botbuttons.style.marginLeft = "200px"; // Move content right when the menu is displayed
		$('#calsinfo').css({
			marginLeft:'200px'
		});
    } else {
        navMenu.style.left = "-250px"; // Hide the menu when checkbox is not checked
        content.style.marginLeft = "0"; // Reset content margin
        botbuttons.style.marginLeft = "0"; // Reset content margin
				$('#calsinfo').css({
			marginLeft:'0px'
		});
    }
});


let errorCount = 0; // Initialize the error count

	  	<?php if (isset($_SESSION['defaultWeek'])) : ?>
    // Retrieve the default week value from the PHP session
    var defaultWeek = "<?php echo $_SESSION['defaultWeek']; ?>";

    // Set the default week in the week dropdown
    document.getElementById("week").value = defaultWeek;
<?php endif; ?>


  </script>
</body>
</html>

