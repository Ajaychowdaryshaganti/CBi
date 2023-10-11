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
        
    </style>
</head>

<body>
    <div id="moveJobsPop">
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
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Define the months array here
        const months = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

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

            // Clear the existing options and populate the week dropdown
            weekDropdown.innerHTML = "";

            // Calculate the number of days in the selected month
            const daysInMonthPop = new Date(selectedYearPop, monthIndexPop + 1, 0).getDate();

            // Calculate the number of weeks
            const weeksInMonthPop = Math.ceil(daysInMonthPop / 7);

            for (let i = 1; i <= weeksInMonthPop; i++) {
                const startOfWeekPop = new Date(selectedYearPop, monthIndexPop, (i - 1) * 7 + 1);
                const endOfWeekPop = new Date(selectedYearPop, monthIndexPop, Math.min(i * 7, daysInMonthPop));
                const formattedWeekPop = `Week ${i} (${formatDatePop(startOfWeekPop)} to ${formatDatePop(endOfWeekPop)})`;
                const weekOptionPop = document.createElement("option");
                weekOptionPop.value = `${formatDatePop(startOfWeekPop)},${formatDatePop(endOfWeekPop)}`;
                weekOptionPop.textContent = formattedWeekPop;
                weekDropdown.appendChild(weekOptionPop);
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

            // Initial population of the year dropdown and months/weeks
            populateYearsPop();
            updateWeeksPop();
        }

        // Call the initialization function
        initPop();
    </script>
</body>
</html>
