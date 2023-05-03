<?php
    //session_start();

    include "dbConn.php";

    $fname = $lname = $stnumber = $email = $password = $cpassword = $output =$rowCount =$row = null;

    if(isset($_POST['btnReg'])){

        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $stnumber = $_POST['stnumber'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];

        //check if the user exists
        $qry = "SELECT fname, lname, stnumber, email, password FROM tblusers WHERE email = '$email' OR stnumber = '$stnumber' ";
        $qryResult = mysqli_query($conn, $qry);
        //count number of rows
        $rowCount = mysqli_num_rows($qryResult);
        
        if($rowCount > 0){
            //store array results in row array
            $row = mysqli_fetch_assoc($qryResult);
            if(($row['email']===$email) || ($row['stnumber']===$stnumber)){
                $output = "user already exits";
            }      
        }
        elseif(empty($fname)|| empty($lname)|| empty($stnumber)|| empty($email)|| empty($password)|| empty($cpassword))
        {
            $output = "No fields can be empty<br>";
        }
        elseif($password!==$cpassword){
            
            $output = "Passwords do not match";
        }elseif(strlen($password)<8){
            $output = "Password must be at least 8 characters";
        }
        else{
            $hpass = md5($password);
            $insert = "INSERT INTO tblusers (fname, lname, stnumber, email, password) VALUES('$fname','$lname','$stnumber','$email','$hpass')";
            $insertResult = mysqli_query($conn,$insert);

            //check if row was affected
            if($insertResult){
                $output = "User created successfully!";
                header('location: Login.php');
            }else{
                $output = "<br>ERROR. Row NOT Inserted!!!";
            }
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
    <title>Regiser Account</title>
</head>
<body>
    <header>
        <img src="images/bookCart_logo.png" alt="">
    </header>
    <form action="register.php" method="post">
        <div class="userInfoDiv">
            <?php echo $output."<br><br>"; ?>
            <input type="text" name = "fname" placeholder ="Name" required><br><br>

            <input type="text" name = "lname" placeholder ="Surame" required><br><br>

            <input type="text" name = "stnumber" placeholder ="Student Number" required><br><br>

           <input type="email" name = "email" placeholder ="Email" required><br><br>

            <input type="password" name = "password" placeholder ="Password" required><br><br>

            <input type="password" name = "cpassword" placeholder ="Confirm Password" required><br><br>

            <input class = "btnLog" type="submit" value="Register" name="btnReg"><br><br>
            <a class = "loglink" href="login.php">Already have an account? Login.</a>
        </div>
    </form>
</body>
</html>

<?php
    /*echo $fname;
    echo $lname;
    echo $stnumber;
    echo $email;
    echo $password;
    echo $cpassword;*/

?>