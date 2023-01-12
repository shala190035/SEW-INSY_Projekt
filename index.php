<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);
// Check if the calorie variable was posted
if(!empty($_POST['calorie'])) {
    $calorie = $_POST['calorie'];



    // Save the decoded text to the database
    $query = "insert into fitness (calories) values ('$calorie')";
    $result = mysqli_query($con,$query);

    // Check if the query was successful
    if ($result === false) {
        // Log the error and display an error message
        error_log(mysqli_error($con));
        echo "There was an error saving the calories to the database.";
    } else {
        // Check if the query affected any rows
        if (mysqli_affected_rows($con) == 0) {
            // Log an error message
            error_log("The calories was not saved to the database because the query did not affect any rows.");
            echo "calories was not saved to the database.";
        } else {
            // Log a success message
            error_log("calories was successfully saved to the database.");
            echo "calories was successfully saved to the database.";
        }
    }
    error_log($calorie);
} else {
    // Log an error message if the calorie variable was not posted
    error_log("The calorie variable was not posted.");
}


?>

<html>
<head>
    <title>Fitness-Tracker</title>
</head>
<body>
    <!-- Add a button to trigger the Ajax request -->
    <button id="send-calorie">Send calorie</button>

</body>

<!-- Include the jQuery library and the html5-qrcode library -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


<script>

function docReady(fn) {
    // see if DOM is already available
    if (document.readyState === "complete"
        || document.readyState === "interactive") {
        // call on next available tick
        setTimeout(fn, 1);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

/*docReady(function () {
    var resultContainer = document.getElementById('qr-reader-results');
    var lastResult, countResults = 0;
    var decodedResult2 = "";
    function onScanSuccess(decodedText, decodedResult) {
        if (decodedText !== lastResult) {
            ++countResults;
            lastResult = decodedText;
            // Handle on success condition with the decoded message.
            console.log(`Scan result ${decodedText}`, decodedResult);
           
        }
        
    }

    // Bind an event listener to the Send calorie button
    $('#send-calorie').click(function() {
        // Send the decoded text to the PHP script via an Ajax request
        $.ajax({
            url: 'http://localhost/fitness/index.php',
            type: 'POST',
            data: {
                calorie: calorie
            },
            success: function(response) {
                console.log('The Ajax request was successful.', calorie);
            },
            error: function(error) {
                console.log('There was an error with the Ajax request:', error, calorie);
            }
        });
    });

});


</script>

<!-- Display the logged-in user's name and a logout link -->
<div class="input-group mb-3">
  <div class="input-group-prepend">
  </div>
    <br>
    Hello, <?php echo $user_data['user_name']; ?>
    <a href="logout.php">logout</a>
</div>
</head>
</html>