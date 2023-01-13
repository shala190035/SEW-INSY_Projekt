<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

if(!empty($_POST['calorie'])) {
    $calorie = $_POST['calorie'];
    $id = $_SESSION['user_id'];
    $query = "insert into fitness (calories) values ('$calorie,$id')";
    $result = mysqli_query($con,$query);

    if ($result === false) {
        error_log(mysqli_error($con));
        echo "There was an error saving the calories to the database.";
    } else {
        if (mysqli_affected_rows($con) == 0) {
            error_log("The calories was not saved to the database because the query did not affect any rows.");
            echo "calories was not saved to the database.";
        } else {
            error_log("calories was successfully saved to the database.");
            echo "calories was successfully saved to the database.";
        }
    }
    error_log($calorie);
} else {
    error_log("The calorie variable was not posted.");
}
?>

<html>
<head>
    <title>Fitness-Tracker</title>
</head>
<body>
    <div>
        <label for="calorie-input">Enter calorie intake:</label>
        <input type="number" id="calorie-input" name="calorie">
    </div>
    <button id="send-calorie">Send calorie</button>
    <button type="reset" id="reset-calorie">Reset</button>
</body>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>

function docReady(fn) {
    if (document.readyState === "complete"
        || document.readyState === "interactive") {
        setTimeout(fn, 1);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

docReady(function () {
    $('#send-calorie').click(function() {
        $.ajax({
            url: 'http://localhost/fitness/index.php',
            type: 'POST',
            data: { calorie: $('#calorie-input').val() },
            success: function(response) {
                console.log('The Ajax request was successful.', calorie);
            },
            error: function(error) {
                console.log('There was an error with the Ajax request:', error, calorie);
            }
        });
    });
    $('#reset-calorie').click(function(){
        $('#calorie-input').val('');
    });
});

</script>

<div class="input-group mb-3">
  <div class="input-group-prepend">
  </div>
    <br>
    Hello, <?php echo $user_data['user_name']; ?>
    <a href="log
out.php">logout</a>
</div>
</head>
</html>