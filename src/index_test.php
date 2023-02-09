<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);
$id = $_SESSION['id'];
$query = "SELECT calorie FROM day_calorie WHERE user_id='$id'";
$result = mysqli_query($con, $query);
$query_history = "SELECT calorie, date_saved FROM saved_calorie WHERE user_id='$id'";
$result_history = mysqli_query($con, $query_history);
$query_food = "SELECT food_name, calorie FROM `food` WHERE 1";
$result_food = mysqli_query($con, $query_food);
$query_sport = "SELECT sport_name, calorie FROM `sport` WHERE 1";
$result_sport = mysqli_query($con, $query_sport);

if(isset($_POST['calorie'])){
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
}

if(isset($_POST['sport'])){
    if(!empty($_POST['sport'])) {
        $sport = $_POST['sport'];
        $id = $_SESSION['id'];
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
}

if(isset($_POST['food'])){
    if(!empty($_POST['food'])) {
        $food = $_POST['food'];
        $id = $_SESSION['id'];
        $query = "UPDATE day_calorie SET calorie = calorie - '$food' WHERE user_id = '$id'";
        $result = mysqli_query($con,$query);

        if ($result === false) {
            error_log(mysqli_error($con));
            echo "There was an error adding the food calories to the database.";
        } else {
            if (mysqli_affected_rows($con) == 0) {
                error_log("The food calories was not saved to the database because the query did not affect any rows.");
                echo "food calories was not saved to the database.";
            } else {
                error_log("food calories was successfully added to the database.");
                echo "food calories was successfully added to the database.";
            }
        }
        error_log($food);
    } else {
        error_log("The food variable was not posted.");
    }
}

if(isset($_POST['reset'])) {
    $id = $_SESSION['id'];
    $query = "UPDATE day_calorie SET calorie = 0 WHERE user_id = '$id'";
    $result = mysqli_query($con,$query);

    error_log("The calorie variable was reset.");
}
?>


<html>

<head>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link href="scan.css" rel="scan">
</head>
       

<body style="background-image: url('assets/brand/backg2.jpg'); background-size: cover;"> 
<div style="padding: 20px;">
    <div class="interface" style="  width: 50%; background-color: white; border-radius: 20px; margin: 0 auto; padding: 20px;">

        <h1 class="text-center">Calorie-Tracker</h3>
        <form>
            <div class="user">
                Hello, <?php echo $user_data['user_name']; ?>
            
                <a href="logout.php" class="btn btn-outline-dark" role="button" data-bs-toggle="button">logout </a>

            </div>
            
                <div class="form-group">
                    <label class="form-lable"  for="calorie-input">Enter calorie intake:</label>
                    <input type="number" id="calorie-input" name="calorie" class="form-control"  placeholder="calories for the day">
                    <div class="mx-auto">
                        <button  type="button" class="btn btn-outline-dark w-100" id="send-calorie">Send calorie</button>            
                        <button   type="button" class="btn btn-outline-dark w-100" id="reset">reset</button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="sport-input">sport:</label>
                    <input type="number" id="sport-input" name="sport" class="form-control"  placeholder="calorie used">
                    <p>
                        <button class="btn btn-outline-dark w-100" type="button" data-toggle="collapse" data-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2">
                            sport choise
                        </button>
                    </p>   
                    <div class="collapse" id="collapseExample2">
                    <div class="card card-body">
                        <form>
                            <!-- Add options from the database here -->
                            <?php
                            while($row = mysqli_fetch_array($result_sport)) {
                                echo "<div class='form-check'>
                                    <input type='checkbox' class='sport-checkbox' data-calorie='" . $row['calorie'] . "'>
                                    <label class='form-check-label'>" . $row['sport_name'] . " - " . $row['calorie'] . "</label>
                                </div>";
                            }
                            ?>
                        </form>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-dark w-100" id="send-sport">Send sport calorie</button>

                <div class="form-group">
                    <label for="food-input"><h>food</h> </label>
                    <input type="number" id="food-input" name="food" class="form-control"  placeholder="calorie take in">
                    <p>
                        <button class="btn btn-outline-dark w-100" type="button" data-toggle="collapse" data-target="#collapseExample1" aria-expanded="false" aria-controls="collapseExample1">
                            food choise
                        </button>
                    </p>                    
                    <div class="collapse" id="collapseExample1">
                    <div class="card card-body">
                    <form>
                        <!-- Add options from the database here -->
                        <?php
                        while($row = mysqli_fetch_array($result_food)) {
                        echo "<div class='form-check'>
                            <input type='checkbox' class='food-checkbox' data-calorie='" . $row['calorie'] . "'>
                            <label class='form-check-label'>" . $row['food_name'] . " - " . $row['calorie'] . "</label>
                        </div>";
                        }
                        ?>
                    </form>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-dark w-100" id="send-food">Send food calorie</button>

            <div class="text-black">
                <h3>current Calorie intake:</h3>
            </div>
            <div >
                <span class="text-black">
                    <h3>
                        <?php
                        while($row = mysqli_fetch_assoc($result)) {
                            echo $row['calorie'] . "<br>";
                            //echo $current_date = date("Y-m-d");
                        }
                        ?>
                    </h3>
                    <div id="calorie-display"></div>
                </span>
            </div>

            
            <div>
                <p>
                    <button class="btn btn-outline-dark w-100" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        history
                    </button>
                </p>
                <div class="collapse" id="collapseExample">
                    <div class="card card-body">
                        <?php
                        while($row = mysqli_fetch_assoc($result_history)) {
                        echo $row['calorie'] . " - " . $row['date_saved'] . "<br>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>  
        </form>    
    </div> 
</body>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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

        $('#reset').click(function() {
            $.ajax({
                url: 'http://localhost/fitness/index_test.php',
                type: 'POST',
                data: { reset: 0 },
                success: function(response) {
                    console.log('The Ajax request was successful.');
                },
                error: function(error) {
                    console.log('There was an error with the Ajax request:', error);
                }
            });

            location.reload();
        });

        $('#send-sport').click(function() {
            let selectedCalorie = $('#sport-input').val();

            $(".sport-checkbox").each(function() {
                if ($(this).is(":checked")) {
                    selectedCalorie = $(this).data("calorie");
                    return false; // break the loop
                }
            });

            if (selectedCalorie !== "") {
                $.ajax({
                    url: 'http://localhost/fitness/index_test.php',
                    type: 'POST',
                    data: { sport: selectedCalorie },
                    success: function(response) {
                        console.log('The Ajax request was successful.');
                    },
                    error: function(error) {
                        console.log('There was an error with the Ajax request:', error);
                    }
                });
            } else {
                alert("Please enter a value for calorie or select a sport item");
            }
            location.reload();
        });


        $('#send-food').click(function() {
            let selectedCalorie = $('#food-input').val();

            $(".food-checkbox").each(function() {
                if ($(this).is(":checked")) {
                    selectedCalorie = $(this).data("calorie");
                    return false; // break the loop
                }
            });

            if (selectedCalorie !== "") {
                $.ajax({
                    url: 'http://localhost/fitness/index_test.php',
                    type: 'POST',
                    data: { food: selectedCalorie },
                    success: function(response) {
                        console.log('The Ajax request was successful.');
                    },
                    error: function(error) {
                        console.log('There was an error with the Ajax request:', error);
                    }
                });
            } else {
                alert("Please enter a value for calorie or select a food item");
            }

            location.reload();
        });




        
    });

    </script>
</div>
</div>
</html>
