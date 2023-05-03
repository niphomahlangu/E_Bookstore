<?php
    include "dbConn.php";
    session_start();
    unset($_SESSION['email']);
    $username = $password = $output =$user = null;

    if(isset($_POST['btnLogin'])){
        
        $username = $_POST['email'];
        $password = $_POST['password'];

        //encrypt password
        $hpass = md5($password);
        //check if user exists
        $qry = "SELECT * FROM tblusers WHERE email = '$username' AND password = '$hpass' ";
        $qryResult = mysqli_query($conn,$qry);

        //place query result in array
        $user = mysqli_fetch_assoc($qryResult);
        if(($user['email']===$username) && ($user['password']===$hpass)){
            $_SESSION['email'] = $_POST['email'];
            header('location: storeAdmin.php');
        }  
        else{
            $output = "Invalid username or password<br><br>";
        }   

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Log in</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<form action="admin.php" method="post">
        
        <div class="userInfoDiv">
            <?php echo "Username = admin@admin.com | Password = admin<br><br>";?>
        <?php echo $output; ?>
            <h2>Admin page</h2>
            <label>Username\Email:</label><br>
            <input type="email" name="email" required><br><br>

            <label>Password:</label><br>
            <input type="password" name="password" required><br><br>
            <input type="submit" class = "btn" name = "btnLogin" value="Login"><br><br>
            <a href="login.php" class = "loglink">Go back to home page.</a>
        </div>
    </form>
</body>
</html>