<?php

function check_login($con)
{

    if(isset($_SESSION['id']))
    {

        $id = $_SESSION['id'];
        $query = "select * from users where id = '$id' limit 1";

        $result = mysqli_query($con,$query);
        if($result && mysqli_num_rows($result) > 0)
        {

            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }

    }

    //redirect to login
    header("Location: login.php");
    die;

}

function bracode_post($con)
{

    

}

function random_num($lenght)
{

    $text = "";
    if($lenght < 5)
    {
        $lenght = 5;
    }

    $len = rand(4,$lenght);

    for($i=0; $i < $len; $i++)
    {
        
        $text .= rand(0,9);

    }

    return $text;

}