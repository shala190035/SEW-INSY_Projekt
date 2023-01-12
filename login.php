<?php
session_start();

include("connection.php");
include("functions.php");

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    //something was posted
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    if(!empty($user_name) && !empty($password) && !is_numeric($user_name))
    {
        //read from database
        $query = "select * from users where user_name = '$user_name' limit 1";
        
        $result = mysqli_query($con,$query);

        if($result)
        {
            if($result && mysqli_num_rows($result) > 0)
            {

                $user_data = mysqli_fetch_assoc($result);
                
                if($user_data['password'] === $password)
                {
                    $_SESSION['user_id'] = $user_data['user_id'];
                    header("Location: index.php");
                    die;
                }
            }
        }
        
        echo '<script>alert("Username or password not correct!")</script>';
    }else 
    {
        echo '<script>alert("Username or password not correct!")</script>';
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Signin Template · Bootstrap v5.1</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/sign-in/">

    

    <!-- Bootstrap core CSS -->
<link href="assets\dist\css\bootstrap.min.css" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
  </head>
  <body class="text-center">

<main class="form-signin">
    <form method="post">
        <img class="mb-4 center" src="assets\brand\barcodescanner_logo.png" alt="logo" width="206" height="206">

        <div class="form-floating">
            
            <input class="form-control" id="floatingInput" type="user" name="user_name"><br><br>
            <label for="floatingInput">Username</label>
        </div>

        <div class="form-floating">
            
            <input type="password" class="form-control" id="floatingPassword" name="password"><br><br>
            <label for="floatingPassword">Password</label>
        </div>

        <div class="checkbox mb-3">
        </div>
        <input  class="w-100 btn btn-lg btn-primary" id="button" type="submit"  value="Login"><br><br>
        <!--<a href="signup.php">Click to Signup</a><br><br> -->
    </form>
</main>
  </body>
</html>
