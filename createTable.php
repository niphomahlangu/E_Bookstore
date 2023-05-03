<?php
    
    
    $tblusers = "CREATE TABLE `tblusers` (
        `userid` int(10) NOT NULL AUTO_INCREMENT,
        `fname` varchar(50) NOT NULL,
        `lname` varchar(50) NOT NULL,
        `stnumber` varchar(20) NOT NULL,
        `email` varchar(50) NOT NULL,
        `password` varchar(100) NOT NULL,
        `usertype` varchar(10) NOT NULL DEFAULT 'user',
        `vstatus` bit(1) NOT NULL DEFAULT b'0',
        PRIMARY KEY (`userid`)
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
      
      $tblbooks = "CREATE TABLE `tblbooks` (
        `bookid` int(10) NOT NULL AUTO_INCREMENT,
        `booktitle` varchar(50) NOT NULL,
        `category` varchar(50) NOT NULL,
        `image` varchar(50) NOT NULL,
        `price` decimal(10,2) NOT NULL,
        `qnty` int(10) NOT NULL,
        PRIMARY KEY (`bookid`)
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
      
      
      $tblorders = "CREATE TABLE `tblorders` (
        `orderid` int(10) NOT NULL AUTO_INCREMENT,
        `userid` int(10) NOT NULL,
        `orderdate` date NOT NULL,
        PRIMARY KEY (`orderid`),
        CONSTRAINT `tblorders_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `tblusers` (`userid`)
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
      
      
      $tblorderbooks = "CREATE TABLE `tblorderbooks` (
        `orderid` int(10) NOT NULL,
        `bookid` int(10) NOT NULL,
        `price` decimal(10,2) NOT NULL,
        `qnty` int(10) NOT NULL,
        PRIMARY KEY (`orderid`,`bookid`),
        CONSTRAINT `tblorderbooks_ibfk_1` FOREIGN KEY (`bookid`) REFERENCES `tblbooks` (`bookid`),
        CONSTRAINT `tblorderbooks_ibfk_2` FOREIGN KEY (`orderid`) REFERENCES `tblorders` (`orderid`)
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
      
      
      $createTableUsers = mysqli_query($conn,$tblusers);
      $createTableBooks = mysqli_query($conn,$tblbooks);
      $createTableOrders = mysqli_query($conn,$tblorders);
      $createTableOrderBooks = mysqli_query($conn,$tblorderbooks);
      
              if ($createTableUsers && $createTableBooks &&  $createTableOrders && $createTableOrderBooks) {
                  
                  echo "<br>Tables created successfully<br>";
                  
              } else {
                  
                  echo "<br>Tables already exist<br>";
              }

              $qry = "SELECT * FROM tblbooks";

		          $qryResult = mysqli_query($conn,$qry);

              if (mysqli_num_rows($qryResult) == 0) {
			
                /*
                This code was obtained from YouTube:
                Author: Alimon Pito
                URL: https://www.youtube.com/watch?v=sjF7A_uMbgc
                */

                $file = fopen("bookData.txt","r");

                while(!feof($file)){
                    $content = fgets($file);
                    $carray = explode(",",$content);
                    list($bookTitle,$category,$image,$price,$qnty) = $carray;
                    $sqlCommand = "INSERT INTO tblbooks (booktitle, category, image, price, qnty) VALUES ('$bookTitle','$category','$image','$price','$qnty')";
                    $conn->query($sqlCommand);
                }
                fclose($file);
              }


?>