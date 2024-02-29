<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBi - Password Reset</title>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="icon" type="image/x-icon" href="images/game-fill.png">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<style>
    body {
        background: url(images/loginbg.jpg);
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        margin: 0;
        padding: 0;
        height: 100vh;
    }

    .input-field1 {
        border: solid 1.5px Black;
        margin: 2px 0 17px;
        border-radius: 3px;
        display: flex;
        align-items: center;
    }

    button#fill1 {
        font: 400 1rem 'Jost', sans-serif;
        color: black;
        background-color: #BF9972;
        text-decoration: none;
        border: 2px solid transparent;
        border-radius: 8px;
        padding: 8px 20px;
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

    #loading-animation img {
        width: 60%;
        height: 60%;
        margin-left: 10%;
    }

    #page-content {
        transition: ease-in 2s;
        margin-left: 0%;
        margin-top:-10%;
    }

    #errormsg {
        font-weight: bold;
        color: red;
        //margin-left: 2%;
        text-align:center;
    }
</style>
<body>
<div id="loading-animation">
    <img src="images/loading.gif" alt="Loading..." class="spinner">
</div>

<div id="page-content" style="display: none;">
    <br><br><br><br><br><br><br><br><br><br>

    <?php
    $username = $_GET['username'];
    ?>

    <form method="post" action="passwordreset.php">
        <div class="input-container" style="width:15%;margin-left:40%; margin-top:10%;">
        <h2> Change/Reset  Password </h2><br><br>
            <div id="errormsg"></div>
            <div class="input-field1">
                <i class="ri-user-fill"></i>
                <input type="text" name="username" id="username" value="<?php echo $username; ?>" readonly>
            </div>
            <div class="input-field1">
                <i class="ri-lock-fill"></i>
                <input type="password" name="newPassword" id="newPassword" maxlength="10" placeholder="New Password" required>
            </div>
            <div class="input-field1">
                <i class="ri-lock-fill"></i>
                <input type="text" name="confirmPassword" id="confirmPassword" maxlength="10"
                       placeholder="Confirm Password">
            </div>
            <div id="float-right">
                <button id="fill1" class="signinBttn" type="submit" name="resetPassword" value="resetPassword" required>Change/Reset
                </button>
            </div>
        </div>
    </form>
</div>
</body>
</html>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("loading-animation").style.display = "none";
        document.getElementById("page-content").style.display = "block";

        document.querySelector("form").addEventListener("submit", function (event) {
            event.preventDefault();

            var username = document.getElementById("username").value;
            var newPassword = document.getElementById("newPassword").value;
            var confirmPassword = document.getElementById("confirmPassword").value;
            var errormsg = document.getElementById("errormsg");

            if (newPassword !== confirmPassword) {
                errormsg.style.color = "red";
                errormsg.style.marginLeft = "10%";
                errormsg.textContent = "Passwords do not match.";
                return;
            }

            // Send the form data to the server for processing
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "reset_password.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        var response = xhr.responseText;
						console.log(response);
if (response.trim() === "success") {
    errormsg.style.color = "green";
    errormsg.style.marginLeft = "0";
    errormsg.textContent = "Password changed successfully!";
	setTimeout(function () {
        window.location.href = "index.html"; // Redirect to index.html
    }, 3000);
} else if (response.trim() === "error") {
    errormsg.style.color = "red";
    errormsg.style.marginLeft = "0";
    errormsg.textContent = "Password change failed. Please contact support.";
}
                    } else {
                        errormsg.style.color = "red";
                        errormsg.style.marginLeft = "0";
                        errormsg.textContent = "An error occurred while processing your request. Please try again later.";
                    }
                }
            };
            xhr.send("username=" + username + "&newPassword=" + newPassword);
        });
    });
</script>
