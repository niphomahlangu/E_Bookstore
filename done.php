<?php
session_start();
include "dbConn.php";


if(isset($_POST['Logout'])){
    unset($_SESSION['stnumber']);
    session_destroy ();
    header('location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Done</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="userInfoDiv">
    <h1>
    Thank you for shopping with Book Cart
    </h1>

    <h5>
    please select from the options below 
    </h5>
    </div>

    <div class = "doneShopping">
    <form class = "option" action="done.php" method = "post">
        <input type="submit" class="logOut" name="Logout" value="Log Out">
    </form>

    <a href = "index.php" class="logShop" >Continue Shopping</a>
    </div>
    <style>
         .doneShopping
 {
     text-align: center;
 }
 
    .logOut
    {
        background-color: maroon;
        padding: 15px;
        font-size: 20px;
        color: white;
    }
    
    .logShop
    {
        background-color: #26c000;
        padding: 15px;
        font-size: 20px;
        color: white;
        border-radius: 25px;
        border-color: white;
        text-decoration: none;
        padding left: 40px;

    }
    </style>
</body>
</html>