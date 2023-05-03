<?php
include "dbConn.php";
include "createTable.php";

    session_start();

    $stnumber = $username = $password = $output =$user = null;

    if(isset($_POST['btnLogin'])){
        $_SESSION['stnumber'] = $_POST['stnumber'];
        $username = $_POST['email'];
        $password = $_POST['password'];
        $stnumber = $_POST['stnumber'];
        //encrypt password
        $hpass = md5($password);
        //check if user exists
        $qry = "SELECT * FROM tblusers WHERE email = '$username' AND password = '$hpass' AND stnumber = '$stnumber'";
        $qryResult = mysqli_query($conn,$qry);

        //place query result in array
        $user = mysqli_fetch_assoc($qryResult);
        if(($user['email']===$username) && ($user['stnumber']===$stnumber) && ($user['password']===$hpass)){
            header('location: index.php');
        }  
        else{
            $output = "Invalid username, student number or password<br><br>";
        }   

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Book Cart | Login or Register</title>
</head>
<body>
    <div class = "adminlink">
        <a href ="admin.php"> Admin page</a>
    </div>

    <header>
        <img src="images/bookCart_logo.png" alt="Book Cart Logo">
    </header>
    <form action="login.php" method="post">
        <div class="userInfoDiv">
        <?php echo $output; ?>
            
            <input type="email" name="email" placeholder="Username\Email" required><br><br>

            
            <input type="text" name="stnumber" placeholder="Student Number" required><br><br>

            
            <input type="password" name="password" placeholder="Password" required><br><br>
            <input class = "btnLog" type="submit" name = "btnLogin" value="Login"><br><br>

            <a class = "loglink" href="register.php">Don't have an account? Regiser account.</a>
        </div>
        <style>
            .btnLog
{
    color: white;
    background-color: maroon;
}
footer
{
    text-align: center;
    color: white;
    background-color: rgba(0, 0, 0, 0.75);
}
        </style>
    </form>
    <footer>
            <p>
               <strong> <h2> Welcome to Book Cart, Your number 1 online secondhand textbook store. </h2></strong>
            </p>
    </footer>
</body>


</html>