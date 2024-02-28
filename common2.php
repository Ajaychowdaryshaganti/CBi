<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>CBi &#8211; Stock Management System</title>
  <link rel="stylesheet" type="text/css" href="styles/style.css">
  <link rel="icon" type="image/x-icon" href="images/game-fill.png">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/d7376949ab.js" crossorigin="anonymous"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    table {
      width: 70%;
      border-collapse: collapse;
    }

    table,
    th,
    td {
      text-align: center;
      border: 1px solid black;
    }

    #InProgress{
      background-color: #ffff00;
    }
	    #Assigned{
      background-color: #ffc000;
    }
	    #Completed{
      background-color: #04b0f0;
    }
	    #Tested{
      background-color: #00ff80;
    }

    th {
      text-align: center;
	  background-color: #ff8a8a;
      height: 50px;
    }

    #filters {
      width: 20%;
      margin-left: 3%;
    }

    #output {
      margin-left: 20%;
      margin-top: -25%;
      padding-bottom: 10%;
    }
	#full-container {
		//overflow-x:hidden;
		//height:930px;
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


.spinner {
  width: 200px;
  height: 200px;
}
#icons{
	width:50px;
	height:50px;
	padding-top:20px;
}
  </style>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js">
</script>
		    <script type="text/javascript">
        function handleBarcodeInput(event) {
            var barcodeInput = document.getElementById("barcodeInput");
            barcodeInput.value = event.data; // Set the input value to the scanned barcode data
            document.getElementById("myForm").submit(); // Submit the form
        }

        document.addEventListener("DOMContentLoaded", function() {
            window.addEventListener("message", handleBarcodeInput);
        });
    </script>


</head>

<body>
  <header>
    <nav>
      <div class="corpu-logo"><img src="images/cbi-logo.png" alt="CBI logo"></div>
      <input type="checkbox" id="burger">
      <label for="burger" class="burgerbtn">
        <i class="ri-menu-line"></i>
      </label>
      <ul>
        <li><a href="prodschedule2.php" id="select">
            <p>Production Schedule</p>
          </a></li>
		  <li><a href="workorders2.php" id="select">
            <p>Work Orders</p>
          </a></li>
		  <li><a href="workordershistory2.php" id="select">
            <p>Work Orders History</p>
          </a></li>
          	<li><a href="usage2.php" id="select">
            <p>Usage</p>
          </a></li>	
		  <li><a href="logout.php" id="select">
            <p>Logout</p>
          </a></li>


      </ul>
    </nav>
  </header><div id="loading-animation"><img src="images/loading.gif" alt="Loading..." class="spinner"></div></div>
  <div id="full-container">
    <section id="page-top-2">
      <h4 class="sub-header white-txt">Stock Management System</h4>
      <br>
      <p class="white-txt center">Welcome</p>
    </section>
