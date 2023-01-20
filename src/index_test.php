<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

if(!empty($_POST['calorie'])) {
    $calorie = $_POST['calorie'];
    $id = $_SESSION['id'];
    $check_query = "SELECT * FROM day_calorie WHERE user_id = '$id'";
    $check_result = mysqli_query($con, $check_query);
    if(mysqli_num_rows($check_result) > 0) {
        $query = "UPDATE day_calorie SET calorie = '$calorie' WHERE user_id = '$id'";
        $result = mysqli_query($con, $query);
    } else {
        $query = "INSERT INTO day_calorie (user_id, calorie) VALUES ('$id', '$calorie')";
        $result = mysqli_query($con, $query);
    }
    

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

/* if(!empty($_POST['sport'])) {
    $sport = $_POST['sport'];
    $id = $_SESSION['user_id'];
    $query = "UPDATE day_calorie SET calorie = calorie + '$sport' WHERE user_id = '$id'";
    $result = mysqli_query($con,$query);

    if ($result === false) {
        error_log(mysqli_error($con));
        echo "There was an error adding the sport calories to the database.";
    } else {
        if (mysqli_affected_rows($con) == 0) {
            error_log("The sport calories was not saved to the database because the query did not affect any rows.");
            echo "sport calories was not saved to the database.";
        } else {
            error_log("sport calories was successfully added to the database.");
            echo "sport calories was successfully added to the database.";
        }
    }
    error_log($sport);
} else {
    error_log("The sport variable was not posted.");
}
*/

$id = $_SESSION['id'];
$query = "SELECT calorie FROM day_calorie WHERE user_id='$id'";
$result = mysqli_query($con, $query);
$query_history = "SELECT calorie, date_saved FROM saved_calorie WHERE user_id='$id'";
$result_history = mysqli_query($con, $query_history);
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
    <div>
        <h3>current Calorie intake:</h3>
        <?php
        while($row = mysqli_fetch_assoc($result)) {
            echo $row['calorie'] . "<br>";
            echo $current_date = date("Y-m-d");
        }
        ?>
    </div>
    <div>
        <h3>calorie history</h3>
        <?php
        while($row = mysqli_fetch_assoc($result_history)) {
            echo $row['calorie'] . " - " . $row['date_saved'] . "<br>";
        }
        ?>
    </div>
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
        if($('#calorie-input').val() !== ""){
            $.ajax({
                url: 'http://localhost/fitness/index_test.php',
                type: 'POST',
                data: { calorie: $('#calorie-input').val() },
                success: function(response) {
                    console.log('The Ajax request was successful.');
                },
                error: function(error) {
                    console.log('There was an error with the Ajax request:', error);
                }
            });
        }else{
            alert("Please enter a value for calorie");
        }
        location.reload();
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
    <a href="logout.php">logout</a>
</div>
</head>
</html>