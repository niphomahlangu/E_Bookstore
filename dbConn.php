<?php
    /*
        This code was obtained from w3schools.com
        Author: w3schools
        URL: https://www.w3schools.com/php/php_mysql_create.asp
    */ 

    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbName = 'bookstore';

    //create server connection
    $conn = mysqli_connect($servername, $username, $password, $dbName);

    if($conn){
        echo"connection Succesfull.";
    }
    else{
        echo "connection failed";
    }
?>