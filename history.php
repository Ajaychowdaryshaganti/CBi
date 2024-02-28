<?php
// Include your database connection file
include "connection.php";

// Fetch unique Job IDs for datalist
$queryJobIds = "SELECT DISTINCT jobId FROM psupdates";
$resultJobIds = mysqli_query($conn, $queryJobIds);
$jobIdOptions = '';
while ($rowJobIds = mysqli_fetch_assoc($resultJobIds)) {
    $jobIdOptions .= "<option value='{$rowJobIds['jobId']}'>";
}
?>

<html>
<head>
    <title>Update History</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        label, select, input {
            margin: 5px;
        }
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        form {
            margin: 20px;
        }

        label,
        select,
        input {
            margin: 5px;
        }

        button {
            margin: 5px;
        }

        table {
            width: 98%;
            margin: 20px;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h1>Update History</h1>

<form id="filterForm" style="margin: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9;">
    <label for="jobId" style="margin-right: 10px;">Job ID:</label>
    <input type="text" id="jobId" list="jobIdList" name="jobId" onchange="applyFilters()" style="padding: 5px;">

    <datalist id="jobIdList">
        <?php echo $jobIdOptions; ?>
    </datalist>

    <label for="updatedBy" style="margin-left: 20px; margin-right: 10px;">Updated By:</label>
    <select id="updatedBy" name="updatedBy" onchange="applyFilters()" style="padding: 5px;">
        <!-- Fetch and populate unique updatedBy values from the database -->
        <?php
        $queryUpdatedBy = "SELECT DISTINCT updatedBy FROM psupdates";
        $resultUpdatedBy = mysqli_query($conn, $queryUpdatedBy);
        while ($rowUpdatedBy = mysqli_fetch_assoc($resultUpdatedBy)) {
            echo "<option value='{$rowUpdatedBy['updatedBy']}'>{$rowUpdatedBy['updatedBy']}</option>";
        }
        ?>
    </select>

    <label for="action" style="margin-left: 20px; margin-right: 10px;">Action:</label>
    <select id="action" name="action" onchange="applyFilters()" style="padding: 5px;">
        <!-- Fetch and populate unique action values from the database -->
        <?php
        $queryActions = "SELECT DISTINCT action FROM psupdates";
        $resultActions = mysqli_query($conn, $queryActions);
        while ($rowAction = mysqli_fetch_assoc($resultActions)) {
            echo "<option value='{$rowAction['action']}'>{$rowAction['action']}</option>";
        }
        ?>
    </select>

    <label for="fromDate" style="margin-left: 20px; margin-right: 10px;">From Date:</label>
    <input type="date" id="fromDate" name="fromDate" style="padding: 5px;">

    <label for="toDate" style="margin-left: 20px; margin-right: 10px;">To Date:</label>
    <input type="date" id="toDate" name="toDate" style="padding: 5px;">

    <button type="button" onclick="applyFilters()" style="margin-left: 20px; padding: 8px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">Apply</button>
    <button type="button" onclick="resetFilters()" style="margin-left: 10px; padding: 8px; background-color: #ddd; color: black; border: none; border-radius: 4px; cursor: pointer;">Reset</button>
    <button type="button" onclick="goBack()" style="margin-left: 10px; padding: 8px; background-color: #E5A220; color: black; border: none; border-radius: 4px; cursor: pointer;">Back To Home</button>
</form>


<table id="updateHistoryTable" border="1">
    <thead>
        <tr>
            <th>Updated By</th>
            <th>Job ID</th>
            <th>Field Name</th>
            <th>New Value</th>
            <th>Last Updated</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- This part will be populated dynamically using JavaScript -->
    </tbody>
</table>

<script>
    function applyFilters() {
        // Get filter values
        var jobId = $('#jobId').val();
        var updatedBy = $('#updatedBy').val();
        var action = $('#action').val();
        var fromDate = $('#fromDate').val();
        var toDate = $('#toDate').val();

        // Make an AJAX request to fetch filtered data
        $.ajax({
            type: 'POST',
            url: 'fetch_updates.php', // Replace with your PHP script's URL
            data: {
                jobId: jobId,
                updatedBy: updatedBy,
                action: action,
                fromDate: fromDate,
                toDate: toDate
            },
            success: function (response) {
                // Update the table body with the fetched data
                $('#updateHistoryTable tbody').html(response);
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
                // Handle AJAX error
            }
        });
    }
    function goBack() {
            // Use the history object to go back one step
            window.history.back();
        }

    function resetFilters() {
        // Reset all filters to default values
        $('#jobId').val('');
        $('#updatedBy').val('');
        $('#action').val('');
        $('#fromDate').val('');
        $('#toDate').val('');

        // Make an AJAX request to fetch all data (reset)
        $.ajax({
            type: 'POST',
            url: 'fetch_updates.php', // Replace with your PHP script's URL
            data: {},
            success: function (response) {
                // Update the table body with the fetched data
                $('#updateHistoryTable tbody').html(response);
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
                // Handle AJAX error
            }
        });
    }

    // Apply filters on page load
    $(document).ready(function () {
        applyFilters();
    });
</script>

</body>
</html>
